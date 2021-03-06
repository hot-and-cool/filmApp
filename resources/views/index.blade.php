@extends('layouts.app')

@section('js')
      <script src="{{ asset('js/index.js') }}" defer></script>
@endsection

@section('content')
{!! Form::open(['route' => 'index', 'method' => 'GET' ]) !!}
	<div class="sort-wrapper">
		{!! Form::submit('Trend',['name' => 'trend', 'class' => 'pagetitle btn']) !!}
		{!! Form::submit('Top Rated',['name' => 'top_rated', 'class' => 'pagetitle btn']) !!}
		{!! Form::submit('Latest',['name' => 'latest', 'class' => 'pagetitle btn']) !!}
		{!! Form::submit('Upcoming',['name' => 'upcoming', 'class' => 'pagetitle btn']) !!}
	</div>
{!! Form::close() !!}
	<div class="row justify-content-center">
		@foreach ($items['results'] as $item)
		<div class="col-md-4">
			<div class="card mb50">
				<div class="card-body text-center">
					<div class="film-id d-none">{{ $item['id'] }}</div>
					<div class="image-wrapper">
					<a href="{{ route('show', ['id' => $item['id'], 'search-movie' => $searchWord] ) }}">
						<img src=@if (empty($item['poster_path'])) "{{ asset('images/sample-movie.png') }}" @else "https://image.tmdb.org/t/p/w300{{ $item['poster_path'] }}" @endif alt="" class="film-image" >
					</a>
					</div>
					<p class="h3 film-title">{{ $item['title'] }}</p>
					<div class="h3 text-yellow">★{{ $item['vote_average'] }}</div>
					<p class="description">
					@if (isset($item['release_date']))
						公開日 {{ $item['release_date'] }}
					@endif
					</p>
					<a href="{{ route('show', ['id' => $item['id'], 'search-movie' => $searchWord] ) }}" class="btn btn-secondary detail-btn">詳細を読む</a>
				</div>
			</div>
		</div>
		@endforeach
	</div>

@endsection
