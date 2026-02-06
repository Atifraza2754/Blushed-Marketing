<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessNotificationSchedule implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notificationData;
    protected $availableUsers;

    /**
     * Create a new job instance.
     */
    public function __construct($notificationData, $availableUsers)
    {
        $this->notificationData = $notificationData;
        $this->availableUsers = $availableUsers;
    }

    /**
     * Execute the job.
     */
       public function handle()

    {
        Log::info('Job dispatched', [
            'users' => $this->availableUsers,
            'notification' => $this->notificationData,
        ]);

        if (empty($this->availableUsers)) {
            return;
        }

        $records = [];
        foreach ($this->availableUsers as $userId) {
            $records[] = [
                'user_id'     => $userId,
                'title'       => $this->notificationData['title'] ?? '',
                'description' => $this->notificationData['description'] ?? '',
                'link'        => $this->notificationData['link'] ?? '',
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        // Bulk insert all notifications
        Notification::insert($records);
    }
}
