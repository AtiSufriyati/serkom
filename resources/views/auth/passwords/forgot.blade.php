@extends('layouts.auth')

@section('content')
<form class="login-form" id="formForgot" novalidate>
    @csrf
    <div class="card mb-0 bg-transparent border-0 shadow-none">
        <div class="card-body">
            <div id="logo-app" class="text-center justify-content-center align-items-center mb-3">
                <img src="{{asset('themes/images/logo/change_password.png')}}" alt="ARJUNA" class="auth-logo">
                @if(App::environment() == 'local' || App::environment() == 'development')
                    <p class="text-right pr-4 mr-2 pt-1"><span class="badge badge-primary">DEVELOPMENT</span></p>
                @elseif(App::environment() == 'staging')
                    <p class="text-right pr-4 mr-2 pt-1"><span class="badge badge-warning">STAGING</span></p>
                @elseif(App::environment() == 'cloud')
                    <p class="text-right pr-4 mr-2 pt-1"><span class="badge badge-success">CLOUD</span></p>
                @elseif(App::environment() == 'backup')
                    <p class="text-right pr-4 mr-2 pt-1"><span class="badge badge-danger">BACKUP</span></p>
                @endif
            </div>
            <div class="auth-img-bottom"></div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text auth-rounded auth-icon-rounded">
                            <i class="icon-user text-white auth-icon-bg"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control keyFontUp {{ $errors->has('EmployeeID') ? ' border-danger' : '' }} auth-rounded auth-input-rounded border-left-0" name="EmployeeID" id="EmployeeID" placeholder="Employee ID" required autocomplete="off" >
                </div>
                @if ($errors->has('EmployeeID'))
                    <span class="form-text text-danger">{{ $errors->first('EmployeeID') }}</span>
                @endif
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text auth-rounded auth-icon-rounded">
                            <i class="icon-calendar22 text-white auth-icon-bg"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control {{ $errors->has('BirthDate') ? ' border-danger' : '' }} datepicker-birthdate auth-rounded auth-input-rounded border-left-0 BirthDate" id="BirthDate" name="BirthDate" placeholder="Birthdate" required autocomplete="off" readonly>
                </div>
                @if ($errors->has('BirthDate'))
                    <span class="form-text text-danger">{{ $errors->first('BirthDate') }}</span>
                @endif
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6 d-none d-sm-block pt-0 pb-0 mt-0 mb-0">
                        <span class="form-text text-white text-left auth-link">
                            <a href="javascript:void(0)" onclick="return assistanceForgotPass();">Need Assistance?</a>
                        </span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 pt-0 pb-0 mt-0 mb-0">
                        <span class="form-text text-white text-right auth-link">
                            <a href="{{route('auth.login')}}">Back to login</a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group mt-3">
                <div class="input-group justify-content-center align-items-center">
                    <button type="submit" class="btn button-submit auth-btn" id="auth-btn">Submit</button>
                </div>
            </div>

        </div>
    </div>
</form>
@endsection
@section('plugin')
<script src="{{asset('js/pages/auth/forgot_password.js')}}"></script>
@endsection
