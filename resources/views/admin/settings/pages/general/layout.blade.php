@extends('admin.settings.setting-layout')
@section('title')
    {{ __('settings') }}
@endsection

@section('website-settings')
<div class="row pt-3 gutters-sm">
    <div class="col-md-3 d-md-block">
        <div class="card">
            <div class="card-body">
                <nav class="nav flex-column nav-pills nav-gap-y-1">
                    <a href="{{ route('settings.general') }}"
                        class="nav-item nav-link has-icon nav-link-faded {{ Route::is('settings.general') ? 'active':'' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-circle mr-2">
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        <span>{{ __('brand_information') }}</span>
                    </a>
                    <a href="{{ route('settings.general.app.config') }}"
                        class="nav-item nav-link has-icon nav-link-faded {{ Route::is('settings.general.app.config') ? 'active':'' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tool mr-2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                        <span>{{ __('app_configuration') }}</span>
                    </a>
                    <a href="{{ route('settings.general.recaptcha') }}"
                        class="nav-item nav-link has-icon nav-link-faded {{ Route::is('settings.general.recaptcha') ? 'active':'' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield mr-2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        <span>{{ __('recaptcha_configuration') }}</span>
                    </a>
                    <a href="{{ route('settings.general.watermark') }}"
                        class="nav-item nav-link has-icon nav-link-faded {{ Route::is('settings.general.watermark') ? 'active':'' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-droplet mr-2"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>
                        <span>{{ __('watermark_on_ads_images') }}</span>
                    </a>
                    <a href="{{ route('settings.general.broadcasting') }}"
                        class="nav-item nav-link has-icon nav-link-faded {{ Route::is('settings.general.broadcasting') ? 'active':'' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2 mr-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                        <span>{{ __('broadcasting') }}</span>
                    </a>
                    <a href="{{ route('settings.general.push-notification') }}"
                        class="nav-item nav-link has-icon nav-link-faded {{ Route::is('settings.general.push-notification') ? 'active':'' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle mr-2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span>{{ __('push_notification') }}</span>
                    </a>
                    <a href="{{ route('settings.general.pwa') }}"
                        class="nav-item nav-link has-icon nav-link-faded {{ Route::is('settings.general.pwa') ? 'active':'' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27"><path fill="currentColor" d="M20.597 7.482L24 16.518h-2.51l-.58-1.618h-3.246l.694-1.754h2.002l-.95-2.66l1.188-3.004zm-8.111 0l1.772 5.84l2.492-5.84h2.415l-3.643 9.036H13.14l-1.64-5.237l-1.72 5.237H7.404L6.17 14.402l1.214-3.742l1.342 2.661l1.903-5.839h1.857zm-8.746 0c1.064 0 1.872.305 2.424.917a2.647 2.647 0 0 1 .28.368L5.37 12.08l-.385 1.185c-.352.1-.753.151-1.204.151H2.293v3.102H0V7.482zm-.58 1.753h-.866v2.428h.86c.557 0 .94-.12 1.148-.358c.19-.215.284-.506.284-.873c0-.364-.107-.654-.323-.871c-.216-.217-.583-.326-1.103-.326z"/></svg>

                        <span>{{ __('pwa_settings') }}</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content">
            <div class="tab-pane fade show active">
                @yield('general-setting')
                {{-- <div class="card">
                    <div class="card-body">
                        <h6>Brand Information</h6>
                        <hr>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
