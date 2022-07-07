<?php

namespace App\Http\Livewire\Pages;

use App\Jobs\SendSMSJob;
use League\Csv\Reader;
use Livewire\Component;
use Livewire\WithFileUploads;

class InvoiceImportPage extends Component
{

    use WithFileUploads;

    public $file;

    public $hasFile = false;

    public $orders = 0;

    public $ordersToBeProcessed = [];

    public $processStarted = false;

    const PHONE_NUMBER = 'Phone Number';
    const NAME = 'Name';
    const PRODUCT_NAME = 'Product Name';
    const SKU = 'SKU';
    const SHORT_CODE = 'Short Code';
    const PRICE = 'Price per Quantity';
    const REMARKS = 'Remarks';
    const NEXT_PAY_LINK = 'Next Pay Link';
    const QUANTITY = 'Quantity';
    const DISCOUNT = 'Discount';


    public function uploadFile()
    {
        $this->hasFile = true;
        $path = $this->file->getRealPath();

        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        $orders = [];

        foreach ($records as $key => $record) {
            $phoneNumber = $record[self::PHONE_NUMBER];
            if (!array_key_exists($phoneNumber, $orders)) {
                $orders[$phoneNumber] = [
                    'name' => $record[self::NAME],
                    'phone_number' => $record[self::PHONE_NUMBER],
                    'nextpay_link' => $record[self::NEXT_PAY_LINK],
                    'items' => []
                ];
            }

            $orders[$phoneNumber]['items'][] = [
                'sku' => $record[self::SKU],
                'product_name' => $record[self::PRODUCT_NAME],
                'short_code' => $record[self::SHORT_CODE],
                'price_per_quantity' => $record[self::PRICE],
                'discount' => $record[self::DISCOUNT],
                'remarks' => $record[self::REMARKS],
                'quantity' => $record[self::QUANTITY]
            ];

        }

        $this->orders = count($orders);
        $this->ordersToBeProcessed = $orders;

    }

    public function sendSMS()
    {
        foreach ($this->ordersToBeProcessed as $order) {
            SendSMSJob::dispatch($order);
        }
        $this->processStarted = true;
    }

    public function render()
    {
        return view('livewire.pages.invoice-import-page');
    }
}
