@extends('layouts.app')
@section('title', 'APIs Consume')

@section('content')
  <h1>APIs Consume</h1>

  <div class="mt-4">
    <div class="d-flex justify-content-between mb-3">
      <div>
        <button class="btn btn-primary">
          <i class="align-middle me-1" data-feather="save"></i>
          Save
        </button>
      </div>
      <div class="d-flex flex-row justify-content-end align-items-center gap-2">
        <span class="alert alert-info" id="alertMessage"></span>
        <button id="copyButton" class="btn btn-info">
          <i class="align-middle me-1" data-feather="copy"></i>
          Copy
        </button>
      </div>
    </div>
    <div class="border rounded" id="container-json">
      <pre id="jsonCode" class="text-dark">{{ json_encode($data, JSON_PRETTY_PRINT, JSON_UNESCAPED_SLASHES) }}</pre>
    </div>
  </div>
@endsection

@push('css')
  <style>
    #container-json {
      overflow-x: auto;
      overflow-y: scroll;
      scroll-behavior: smooth;
      max-height: 60vh;
    }
  </style>
@endpush

@push('js')
  <script>
    let jsonCode = document.getElementById('jsonCode').innerText
    let copyButton = document.getElementById('copyButton')
    let alertMessage = document.getElementById('alertMessage')

    copyButton.addEventListener('click', () => {
      jsonCode.innerText
      const textarea = document.createElement('textarea')
      textarea.value = jsonCode
      document.body.appendChild(textarea)
      textarea.select()
      document.execCommand('copy')
      document.body.removeChild(textarea)

      alertMessage.innerText = 'Successfully copied!'
    })
  </script>
@endpush
