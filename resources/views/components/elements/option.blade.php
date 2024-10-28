@props([ 'for', 'label', 'wiremodel', 'currentValue'=>false])
<div class="mx-20 my-8">
    <label for="{{$for}}" class="mt-8 w-full font-medium text-gray-700">{{$label}} : {{$currentValue}}</label>
        <select id="{{$for}}" wire:model="{{$wiremodel}}" class="my-2 w-3/4 block border-gray-500 border-2 rounded-md">
            {{$slot}}
        </select>
</div>


