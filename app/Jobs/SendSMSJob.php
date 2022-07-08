<?php

namespace App\Jobs;

use App\Models\Order;
use BulkGate\Message\Connection;
use BulkGate\Sms\Country;
use BulkGate\Sms\Message;
use BulkGate\Sms\Sender;
use BulkGate\Sms\SenderSettings\CountrySenderID;
use BulkGate\Sms\SenderSettings\CountrySenderSettings;
use BulkGate\Sms\SenderSettings\Gate;
use BulkGate\Sms\SenderSettings\StaticSenderSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Psy\Util\Str;

class SendSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $connection = new Connection('27456', 'iqqP8rBst6ko1lf7JgRo8Mjqsxp4DNQKQ5nn34aKS3QaETXQ6e');
        $type = Gate::GATE_TEXT_SENDER;
        $value = 'Inspire';

        $settings = new StaticSenderSettings($type, $value);
        $sender = new Sender($connection);
        $sender->setSenderSettings($settings);
        $order = Order::create([
            'key' => $this->order['phone_number'],
            'data' => $this->order,
            'uuid' => \Illuminate\Support\Str::uuid()
        ]);

        $message = 'Hey ' . $this->order['name'] . '! Thanks for mining with Komento! To view and pay your invoice, please click the link below. Once paid, please send your proof of payment to our facebook page! See you soon!  https://komento.inspiredropshipping.com/invoice/' . $order->uuid;

        $message = new Message($order->key, $message);
        $sender->send($message);


    }
}
