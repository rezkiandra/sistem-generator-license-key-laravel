@extends('layouts.app')
@section('title', 'Edit license')

@section('content')
  <h1 class="mb-4">Edit license</h1>

  <a href="{{ route('admin.licenses') }}" class="btn btn-primary mb-4">{{ 'Back to list' }}</a>
  <div class="row">
    <div class="col-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Edit specific license - {{ $response['message'] }}</h5>
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
          <form action="{{ route('license.update', $response['license']['key']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
              <label for="key" class="form-label">Key</label>
              <input type="text" id="key" name="key" class="form-control" disabled readonly
                value="{{ $response['license']['key'] }}">
            </div>
            <div class="mb-4">
              <label for="license_name" class="form-label">License name</label>
              <input type="text" id="license_name" name="license_name"
                class="form-control"value="{{ $response['license']['license_name'] ?? old('license_name') }}">
            </div>
            <div class="mb-4">
              <label for="domain_name" class="form-label">Domain name</label>
              <input type="text" id="domain_name" name="domain_name" class="form-control"
                value="{{ $response['license']['domain_name'] ?? old('domain_name') }}">
            </div>
            <div class="mb-4">
              <label for="duration_day" class="form-label">Duration day</label>
              <input type="number" id="duration_day" name="duration_day" class="form-control"
                value="{{ $response['license']['duration_day'] ?? old('duration_day') }}" min="1">
            </div>
            <div class="mb-4">
              <label for="is_active" class="form-label">Status</label>
              <select name="is_active" id="is_active" class="form-control">
                <option value="1" {{ old('is_active', $response['license']['is_active']) == 1 ? 'selected' : '' }}>
									Activated
                </option>
                <option value="0" {{ old('is_active', $response['license']['is_active']) == 0 ? 'selected' : '' }}>
                  Unactivated
                </option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary">
              <i class="align-center me-2" data-feather="save"></i>
              Update
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
