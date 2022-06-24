@extends('backend.layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h5 class="mb-md-0 h6">{{ translate('Role Information') }}</h5>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-8 mx-auto">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">{{ translate('Role Name') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header bord-btm">
                    <h5 class="mb-md-0 h6">{{ translate('Permissions') }}</h5>
                </div>
                <br>

                @php
                    $permission_groups = \App\Models\Permission::all()->groupBy('parent');
                @endphp
                @foreach ($permission_groups as $key => $permission_group)
                    @php
                        $check = true;
                        if (
                            ($permission_group[0]['parent'] == 'multivendor' && !addon_is_activated('multi_vendor'))
                            || ($permission_group[0]['parent'] == 'refund' && !addon_is_activated('refund'))
                        ) {
                            $check = false;
                        }
                    @endphp
                    @if ($check)
                        <div class="bd-example">
                            <ul class="list-group">
                                <li class="list-group-item bg-light" aria-current="true">
                                    {{ translate(ucwords(str_replace('_', ' ', $permission_group[0]['parent']))) }}</li>
                                <li class="list-group-item">
                                    <div class="row">
                                        @foreach ($permission_group as $key => $permission)
                                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-2">
                                                    <label
                                                        class="control-label d-flex">{{ translate(ucwords(str_replace('_', ' ', $permission->name))) }}</label>
                                                    <label class="aiz-switch aiz-switch-success">
                                                        <input type="checkbox" name="permissions[]"
                                                            class="form-control demo-sw" value="{{ $permission->id }}">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @endif
                    <br>
                @endforeach
            </div>

            <div class="form-group mb-3 mt-3 text-right">
                <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
            </div>
        </form>

    </div>


@endsection
