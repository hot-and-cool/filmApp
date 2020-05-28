@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/show.css') }}" rel="stylesheet">
@endsection

@section('js')
      <script src="{{ asset('js/show.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
  <div class="card">
    <div class="card-body d-flex">
      <section class='review-main'>
        <div class='base-info'>
          <p class='h2 title'>{{ $item['title'] }}<span class='small pl10'>({{ $releaseYear }}公開)</span> </p>
          <p class='pb10 original-title text-muted'>{{ $item['original_title']}}</p>
          <p class='pb10'>公開日:{{ $item['release_date'] }} / @isset($item['production_countries'][0]) 制作:{{$item['production_countries'][0]['name']}} / @endisset 上映時間:{{ $item['runtime'] }}分</p>
          <p class='release-date pb10'>ジャンル:
              @foreach ($item['genres'] as $genre)
                <a href="#" class="text-primary">{{ $genre['name'] }}</a>
                <span>/</span>
              @endforeach
          </p>
          <p id='star' class=''>tmdb評価({{ $item['vote_count'] }})<span class='h3 pl10 text-yellow'>★{{ $item['vote_average'] }}</span></p>
        </div>
        <div class='over-view'>
          <h3>あらすじ</h3>
          @if (!empty($item['overview']))
          <p>{{ $item['overview'] }}</p>
          @else
          <p>作品のあらすじは秘密です。</p>
          @endif
        </div>
        <div class='crews pt30'>
          @if (isset($director))
          <div class="director">
            <p>監督</p>
            <a href="{{ route('person', ['person_id' => $director['id']]) }}" class='btn btn-secondary mb10'>{{ $director['name'] }}</a>
          </div>
          @endif
          @if (isset($writer))
          <div class="writer">
            <p>脚本</p>
            <a href="{{ route('person', ['person_id' => $writer['id']]) }}" class='btn btn-secondary mb10'>{{ $writer['name'] }}</a>
          </div>
          @endif
        </div>
        <div class='casts pt30'>
          <p>出演者</p>
        @foreach ($casts as $cast)
          <a href="{{ route('person', ['person_id' => $cast['id']]) }}" class='btn btn-secondary mb10'>{{ $cast['name'] }}</a>
        @endforeach
        </div>
      </section>
      <aside class='review-image pl10'>
      @empty($item['poster_path'])
        <img src= "{{ asset('images/sample-movie.png') }}">
      @else
			  <a href="{{ $item['homepage'] }}" target="_blank"><img src= "https://image.tmdb.org/t/p/w300{{ $item['poster_path'] }}" class="film-image"></a>
      @endempty
        <div class="clip-container">
          <!--<div id="clip-success" class="is-hidden">Clip!</div>-->
        @if(isset($clippedMovie))
          <a href="" data-movie_id="{{ $item['id'] }}" data-movie_title="{{ $item['title'] }}" data-poster_path="{{ $item['poster_path'] }}" class='clip is-active'><i id="clip-icon" class="clip-icon fas fa-clipboard-check fa-3x text-black"></i></a>
        @else
          <a href="" data-movie_id="{{ $item['id'] }}" data-movie_title="{{ $item['title'] }}" data-poster_path="{{ $item['poster_path'] }}" class='clip'><i id="clip-icon" class="fas fa-clipboard fa-3x"></i></a>
        @endif
        </div>
      </aside>
    </div>
    <div class="card-body recommend-movies">
      <h3>関連作品</h3>
      <div class="movies-container text-center is-hidden clearfix">
      @foreach ($recommends['results'] as $recommendMovie)
        <li class="movie-list">
          <a href="{{ route('show', ['id' => $recommendMovie['id']]) }}"><img class="image-size" src="https://image.tmdb.org/t/p/w200{{ $recommendMovie['poster_path'] }}"></img></a>
          <p>{{ mb_strimwidth($recommendMovie['title'], 0, 28, '...') }}</p>
        </li>
      @endforeach
        <button class='btn btn-secondary more'>movie more</button>
      </div>
    </div>
    <a href="{{ route('index', ['search-movie' => $searchWord]) }}" class='btn btn-info btn-back mb20'>一覧へ戻る</a>
  </div>
</div>

@endsection

