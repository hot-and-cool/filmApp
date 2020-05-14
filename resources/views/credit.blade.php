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
          @if ($jpName)
            <p class='h2 name'>{{ array_values($jpName)[0] }}</p>
            <p class='pb10 original-title text-muted'>{{ $item['name'] }}</p>
          @else
            <p class='h2 name'>{{ $item['name'] }}</p>
          @endif
          </div>
          <div class="from">出身地：{{ $item['place_of_birth'] }}</div>
          <div class="birthday">生年月日：{{ $item['birthday'] }}</div>
          <div class="popularity mt30"><span class="font-weight-bold">{{ $item['popularity'] }}</span>人がフォローしています！</div>
        </div>
      </section>  
      <aside class='review-image'>
      @empty($item['profile_path'])
        <img src= "{{ asset('images/sample-person.png') }}">
      @else
			  <img src= "https://image.tmdb.org/t/p/w200{{ $item['profile_path'] }}" class="">
      @endempty
        <ul class="sns-wrapper d-flex pt10">
          <li class="mr30">
            <a href="https://twitter.com/{{ $item['external_ids']['twitter_id'] }}" class="fab fa-twitter-square fa-2x" target="_blank"></a>
          </li>
          <li class="mr30">
            <a href="https://facebook.com/{{ $item['external_ids']['facebook_id'] }}" class="fab fa-facebook-square fa-2x" target="_blank"></a>
          </li>
          <li class="mr30 insta">
            <a href="https://instagram.com/{{ $item['external_ids']['instagram_id'] }}" class="fab fa-instagram fa-2x" target="_blank"></a>
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
        <li class="movie-list">
          <a href="{{ route('show', ['id' => $appearance['id']]) }}"><img class="image-size" src="https://image.tmdb.org/t/p/w200{{ $appearance['poster_path'] }}"></img></a>
          <p></p>
        </li>
      @endforeach
        <button class='btn btn-secondary more'>movie more</button>
      </div>
    </div>
    <a href="" class='btn btn-info btn-back mb20'>ホームへ</a>
  </div>
</div>

@endsection
