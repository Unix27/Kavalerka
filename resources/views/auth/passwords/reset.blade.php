@extends('site::layouts.site')

@section('content')
{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">{{ __('Reset Password') }}</div>--}}

{{--                <div class="card-body">--}}
{{--                    <form method="POST" action="{{ route('password.update') }}">--}}
{{--                        @csrf--}}

{{--                        <input type="hidden" name="token" value="{{ $token }}">--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>--}}

{{--                                @error('email')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">--}}

{{--                                @error('password')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row mb-0">--}}
{{--                            <div class="col-md-6 offset-md-4">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    {{ __('Reset Password') }}--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<main class="main"><div class="login">
        <div class="container">
            <div class="login__content">
                <div class="login__left">
                    <div class="login__inner">
                        <div class="login__header">
                            <div class="login__title title-default">{{ __('Reset Password') }}</div>
                        </div>
                        <div class="login__body">
                            <form method="POST" action="{{ route('password.update') }}" class="reset-password">

                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="login__inputs">
                                        <input
                                            type="hidden"
                                            name="email"
                                            id="login-email"
                                            value="{{ $email }}"
                                            required
                                        />
                                    <div class="login__input input-default">
                                        <label for="login-password">Пароль</label>
                                        <input
                                            type="password"
                                            name="password"
                                            id="login-password"
                                            class="password validatePassword"
                                            value=""
                                            placeholder="Password"
                                            required
                                        />
                                        <div
                                            class="icon-password icon__eye-close js-icon-password"
                                        ></div>
                                    </div>


                                    <div class="login__input input-default">
                                        <label for="login-password">Повторите пароль</label>
                                        <input
                                            type="password"
                                            name="password_confirmation"
                                            id="login-password"
                                            class="password password_confirmation"
                                            value=""
                                            placeholder="Password"
                                            required
                                        />
                                        <div
                                            class="icon-password icon__eye-close js-icon-password"
                                        ></div>
                                    </div>

                                </div>
                                <div class="errors"></div>
                                <div class="change-password__fits registration__fits">
                                    <div class="fit symbol">
                                        <div class="icon icon__check"></div>
                                        <span>8 символов</span>
                                    </div>
                                    <div class="fit number">
                                        <div class="icon icon__check"></div>
                                        <span>1 цифра</span>
                                    </div>
                                    <div class="fit spec_symbol">
                                        <div class="icon icon__check"></div>
                                        <span>1 спецсимвол</span>
                                    </div>
                                    <div class="fit с_symbol ">
                                        <div class="icon icon__check"></div>
                                        <span>1 большая буква</span>
                                    </div>
                                </div>
                                <div class="password-save errors"></div>
                                <div class="login__button">
                                    <button class="btn btn--atlantis">Изменить пароль</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="login__right">
                    <div class="login__main main-login">
                        <div class="main-login__content">
                            <div class="main-login__wrapper">
                                <div class="main-login__button">
                                </div>
                            </div>
                            <div class="main-login__image">
                                <img src="{{asset('assets/img/png/login/1.png')}}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
