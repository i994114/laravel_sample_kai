@component('components.form')
  @slot('route')
    {{ route('drills.store') }}
  @endslot

  @slot('title')
    {{ old('title') }}
  @endslot

  @slot('category_name')
    {{ old('category_name') }}
  @endslot

  @slot('problem_value')
    @for ($i = 1; $i <= 10; $i++)
      <div class="form-group row">
        <label for="problem{{ $i - 1 }}" class="col-md-4 col-form-label text-md-right">{{ __('Problem').$i }}</label>

        <div class="col-md-6">
          <input id="problem{{ $i - 1 }}" type="text" class="form-control @error('problem'.($i-1)) is-invalid @enderror" name="problem{{ $i-1 }}" value="{{ old('problem'.($i - 1)) }}" autocomplete="problem{{ $i - 1 }}" autofocus>
          
          @error('problem'.($i - 1))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>
    @endfor
  @endslot


@endcomponent

