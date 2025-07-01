<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sms;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

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

    private function sendSms($to, $message)
    {
        // API endpoint
        $url =  env('API_END_POINT');

        // API Key
        $apiKey = env('API_KEY');

        // Message details
        $from = env('MSG_FROM');
        $schedule = "";
        $reference = "";

        // Create a Guzzle client instance
        $client = new Client();

        // Send POST request with parameters
        $response = $client->post($url, [
            'form_params' => [
                'apiKey' => $apiKey,
                'message' => $message,
                'from' => $from,
                'to' => $to,
                'schedule' => $schedule,
                'reference' => $reference
            ]
        ]);

        // Get response body
        //$body = $response->getBody();
    }
}
