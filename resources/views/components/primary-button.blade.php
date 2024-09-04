<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary d-block']) }}>
    {{ $slot }}
</button>
