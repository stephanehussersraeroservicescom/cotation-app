

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $isEdit ? 'Edit' : 'Create' }} Quote
        </h2>
    </x-slot>




<div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <div class="mx-auto w-3/4 bg-gray-200 py-6 sm:px-4 lg:px-15">
        <h1 class="font-semibold text-xl text-gray-800 m-10 text-left"> Quote</h1>

        
        <form wire:submit.prevent="save">      <!-- Quote Information -->
            
            
            
            <x-elements.input 
                for='SAE' 
                label='quoted by' 
                type='text' 
                wiremodel='SAE'
                :error="$errors->first('SAE')"  
                >
            </x-elements.input>

            <x-elements.input 
            for='customer_name' 
            label='Customer Name' 
            type='text' 
            wiremodel='customer_name' 
            :error="$errors->first('customer_name')" 
            
            >
            </x-elements.input>

            <x-elements.input 
            for='customer_email' 
            label='Customer Email' 
            type='email' 
            wiremodel='customer_email' 
            :error="$errors->first('customer_email')" 
             >
            </x-elements.input>

            <x-elements.input 
            for='quote-date' 
            label='date Quoted' 
            type='date' 
            wiremodel='date_entry' 
            :error="$errors->first('date_entry')" 
             >
            </x-elements.input>

            <x-elements.input 
            for='comments' 
            label='Quote Notes' 
            type='text' 
            wiremodel='comments' 
            :error="$errors->first('comments')" 
            >
            </x-elements.input>
             
            {!!$this->textuel!!}

            <div>
                <div class=" my-8 border-t-2 border-gray-500"></div>

                <h4 class="text-lg leading-6 font-medium text-gray-900 mt-4">Quote Lines</h4>
                @foreach($quoteLines as $index => $line)

                

                <div class=" my-8 border-t-2 border-gray-500"></div>

                    <h3 class="font-semibold text-l text-gray-800 m-10 text-left"> Quote Line {{$index +1}}</h3>

                    <x-elements.option
                    :for="'product_' . $index"
                    label='Product'
                    :wiremodel="'quoteLines.' . $index . '.product_id'"  >
                        @foreach($products as $product)                            
                            <option value="{{ $product['id'] }}">{{ $product['product'] }}</option>
                        @endforeach
                    </x-elements.option>

                    <x-elements.input 
                    :for="'quoteLines.' . $index . '.part_number'"
                    label='Part number' 
                    type='text' 
                    :wiremodel="'quoteLines.'.$index.'.part_number'"
                    >
                    </x-elements.input>


                    <x-elements.option
                    :for="'UOM_' . $index"
                    label='Unit of  Measure'
                    :wiremodel="'quoteLines.' . $index . '.UOM'"  >
                    <option value="LY">LY</option>
                    <option value="LM">LM</option>
                    </x-elements.option>



                    <div class="mx-20 >
                            <label for="quoteLines.{{$index}}.price" class="mt-8 w-full font-medium text-gray-700">Price : {{ $quoteLines[$index]['price'] }} USD per {{$quoteLines[$index]['UOM']}}</label>
                            <input  
                            type="number" 
                            id="quoteLines.{{$index}}.price" 
                            step="0.01"
                            wire:model="quoteLines.{{$index}}.price" 
                            class="my-2 w-3/4 block border-gray-500 border-2 rounded-md"
                            />
                        @error('quoteLines.'.$index.'.price') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="mx-20 ">
                        <label for="quoteLines.{{$index}}.MOQ" class="mt-8 w-full font-medium text-gray-700">Minimum Ordering Quantity</label>
                        <input  
                        type="number" 
                        id="quoteLines.{{$index}}.MOQ" 
                        wire:model="quoteLines.{{$index}}.MOQ" 
                        class="my-2 w-3/4 block border-gray-500 border-2 rounded-md"
                        />
                    @error('quoteLines.'.$index.'.MOQ') <span class="error">{{ $message }}</span> @enderror
                </div>

                    <!-- Remove Button for Product Line -->
                    <div class="px-20 mb-15">
                            <x-button-light type="button" wire:click="removeQuoteLine({{ $index }})">Remove</x-button-light>
                    </div>

                @endforeach
            </div>
                
                
            <div class=" my-8 border-t-2 border-gray-500"></div>
            <!-- Add Product Line Button -->
            <div class="px-10 pb-5">
                <x-button-light type="button" wire:click="addQuoteLine" > Add Line </x-button-light>
            </div>
            <!-- Submit Button -->
            <div class="px-10 pb-5">
                <x-button type="button" wire:click="submit" > Submit </x-button>
            </div>
        </form>
    </div>
    
</div>
