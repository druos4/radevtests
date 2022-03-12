@extends('layouts.client')
@section('css')
    <style>

    </style>
@endsection
@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <br />
            <h1 class="block-title">
                <span class="title-angle-shap"> {{ trans('register.title') }} </span>
            </h1>

                    <form method="POST" id="register-form" action="{{ route('register') }}">
                        @csrf
                        <input type="hidden" name="ghost" id="ghost" value="">
                        <div class="form-group row">
                            <label for="nickname" class="col-md-4 col-form-label text-md-right">{{ trans('register.nickname') }}</label>
                            <div class="col-md-6">
                                <input id="nickname" type="text" class="form-control{{ $errors->has('nickname') ? ' is-invalid' : '' }}" name="nickname" value="{{ old('nickname') }}" autofocus>
                                <small id="nicknameHelp" class="form-text text-muted">{{ trans('register.nickname-tip') }}</small>
                                @if ($errors->has('nickname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nickname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ trans('register.surname') }}</label>
                            <div class="col-md-6">
                                <input id="surname" type="text" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" value="{{ old('surname') }}">
                                @if ($errors->has('surname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ trans('register.name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ trans('register.midname') }}</label>
                            <div class="col-md-6">
                                <input id="middlename" type="text" class="form-control{{ $errors->has('middlename') ? ' is-invalid' : '' }}" name="middlename" value="{{ old('middlename') }}" >
                                @if ($errors->has('middlename'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('middlename') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ trans('register.email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ trans('register.password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ trans('register.password2') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        {{--
                        <div class="form-group row">
                            <label for="captcha" class="col-md-4 col-form-label text-md-right captcha">

                                    <span>{!! captcha_img() !!}</span>
                                    <button type="button" class="btn btn-orange" class="reload" id="reload">
                                        &#x21bb;
                                    </button>
                            </label>
                            <div class="col-md-6">
                                <input id="captcha" type="text" class="form-control" name="captcha" required>
                                @if ($errors->has('captcha'))
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ trans('register.incorrect-captcha') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
--}}
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-orange btn-register">
                                    {{ trans('register.title') }}
                                </button>
                            </div>
                        </div>
                    </form>

        </div>
    </div>
</div>
@endsection
@section('scripts')
    @parent
    <script>
        /*
        $('.btn-register').click(function (e) {
            e.preventDefault();
            var flag = true;
            var pass = $('#password').val();
            var pass2 = $('#password-confirm').val();

            if(pass != '' && pass != pass2){
                flag = false;


            }

            if(flag == true){
                $('#register-form').submit();
            }
        });
*/
        function getCaptcha()
        {
            $.ajax({
                type: 'GET',
                url: '/reload-captcha',
                success: function (data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        }
        getCaptcha();
        getCaptcha();
        $('#reload').click(function () {
            getCaptcha();
        });
/*
        $('.btn-register').click(function (e) {
            e.preventDefault();
            var cap = $('#captcha').val();
            $.ajax({
                type: 'POST',
                url: '/captcha-validation',
                data:{captcha:cap},
                success: function (data) {
                    if(data.valid == true){

                        $('#register-form').submit();
                    } else {

                    }




                }
            });
        });*/


    </script>
@endsection
