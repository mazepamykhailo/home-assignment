@extends('layouts.app')

@section('content')

<div class="container">  

  <form method="POST" action="{{ route('record/store') }}">
    @csrf
    <div class="row mb-3">
        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
      <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>

      <div class="col-md-6">
          <input id="image" type="text" class="form-control @error('image') is-invalid @enderror" name="image" required autocomplete="image" autofocus>

          @error('image')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>
    </div>

    <div class="row mb-3">
      <label for="category" class="col-md-4 col-form-label text-md-end">{{ __('Category') }}</label>

      <div class="col-md-6"> 
          <select name="category_id"  id="category_id" class="form-control @error('category') is-invalid @enderror">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category }}</option>   
            @endforeach
          </select>
      </div>
    </div>

    <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Submit') }}
            </button>
        </div>
    </div>
  </form>
</div>
@endsection
