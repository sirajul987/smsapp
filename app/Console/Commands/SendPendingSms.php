<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sms;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SendPendingSms extends Command
{
    protected $signature = 'sms:send-pending';
    protected $description = 'Send pending SMS messages';

    public function handle()
    {
        // Get pending SMS messages
        $pendingSms = Sms::where('sms_sending_time', '<=', Carbon::now()->toDateTimeString())
                         ->where('send_flag', 'N')
                         ->get();
        // Send each pending SMS message
        foreach ($pendingSms as $sms) {
            // Send SMS using GlobalSMS API
            $this->sendSms($sms->target_phone_no, $sms->message);

            // Update send_flag to indicate that SMS has been sent
            $sms->send_flag = 'Y';
            $sms->save();
        }
    }

    private function sendSms($phone, $message)
    {
        $apiUrl = 'https://api.globalsms.com/send';
        $apiKey = 'your-api-key';

        //Prepare SMS data
        $smsData = [
            'to' => $phone,
            'message' => $message
        ];

        // Send SMS using HTTP client
        $response = Http::post($apiUrl, [
            'api_key' => $apiKey,
            'to' => $smsData['to'],
            'message' => $smsData['message']
        ]);

        // Handle response
        if ($response->successful()) {
            $this->info('SMS sent successfully.');
        } else {
            $this->error('Failed to send SMS.');
        }
    }
}
