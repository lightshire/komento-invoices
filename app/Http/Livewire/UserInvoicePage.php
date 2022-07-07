<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class UserInvoicePage extends Component
{

    public $invoice;

    public $total;

    public function mount($invoice)
    {
        $invoice = Order::where('uuid', $invoice)->first();
        $this->invoice = $invoice;

        $total = 0;

        foreach ($invoice['data']['items'] as $data) {
            $total += (((int)$data['quantity'] * (float)$data['price_per_quantity']) - (float)$data['discount']);
        }

        $this->total = $total;

    }

    public function render()
    {
        return view('livewire.user-invoice-page');
    }
}
