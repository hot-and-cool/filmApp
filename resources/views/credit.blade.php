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
        @foreach ($casts as $cast)
          <img class="cast-pic" src="https://image.tmdb.org/t/p/w300/{{ $cast['profile_path'] }}"></img>
          <p>{{ $cast['character'] }}({{ $cast['name'] }})</p>

            
        @endforeach
        </div>
      </section>  
    </div>
    <a href="{{ route('show', ['id' => $id, 'search-movie' => $searchWord]) }}" class='btn btn-info btn-back mb20'>一覧へ戻る</a>
  </div>
</div>

@endsection
