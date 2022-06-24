@extends('backend.layouts.app')

@section('content')
    @php
    CoreComponentRepository::instantiateShopRepository();
    @endphp
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('All categories') }}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                @can('add_categories')
                    <a href="{{ route('categories.create') }}" class="btn btn-circle btn-primary">
                        <span>{{ translate('Add New category') }}</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Categories') }}</h5>
            <div class="pull-right clearfix">
                <form class="" id="sort_categories" action="" method="GET">
                    <div class="box-inline pad-rgt pull-left">
                        <div class="" style="min-width: 200px;">
                            <input type="text" class="form-control" id="search" name="search"
                                @isset($sort_search) value="{{ $sort_search }}" @endisset
                                placeholder="{{ translate('Type name & Enter') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th data-breakpoints="lg">#</th>
                        <th>{{ translate('Name') }}</th>
                        <th data-breakpoints="lg">{{ translate('Parent Category') }}</th>
                        <th data-breakpoints="lg">{{ translate('Order Level') }}</th>
                        <th data-breakpoints="lg">{{ translate('Level') }}</th>
                        <th data-breakpoints="lg">{{ translate('Banner') }}</th>
                        {{-- <th data-breakpoints="lg">{{translate('Icon')}}</th> --}}
                        <th data-breakpoints="lg">{{ translate('Featured') }}</th>
                        <th width="10%" class="text-right">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $key => $category)
                        <tr>
                            <td>{{ $key + 1 + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                            <td>{{ $category->getTranslation('name') }}</td>
                            <td>
                                @php
                                    $parent = \App\Models\Category::where('id', $category->parent_id)->first();
                                @endphp
                                @if ($parent != null)
                                    {{ $parent->getTranslation('name') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $category->order_level }}</td>
                            <td>{{ $category->level }}</td>
                            <td>
                                <img src="{{ uploaded_asset($category->banner) }}" alt="{{ translate('Banner') }}"
                                    class="h-50px"
                                    onerror="this.onerror=null;this.src='{{ static_asset('/assets/img/placeholder.jpg') }}';">
                            </td>
                            {{-- <td>
                            <span class="avatar avatar-square avatar-xs">
                                <img src="{{ uploaded_asset($category->icon) }}" alt="{{translate('icon')}}">
                            </span>
                        </td> --}}
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="update_featured(this)" value="{{ $category->id }}"
                                        <?php if ($category->featured == 1) {
                                            echo 'checked';
                                        } ?>>
                                    <span></span>
                                </label>
                            </td>
                            <td class="text-right">
                                @can('edit_categories')
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="{{ route('categories.edit', ['id' => $category->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                        title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                @endcan
                                @can('delete_categories')
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('categories.destroy', $category->id) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $categories->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection


@section('modal')
    @include('backend.inc.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">
        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('categories.featured') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Featured categories updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
