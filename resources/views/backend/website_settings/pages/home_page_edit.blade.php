@extends('backend.layouts.app')
@section('content')
@php
	$all_products = \App\Models\Product::where('published',1)->get();
	$all_shops = filter_shops(\App\Models\Shop::query())->get();
@endphp
<h6 class="fw-600">{{ translate('Home Page Settings') }}</h6>
<div class="accordion" id="accordionExample">
	<!-- Home Slider -->
	<div class="card border-bottom">
		<div class="card-header c-pointer" data-toggle="collapse" data-target="#collapseHomeSlider" aria-expanded="true" aria-controls="collapseHomeSlider">
			<h6 class="my-2">{{ translate('Home Page Main Sliders') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseHomeSlider" class="collapse show" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row gutters-10 border-bottom pb-4 mb-4">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('1st Sliders image & link')}}</label>
							<small>{{ translate('Recommended size').' 640x310' }}</small>
						</div>
						<div class="col-lg-9">
							<div class="home-slider-1-target">
								<input type="hidden" name="types[]" value="home_slider_1_images">
								<input type="hidden" name="types[]" value="home_slider_1_links">
								@if (get_setting('home_slider_1_images') != null)
								@foreach (json_decode(get_setting('home_slider_1_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_slider_1_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_slider_1_links[]" value="{{ json_decode(get_setting('home_slider_1_links'),true)[$key] }}" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>
								@endforeach
								@endif
							</div>
							<div class="text-right">
								<button
									type="button"
									class="btn btn-soft-secondary btn-sm"
									data-toggle="add-more"
									data-content='<div class="row gutters-5">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_slider_1_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_slider_1_links[]" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".home-slider-1-target">
									{{ translate('Add New') }}
								</button>
							</div>
						</div>
					</div>
					<div class="form-group row gutters-10  border-bottom pb-4 mb-4">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('2nd Sliders image & link')}}</label>
							<small>{{ translate('Recommended size').' 310x310' }}</small>
						</div>
						<div class="col-lg-9">
							<div class="home-slider-2-target">
								<input type="hidden" name="types[]" value="home_slider_2_images">
								<input type="hidden" name="types[]" value="home_slider_2_links">
								@if (get_setting('home_slider_2_images') != null)
								@foreach (json_decode(get_setting('home_slider_2_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_slider_2_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_slider_2_links[]" value="{{ json_decode(get_setting('home_slider_2_links'),true)[$key] }}" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>
								@endforeach
								@endif
							</div>
							<div class="text-right">
								<button
									type="button"
									class="btn btn-soft-secondary btn-sm"
									data-toggle="add-more"
									data-content='<div class="row gutters-5">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_slider_2_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_slider_2_links[]" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".home-slider-2-target">
									{{ translate('Add New') }}
								</button>
							</div>
						</div>
					</div>
					<div class="form-group row gutters-10 border-bottom pb-4 mb-4">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('3rd Sliders image & link')}}</label>
							<small>{{ translate('Recommended size').' 310x145' }}</small>
						</div>
						<div class="col-lg-9">
							<div class="home-slider-3-target">
								<input type="hidden" name="types[]" value="home_slider_3_images">
								<input type="hidden" name="types[]" value="home_slider_3_links">
								@if (get_setting('home_slider_3_images') != null)
								@foreach (json_decode(get_setting('home_slider_3_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_slider_3_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_slider_3_links[]" value="{{ json_decode(get_setting('home_slider_3_links'),true)[$key] }}" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>
								@endforeach
								@endif
							</div>
							<div class="text-right">
								<button
									type="button"
									class="btn btn-soft-secondary btn-sm"
									data-toggle="add-more"
									data-content='<div class="row gutters-5">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_slider_3_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_slider_3_links[]" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".home-slider-3-target">
									{{ translate('Add New') }}
								</button>
							</div>
						</div>
					</div>
					<div class="form-group row gutters-10">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('4th Sliders image & link')}}</label>
							<small>{{ translate('Recommended size').' 310x145' }}</small>
						</div>
						<div class="col-lg-9">
							<div class="home-slider-4-target">
								<input type="hidden" name="types[]" value="home_slider_4_images">
								<input type="hidden" name="types[]" value="home_slider_4_links">
								@if (get_setting('home_slider_4_images') != null)
								@foreach (json_decode(get_setting('home_slider_4_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_slider_4_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_slider_4_links[]" value="{{ json_decode(get_setting('home_slider_4_links'),true)[$key] }}" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>
								@endforeach
								@endif
							</div>
							<div class="text-right">
								<button
									type="button"
									class="btn btn-soft-secondary btn-sm"
									data-toggle="add-more"
									data-content='<div class="row gutters-5">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_slider_4_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_slider_4_links[]" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".home-slider-4-target">
									{{ translate('Add New') }}
								</button>
							</div>
						</div>
					</div>

					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Popular categories -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapsePopularCategories" aria-expanded="true" aria-controls="collapsePopularCategories">
			<h6 class="my-2">{{ translate('Popular categories') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapsePopularCategories" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Select categories')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_popular_categories">
							<select name="home_popular_categories[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_popular_categories') }}" data-container="body">
								@foreach (\App\Models\Category::where('level',0)->get() as $key => $category)
									<option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
									@foreach ($category->childrenCategories as $childCategory)
										@include('backend.inc.child_category', ['child_category' => $childCategory])
									@endforeach
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Product section 1 -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseProductSectionOne" aria-expanded="true" aria-controls="collapseProductSectionOne">
			<h6 class="my-2">{{ translate('Product section 1') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseProductSectionOne" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Section title')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_product_section_1_title">
							<input type="text" placeholder="" name="home_product_section_1_title" value="{{ get_setting('home_product_section_1_title') }}" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Select product')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_product_section_1_products">
							<select name="home_product_section_1_products[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_product_section_1_products') }}" data-container="body">
								@foreach ($all_products as $key => $product)
									<option value="{{ $product->id }}">{{ $product->getTranslation('name') }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Home banner section 1 -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseHomeBannerOne" aria-expanded="true" aria-controls="collapseHomeBannerOne">
			<h6 class="my-2">{{ translate('Home banner section 1') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseHomeBannerOne" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row gutters-10">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('Banner image & link')}}</label>
							<small>{{ translate('Recommended size').' 1300x145' }}</small>
						</div>
						<div class="col-lg-9">
							<div class="home-banner-1-target">
								<input type="hidden" name="types[]" value="home_banner_1_images">
								<input type="hidden" name="types[]" value="home_banner_1_links">
								@if (get_setting('home_banner_1_images') != null)
								@foreach (json_decode(get_setting('home_banner_1_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_banner_1_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_banner_1_links[]" value="{{ json_decode(get_setting('home_banner_1_links'),true)[$key] }}" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>
								@endforeach
								@endif
							</div>
							<div class="text-right">
								<button
									type="button"
									class="btn btn-soft-secondary btn-sm"
									data-toggle="add-more"
									data-content='<div class="row gutters-5">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_banner_1_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_banner_1_links[]" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".home-banner-1-target">
									{{ translate('Add New') }}
								</button>
							</div>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	@if (addon_is_activated('multi_vendor'))
		{{-- shop section 1 --}}
		<div class="card border-bottom">
			<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseShopSectionOne" aria-expanded="true" aria-controls="collapseShopSectionOne">
				<h6 class="my-2">{{ translate('Shop section 1') }}</h6>
				<i class="las la-angle-down opacity-60 fs-20"></i>
			</div>
			<div id="collapseShopSectionOne" class="collapse" data-parent="#accordionExample">
				<div class="card-body">
					<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-group row">
							<label class="col-md-3 col-from-label">{{translate('Section title')}}</label>
							<div class="col-md-9">
								<input type="hidden" name="types[]" value="home_shop_section_1_title">
								<input type="text" placeholder="" name="home_shop_section_1_title" value="{{ get_setting('home_shop_section_1_title') }}" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 col-from-label">{{translate('Select shop')}}</label>
							<div class="col-md-9">
								<input type="hidden" name="types[]" value="home_shop_section_1_shops">
								<select name="home_shop_section_1_shops[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_shop_section_1_shops') }}" data-container="body">
									@foreach ($all_shops as $key => $shop)
										<option value="{{ $shop->id }}">{{ $shop->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="text-right">
							<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		{{-- shop banner section 1 --}}
		<div class="card border-bottom">
			<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseHomeShopBannerOne" aria-expanded="true" aria-controls="collapseHomeShopBannerOne">
				<h6 class="my-2">{{ translate('Home shop banner section 1') }}</h6>
				<i class="las la-angle-down opacity-60 fs-20"></i>
			</div>
			<div id="collapseHomeShopBannerOne" class="collapse" data-parent="#accordionExample">
				<div class="card-body">
					<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-group row gutters-10">
							<div class="col-lg-3">
								<label class="from-label d-block">{{translate('Banner image & link')}}</label>
								<small>{{ translate('Recommended size').' 420x200' }}</small>
							</div>
							<div class="col-lg-9">
								<div class="home-banner-3-target">
									<input type="hidden" name="types[]" value="home_shop_banner_1_images">
									<input type="hidden" name="types[]" value="home_shop_banner_1_links">
									@if (get_setting('home_shop_banner_1_images') != null)
									@foreach (json_decode(get_setting('home_shop_banner_1_images'), true) as $key => $value)
										<div class="row">
											<div class="col-lg-5">
												<div class="form-group">
													<div class="input-group" data-toggle="aizuploader" data-type="image">
														<div class="input-group-prepend">
															<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
														</div>
														<div class="form-control file-amount">{{ translate('Choose File') }}</div>
														<input type="hidden" name="home_shop_banner_1_images[]" class="selected-files" value="{{ $value }}">
													</div>
													<div class="file-preview box sm"></div>
												</div>
											</div>
											<div class="col-lg">
												<input type="text" placeholder="" name="home_shop_banner_1_links[]" value="{{ json_decode(get_setting('home_shop_banner_1_links'),true)[$key] }}" class="form-control">
											</div>
											<div class="col-auto">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
													<i class="las la-times"></i>
												</button>
											</div>
										</div>
									@endforeach
									@endif
								</div>
								<div class="text-right">
									<button
										type="button"
										class="btn btn-soft-secondary btn-sm"
										data-toggle="add-more"
										data-content='<div class="row gutters-5">
											<div class="col-lg-5">
												<div class="form-group">
													<div class="input-group" data-toggle="aizuploader" data-type="image">
														<div class="input-group-prepend">
															<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
														</div>
														<div class="form-control file-amount">{{ translate('Choose File') }}</div>
														<input type="hidden" name="home_shop_banner_1_images[]" class="selected-files">
													</div>
													<div class="file-preview box sm"></div>
												</div>
											</div>
											<div class="col-lg">
												<input type="text" placeholder="" name="home_shop_banner_1_links[]" class="form-control">
											</div>
											<div class="col-auto">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
													<i class="las la-times"></i>
												</button>
											</div>
										</div>'
										data-target=".home-banner-3-target">
										{{ translate('Add New') }}
									</button>
								</div>
							</div>
						</div>
						<div class="text-right">
							<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	@endif

	<!-- Product section 2 -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseProductSectionTwo" aria-expanded="true" aria-controls="collapseProductSectionTwo">
			<h6 class="my-2">{{ translate('Product section 2') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseProductSectionTwo" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Section title')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_product_section_2_title">
							<input type="text" placeholder="" name="home_product_section_2_title" value="{{ get_setting('home_product_section_2_title') }}" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Select product')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_product_section_2_products">
							<select name="home_product_section_2_products[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_product_section_2_products') }}" data-container="body">
								@foreach ($all_products as $key => $product)
									<option value="{{ $product->id }}">{{ $product->getTranslation('name') }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Home banner section 2 -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseHomeBannerTwo" aria-expanded="true" aria-controls="collapseHomeBannerTwo">
			<h6 class="my-2">{{ translate('Home banner section 2') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseHomeBannerTwo" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row gutters-10">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('Banner image & link')}}</label>
							<small>{{ translate('Recommended size').' 640x145' }}</small>
						</div>
						<div class="col-lg-9">
							<div class="home-banner-2-target">
								<input type="hidden" name="types[]" value="home_banner_2_images">
								<input type="hidden" name="types[]" value="home_banner_2_links">
								@if (get_setting('home_banner_2_images') != null)
								@foreach (json_decode(get_setting('home_banner_2_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_banner_2_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_banner_2_links[]" value="{{ json_decode(get_setting('home_banner_2_links'),true)[$key] }}" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>
								@endforeach
								@endif
							</div>
							<div class="text-right">
								<button
									type="button"
									class="btn btn-soft-secondary btn-sm"
									data-toggle="add-more"
									data-content='<div class="row gutters-5">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_banner_2_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_banner_2_links[]" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".home-banner-2-target">
									{{ translate('Add New') }}
								</button>
							</div>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	@if (addon_is_activated('multi_vendor'))
		{{-- shop section 2 --}}
		<div class="card border-bottom">
			<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseShopSectionTwo" aria-expanded="true" aria-controls="collapseShopSectionTwo">
				<h6 class="my-2">{{ translate('Shop section 2') }}</h6>
				<i class="las la-angle-down opacity-60 fs-20"></i>
			</div>
			<div id="collapseShopSectionTwo" class="collapse" data-parent="#accordionExample">
				<div class="card-body">
					<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-group row">
							<label class="col-md-3 col-from-label">{{translate('Section title')}}</label>
							<div class="col-md-9">
								<input type="hidden" name="types[]" value="home_shop_section_2_title">
								<input type="text" placeholder="" name="home_shop_section_2_title" value="{{ get_setting('home_shop_section_2_title') }}" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 col-from-label">{{translate('Select shop')}}</label>
							<div class="col-md-9">
								<input type="hidden" name="types[]" value="home_shop_section_2_shops">
								<select name="home_shop_section_2_shops[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_shop_section_2_shops') }}" data-container="body">
									@foreach ($all_shops as $key => $shop)
										<option value="{{ $shop->id }}">{{ $shop->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="text-right">
							<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		{{-- shop banner section 2 --}}
		<div class="card border-bottom">
			<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseHomeShopBannerTwo" aria-expanded="true" aria-controls="collapseHomeShopBannerTwo">
				<h6 class="my-2">{{ translate('Home shop banner section 2') }}</h6>
				<i class="las la-angle-down opacity-60 fs-20"></i>
			</div>
			<div id="collapseHomeShopBannerTwo" class="collapse" data-parent="#accordionExample">
				<div class="card-body">
					<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-group row gutters-10">
							<div class="col-lg-3">
								<label class="from-label d-block">{{translate('Banner image & link')}}</label>
								<small>{{ translate('Recommended size').' 1300x350' }}</small>
							</div>
							<div class="col-lg-9">
								<div class="home-banner-3-target">
									<input type="hidden" name="types[]" value="home_shop_banner_2_images">
									<input type="hidden" name="types[]" value="home_shop_banner_2_links">
									@if (get_setting('home_shop_banner_2_images') != null)
									@foreach (json_decode(get_setting('home_shop_banner_2_images'), true) as $key => $value)
										<div class="row">
											<div class="col-lg-5">
												<div class="form-group">
													<div class="input-group" data-toggle="aizuploader" data-type="image">
														<div class="input-group-prepend">
															<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
														</div>
														<div class="form-control file-amount">{{ translate('Choose File') }}</div>
														<input type="hidden" name="home_shop_banner_2_images[]" class="selected-files" value="{{ $value }}">
													</div>
													<div class="file-preview box sm"></div>
												</div>
											</div>
											<div class="col-lg">
												<input type="text" placeholder="" name="home_shop_banner_2_links[]" value="{{ json_decode(get_setting('home_shop_banner_2_links'),true)[$key] }}" class="form-control">
											</div>
											<div class="col-auto">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
													<i class="las la-times"></i>
												</button>
											</div>
										</div>
									@endforeach
									@endif
								</div>
								<div class="text-right">
									<button
										type="button"
										class="btn btn-soft-secondary btn-sm"
										data-toggle="add-more"
										data-content='<div class="row gutters-5">
											<div class="col-lg-5">
												<div class="form-group">
													<div class="input-group" data-toggle="aizuploader" data-type="image">
														<div class="input-group-prepend">
															<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
														</div>
														<div class="form-control file-amount">{{ translate('Choose File') }}</div>
														<input type="hidden" name="home_shop_banner_2_images[]" class="selected-files">
													</div>
													<div class="file-preview box sm"></div>
												</div>
											</div>
											<div class="col-lg">
												<input type="text" placeholder="" name="home_shop_banner_2_links[]" class="form-control">
											</div>
											<div class="col-auto">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
													<i class="las la-times"></i>
												</button>
											</div>
										</div>'
										data-target=".home-banner-3-target">
										{{ translate('Add New') }}
									</button>
								</div>
							</div>
						</div>
						<div class="text-right">
							<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		{{-- shop section 3 --}}
		<div class="card border-bottom">
			<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseShopSectionThree" aria-expanded="true" aria-controls="collapseShopSectionThree">
				<h6 class="my-2">{{ translate('Shop section 3') }}</h6>
				<i class="las la-angle-down opacity-60 fs-20"></i>
			</div>
			<div id="collapseShopSectionThree" class="collapse" data-parent="#accordionExample">
				<div class="card-body">
					<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-group row">
							<label class="col-md-3 col-from-label">{{translate('Section title')}}</label>
							<div class="col-md-9">
								<input type="hidden" name="types[]" value="home_shop_section_3_title">
								<input type="text" placeholder="" name="home_shop_section_3_title" value="{{ get_setting('home_shop_section_3_title') }}" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 col-from-label">{{translate('Select shop')}}</label>
							<div class="col-md-9">
								<input type="hidden" name="types[]" value="home_shop_section_3_shops">
								<select name="home_shop_section_3_shops[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_shop_section_3_shops') }}" data-container="body">
									@foreach ($all_shops as $key => $shop)
										<option value="{{ $shop->id }}">{{ $shop->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="text-right">
							<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	@endif

	<!-- Product section 3 -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseProductSectionThree" aria-expanded="true" aria-controls="collapseProductSectionThree">
			<h6 class="my-2">{{ translate('Product section 3') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseProductSectionThree" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Section title')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_product_section_3_title">
							<input type="text" placeholder="" name="home_product_section_3_title" value="{{ get_setting('home_product_section_3_title') }}" class="form-control">
						</div>
					</div>
					<div class="form-group row gutters-10">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('Banner image & link')}}</label>
							<small>{{ translate('Recommended size').' 200x310' }}</small>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<div class="input-group" data-toggle="aizuploader" data-type="image">
									<div class="input-group-prepend">
										<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
									</div>
									<div class="form-control file-amount">{{ translate('Choose File') }}</div>
									<input type="hidden" name="types[]" value="home_product_section_3_banner_img">
									<input type="hidden" name="home_product_section_3_banner_img" class="selected-files" value="{{ get_setting('home_product_section_3_banner_img') }}">
								</div>
								<div class="file-preview box sm"></div>
							</div>
						</div>
						<div class="col-lg-5">
							<input type="hidden" name="types[]" value="home_product_section_3_banner_link">
							<input type="text" placeholder="" name="home_product_section_3_banner_link" value="{{ get_setting('home_product_section_3_banner_link') }}" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Select product')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_product_section_3_products">
							<select name="home_product_section_3_products[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_product_section_3_products') }}" data-container="body">
								@foreach ($all_products as $key => $product)
									<option value="{{ $product->id }}">{{ $product->getTranslation('name') }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Home banner section 3 -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseHomeBannerThree" aria-expanded="true" aria-controls="collapseHomeBannerThree">
			<h6 class="my-2">{{ translate('Home banner section 3') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseHomeBannerThree" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row gutters-10">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('Banner image & link')}}</label>
							<small>{{ translate('Recommended size').' 420x145' }}</small>
						</div>
						<div class="col-lg-9">
							<div class="home-banner-3-target">
								<input type="hidden" name="types[]" value="home_banner_3_images">
								<input type="hidden" name="types[]" value="home_banner_3_links">
								@if (get_setting('home_banner_3_images') != null)
								@foreach (json_decode(get_setting('home_banner_3_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_banner_3_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_banner_3_links[]" value="{{ json_decode(get_setting('home_banner_3_links'),true)[$key] }}" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>
								@endforeach
								@endif
							</div>
							<div class="text-right">
								<button
									type="button"
									class="btn btn-soft-secondary btn-sm"
									data-toggle="add-more"
									data-content='<div class="row gutters-5">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_banner_3_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_banner_3_links[]" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".home-banner-3-target">
									{{ translate('Add New') }}
								</button>
							</div>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	@if (addon_is_activated('multi_vendor'))
		{{-- shop section 4 --}}
		<div class="card border-bottom">
			<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseShopSectionFour" aria-expanded="true" aria-controls="collapseShopSectionFour">
				<h6 class="my-2">{{ translate('Shop section 4') }}</h6>
				<i class="las la-angle-down opacity-60 fs-20"></i>
			</div>
			<div id="collapseShopSectionFour" class="collapse" data-parent="#accordionExample">
				<div class="card-body">
					<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-group row">
							<label class="col-md-3 col-from-label">{{translate('Section title')}}</label>
							<div class="col-md-9">
								<input type="hidden" name="types[]" value="home_shop_section_4_title">
								<input type="text" placeholder="" name="home_shop_section_4_title" value="{{ get_setting('home_shop_section_4_title') }}" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 col-from-label">{{translate('Select shop')}}</label>
							<div class="col-md-9">
								<input type="hidden" name="types[]" value="home_shop_section_4_shops">
								<select name="home_shop_section_4_shops[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_shop_section_4_shops') }}" data-container="body">
									@foreach ($all_shops as $key => $shop)
										<option value="{{ $shop->id }}">{{ $shop->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="text-right">
							<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	@endif

	<!-- Product section 4 -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseProductSectionFour" aria-expanded="true" aria-controls="collapseProductSectionFour">
			<h6 class="my-2">{{ translate('Product section 4') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseProductSectionFour" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Section title')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_product_section_4_title">
							<input type="text" placeholder="" name="home_product_section_4_title" value="{{ get_setting('home_product_section_4_title') }}" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Select product')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_product_section_4_products">
							<select name="home_product_section_4_products[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_product_section_4_products') }}" data-container="body">
								@foreach ($all_products as $key => $product)
									<option value="{{ $product->id }}">{{ $product->getTranslation('name') }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	@if (addon_is_activated('multi_vendor'))
		{{-- shop section 5 --}}
		<div class="card border-bottom">
			<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseShopSectionFive" aria-expanded="true" aria-controls="collapseShopSectionFive">
				<h6 class="my-2">{{ translate('Shop section 5') }}</h6>
				<i class="las la-angle-down opacity-60 fs-20"></i>
			</div>
			<div id="collapseShopSectionFive" class="collapse" data-parent="#accordionExample">
				<div class="card-body">
					<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-group row">
							<label class="col-md-3 col-from-label">{{translate('Section title')}}</label>
							<div class="col-md-9">
								<input type="hidden" name="types[]" value="home_shop_section_5_title">
								<input type="text" placeholder="" name="home_shop_section_5_title" value="{{ get_setting('home_shop_section_5_title') }}" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 col-from-label">{{translate('Select shop')}}</label>
							<div class="col-md-9">
								<input type="hidden" name="types[]" value="home_shop_section_5_shops">
								<select name="home_shop_section_5_shops[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_shop_section_5_shops') }}" data-container="body">
									@foreach ($all_shops as $key => $shop)
										<option value="{{ $shop->id }}">{{ $shop->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="text-right">
							<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		{{-- shop banner section 2 --}}
		<div class="card border-bottom">
			<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseHomeShopBannerThree" aria-expanded="true" aria-controls="collapseHomeShopBannerThree">
				<h6 class="my-2">{{ translate('Home shop banner section 3') }}</h6>
				<i class="las la-angle-down opacity-60 fs-20"></i>
			</div>
			<div id="collapseHomeShopBannerThree" class="collapse" data-parent="#accordionExample">
				<div class="card-body">
					<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-group row gutters-10">
							<div class="col-lg-3">
								<label class="from-label d-block">{{translate('Banner image & link')}}</label>
								<small>{{ translate('Recommended size').' 640x290' }}</small>
							</div>
							<div class="col-lg-9">
								<div class="home-banner-3-target">
									<input type="hidden" name="types[]" value="home_shop_banner_3_images">
									<input type="hidden" name="types[]" value="home_shop_banner_3_links">
									@if (get_setting('home_shop_banner_3_images') != null)
									@foreach (json_decode(get_setting('home_shop_banner_3_images'), true) as $key => $value)
										<div class="row">
											<div class="col-lg-5">
												<div class="form-group">
													<div class="input-group" data-toggle="aizuploader" data-type="image">
														<div class="input-group-prepend">
															<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
														</div>
														<div class="form-control file-amount">{{ translate('Choose File') }}</div>
														<input type="hidden" name="home_shop_banner_3_images[]" class="selected-files" value="{{ $value }}">
													</div>
													<div class="file-preview box sm"></div>
												</div>
											</div>
											<div class="col-lg">
												<input type="text" placeholder="" name="home_shop_banner_3_links[]" value="{{ json_decode(get_setting('home_shop_banner_3_links'),true)[$key] }}" class="form-control">
											</div>
											<div class="col-auto">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
													<i class="las la-times"></i>
												</button>
											</div>
										</div>
									@endforeach
									@endif
								</div>
								<div class="text-right">
									<button
										type="button"
										class="btn btn-soft-secondary btn-sm"
										data-toggle="add-more"
										data-content='<div class="row gutters-5">
											<div class="col-lg-5">
												<div class="form-group">
													<div class="input-group" data-toggle="aizuploader" data-type="image">
														<div class="input-group-prepend">
															<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
														</div>
														<div class="form-control file-amount">{{ translate('Choose File') }}</div>
														<input type="hidden" name="home_shop_banner_3_images[]" class="selected-files">
													</div>
													<div class="file-preview box sm"></div>
												</div>
											</div>
											<div class="col-lg">
												<input type="text" placeholder="" name="home_shop_banner_3_links[]" class="form-control">
											</div>
											<div class="col-auto">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
													<i class="las la-times"></i>
												</button>
											</div>
										</div>'
										data-target=".home-banner-3-target">
										{{ translate('Add New') }}
									</button>
								</div>
							</div>
						</div>
						<div class="text-right">
							<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	@endif

	<!-- Product section 5 -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseProductSectionFive" aria-expanded="true" aria-controls="collapseProductSectionFive">
			<h6 class="my-2">{{ translate('Product section 5') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseProductSectionFive" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Section title')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_product_section_5_title">
							<input type="text" placeholder="" name="home_product_section_5_title" value="{{ get_setting('home_product_section_5_title') }}" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Select product')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_product_section_5_products">
							<select name="home_product_section_5_products[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_product_section_5_products') }}" data-container="body">
								@foreach ($all_products as $key => $product)
									<option value="{{ $product->id }}">{{ $product->getTranslation('name') }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Home banner section 4 -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseHomeBannerFour" aria-expanded="true" aria-controls="collapseHomeBannerFour">
			<h6 class="my-2">{{ translate('Home banner section 4') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseHomeBannerFour" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row gutters-10">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('Banner image & link')}}</label>
							<small>{{ translate('Recommended size').' 310x145' }}</small>
						</div>
						<div class="col-lg-9">
							<div class="home-banner-4-target">
								<input type="hidden" name="types[]" value="home_banner_4_images">
								<input type="hidden" name="types[]" value="home_banner_4_links">
								@if (get_setting('home_banner_4_images') != null)
								@foreach (json_decode(get_setting('home_banner_4_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_banner_4_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_banner_4_links[]" value="{{ json_decode(get_setting('home_banner_4_links'),true)[$key] }}" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>
								@endforeach
								@endif
							</div>
							<div class="text-right">
								<button
									type="button"
									class="btn btn-soft-secondary btn-sm"
									data-toggle="add-more"
									data-content='<div class="row gutters-5">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_banner_4_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_banner_4_links[]" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".home-banner-4-target">
									{{ translate('Add New') }}
								</button>
							</div>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Product section 6 -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseProductSectionSix" aria-expanded="true" aria-controls="collapseProductSectionSix">
			<h6 class="my-2">{{ translate('Product section 6') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseProductSectionSix" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Section title')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_product_section_6_title">
							<input type="text" placeholder="" name="home_product_section_6_title" value="{{ get_setting('home_product_section_6_title') }}" class="form-control">
						</div>
					</div>
					<div class="form-group row gutters-10">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('Banner image & link')}}</label>
							<small>{{ translate('Recommended size').' 280x310' }}</small>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<div class="input-group" data-toggle="aizuploader" data-type="image">
									<div class="input-group-prepend">
										<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
									</div>
									<div class="form-control file-amount">{{ translate('Choose File') }}</div>
									<input type="hidden" name="types[]" value="home_product_section_6_banner_img">
									<input type="hidden" name="home_product_section_6_banner_img" class="selected-files" value="{{ get_setting('home_product_section_6_banner_img') }}">
								</div>
								<div class="file-preview box sm"></div>
							</div>
						</div>
						<div class="col-lg-5">
							<input type="hidden" name="types[]" value="home_product_section_6_banner_link">
							<input type="text" placeholder="" name="home_product_section_6_banner_link" value="{{ get_setting('home_product_section_6_banner_link') }}" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Select product')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_product_section_6_products">
							<select name="home_product_section_6_products[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_product_section_6_products') }}" data-container="body">
								@foreach ($all_products as $key => $product)
									<option value="{{ $product->id }}">{{ $product->getTranslation('name') }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>


	<!-- About  -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#homeAboutText" aria-expanded="true" aria-controls="homeAboutText">
			<h6 class="my-2">{{ translate('Home bottom about text') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="homeAboutText" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>{{ translate('About description') }}</label>
						<input type="hidden" name="types[]" value="home_about_us">
						<textarea class="aiz-text-editor form-control" name="home_about_us" placeholder="Type.." data-min-height="350">
							{!! get_setting('home_about_us') !!}
						</textarea>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
@endsection
