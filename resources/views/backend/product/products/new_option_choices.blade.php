<select class="form-control aiz-selectpicker" name="option_{{ $attribute_id }}_choices[]" multiple data-live-search="true" onchange="update_sku()">
    @foreach($attribute_values as $key => $attribute_value)
        <option value="{{ $attribute_value->id }}">{{ $attribute_value->getTranslation('name') }}</option>
    @endforeach
</select>