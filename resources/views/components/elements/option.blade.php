@props([ 'for', 'label', 'wiremodel', 'currentValue'=>false])
<div class="mx-5 my-6 md:mx-15 lg:mx-20 ">
    <label for="{{$for}}" class="mt-8 w-full font-medium text-gray-700">{{$label}} : {{$currentValue}}</label>
        <select id="{{$for}}" wire:model.blur="{{$wiremodel}}" class="my-2 w-full block border-gray-500 border-2 rounded-md">
            {{$slot}}
        </select>
</div>


