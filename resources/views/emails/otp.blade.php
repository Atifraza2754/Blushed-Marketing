<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>OTP | Blushed</title>
    <meta name="description" content="Reset Password Email Template.">
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
    <style>
        html,
        body {
            padding: 0;
            margin: 0;
        }
    </style>
    <div
        style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; margin-top:50px; width:100%; background-color:#edf2f7">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
            style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
            <tbody>
                {{-- <tr>
                    <td align="center" valign="center" style="text-align:center; padding: 40px">
                        <a href="https://blushed.com/" rel="noopener" target="_blank">
                            <img alt="Logo"
                                src="https://blushed.com/assets/images/logos/black-sm-transparent.png"
                                class="h-45px" style="width: 200px;" />
                        </a>
                    </td>
                </tr> --}}
                <tr>
                    <td align="left" valign="center" style="margin-top: 50px;">
                        <div
                            style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px">
                            <!--begin:Email content-->
                            <div style="padding-bottom: 30px; font-size: 17px;">
                                <strong>Dear {{ $details['title'] }},</strong>
                            </div>
                            <div style="padding-bottom: 30px">To ensure the security of your account, we have generated
                                a One-Time Password (OTP) for your recent sign-in request. Please use the following OTP
                                to complete your authentication:</div>
                            <div style="padding-bottom: 40px; text-align:center;">
                                <h1>Your OTP: {{ $details['otp'] }}</h1>
                            </div>
                            <div style="padding-bottom: 30px">If you did not request this OTP, please ignore this email
                                and ensure your account's security by changing your password immediately.</div>
                            <div style="border-bottom: 1px solid #eeeeee; margin: 15px 0"></div>
                            <!--end:Email content-->
                            <div style="padding-bottom: 10px">Kind regards,
                                <br>Blushed Team.
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="center"
                        style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
                        <p>A108 Adam Street New York, NY 535022 United States</p>
                        <p>Copyright ©
                            <a href="https://blushed.com" rel="noopener" target="_blank">Blushed</a>.
                        </p>
                    </td>
                </tr></br>
            </tbody>
        </table>
    </div>
</body>

</html>