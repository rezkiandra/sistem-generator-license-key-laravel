@extends('layouts.auth')
@section('title', 'Login')

@section('content')
  <div class="text-center mt-4">
    <h1 class="h2">Welcome back!</h1>
    <p class="lead">
      Sign in to your account to continue
    </p>
  </div>

  <div class="card">
    <div class="card-body">
      @if ($errors->any())
        <div class="alert alert-danger">
          <upl>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </upl>
        </div>
      @endif
      <div class="m-sm-3">
        <form action="{{ route('login.action') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input class="form-control form-control-lg" id="email" type="email" name="email"
              placeholder="Enter your email" value="{{ old('email') }}" />
          </div>
          <div class="mb-5">
            <label class="form-label" for="password">Password</label>
            <input class="form-control form-control-lg" id="password" type="password" name="password"
              placeholder="Enter your password" value="{{ old('password') }}" />
          </div>
          <div class="d-grid gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Sign in</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- <div class="text-center mb-3">
    Don't have an account? <a href="pages-sign-up.html">Sign up</a>
  </div> --}}
@endsection
