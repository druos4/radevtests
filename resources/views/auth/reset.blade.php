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
                    <span class="title-angle-shap"> {{ trans('auth.reset.title') }} </span>
                </h1>

                <p>{{ trans('auth.reset.info') }}</p>

                <form method="POST" action="{{getLocaleHrefPrefix()}}/password-reset">
                    @csrf
                    <div class="form-group">
                        <label for="email">{{ trans('auth.reset.email') }}</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} field-valid" name="email" value="{{ old('email') }}" required autofocus>

                    </div>
                    <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ trans('auth.reset.send') }}
                            </button>

                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @parent
    <script>


    </script>
@endsection
