@extends('backend.layouts.app')

@section('content')

    @can('show_languages')
        @php
        CoreComponentRepository::instantiateShopRepository();
        @endphp
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Default Language') }}</h5>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('languages.save_default_language') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <label class="col-from-label">{{ translate('Default Language') }}</label>
                                </div>
                                <div class="col-lg-6">
                                    <select class="form-control aiz-selectpicker" name="DEFAULT_LANGUAGE"
                                        data-live-search="true" data-selected="{{ env('DEFAULT_LANGUAGE') }}">
                                        @foreach (\App\Models\Language::where('status', 1)->get() as $key => $language)
                                            <option value="{{ $language->code }}">{{ $language->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <button type="submit" class="btn btn-info">{{ translate('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can('add_languages')
        <div class="aiz-titlebar text-left mt-2 mb-3">
            <div class="align-items-center">
                <div class="text-md-right">
                    <a href="{{ route('languages.create') }}" class="btn btn-circle btn-info">
                        <span>{{ translate('Add New Language') }}</span>
                    </a>
                </div>
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Language') }}</h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th data-breakpoints="lg">#</th>
                        <th>{{ translate('Name') }}</th>
                        <th data-breakpoints="lg">{{ translate('Code') }}</th>
                        <th data-breakpoints="lg">{{ translate('RTL') }}</th>
                        <th data-breakpoints="lg">{{ translate('Status') }}</th>
                        <th class="text-right" width="15%">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($languages as $key => $language)
                        <tr>
                            <td>{{ $key + 1 + ($languages->currentPage() - 1) * $languages->perPage() }}</td>
                            <td>{{ $language->name }}</td>
                            <td>{{ $language->code }}</td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="update_rtl_status(this)" value="{{ $language->id }}" type="checkbox"
                                        @if ($language->rtl == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="update_status(this)" value="{{ $language->id }}" type="checkbox"
                                        @if ($language->status == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-right">
                                <a class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                    href="{{ route('languages.show', $language->id) }}"
                                    title="{{ translate('Translation') }}">
                                    <i class="las la-language"></i>
                                </a>
                                @if ($language->code != 'en')
                                    @can('edit_languages')
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            href="{{ route('languages.edit', $language->id) }}"
                                            title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                    @endcan
                                @endif
                                @if ($language->code != 'en')
                                    @can('delete_languages')
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('languages.destroy', $language->id) }}"
                                            title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $languages->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('backend.inc.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">
        function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('languages.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function update_rtl_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('languages.update_rtl_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
