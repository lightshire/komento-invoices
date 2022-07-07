<div class="w-full h-screen flex items-center justify-center">
    @if (!$hasFile)
        <form class="flex items-center justify-center flex-col gap-4" wire:submit.prevent="uploadFile">
            <input type="file" accept="text/csv" wire:model="file" class="py-4 w-full border border-gray-500 rounded-md px-8 border-2" />
            <button class="py-4 px-8 bg-orange-400 rounded-md text-white">Submit</button>
        </form>
    @else
        <div class="text-center flex items-center justify-center flex-col gap-4">
            @if($processStarted)
                <div class="bg-green-400 border-green-600 border-2 rounded-md p-4 text-green-800">
                    Process has started. SMS are being sent.
                </div>
            @endif
            <h3>Summary: <span class="font-bold">{{ $orders }} Orders</span></h3>
                @if(!$processStarted)
                    <button class="py-2 px-8 bg-orange-400 rounded-md text-white" wire:click="sendSMS()">Send SMS</button>
                @endif
        </div>
    @endif
</div>
