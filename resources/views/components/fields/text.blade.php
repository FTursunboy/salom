<div class="mb-3">
    <label class="col-form-label" for="message-text">{{ $title }}:</label>
    {{ Form::text($name, $value, ['class' => 'form-control ' . $class, 'required' => $required]) }}
</div>
