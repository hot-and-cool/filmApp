@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/show.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
  <div class="card">
    <div class="card-body d-flex">
      <section class='review-main'>
        <div class='base-info'>
          <p class='h2 title'>{{ $item['title'] }}<span class='small pl10'>({{ $release_year }}公開)</span> </p>
          <p class='mb10 original-title text-muted'>{{ $item['original_title']}}</p>
          <p>公開日:{{ $release_date }} / 制作:{{$item['production_countries'][0]['name']}} / 上映時間:{{ $item['runtime'] }}分</p>
          <p class='release-date'>ジャンル:
              @foreach ($item['genres'] as $genre)
                <span class="text-primary">{{ $genre['name'] }}</span>
                <span>/</span>
              @endforeach
          </p>
          <p id='star' class=''>tmdb評価({{ $item['vote_count'] }})<span class='h3 pl10 text-yellow'>★{{ $item['vote_average'] }}</span></p>
        </div>
        <div class="over-view">
          <h3>あらすじ</h3>
          @if (!empty($item['overview']))
          <p>{{ $item['overview'] }}</p>
          @else
          <p>作品のあらすじは秘密です。</p>
          @endif
        </div>
        <a href="{{ route('credit', ['id' => $id, 'search-movie' => $searchWord]) }}" class='btn btn-secondary'>キャスト一覧</a>
      </section>  
      <aside class='review-image pl10'>
      @empty($item['poster_path'])
        <img src= "{{ asset('images/sample-movie.png') }}">
      @else
			  <a href="{{ $item['homepage'] }}" target="_blank"><img src= "https://image.tmdb.org/t/p/w300{{ $item['poster_path'] }}" class="film-image"></a>
      @endempty
      </aside>
    </div>
    <div class="card-body similar-movies">
      <h3>関連作品</h3>
    @foreach ($similarMovies as $similarMovie)
      <div class="small-wrapper">
        <img class="image-size" src="https://image.tmdb.org/t/p/w200{{ $similarMovie['poster_path'] }}"></img>
      </div>
    @endforeach
    </div>
    <a href="{{ route('index', ['search-movie' => $searchWord]) }}" class='btn btn-info btn-back mb20'>一覧へ戻る</a>
  </div>
</div>

@endsection