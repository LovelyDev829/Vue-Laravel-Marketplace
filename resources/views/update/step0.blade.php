@extends('backend.layouts.blank')
@section('content')
    <div class="container h-100 d-flex flex-column justify-content-center">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="mar-ver pad-btm text-center">
                            <img src="{{ static_asset('assets/img/logo.png') }}" class="mb-4">
                            <h1 class="h3">The Shop Update Process</h1>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('update.step1') }}" class="btn btn-primary text-light">
                                Update Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
