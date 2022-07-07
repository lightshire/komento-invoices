<div class="w-full h-screen flex items-center justify-center bg-gray-200 p-8 flex-col">
    <img src="/img.png" class="w-48" />
    <div class="w-auto md:w-1/2 bg-white p-4">
        <div class="flex items-center justify-between mb-8 text-orange-500">
            <h3>Customer Name</h3>
            <h3 class="font-bold text-black">{{ $invoice->data['name'] }}</h3>
        </div>
        <div class='overflow-x'>
            <table class="table-auto overflow-scroll w-full">
                <thead>
                <tr class="uppercase text-xs text-left text-orange-500">
                    <th>#</th>
                    <th>Product Details</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoice->data['items']  as $index => $item)
                    <tr class="text-xs">
                        <td class="py-1">{{ ++$index }}</td>
                        <td>{{ $item['short_code'] }}</td>
                        <td>
                            <span class="font-bold">Short Code</span> {{ $item['short_code'] }} <br />
                            <span class="font-bold">SKU</span> {{ $item['sku'] }} <br />
                            <span class="font-bold">Product Name</span> {{ $item['product_name'] }} <br />
                            <span class="font-bold">Qty</span> {{ $item['product_name'] }} <br />
                            <span class="font-bold">Price</span> ₱ {{ number_format((float)$item['price_per_quantity'], 2) }} <br />
                            <span class="font-bold">Discount</span> ₱{{ number_format((float) $item['discount'], 2) }} <br />
                            <span class="text-xs italic">{{ $item['remarks'] }}</span>
                        </td>
                        <td>₱ {{ number_format(((float)$item['quantity'] * (float)$item['price_per_quantity']) - (float)$item['discount']) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between my-8">
            <h3 class="text-orange-500">Total</h3>
            <h3 class="font-bold">₱ {{ number_format($total) }}</h3>
        </div>
        <div class="flex items-center justify-center text-center">
            <a href="{{ $invoice->data['nextpay_link'] }}" class="italic font-bold underline">Please pay thru this link (GCash, Credit Card, bank transfer, and more are all accepted)</a>
        </div>
    </div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
</div>
