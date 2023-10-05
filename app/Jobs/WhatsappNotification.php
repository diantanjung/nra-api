<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappNotification extends Job
{
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data  = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = "*NRA - Natari Remote Attendance*\n\n";
        $message .= $this->data['message'];
        $message .= "\n\n--------\n";
        $message .= "_Pesan ini otomatis dikirim melalui https://nra.natari.id, tidak menjawab telepon dan membalas pesan. #ID" . time() . '_';

        return $this->WoowaNotification($this->data['phone'], $message);
    }

    /**
     * WOOWA SERVICE NOTIFICATION
     *
     * @param string $phone_number WhatsApp Number
     * @param string $message Messages
     * @return boolean
     */
    private function WoowaNotification($phone_number = null, $message)
    {
        $route      = $phone_number === null ? '/async_send_message_group_id' : '/async_send_message';
        $recipient  = $phone_number === null ? env('WOOWA_GROUP_ID') : $phone_number;
        $url        = env('WOOWA_API_URL') . $route;
        $key        = env('WOOWA_API_KEY');

        $body       = ["phone_no" => $recipient, "key" => $key, "message" => $message];
        if ($phone_number == null) {
            $body   = ["group_id" => $recipient, "key" => $key, "message" => $message];
        }

        $response = Http::asJson()->post($url, $body);
        Log::info(">> Send Whatsapp to " . $recipient);
        return $response->status() === 200;
    }
}
