@extends('layouts.app')

@section('content')
  <div class="container">
    <h2>
      {{ __('Drill list') }}(マイページは
      <a href="{{ route('drills.mypage') }}">こちら</a>
      )
    </h2>
    <div class="row">
      @foreach ($drills as $drill)
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title">{{ $drill->title }}</h3>
              <a href="{{ route('drills.show', $drill->id ) }}" class="btn btn-primary">{{ __('Go Practice') }}</a>
              <a href="{{ route('drills.edit', $drill->id ) }}" class="btn btn-primary">{{ __('Go Edit') }}</a>
              <form action="{{ route('drills.destroy', $drill->id) }}" method="post" class="d-inline">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger" onclick='return confirm("削除しますか？");'>{{ __('Go Delete') }}</button>
              </form>
    
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
  <div class="d-flex justify-content-center" style="margin-top: 20px">
    {{ $drills->links() }}
  </div>
  
@endsection