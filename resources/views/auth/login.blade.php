@extends('layouts.app')
@section('title', 'Login')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="unstyled-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('doLogin') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="mb-2" for="phone">{{__('Phone Number')}}</label>
                            <input id="phone" type="tel" class="form-control" name="phone" value="{{ old('phone') }}" required autofocus>
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2" for="password">{{__('Password')}}</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{__('Login')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
