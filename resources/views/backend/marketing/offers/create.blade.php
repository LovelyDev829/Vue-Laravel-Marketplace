@extends('backend.layouts.app')

@section('content')

<div class="col-lg-10 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Offer Information')}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('offers.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="name">{{translate('Title')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Title')}}" id="name" name="title" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Banner')}} <small>(1920x500)</small></label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="banner" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="start_date">{{translate('Date')}}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control aiz-date-range" name="date_range" placeholder="Select Date" data-format="DD-MM-Y HH:mm:ss" data-time-picker="true" data-past-disable="true" data-separator=" to ">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-sm-3 control-label" for="products">{{translate('Products')}}</label>
                    <div class="col-sm-9">
                        <select name="products[]" id="products" class="form-control aiz-selectpicker" multiple required data-title="{{ translate('Choose Products') }}" data-selected-text-format="count" data-live-search="true">
                            @foreach(\App\Models\Product::where('published',1)->latest()->get() as $product)
                                <option value="{{$product->id}}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="alert alert-danger">
                    {{ translate('If any product has discount or exists in another offer, that discount will be replaced by this discount & time limit.') }}
                </div>
                <br>
                <div class="form-group row" id="discount_table">

                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#products').on('change', function(){
                var product_ids = $('#products').val();
                if(product_ids.length > 0){
                    $.post('{{ route('offers.product_discount') }}', {_token:'{{ csrf_token() }}', product_ids:product_ids}, function(data){
                        $('#discount_table').html(data);
                        $(".aiz-selectpicker").selectpicker();
                    });
                }
                else{
                    $('#discount_table').html(null);
                }
            });
        });
    </script>
@endsection
