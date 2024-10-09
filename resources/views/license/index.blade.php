@extends('layouts.app')
@section('title', 'Licenses')

@section('content')
  <h1 class="mb-4">Licenses list</h1>

  <a href="{{ route('license.create') }}" class="btn btn-primary">{{ 'Create new' }}</a>
  @if (session('success'))
    <div class="alert alert-success mt-4">
      {{ session('success') }}
    </div>
  @else
    <div class="alert alert-danger mt-4">
      {{ session('error') }}
    </div>
  @endif

  @if ($data['licenses'] != null)
    <table class="table mt-4" id="myTable">
      <thead>
        <tr>
          <th scope="col">License name</th>
          <th scope="col">Key</th>
          <th scope="col">Domain name</th>
          <th scope="col">Remaining days</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data['licenses'] as $license)
          <tr>
            <td>{{ $license['license_name'] }}</td>
            <td>{{ $license['key'] }}</td>
            <td>
              <a href="{{ $license['domain_name'] }}">{{ $license['domain_name'] }}</a>
            </td>
            <td>
              @if ($license['duration_day'] == 1)
                {{ 'Expire in tomorrow' }}
              @elseif ($license['duration_day'] > 1)
                {{ intval(\Carbon\Carbon::now()->diffInDays($license['expired_at'], false)) . ' day' }}
              @endif
            </td>
            <td>
              @if ($license['is_active'] == 0)
                {{ 'Unactivated' }}
              @else
                {{ 'Activated' }}
              @endif
            </td>
            <td class="d-flex d-lg-flex d-md-flex gap-2 align-items-center justify-content-center">
              <a href="{{ route('license.edit', $license['key']) }}" class="btn btn-primary">Edit</a>
              <form action="{{ route('license.destroy', $license['key']) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p class="text-capitalize text-center mt-4">No licenses available</p>
  @endif
@endsection

@push('css')
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.min.css">
@endpush

@push('js')
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#myTable').DataTable({
        ordering: false,
        pageLength: 15,
        lengthMenu: [15, 50, 100],
      });
    });
  </script>
@endpush
