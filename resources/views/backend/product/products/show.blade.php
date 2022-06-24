@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-lg-auto">
                    <img src="{{ uploaded_asset($product->thumbnail_img) }}" class="size-200px">
                </div>
                <div class="col-lg">
                    <h1 class="h5 fw-700">{{ $product->getTranslation('name') }}</h1>
                    <div class="d-flex align-items-center mb-3">
                        <span class="rating">
                            {{ renderStarRating($product->rating) }}
                        </span>
                        <span class="ml-1 mr-0 opacity-50">({{ number_format($product->rating, 2) }})</span>
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="border border-dotted rounded py-2 px-3 mr-3 ml-0">
                            <div class="h3 mb-0 fw-700">{{ $product->reviews_count }}</div>
                            <div class="opacity-60 fs-12">{{ translate('Reviews') }}</div>
                        </div>
                        <div class="border border-dotted rounded py-2 px-3 mr-3 ml-0">
                            <div class="h3 mb-0 fw-700">{{ $product->wishlists_count }}</div>
                            <div class="opacity-60 fs-12">{{ translate('In wishlist') }}</div>
                        </div>
                        <div class="border border-dotted rounded py-2 px-3 mr-3 ml-0">
                            <div class="h3 mb-0 fw-700">{{ $product->carts_count }}</div>
                            <div class="opacity-60 fs-12">{{ translate('In cart') }}</div>
                        </div>
                        <div class="border border-dotted rounded py-2 px-3 mr-3 ml-0">
                            <div class="h3 mb-0 fw-700">{{ $product->num_of_sale }}</div>
                            <div class="opacity-60 fs-12">{{ translate('Times sold') }}</div>
                        </div>
                        <div class="border border-dotted rounded py-2 px-3 mr-3 ml-0">
                            <div class="h3 mb-0 fw-700">{{ format_price($product->orderDetails()->sum('price')) }}</div>
                            <div class="opacity-60 fs-12">{{ translate('Amount sold') }}</div>
                        </div>
                        @if ($product->discount > 0)
                            <div class="border border-dotted rounded py-2 px-3 mr-3 ml-0 bg-danger text-white">
                                @if ($product->discount_type == 'flat')
                                    <span class="h3 mb-0 fw-700">{{ format_price($product->discount) }}</span>
                                @else
                                    <span class="h3 mb-0 fw-700">{{ $product->discount }}%</span>
                                @endif
                                {{ translate('Off') }}
                                <div class="opacity-60 fs-12">
                                    {{ date('Y/m/d H:i:s', $product->discount_start_date) }} -
                                    {{ date('Y/m/d H:i:s', $product->discount_end_date) }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-auto w-lg-320px">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="mr-2 ml-0">{{ translate('Status') }}:</span>
                        @if ($product->published)
                            <span class="badge badge-inline badge-success">{{ translate('Published') }}</span>
                        @else
                            <span class="badge badge-inline badge-secondary">{{ translate('Draft') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="mr-2 ml-0">{{ translate('Brand') }}:</span>
                        @if ($product->brand)
                            <div class="h-30px w-100px d-flex align-items-center justify-content-end">
                                <img src="{{ uploaded_asset($product->brand->logo) }}" alt="{{ translate('Brand') }}"
                                    class="mw-100 mh-100">
                            </div>
                        @else
                            <span>{{ translate('No brand') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="mr-2 ml-0">{{ translate('Category') }}:</span>
                        <span class="text-right">
                            @foreach ($product->categories as $category)
                                <span
                                    class="badge badge-inline badge-md bg-soft-dark mb-1">{{ $category->getTranslation('name') }}</span>
                            @endforeach
                        </span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="mr-2 ml-0">{{ translate('Tags') }}:</span>
                        <span class="text-right">
                            {{ $product->tags }}
                        </span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="mr-2 ml-0">{{ translate('Warranty') }}:</span>

                        @if ($product->has_warranty)
                            <span class="badge badge-inline badge-success">{{ translate('Has warranty') }}</span>
                        @else
                            <span class="badge badge-inline badge-secondary">{{ translate('No warranty') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="mr-2 ml-0">{{ translate('Minimum Purchase Qty ') }}:</span>
                        <span>{{ $product->min_qty }}</span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="mr-2 ml-0">{{ translate('Maximum Purchase Qty ') }}:</span>
                        <span>{{ $product->max_qty }}</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('VAT & Tax') }}</h5>
                </div>
                <div class="card-body">
                    @foreach (\App\Models\Tax::all() as $tax)

                        @php
                            $tax_amount = 0;
                            $tax_type = 'flat';
                            foreach ($product->taxes as $row) {
                                if ($row->tax_id == $tax->id) {
                                    $tax_amount = $row->tax;
                                    $tax_type = $row->tax_type;
                                }
                            }
                        @endphp

                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="name">
                                    {{ $tax->name }}
                                    <input type="hidden" value="{{ $tax->id }}" name="tax_ids[]">
                                </label>
                            </div>
                            <div class="form-group col-6">
                                @if ($tax_type == 'flat')
                                    <span class="">{{ format_price($tax_amount) }}</span>
                                @else
                                    <span class="">{{ $tax_amount }}%</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg">
            <div class="card">
                <div class="card-header mb-0 h6">{{ translate('Product price, stock') }}</div>
                <div class="card-body">
                    <table class="table table-bordered table-responsive-xl">
                        <thead>
                            <tr>
                                @if ($product->is_variant)
                                    <td class="">
                                        <label for="" class="control-label">{{ translate('Variant') }}</label>
                                    </td>
                                @endif
                                <td class="">
                                    <label for="" class="control-label">{{ translate('Price') }}</label>
                                </td>
                                <td class="">
                                    <label for="" class="control-label">{{ translate('Stock') }}</label>
                                </td>
                                <td class="">
                                    <label for="" class="control-label">{{ translate('SKU') }}</label>
                                </td>
                                @if ($product->is_variant)
                                    <td class="">
                                        <label for="" class="control-label">{{ translate('Image') }}</label>
                                    </td>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($product->variations as $key => $variation)
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
                                    @if ($product->is_variant)
                                        <td>
                                            <div>{{ $name }}</div>
                                        </td>
                                    @endif
                                    <td>
                                        <div>{{ format_price($variation->price) }}</div>
                                    </td>
                                    <td>
                                        <div>
                                            @if ($variation->stock == '1')
                                                {{ translate('In stock') }}
                                            @else
                                                {{ translate('Out of stock') }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            {{ $variation->sku }}
                                        </div>
                                    </td>
                                    @if ($product->is_variant)
                                        <td>
                                            <img src="{{ uploaded_asset($variation->img) }}" class="size-50px">
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Gallery') }}</h5>
                </div>
                <div class="card-body">
                    <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="5" data-xl-items="5"
                        data-lg-items="3" data-md-items="2" data-sm-items="1">
                        @foreach (explode(',', $product->photos) as $key => $image)
                            <div class="carousel-box">
                                <img src="{{ uploaded_asset($image) }}" class="img-fluid">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Shipping Information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Standard delivery time') }}</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="number" class="form-control" name="standard_delivery_time" min="0"
                                    value="{{ $product->standard_delivery_time }}" required readonly>
                                <div class="input-group-append"><span class="input-group-text">hr(s)</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Express delivery time') }}</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="number" class="form-control" name="express_delivery_time" min="0"
                                    value="{{ $product->express_delivery_time }}" required readonly>
                                <div class="input-group-append"><span class="input-group-text">hr(s)</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Weight') }}</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="number" class="form-control" name="weight" min="0"
                                    value="{{ $product->weight }}" required readonly>
                                <div class="input-group-append"><span
                                        class="input-group-text">{{ get_setting('weight_unit') }}</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Height') }}</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="number" class="form-control" name="height" min="0"
                                    value="{{ $product->height }}" required readonly>
                                <div class="input-group-append"><span
                                        class="input-group-text">{{ get_setting('dimension_unit') }}</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Length') }}</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="number" class="form-control" name="length" min="0"
                                    value="{{ $product->length }}" required readonly>
                                <div class="input-group-append"><span
                                        class="input-group-text">{{ get_setting('dimension_unit') }}</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Width') }}</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="number" class="form-control" name="width" min="0"
                                    value="{{ $product->width }}" required readonly>
                                <div class="input-group-append"><span
                                        class="input-group-text">{{ get_setting('dimension_unit') }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Product Description') }}</h5>
                </div>
                <div class="card-body">
                    {!! $product->getTranslation('description') !!}
                </div>
            </div>

        </div>
    </div>
@endsection
