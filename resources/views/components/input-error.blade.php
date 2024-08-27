@props(['messages'])

@if ($messages)
    @foreach ((array) $messages as $message)
        <div class="invalid-feedback d-block" {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>{{ $message }}</div>
    @endforeach
@endif
