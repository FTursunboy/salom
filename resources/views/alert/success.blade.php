@if(session()->get('flash_message'))
    <div class="mb-3">
        <div class="alert alert-danger" role="alert">{{ session()->get('flash_message') }}</div>
    </div>
@endif
