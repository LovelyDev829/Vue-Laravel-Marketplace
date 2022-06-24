@if (count($combinations[0]) > 0)
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
            @foreach ($combinations as $key => $combination)
                @php
                    $name = '';
                    $code = '';
                    $lstKey = array_key_last($combination);
                    
                    foreach ($combination as $option_id => $choice_id) {
                        $option_name = \App\Models\Attribute::find($option_id)->getTranslation('name');
                        $choice_name = \App\Models\AttributeValue::find($choice_id)->getTranslation('name');
                    
                        $name .= $option_name . ': ' . $choice_name;
                        $code .= $option_id . ':' . $choice_id . '/';
                    
                        if ($lstKey != $option_id) {
                            $name .= ' / ';
                        }
                    }
                @endphp
                <tr class="variant">
                    <td>
                        <label for="" class="control-label">{{ $name }}</label>
                        <input type="hidden" value="{{ $code }}" name="variations[{{ $key }}][code]">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="variations[{{ $key }}][price]" value="0" min="0"
                            class="form-control" required>
                    </td>
                    <td>
                        <select class="form-control aiz-selectpicker" name="variations[{{ $key }}][stock]">
                            <option value="1">{{ translate('In stock') }}</option>
                            <option value="0">{{ translate('Out of stock') }}</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="variations[{{ $key }}][sku]" class="form-control">
                    </td>
                    <td>
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                    {{ translate('Browse') }}</div>
                            </div>
                            <div class="form-control file-amount text-truncate">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="variations[{{ $key }}][img]" class="selected-files">
                        </div>
                        <div class="file-preview box sm"></div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
