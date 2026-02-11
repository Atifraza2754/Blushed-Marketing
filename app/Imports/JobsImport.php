<?php

namespace App\Imports;

use App\Models\Job;
use Date;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;


class JobsImport implements ToModel, WithHeadingRow
{
    protected $successCount;
    protected $failureCount;

    // Constructor to accept counters by reference
    public function __construct(&$successCount, &$failureCount)
    {
        $this->successCount = &$successCount;
        $this->failureCount = &$failureCount;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        // Define the regex pattern for the time format (e.g., 5-5pm, 3-9pm)
        $timePattern = '/^([1-9]|1[0-2])(:[0-5][0-9])?(am|pm)-([1-9]|1[0-2])(:[0-5][0-9])?(am|pm)$/i';

        // Validate the scheduled_time using the regex
        if (preg_match($timePattern, $row['scheduled_time'])) {

            $date = ($row['date']);
            $unixTimestamp = ($date - 25569) * 86400; // Default 1900 system
            $formated_date = date('Y-m-d', $unixTimestamp);

            $shifttime = $this->formatShift($row['scheduled_time']);
            $this->successCount++;
            // Save the job as the time is valid
            
            $nowEST = Carbon::now('America/New_York')->format('Y-m-d H:i:s');

return new Job([
    'user_id' => Auth::id(),
    'date' => $formated_date,
    'account' => $row['account'],
    'address' => $row['address'],
    'contact' => $row['contact'],
    'phone' => $row['phone'],
    'scheduled_time' => $row['scheduled_time'],
    'shift_start' => $shifttime['shift_start'],
    'shift_end' => $shifttime['shift_end'],
    'timezone' => $row['timezone'],
    'email' => $row['email'],
    'method_of_communication' => $row['method_of_communication'],
    'brand' => $row['brand'],
    'skus' => $row['skus'],
    'samples_requested' => $row['samples_requested'] ?? false,
    'reschedule' => $row['reschedule'] ?? false,
    'added_to_homebase' => $row['added_to_homebase'] ?? false,
    'confirmed' => $row['confirmed'] ?? false,
    'notes' => $row['notes'] ?? null,
    'how_to_serve' => $row['how_to_serve'] ?? null,
    'supplies_needed' => $row['supplies_needed'] ?? null,
    'attire' => $row['attire'] ?? null,
    'is_published' => false,

    // ✅ GUARANTEED SAME TIME
    'created_at' => $nowEST,
    'updated_at' => $nowEST,
]);

        } else {
            // Invalid time format, increment failure count and skip this row
            $this->failureCount++;
            return null; // Skip this row
        }
    }

    // After the import, you can access the success and failure counts
    public function afterImport()
    {
        // Optional: You can access these counts here if needed
        return [
            'successCount' => $this->successCount,
            'failureCount' => $this->failureCount
        ];
    }

    public function startRow(): int
    {
        return 2; // Skip the first row (header row) and start importing from row 2
    }

    function formatShift($shift)
    {
        // Split the input by the dash
        [$start, $end] = explode('-', $shift);

        // Convert start and end times to 24-hour format
        $start_time = date("H:i", strtotime($start));
        $end_time = date("H:i", strtotime($end));

        // Return the formatted times
        return [
            'shift_start' => $start_time,
            'shift_end' => $end_time
        ];
    }
}
