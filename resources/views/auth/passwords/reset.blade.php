@extends('layouts.auth')

@section('content')
<form id="formReset" class="login-form" action="{{ route('auth.doResetPassword') }}" method="POST">
    @csrf
    <div class="card mb-0 bg-transparent border-0 shadow-none">
        <div class="card-body">
            <div class="text-center justify-content-center align-items-center mb-3">
                <img src="{{asset('themes/images/logo/reset_password.png')}}" alt="" class="auth-logo">
            </div>
            <input type="hidden" id="EmployeeID" name="EmployeeID" value="{{encrypt($Employee->EmployeeID)}}">

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-prepend">
                        <span class="input-group-text auth-rounded auth-icon-round">
                            <i class="icon-user text-white auth-icon-bg"></i>
                        </span>
                    </span>
                    <input type="text" class="form-control keyFontUp auth-rounded auth-input-rounded border-left-0" readonly value="{{$Employee->EmployeeID}}">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-prepend">
                        <span class="input-group-text auth-rounded auth-icon-round">
                            <i class="icon-lock text-white auth-icon-bg"></i>
                        </span>
                    </span>
                    <input type="password" class="form-control {{ $errors->has('PasswordNew') ? ' border-danger' : '' }} auth-rounded auth-input-rounded border-left-0 border-right-0" id="PasswordNew" name="PasswordNew" placeholder="New Password" autocomplete="off">
                    @if ($errors->has('PasswordNew'))
                        <span class="form-text text-danger">{{ $errors->first('PasswordNew') }}</span>
                    @endif
                    <div class="input-group-append">
                        <button type="button" class="btn btn-light btn-eye auth-rounded auth-icon-rounded border-left-0" ><i class="icon-eye2 text-white auth-icon-bg"></i></button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-prepend">
                        <span class="input-group-text auth-rounded auth-icon-round">
                            <i class="icon-lock text-white auth-icon-bg"></i>
                        </span>
                    </span>
                    <input type="password" class="form-control {{ $errors->has('PasswordConfirm') ? ' border-danger' : '' }} auth-rounded auth-input-rounded border-left-0 border-right-0" id="PasswordConfirm" name="PasswordConfirm" placeholder="Confirm New Password" autocomplete="off">
                    @if ($errors->has('PasswordConfirm'))
                        <span class="form-text text-danger">{{ $errors->first('PasswordConfirm') }}</span>
                    @endif
                    <div class="input-group-append">
                        <button type="button" class="btn btn-light btn-eye-confirm auth-rounded auth-icon-rounded border-left-0" ><i class="icon-eye2 text-white auth-icon-bg"></i></button>
                    </div>
                </div>
            </div>

            <div class="form-group mt-3">
                <div class="input-group justify-content-center align-items-center">
                    <button type="submit" class="btn auth-btn">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('plugin')
    <script src="{{asset('js/pages/auth/reset_password.js')}}"></script>
@endsection
