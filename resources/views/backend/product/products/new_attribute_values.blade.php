<select class="form-control aiz-selectpicker" name="attribute_{{ $attribute_id }}_values[]" multiple data-live-search="true">
    @foreach($attribute_values as $key => $attribute_value)
        <option value="{{ $attribute_value->id }}">{{ $attribute_value->getTranslation('name') }}</option>
    @endforeach
</select>