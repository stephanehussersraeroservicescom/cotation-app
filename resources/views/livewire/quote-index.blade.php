<div class="flex justify-center bg-gray-400">
    <div class="w-4/5">
        <table class="min-w-full divide-y divide-gray-700  ">
            <thead class="bg-gray-50">
                <tr class="">
                    <th class="border-t border-b border-gray-400 px-6 py-8 text-left text-s font-medium text-gray-700 uppercase tracking-wider ">Quote #</th>
                    <th class="border-t border-b border-gray-400 px-6 py-8 text-left text-s font-medium text-gray-700 uppercase tracking-wider">SAE</th>
                    <th class="border-t border-b border-gray-400 px-6 py-8 text-left text-s font-medium text-gray-700 uppercase tracking-wider">Customer Name</th>
                    <th class="border-t border-b border-gray-400 px-6 py-8 text-left text-s font-medium text-gray-700 uppercase tracking-wider">Date</th>
                    <th class="border-t border-b border-gray-400 px-6 py-8 text-left text-s font-medium text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="border-t border-b border-gray-400 px-6 py-8 text-center text-s font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Livewire Search Row -->
                <tr>
                    <td class="px-6 py-4 border-b border-gray-400">
                        <input type="text" wire:model.live="searchId" placeholder="Search ID" class="mt-1 block w-full border border-gray-500 rounded-md shadow-sm">
                    </td>
                    <td class="px-6 py-4 border-b border-gray-400">
                        <input type="text" wire:model.live="searchSae" placeholder="Search SAE" class="mt-1 block w-full border border-gray-500 rounded-md shadow-sm">
                    </td>
                    <td class="px-6 py-4 border-b border-gray-400">
                        <input type="text" wire:model.live="searchCustomerName" placeholder="Search Customer" class="mt-1 block w-full border border-gray-500 rounded-md shadow-sm">
                    </td>
                    <td class="px-6 py-4 border-b border-gray-400">

                    </td>
                    <td class="px-6 py-4 border-b border-gray-400">
                        <input type="text" wire:model.live="searchComments" placeholder="Search Comment" class="mt-1 block w-full border border-gray-500 rounded-md shadow-sm">
                    </td>
                    <td class="px-6 py-4 border-b border-gray-400">
                        <!-- Empty for actions -->
                    </td>
                </tr>
                <!-- Data Rows -->
                @foreach($quotes as $quote)
                <tr wire:key="{{$quote->id}}">
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-400">{{ $quote->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-400">{{ $quote->SAE }}</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-400">{{ $quote->customer_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-400">{{ $quote->date_entry }}</td>
                    <td class="px-6 py-4 whitespace-nowrap max-w-xs truncate border-b border-gray-400">{{ $quote->comments }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center border-b border-gray-400">
                        <x-button-light wire:click="print({{ $quote->id }})"> Print </x-button-light>
                        <x-button-light wire:click="editQuote({{ $quote->id }})"> Edit </x-button-light> 
                        <x-button-light wire:click="previewEmail({{ $quote->id }})"> Preview Email </x-button-light>                   
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

       
</div>
