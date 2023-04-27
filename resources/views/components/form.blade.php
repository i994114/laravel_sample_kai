@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Drill Register') }}</div>

          <div class="card-body">
            <form method="POST" action="{{ $route }}">
              @method('PATCH')
              @csrf

              <div class="form-group row">
                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                <div class="col-md-6">
                  <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $title }}" autocomplete="title" autofocus>
                  @error('title')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="category_name" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

                <div class="col-md-6">
                  <input id="category_name" type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" value="{{ $category_name }}" autocomplete="category_name" autofocus>

                  @error('category_name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              {{$problem_value}}

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="button" class="btn btn-secondary" onclick="history.back();">
                    {{ __('Back') }}
                  </button>

                  <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection