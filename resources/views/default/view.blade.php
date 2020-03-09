@extends('layouts.main')

@section('title', $news->title)

@section('content')
    <h1>{{ $news->title }}</h1>
    @if(!empty($news->image))
        <img src="{{ $news->image }}" class="img-fluid"/>
    @endif
    {!! $news->content !!}
@endsection

