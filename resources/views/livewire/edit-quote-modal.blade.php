<div>
    @if($showModal)
        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Edit Quote
                                </h3>
                                <div class="mt-2">
                                    <form wire:submit.prevent="save">
                                        <div>
                                            {{-- <x-elements.inputlabel 
                                            for="customer_name" 
                                            label="Cutsomer" 
                                            type="text" 
                                            currentValue="{{$quoteSelected->customer_name}}"
                                            wiremodel="quote.customer_name"
                                            />  --}}
                                            <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                                            <input type="text" wire:model="quote.customer_name" id="customer_name" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div>
                                            <label for="date_entry" class="block text-sm font-medium text-gray-700">Date Entry</label>
                                            <input type="date" wire:model="quote.date_entry" id="date_entry" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div>
                                            <label for="comments" class="block text-sm font-medium text-gray-700">Comments</label>
                                            <textarea wire:model="quote.comments" id="comments" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                        </div>
                                        <div>
                                            <h4 class="text-lg leading-6 font-medium text-gray-900 mt-4">Quote Lines</h4>
                                            @foreach($quoteLines as $index => $line)
                                                <div class="mt-2">
                                                    <label for="product_{{ $index }}" class="block text-sm font-medium text-gray-700">Product</label>
                                                    <select wire:model="quoteLines.{{ $index }}.product_id" id="product_{{ $index }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                        @foreach($products as $product)
                                                            <option value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="quantity_{{ $index }}" class="block text-sm font-medium text-gray-700 mt-2">Quantity</label>
                                                    <input type="number" wire:model="quoteLines.{{ $index }}.quantity" id="quantity_{{ $index }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="mt-5 sm:mt-6">
                                            <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" wire:click="$set('showModal', false)">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>