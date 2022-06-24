@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Tax Information')}}</h5>
</div>

<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-header">
          <h5 class="mb-0 h6">{{ translate('Edit Tax Information') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('taxes.update', $tax->id) }}" method="POST" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PATCH">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" value="{{ $tax->name }}" class="form-control" required value="{{ $tax->name }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Tax Type')}}</label>
                    <div class="col-sm-9">
                      <select class="form-control aiz-selectpicker" name="tax_type" required>
                        <option value="amount" @if($tax->type == 'amount') selected @endif>{{translate('Flat')}}</option>
                        <option value="percent" @if($tax->type == 'percent') selected @endif>{{translate('Percent')}}</option>
                      </select>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
