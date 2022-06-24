@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
    	<div class="row align-items-center">
    		<div class="col">
    			<h1 class="h3">{{ translate('Website Footer') }}</h1>
    		</div>
    	</div>
    </div>

    <div class="card">
    	<div class="card-header">
    		<h6 class="fw-600 mb-0">{{ translate('Footer Widget') }}</h6>
    	</div>
    	<div class="card-body">
    		<div class="row gutters-10">
				<div class="col-12">
    				<div class="card shadow-none bg-light">
    					<div class="card-header">
    						<h6 class="mb-0">{{ translate('Footer logo') }}</h6>
    					</div>
    					<div class="card-body">
    						<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
    							@csrf
    							<div class="form-group">
    			                    <label class="form-label" for="signinSrEmail">{{ translate('Logo') }}</label>
    			                    <div class="input-group " data-toggle="aizuploader" data-type="image">
    			                        <div class="input-group-prepend">
    			                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
    			                        </div>
    			                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
    									<input type="hidden" name="types[]" value="footer_logo">
    			                        <input type="hidden" name="footer_logo" class="selected-files" value="{{ get_setting('footer_logo') }}">
    			                    </div>
    								<div class="file-preview"></div>
    			                </div>
    							<div class="text-right">
    								<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
    							</div>
    						</form>
    					</div>
    				</div>
				</div>
                <div class="col-12">
                    <div class="card shadow-none bg-light">
    					<div class="card-header">
    						<h6 class="mb-0">{{ translate('Link widget one') }}</h6>
    					</div>
    					<div class="card-body">
                            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
    							<div class="form-group">
    								<label>{{ translate('Title') }}</label>
    								<input type="hidden" name="types[]" value="footer_link_one_title">
    								<input type="text" class="form-control" placeholder="{{ translate('Widget title') }}" name="footer_link_one_title" value="{{ get_setting('footer_link_one_title') }}">
    							</div>
    			                <div class="form-group">
    								<label>{{ translate('Links') }}</label>
    								<div class="w1-links-target">
    									<input type="hidden" name="types[]" value="footer_link_one_labels">
    									<input type="hidden" name="types[]" value="footer_link_one_links">
    									@if (get_setting('footer_link_one_labels') != null)
    										@foreach (json_decode(get_setting('footer_link_one_labels'), true) as $key => $value)
    											<div class="row gutters-5">
    												<div class="col-4">
    													<div class="form-group">
    														<input type="text" class="form-control" placeholder="{{ translate('Label') }}" name="footer_link_one_labels[]" value="{{ $value }}">
    													</div>
    												</div>
    												<div class="col">
    													<div class="form-group">
    														<input type="text" class="form-control" placeholder="" name="footer_link_one_links[]" value="{{ json_decode(get_setting('footer_link_one_links'), true)[$key] }}">
    													</div>
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
    								<button
    									type="button"
    									class="btn btn-soft-secondary btn-sm"
    									data-toggle="add-more"
    									data-content='<div class="row gutters-5">
    										<div class="col-4">
    											<div class="form-group">
    												<input type="text" class="form-control" placeholder="{{ translate('Label') }}" name="footer_link_one_labels[]">
    											</div>
    										</div>
    										<div class="col">
    											<div class="form-group">
    												<input type="text" class="form-control" placeholder="" name="footer_link_one_links[]">
    											</div>
    										</div>
    										<div class="col-auto">
    											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
    												<i class="las la-times"></i>
    											</button>
    										</div>
    									</div>'
    									data-target=".w1-links-target">
    									{{ translate('Add New') }}
    								</button>
    							</div>
    							<div class="text-right">
    								<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
    							</div>
    						</form>
    					</div>
    				</div>
    			</div>
                <div class="col-12">
                    <div class="card shadow-none bg-light">
    					<div class="card-header">
    						<h6 class="mb-0">{{ translate('Link widget two') }}</h6>
    					</div>
    					<div class="card-body">
                            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
    							<div class="form-group">
    								<label>{{ translate('Title') }}</label>
    								<input type="hidden" name="types[]" value="footer_link_two_title">
    								<input type="text" class="form-control" placeholder="{{ translate('Widget title') }}" name="footer_link_two_title" value="{{ get_setting('footer_link_two_title') }}">
    							</div>
    			                <div class="form-group">
    								<label>{{ translate('Links') }}</label>
    								<div class="w2-links-target">
    									<input type="hidden" name="types[]" value="footer_link_two_labels">
    									<input type="hidden" name="types[]" value="footer_link_two_links">
    									@if (get_setting('footer_link_two_labels') != null)
    										@foreach (json_decode(get_setting('footer_link_two_labels'), true) as $key => $value)
    											<div class="row gutters-5">
    												<div class="col-4">
    													<div class="form-group">
    														<input type="text" class="form-control" placeholder="{{ translate('Label') }}" name="footer_link_two_labels[]" value="{{ $value }}">
    													</div>
    												</div>
    												<div class="col">
    													<div class="form-group">
    														<input type="text" class="form-control" placeholder="" name="footer_link_two_links[]" value="{{ json_decode(get_setting('footer_link_two_links'), true)[$key] }}">
    													</div>
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
    								<button
    									type="button"
    									class="btn btn-soft-secondary btn-sm"
    									data-toggle="add-more"
    									data-content='<div class="row gutters-5">
    										<div class="col-4">
    											<div class="form-group">
    												<input type="text" class="form-control" placeholder="{{ translate('Label') }}" name="footer_link_two_labels[]">
    											</div>
    										</div>
    										<div class="col">
    											<div class="form-group">
    												<input type="text" class="form-control" placeholder="" name="footer_link_two_links[]">
    											</div>
    										</div>
    										<div class="col-auto">
    											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
    												<i class="las la-times"></i>
    											</button>
    										</div>
    									</div>'
    									data-target=".w2-links-target">
    									{{ translate('Add New') }}
    								</button>
    							</div>
    							<div class="text-right">
    								<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
    							</div>
    						</form>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-6">
                    <div class="card shadow-none bg-light">
    					<div class="card-header">
    						<h6 class="mb-0">{{ translate('Contact info widget') }}</h6>
    					</div>
    					<div class="card-body">
                            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
    							@csrf
                                <div class="form-group">
    								<label>{{ translate('Contact address') }}</label>
    								<input type="hidden" name="types[]" value="contact_address">
    								<input type="text" class="form-control" placeholder="{{ translate('Address') }}" name="contact_address" value="{{ get_setting('contact_address') }}">
    							</div>
                                <div class="form-group">
    								<label>{{ translate('Contact email') }}</label>
    								<input type="hidden" name="types[]" value="contact_email">
    								<input type="text" class="form-control" placeholder="{{ translate('Email') }}" name="contact_email" value="{{ get_setting('contact_email') }}">
    							</div>
                                <div class="form-group">
    								<label>{{ translate('Contact phone') }}</label>
    								<input type="hidden" name="types[]" value="contact_phone">
    								<input type="text" class="form-control" placeholder="{{ translate('Phone') }}" name="contact_phone" value="{{ get_setting('contact_phone') }}">
    							</div>
    							<div class="text-right">
    								<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
    							</div>
    						</form>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-6">
                    <div class="card shadow-none bg-light">
    					<div class="card-header">
    						<h6 class="mb-0">{{ translate('Mobile apps link') }}</h6>
    					</div>
    					<div class="card-body">
                            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
    							@csrf
                                <div class="form-group">
                                    <label>{{ translate('Play Store Link') }}</label>
                                    <input type="hidden" name="types[]" value="play_store_link">
                                    <input type="text" class="form-control" placeholder="" name="play_store_link" value="{{ get_setting('play_store_link') }}">
                                </div>
                                <div class="form-group">
                                    <label>{{ translate('App Store Link') }}</label>
                                    <input type="hidden" name="types[]" value="app_store_link">
                                    <input type="text" class="form-control" placeholder="" name="app_store_link" value="{{ get_setting('app_store_link') }}">
                                </div>
    							<div class="text-right">
    								<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
    							</div>
    						</form>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

    <div class="card">
    	<div class="card-header">
    		<h6 class="fw-600 mb-0">{{ translate('Footer Bottom') }}</h6>
    	</div>
        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
        	<div class="card-body">
				<div class="card shadow-none bg-light">
					<div class="card-header">
						<h6 class="mb-0">{{ translate('Footer menu') }}</h6>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label>{{ translate('Links') }}</label>
							<div class="footer-menu-target">
								<input type="hidden" name="types[]" value="footer_menu_labels">
								<input type="hidden" name="types[]" value="footer_menu_links">
								@if (get_setting('footer_menu_labels') != null)
									@foreach (json_decode(get_setting('footer_menu_labels'), true) as $key => $value)
										<div class="row gutters-5">
											<div class="col-4">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="{{ translate('Label') }}" name="footer_menu_labels[]" value="{{ $value }}">
												</div>
											</div>
											<div class="col">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="" name="footer_menu_links[]" value="{{ json_decode(get_setting('footer_menu_links'), true)[$key] }}">
												</div>
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
							<button
								type="button"
								class="btn btn-soft-secondary btn-sm"
								data-toggle="add-more"
								data-content='<div class="row gutters-5">
									<div class="col-4">
										<div class="form-group">
											<input type="text" class="form-control" placeholder="{{ translate('Label') }}" name="footer_menu_labels[]">
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<input type="text" class="form-control" placeholder="" name="footer_menu_links[]">
										</div>
									</div>
									<div class="col-auto">
										<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
											<i class="las la-times"></i>
										</button>
									</div>
								</div>'
								data-target=".footer-menu-target">
								{{ translate('Add New') }}
							</button>
						</div>
					</div>
				</div>
                <div class="card shadow-none bg-light">
                    <div class="card-header">
						<h6 class="mb-0">{{ translate('Copyright Widget ') }}</h6>
					</div>
                    <div class="card-body">
						<div class="form-group">
								<label>{{ translate('Copyright Text') }}</label>
								<input type="hidden" name="types[]" value="frontend_copyright_text">
								<textarea class="aiz-text-editor form-control" name="frontend_copyright_text" data-buttons='[["font", ["bold", "underline", "italic"]],["insert", ["link"]],["color", ["color"]],["view", ["undo","redo"]]]' placeholder="Type.." data-min-height="150">
								{!! get_setting('frontend_copyright_text') !!}
							</textarea>
						</div>
                    </div>
                </div>
                <div class="card shadow-none bg-light">
					<div class="card-header">
						<h6 class="mb-0">{{ translate('Social Link Widget ') }}</h6>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label>{{ translate('Social Links') }}</label>
							<input type="hidden" name="types[]" value="footer_social_link">
							@php
								$social_links = get_setting('footer_social_link')
									? json_decode(get_setting('footer_social_link'), true)
									: ['facebook-f' => null,'twitter' => null,'instagram' => null,'youtube' => null,'linkedin-in' => null];
							@endphp
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="lab la-facebook-f"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="" name="footer_social_link[facebook-f]" value="{{  $social_links['facebook-f'] }}">
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="lab la-twitter"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="" name="footer_social_link[twitter]" value="{{ $social_links['twitter'] }}">
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="lab la-instagram"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="" name="footer_social_link[instagram]" value="{{ $social_links['instagram'] }}">
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="lab la-youtube"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="" name="footer_social_link[youtube]" value="{{ $social_links['youtube'] }}">
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="lab la-linkedin-in"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="" name="footer_social_link[linkedin-in]" value="{{ $social_links['linkedin-in'] }}">
							</div>
						</div>
					</div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                </div>
            </div>
        </form>
	</div>
@endsection
