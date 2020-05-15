@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    @if(session('error'))
                        <h3 class="btn btn-danger">{{session('error')}}</h3>
                    @endif
                    <form method="POST" action="{{ route('auctions.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', 'House') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="starting_bid" class="col-md-4 col-form-label text-md-right">{{ __('Starting Bid') }}</label>

                            <div class="col-md-6">
                                <input id="starting_bid" type="number" class="form-control @error('starting_bid') is-invalid @enderror" name="starting_bid" value="{{ old('starting_bid', '1000') }}" required>

                                @error('starting_bid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_at" class="col-md-4 col-form-label text-md-right">{{ __('Starts At') }}</label>

                            <div class="col-md-6">
                                <input id="start_at" type="datetime-local" class="form-control @error('start_at') is-invalid @enderror" name="start_at" value="{{ old('start_at', date('Y-m-d\Th:i')) }}" required>

                                @error('start_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_at" class="col-md-4 col-form-label text-md-right">{{ __('Ends At') }}</label>

                            <div class="col-md-6">
                                <input id="end_at" type="datetime-local" class="form-control @error('end_at') is-invalid @enderror" name="end_at" value="{{ old('end_at', date('Y-m-d\Th:i')) }}" required>

                                @error('end_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>

                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" required>

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" rows="5" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', 'Hello') }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Submit') }}
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
