@extends('layouts.main')

@section('title', 'Список новостей')

@section('content')
    <h1>Список новостей</h1>
    <div class="row row-cols-2">
        @forelse($news as $newsItem)
            <div class="col">
                <div class="card mb-3">
                    @if(!empty($newsItem->image))
                        <img src="{{ $newsItem->image }}" class="card-img-top"/>
                    @endif
                    <div class="card-body">
                        <h5>{{ $newsItem->title }}</h5>
                        <p>
                            {{ Str::limit(strip_tags($newsItem->content), 200) }}
                            <a href="{{ route('view', ['id' => $newsItem->id]) }}">Подробнее</a>
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <p>Список пуст!</p>
        @endforelse
    </div>
    <div class="text-center">
        <div class="list-inline-item">
            {{ $news->links() }}
        </div>
    </div>
@endsection
