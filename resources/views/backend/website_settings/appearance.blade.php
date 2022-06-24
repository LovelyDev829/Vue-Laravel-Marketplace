@extends('backend.layouts.app')

@section('content')

    <div class="row">
    	<div class="col-lg-8 mx-auto">
    		<div class="card">
    			<div class="card-header">
    				<h6 class="fw-600 mb-0">{{ translate('General') }}</h6>
    			</div>
    			<div class="card-body">
    				<form action="{{ route('settings.update') }}" method="POST">
    					@csrf
    	                <div class="form-group row">
    	                    <label class="col-sm-2 col-from-label">{{translate('Website Theme Color')}}</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="types[]" value="base_color">
        	                    <input type="text" name="base_color" class="form-control" placeholder="#377dff" value="{{ get_setting('base_color') }}">
        						<small class="text-muted">{{ translate('Hex Color Code') }}</small>
                            </div>
    	                </div>
    					<div class="text-right">
    						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
    					</div>
                    </form>
    			</div>
    		</div>
    		<div class="card">
    			<div class="card-header">
    				<h6 class="fw-600 mb-0">{{ translate('Global Seo') }}</h6>
    			</div>
    			<div class="card-body">
    				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
    					@csrf
    					<div class="form-group row">
    						<label class="col-sm-2 col-from-label">{{ translate('Meta Title') }}</label>
                            <div class="col-sm-10">
        						<input type="hidden" name="types[]" value="meta_title">
        						<input type="text" class="form-control" placeholder="Title" name="meta_title" value="{{ get_setting('meta_title') }}">
                            </div>
    					</div>
    					<div class="form-group row">
    						<label class="col-sm-2 col-from-label">{{ translate('Meta description') }}</label>
                            <div class="col-sm-10">
        						<input type="hidden" name="types[]" value="meta_description">
        						<textarea class="resize-off form-control" placeholder="Description" name="meta_description">{{  get_setting('meta_description') }}</textarea>
                            </div>
    					</div>
    					<div class="form-group row">
    						<label class="col-sm-2 col-from-label">{{ translate('Keywords') }}</label>
                            <div class="col-sm-10">
        						<input type="hidden" name="types[]" value="meta_keywords">
        						<textarea class="resize-off form-control" placeholder="Keyword, Keyword" name="meta_keywords">{{ get_setting('meta_keywords') }}</textarea>
        						<small class="text-muted">{{ translate('Separate with coma') }}</small>
                            </div>
    					</div>
    					<div class="form-group row">
    						<label class="col-sm-2 col-from-label">{{ translate('Meta Image') }}</label>
                            <div class="col-sm-10">
        						<div class="input-group " data-toggle="aizuploader" data-type="image">
        							<div class="input-group-prepend">
        								<div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}</div>
        							</div>
        							<div class="form-control file-amount">{{ translate('Choose File') }}</div>
        							<input type="hidden" name="types[]" value="meta_image">
        							<input type="hidden" name="meta_image" value="{{ get_setting('meta_image') }}" class="selected-files">
        						</div>
        						<div class="file-preview box"></div>
                            </div>
    					</div>
    					<div class="text-right">
    						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
    					</div>
    				</form>
    			</div>
    		</div>
			<div class="card">
                <div class="card-header">
                    <h6 class="fw-600 mb-0">{{ translate('Custom CSS & Script') }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Custom css for website') }}</label>
                            <div class="col-md-8">
                                <input type="hidden" name="types[]" value="web_custom_css">
                                <textarea name="web_custom_css" rows="8" class="form-control" placeholder="<style>&#10;...&#10;</style>">{{ get_setting('web_custom_css') }}</textarea>
                                <small class="">{{ translate('Write css with') .' <style> '. translate('tag') }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Header custom script - before').' </head>' }}</label>
                            <div class="col-md-8">
                                <input type="hidden" name="types[]" value="header_script">
                                <textarea name="header_script" rows="6" class="form-control" placeholder="<script>&#10;...&#10;</script>">{{ get_setting('header_script') }}</textarea>
                                <small class="">{{ translate('Write script with') .' <script> '. translate('tag') }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Footer custom script - before') .' </body>' }}</label>
                            <div class="col-md-8">
                                <input type="hidden" name="types[]" value="footer_script">
                                <textarea name="footer_script" rows="6" class="form-control" placeholder="<script>&#10;...&#10;</script>">{{ get_setting('footer_script') }}</textarea>
                                <small class="">{{  translate('Write script with') .' <script> '. translate('tag') }}</small>
                            </div>
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
