@extends('backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Language Information')}}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('languages.store') }}" method="POST" enctype="multipart/form-data">
                	@csrf
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Name') }}</label>
                        </div>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="name" placeholder="{{ translate('Name') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Flag') }}</label>
                        </div>
                        <div class="col-lg-9">
                            <select class="form-control aiz-selectpicker mb-2 mb-md-0" name="flag" data-live-search="true" >
                                @foreach(\File::files(base_path('public/assets/img/flags')) as $path)
                                    <option value="{{ pathinfo($path)['filename'] }}" data-content="<div class=''><img src='{{ static_asset('assets/img/flags/'.pathinfo($path)['filename'].'.png') }}' class='mr-2'><span>{{ strtoupper(pathinfo($path)['filename']) }}</span></div>"></option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="control-label">{{ translate('Lang Code') }}</label>
                        </div>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="code" placeholder="{{ translate('Lang Code') }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
