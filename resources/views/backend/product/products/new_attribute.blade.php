<div class="form-group row gutters-10">
    <div class="col-xxl-3 col-xl-4 col-md-5 attr-names">
        <select class="form-control aiz-selectpicker" name="product_attributes[]" onchange="get_attributes_values(this)" data-live-search="true">
            <option value="">{{ translate('Select an attribute') }}</option>
            @foreach($attributes as $key => $attribute)
                <option value="{{ $attribute->id }}">{{ $attribute->getTranslation('name') }}</option>
            @endforeach
        </select>
    </div>
    <div class="col attr-values">
        <div class="form-control">
            <span>{{ translate('Select an attribute') }}</span>
        </div>
    </div>
    <div class="col-auto">
        <button type="button" data-toggle="remove-parent" class="btn btn-icon p-0" data-parent=".row">
            <i class="la-2x la-trash las opacity-70"></i>
        </button>
    </div>
</div>