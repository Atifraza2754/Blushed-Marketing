<?php
    
namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Session;
use Stripe;
     
class StripePaymentController extends Controller
{
    /*
    |=================================================================
    | Show the stripe payment form / page
    |=================================================================
    */
    public function stripe()
    {
        try {
            Stripe\Stripe::setApiKey(config('stripe.secret'));
            $customers = \Stripe\Customer::all();
            dd($customers);

            return view('stripe');
        } 
        catch (\Throwable $th) {
            throw $th;
        }
    }
    

    
    /*
    |=================================================================
    | Pay using stripe
    |=================================================================
    */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(config('stripe.secret'));

        // create new customer in stripe panel
        $customer = Stripe\Customer::create(array(
            "address" => [
                "line1" => "Model Town Lahore",
                "postal_code" => "54700",
                "city" => "Lahore",
                "state" => "Punjab",
                "country" => "Pakistan",
            ],
            "email" => "dev.shahzadmahota@gmail.com",
            "name" => "Shahzad Mahota",
            "source" => $request->stripeToken
        ));

        // create new charge in stripe panel
        $response = Stripe\Charge::create ([
            "amount" => 100 * 100,
            "currency" => "usd",
            "customer" => $customer->id,
            "description" => "Test payment from Invictamentis Student For Level Upgradation",
            "shipping" => [
                "name" => "Invicta Mentis",
                "address" => [
                    "line1" => "Karachi, Pakistan",
                    "postal_code" => "24700",
                    "city" => "Karachi",
                    "state" => "Sindh",
                    "country" => "Pakistan",
                ],
            ]
        ]);

        dd($response);

        Session::flash('success', 'Payment successful!');
        return back();
    }



    /*
    |=================================================================
    | Find specific exising customer details from stripe panel
    |=================================================================
    */
    public function existingCustomer()
    {
        $stripe = new \Stripe\StripeClient(config('stripe.secret'));
        $stripe->customers->retrieve('cus_OscxuuSLzwk07s',[]
        );
    }




    /*
    |=================================================================
    | Get listing of all stripe customers
    |=================================================================
    */
    function find_existing_customer($email)
    {
        
        // Stripe\Stripe::setApiKey(config('stripe.secret'));
        // $customers = \Stripe\Customer::all();
        // dd($customers);

        $existing_customer = null;

        // List all customers
        $customers = \Stripe\Customer::all();
        dd($customers);

        // Check if the customer with the given email already exists
        foreach ($customers->autoPagingIterator() as $customer) {
            if ($customer->email == $email) {
                $existing_customer = $customer;
                break;
            }
        }

        return $existing_customer;
    }

}