<div class="row mb-3">
    <label
        for="input{{ $name }}"
        class="{{ isset($labelClass) ? $labelClass : 'col-md-2 col-form-label' }}"
    >
        {{ $title }}
    </label>
    <div class="{{ isset($inputClass) ? $inputClass : 'col-sm-10' }}">
        <input
            name="{{ $name }}"
            value="{{ $value }}"
            type="{{ $type }}"
            @class(['form-control', 'is-invalid' => $errors->has($name)])
            id="input{{ $name }}"
            {{ isset($step) ? 'step='.$step : '' }}
        >
        @error($name)
            <span class="invalid-feedback" role="alert">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>
