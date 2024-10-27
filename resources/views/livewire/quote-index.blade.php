<div>
    <table class="min-w-full divide-y divide-gray-500  ">
        <thead class="bg-gray-50 ">
            <tr class="">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider ">Quote ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SAE</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Entry</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <!-- Livewire Search Row -->
            <tr>
                <td class="px-6 py-4">
                    <input type="text" wire:model.live="searchId" placeholder="Search ID" class="mt-1 block w-full border border-gray-500 rounded-md shadow-sm">
                </td>
                <td class="px-6 py-4">
                    <input type="text" wire:model.live="searchSae" placeholder="Search SAE" class="mt-1 block w-full border border-gray-500 rounded-md shadow-sm">
                </td>
                <td class="px-6 py-4">
                    <input type="text" wire:model.live="searchCustomerName" placeholder="Search Customer" class="mt-1 block w-full border border-gray-500 rounded-md shadow-sm">
                </td>
                <td class="px-6 py-4">
                    
                    {{-- <input type="date" wire:model.change="searchDateEntry" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"> --}}
                </td>
                <td class="px-6 py-4">
                    <input type="text" wire:model.live="searchStatus" placeholder="Search Comment" class="mt-1 block w-full border border-gray-500 rounded-md shadow-sm">
                </td>
                <td class="px-6 py-4">
                    <!-- Empty for actions -->
                </td>
            </tr>
            <!-- Data Rows -->
            @foreach($quotes as $quote)
            <tr wire:key="{{$quote->id}}">
                <td class="px-6 py-4 whitespace-nowrap">{{ $quote->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $quote->SAE }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $quote->customer_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $quote->date_entry }}</td>
                <td class="px-6 py-4 whitespace-nowrap max-w-xs truncate">{{ $quote->comments }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <x-button-light wire:click="print({{ $quote->id }})"> Print </x-button-light>
                    <x-button-light wire:click="editQuote({{ $quote->id }})"> Edit </x-button-light> 
                    <x-button-light wire:click="previewEmail({{ $quote->id }})"> Preview Email </x-button-light>                   
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
