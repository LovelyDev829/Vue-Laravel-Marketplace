@if (count($product_ids) > 0)
    <label class="col-sm-3 col-from-label">{{ translate('Discounts') }}</label>
    <div class="col-sm-9">
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <td class="" width="40%">
                        <label class="control-label">{{ translate('Product') }}</label>
                    </td>
                    <td class="text-center">
                        <label class="control-label">{{ translate('Price') }}</label>
                    </td>
                    <td class="text-center">
                        <label class="control-label">{{ translate('Discount') }}</label>
                    </td>
                    <td class="text-center" width="15%">
                        <label class="control-label">{{ translate('Discount Type') }}</label>
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach ($product_ids as $key => $id)
                    @php
                        $product = \App\Models\Product::findOrFail($id);
                    @endphp
                    <tr>
                        <td>
                            <div class="from-group row gutters-5">
                                <div class="col-auto">
                                    <img class="size-80px" src="{{ uploaded_asset($product->thumbnail_img) }}"
                                        alt="Image">
                                </div>
                                <div class="col">
                                    <div class="">{{ $product->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($product->highest_price != $product->lowest_price)
                                <span class="fw-600">{{ format_price($product->lowest_price) }} -
                                    {{ format_price($product->highest_price) }}</span>
                            @else
                                <span class="fw-600">{{ format_price($product->lowest_price) }}</span>
                            @endif
                        </td>
                        <td>
                            <input type="number" step="0.01" name="discount_{{ $id }}"
                                value="{{ $product->discount }}" min="0" max="{{ $product->lowest_price }}"
                                class="form-control" required>
                        </td>
                        <td>
                            <select class="form-control aiz-selectpicker" name="discount_type_{{ $id }}">
                                <option value="flat">{{ translate('Flat') }}</option>
                                <option value="percent">{{ translate('Percent') }}</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
