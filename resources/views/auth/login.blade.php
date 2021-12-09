@extends('layouts.app')

@section('content')
<section id="login">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Логин</label>
            <div>
                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <div>
                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
            </div>
        </div>

{{--        <div class="form-group">--}}
{{--            <div>--}}
{{--                <div class="form-check">--}}
{{--                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                    <label class="form-check-label" for="remember">--}}
{{--                        {{ __('Remember Me') }}--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>
            </div>
        </div>

    </form>
</section>
@endsection
