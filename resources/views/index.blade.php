@extends('layouts.app')

@section('content')
	<div class="row justify-content-center">
		@foreach ($results['results'] as $item)
		<div class="col-md-4">
			<div class="card mb50">
				<div class="card-body">
					<div class="image-wrapper"><img src="https://image.tmdb.org/t/p/w300{{ $item['poster_path'] }}" alt="" class="film-image" ></div>
					<h3 class="h3 film-title text-center">{{ $item['title'] }}</h3>
					<p class="description text-center">
						公開日 {{ $item['release_date'] }}
					</p>
					<a href="" class="btn btn-secondary detail-btn">詳細を読む</a>
				</div>
			</div>
		</div>
		@endforeach
	</div>

@endsection