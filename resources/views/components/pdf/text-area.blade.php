@props(['label', 'value'])
<div>
    <div class="text-area">
        <label for="" style="font-weight: bold; font-size: 12px">
            {{ $label }}
        </label>
        <div>
            {{ $slot }}
        </div>
    </div>
</div>
