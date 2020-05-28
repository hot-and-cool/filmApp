@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/show.css') }}" rel="stylesheet">
@endsection

@section('js')
    <script src="{{ asset('js/show.js') }}"></script>
@endsection

@section('content')
<div class="container">
  <div class="card">
    <div class="card-body d-flex">
      <section class='review-main'>
        <div class='base-info'>
          <div class="name-info">
          @empty($knownAsName)
            <p class='h2 name'>{{ $person['name'] }}</p>
          @else
            <p class='h2 name'>{{ $knownAsName[0] }}</p>
            <p class='pb10 original-title text-muted'>{{ $person['name'] }}</p>
          @endif
          </div>
          <div class="from">出身地：{{ $person['place_of_birth'] }}</div>
          <div class="birthday">生年月日：{{ $person['birthday'] }}<span class="pl-2">({{ Carbon::parse($person['birthday'])->age }}歳)</span></div>
          <div class="popularity mt30"><span class="font-weight-bold">{{ $person['popularity'] }}</span>人がフォローしています！</div>
        </div>
      </section>  
      <aside class='review-image'>
      @empty($person['profile_path'])
        <img src= "{{ asset('images/sample-person.png') }}">
      @else
			  <img src= "https://image.tmdb.org/t/p/w200{{ $person['profile_path'] }}" class="">
      @endempty
        <ul class="sns-wrapper d-flex pt10">
          <li class="mr30">
            <a href="https://twitter.com/{{ $person['external_ids']['twitter_id'] }}" class="fab fa-twitter-square fa-2x" target="_blank"></a>
          </li>
          <li class="mr30">
            <a href="https://facebook.com/{{ $person['external_ids']['facebook_id'] }}" class="fab fa-facebook-square fa-2x" target="_blank"></a>
          </li>
          <li class="mr30 insta">
            <a href="https://instagram.com/{{ $person['external_ids']['instagram_id'] }}" class="fab fa-instagram fa-2x" target="_blank"></a>
          </li>

          <li class="twitter"></li>
          <li class="twitter"></li>
        </ul>
      </aside>
    </div>
    <div class="card-body recommend-movies text-align-center">
      <h3>出演作品・関連作品</h3>
      <div class="movies-container text-center is-hidden clearfix">
      @foreach ($appearances as $appearance)
      <!-- forelseでリファクタ可能？ -->
        <li class="movie-list">
          @if (!empty($appearance['poster_path']))
          <a href="{{ route('show', ['id' => $appearance['id']]) }}"><img class="image-size" src="https://image.tmdb.org/t/p/w200{{ $appearance['poster_path'] }}"></img></a>
          @else
          <a href="{{ route('show', ['id' => $appearance['id']]) }}"><img class="image-size" src="{{ asset('images/sample-movie.png') }}"></img></a>
          @endif
          <p>{{ mb_strimwidth($appearance['title'], 0, 28, '...') }}</p>
        </li>
      @endforeach
        <button class='btn btn-secondary more'>movie more</button>
      </div>
    </div>
    <a href="" class='btn btn-info btn-back mb20'>ホームへ</a>
  </div>
</div>

@endsection
