

<div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <div class="mx-auto w-3/4 bg-gray-200 py-6 sm:px-4 lg:px-15">
        <h1 class="pt-20 m-10 text-center text-lg">{{ $isEdit ? 'Edit' : 'Create' }} Quote</h1>

        <form wire:submit.prevent="save">
            <!-- Quote Information -->
            <x-elements.input 
                for='SAE' 
                label='quoted by' 
                type='text' 
                wiremodel='SAE' 
                :error="$errors->first('SAE')" 
                currentValue="{{$this->quote->SAE}}"
                >
            </x-elements.input>

            <x-elements.input 
            for='customer_name' 
            label='Customer Name' 
            type='text' 
            wiremodel='customer_name' 
            :error="$errors->first('customer_name')" 
            currentValue="{{$this->quote->customer_name}}" >
            </x-elements.input>

            <x-elements.input 
            for='customer_email' 
            label='Customer Email' 
            type='email' 
            wiremodel='customer_email' 
            :error="$errors->first('customer_email')" 
            currentValue="{{$this->quote->customer_email}}" >
            </x-elements.input>

            <x-elements.input 
            for='quote-date' 
            label='date Quoted' 
            type='date' 
            wiremodel='date_entry' 
            :error="$errors->first('date_entry')" 
            currentValue="{{$this->quote->date_entry}}" >
            </x-elements.input>

            <x-elements.input 
            for='comments' 
            label='Quote Notes' 
            type='text' 
            wiremodel='comments' 
            :error="$errors->first('comments')" 
            currentValue="{{$this->quote->date_entry}}" >
            </x-elements.input>

            {{-- <div>
                <label for="date_valid">Date Valid (1 month from Date Entry):</label>
                <input type="date" id="date_valid" wire:model.defer="date_valid" readonly>
                @error('date_valid') <span class="error">{{ $message }}</span> @enderror
            </div> --}}

            {{-- <div>
                <label for="comments">Comments:</label>
                <textarea id="comments" wire:model.defer="comments"></textarea>
            </div> --}}


             <!-- Product Lines -->
            {{-- <div class="bg-slate-300">
                <h3 class="px-10 py-5 w-full font-medium text-gray-700">Product Lines</h3>


                <div class="mx-20 my-8">
                    @foreach($quoteLines as $index => $quoteLine)
                        <div wire:key="product-line-{{ $index }}">
                            <div>
                                <label for="product_id_{{ $index }}">Product:</label>
                                <select id="product_id_{{ $index }}" wire:model.defer="quoteLines.{{ $index }}.product_id">
                                    <option value="">Select a Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product['id'] }}">{{ $product['product'] }}</option>
                                    @endforeach
                                </select>
                                @error('quoteLines.'.$index.'.product_id') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="part_number_{{ $index }}">Part Number:</label>
                                <input type="text" id="part_number_{{ $index }}" wire:model.defer="quoteLines.{{ $index }}.part_number">
                                @error('quoteLines.'.$index.'.part_number') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="UOM_{{ $index }}">Unit of Measure:</label>
                                <select id="UOM_{{ $index }}" wire:model.defer="quoteLines.{{ $index }}.UOM">
                                    <option value="EACH">EACH</option>
                                    <option value="LY">LY</option>
                                    <option value="LM">LM</option>
                                </select>
                                @error('quoteLines.'.$index.'.UOM') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="price_{{ $index }}">Price:</label>
                                <input type="number" step="0.01" id="price_{{ $index }}" wire:model.defer="quoteLines.{{ $index }}.price">
                                @error('quoteLines.'.$index.'.price') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="MOQ_{{ $index }}">MOQ:</label>
                                <input type="number" id="MOQ_{{ $index }}" wire:model.defer="quoteLines.{{ $index }}.MOQ" min="1">
                                @error('quoteLines.'.$index.'.MOQ') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <!-- Remove Button for Product Line -->
                            <button type="button" wire:click="removeQuoteLine({{ $index }})">Remove</button>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div> --}}


            <div>
                <h4 class="text-lg leading-6 font-medium text-gray-900 mt-4">Quote Lines</h4>
                @foreach($quoteLines as $index => $line)

                    <x-elements.option
                    :for="'product_' . $index"
                    label='Product'
                    :wiremodel="'quoteLines.' . $index . '.product_id'" 
                    :error="$errors->first("'quoteLines.' . $index . '.product_id'" )" 
                    :currentValue="'quoteLines.' . $index . '.product_id'" >
                    </x-elements.option>



                    {{-- <div class="mt-2">
                        <label for="product_{{ $index }}" class="block text-sm font-medium text-gray-700">Product</label>
                        <select wire:model="quoteLines.{{ $index }}.product_id" id="product_{{ $index }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @foreach($products as $product)
                                <option value="{{ $product['id'] }}">{{ $product['product'] }}</option>
                            @endforeach
                        </select>
                        <label for="quantity_{{ $index }}" class="block text-sm font-medium text-gray-700 mt-2">Quantity</label>
                        <input type="number" wire:model="quoteLines.{{ $index }}.quantity" id="quantity_{{ $index }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div> --}}
                    <div>
                        <label for="part_number_{{ $index }}">Part Number:</label>
                        <input type="text" id="part_number_{{ $index }}" wire:model.defer="quoteLines.{{ $index }}.part_number">
                        @error('quoteLines.'.$index.'.part_number') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="UOM_{{ $index }}">Unit of Measure:</label>
                        <select id="UOM_{{ $index }}" wire:model.defer="quoteLines.{{ $index }}.UOM">
                            <option value="LY">LY</option>
                            <option value="LM">LM</option>
                        </select>
                        @error('quoteLines.'.$index.'.UOM') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="price_{{ $index }}">Price:</label>
                        <input type="number" step="0.01" id="price_{{ $index }}" wire:model.defer="quoteLines.{{ $index }}.price">
                        @error('quoteLines.'.$index.'.price') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="MOQ_{{ $index }}">MOQ:</label>
                        <input type="number" id="MOQ_{{ $index }}" wire:model.defer="quoteLines.{{ $index }}.MOQ" min="1">
                        @error('quoteLines.'.$index.'.MOQ') <span class="error">{{ $message }}</span> @enderror
                    </div>

                @endforeach
            </div>

                <!-- Add Product Line Button -->
                <div class="px-10 pb-5">
                    <x-button-light type="button" wire:click="addQuoteLine" > Add Line </x-button-light>
                    {{-- <button type="button" wire:click="addQuoteLine">Add Product Line</button> --}}
               </div>


            <!-- Submit Button -->
            <div>
                <button type="submit">Save Quote</button>
            </div>
        </form>
    </div>
    
</div>
