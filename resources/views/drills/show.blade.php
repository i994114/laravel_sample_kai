@extends('layouts.app')

@section('content')
  <div id="app">
    <example-component title="{{ __('Practice').'「'.$drill->title.'」' }}" :problem="{{$problem}}"></example-component>
  </div>

@endsection