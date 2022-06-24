<table class="table table-bordered table-responsive-xl">
    <thead>
        <tr>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Variant') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Variant Price') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Stock') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('SKU') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Image') }}</label>
            </td>
        </tr>
    </thead>

    <tbody>
        @foreach ($variations as $key => $variation)
            @php
                $name = '';
                $code_array = array_filter(explode('/', $variation->code));
                $lstKey = array_key_last($code_array);
                
                foreach ($code_array as $j => $comb) {
                    $comb = explode(':', $comb);
                
                    $option_name = \App\Models\Attribute::find($comb[0])->getTranslation('name');
                    $choice_name = \App\Models\AttributeValue::find($comb[1])->getTranslation('name');
                
                    $name .= $option_name . ': ' . $choice_name;
                
                    if ($lstKey != $j) {
                        $name .= ' / ';
                    }
                }
            @endphp
            <tr class="variant">
                <td>
                    <label for="" class="control-label">{{ $name }}</label>
                    <input type="hidden" value="{{ $variation->code }}" name="variations[{{ $key }}][code]">
                </td>
                <td>
                    <input type="number" step="0.01" name="variations[{{ $key }}][price]"
                        value="{{ $variation->price }}" min="0" class="form-control" required>
                </td>
                <td>
                    <select class="form-control aiz-selectpicker" name="variations[{{ $key }}][stock]"
                        data-selected="{{ $variation->stock }}">
                        <option value="1">{{ translate('In stock') }}</option>
                        <option value="0">{{ translate('Out of stock') }}</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="variations[{{ $key }}][sku]" value="{{ $variation->sku }}"
                        class="form-control">
                </td>
                <td>
                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                {{ translate('Browse') }}</div>
                        </div>
                        <div class="form-control file-amount text-truncate">{{ translate('Choose File') }}</div>
                        <input type="hidden" name="variations[{{ $key }}][img]" class="selected-files"
                            value="{{ $variation->img }}">
                    </div>
                    <div class="file-preview box sm"></div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
