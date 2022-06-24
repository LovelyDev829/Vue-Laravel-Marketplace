@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('Offers')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
			@can('add_offers')
                <a href="{{ route('offers.create') }}" class="btn btn-circle btn-primary">
                    <span>{{translate('Create Offer')}}</span>
                </a>
            @endcan
		</div>
	</div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Offer')}}</h5>
        <div class="pull-right clearfix">
            <form class="" id="sort_offers" action="" method="GET">
                <div class="box-inline pad-rgt pull-left">
                    <div class="" style="min-width: 200px;">
                        <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0" >
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{translate('Title')}}</th>
                    <th data-breakpoints="lg">{{ translate('Banner') }}</th>
                    <th data-breakpoints="lg">{{ translate('Start Date') }}</th>
                    <th data-breakpoints="lg">{{ translate('End Date') }}</th>
                    <th data-breakpoints="lg">{{ translate('Status') }}</th>
                    <th data-breakpoints="lg">{{ translate('Page Link') }}</th>
                    <th width="10%">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($offers as $key => $offer)
                    <tr>
                        <td>{{ ($key+1) + ($offers->currentPage() - 1)*$offers->perPage() }}</td>
                        <td>{{ $offer->title }}</td>
                        <td><img src="{{ uploaded_asset($offer->banner) }}" alt="banner" class="h-50px"></td>
                        <td>{{ date('d-m-Y H:i:s', $offer->start_date) }}</td>
                        <td>{{ date('d-m-Y H:i:s', $offer->end_date) }}</td>
                        <td>
							<label class="aiz-switch aiz-switch-success mb-0">
								<input onchange="update_offer_status(this)" value="{{ $offer->id }}" type="checkbox" @if($offer->status == 1) checked @endif >
								<span class="slider round"></span>
							</label>
						</td>
						<td>{{ url('offer/'.$offer->slug) }}</td>
						<td class="text-right">
                            @can('edit_offers')
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('offers.edit', $offer->id )}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                            @endcan
                            @can('delete_offers')
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('offers.destroy', $offer->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="clearfix">
            <div class="pull-right">
                {{ $offers->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('backend.inc.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function update_offer_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('offers.update_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    location.reload();
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
