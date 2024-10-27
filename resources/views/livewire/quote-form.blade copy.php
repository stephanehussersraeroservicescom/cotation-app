

<div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <h1>{{ $isEdit ? 'Edit' : 'Create' }} Quote</h1>

    <form wire:submit.prevent="save">
        <!-- Quote Information -->
        <div>
            <label for="SAE">SAE:</label>
            <input type="text" id="SAE" wire:model.defer="SAE">
            @error('SAE') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="customer_name">Customer Name:</label>
            <input type="text" id="customer_name" wire:model.defer="customer_name">
            @error('customer_name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="customer_email">Customer Email:</label>
            <input type="email" id="customer_email" wire:model.defer="customer_email">
            @error('customer_email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="date_entry">Date Entry:</label>
            <input type="date" id="date_entry" wire:model.defer="date_entry">
            @error('date_entry') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="date_valid">Date Valid (1 month from Date Entry):</label>
            <input type="date" id="date_valid" wire:model.defer="date_valid" readonly>
            @error('date_valid') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="comments">Comments:</label>
            <textarea id="comments" wire:model.defer="comments"></textarea>
        </div>

        <!-- Product Lines -->
        <h3>Product Lines</h3>

        @foreach($quoteLines as $index => $quoteLine)
            <div wire:key="product-line-{{ $index }}">
                <div>
                    <label for="product_id_{{ $index }}">Product:</label>
                    <select id="product_id_{{ $index }}" wire:model.defer="quoteLines.{{ $index }}.product_id">
                        <option value="">Select a Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product }}</option>
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

        <!-- Add Product Line Button -->
        <button type="button" wire:click="addQuoteLine">Add Product Line</button>

        <!-- Submit Button -->
        <div>
            <button type="submit">Save Quote</button>
        </div>
    </form>
</div>
