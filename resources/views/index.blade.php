@extends('layouts.app')

@section('content')
<h1 class='pagetitle container'>Trend</h1>
	<div class="row justify-content-center">
		@foreach ($items['results'] as $item)
		<div class="col-md-4">
			<div class="card mb50">
				<div class="card-body text-center">
					<div class="film-id d-none">{{ $item['id'] }}</div>
					<div class="image-wrapper"><img src="https://image.tmdb.org/t/p/w300{{ $item['poster_path'] }}" alt="" class="film-image" ></div>
					<p class="h3 film-title">{{ $item['title'] }}</p>
					<div class="h3 text-yellow">★{{ $item['vote_average'] }}</div>
					<p class="description">
						公開日 {{ $item['release_date'] }}
					</p>
					<a href="{{ route('show', ['id' => $item['id']] ) }}" class="btn btn-secondary detail-btn">詳細を読む</a>
				</div>
			</div>
		</div>
		@endforeach
	</div>

@endsection
