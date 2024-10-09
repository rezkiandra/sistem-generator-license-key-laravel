@extends('layouts.app')
@section('title', 'Create License')

@section('content')
  <h1 class="mb-4">Create license</h1>

  <a href="{{ route('admin.licenses') }}" class="btn btn-primary mb-4">{{ 'Back to list' }}</a>
  <div class="row">
    <div class="col-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Create new license</h5>
        </div>

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="card-body">
          <form action="{{ route('license.generate') }}" method="POST">
            @csrf
            <div class="mb-4">
              <label for="license_name" class="form-label">License name</label>
              <input type="text" id="license_name" name="license_name"
                class="form-control"value="{{ old('license_name') }}" placeholder="Enter license name">
            </div>
            <div class="mb-4">
              <label for="duration_day" class="form-label">Durasi Day</label>
              <input type="number" id="duration_day" name="duration_day" class="form-control"
                value="{{ old('duration_day') }}" min="1" placeholder="Enter duration day">
            </div>

            <button type="submit" class="btn btn-primary">
              <i class="align-center me-2" data-feather="save"></i>
              Submit
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
