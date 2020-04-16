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
          <p class='h2 title'>{{ $item['title'] }}<span class='small pl10'>{{ "(" . $release_year . "公開)"  }}</span> </p>
          <p class='mb10 original-title text-muted'>{{ $item['original_title']}}</p>
          <p class='release-date'>公開日:<span>{{ $release_date }}</span></p>
          <p id='star' class=''>tmdb評価<span class='h3 pl10 text-yellow'>★{{ $item['vote_average'] . "/10"}}</span></p>
        </div>
        <h2 class='h2'>あらすじ</h2>
@if (!empty($item['overview']))
          <p>{{ $item['overview'] }}</p>
@else
          <p>作品のあらすじは秘密です。</p>
@endif
      </section>  
      <aside class='review-image'>
          <img class='film-image' src="https://image.tmdb.org/t/p/w300{{ $item['poster_path'] }}">
      </aside>
    </div>
    
    <a href="{{ route('index') }}" class='btn btn-info btn-back mb20'>一覧へ戻る</a>
  </div>
</div>

@endsection
