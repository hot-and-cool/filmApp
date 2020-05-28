@extends('layouts.app')
@section('content')

<div class="pagetitle">Clipした作品一覧</div>
<div class="row justify-content-center">
	@forelse ($myClipMovies as $myClipMovie)
	<div class="col-md-4">
		<div class="card mb50">
			<div class="card-body text-center">
				<div class="film-id d-none">{{ $myClipMovie->id }}</div>
				<div class="image-wrapper">
					<img src=@if (empty($myClipMovie->poster_path)) "{{ asset('images/sample-movie.png') }}" @else "https://image.tmdb.org/t/p/w300{{ $myClipMovie->poster_path }}" @endif alt="" class="film-image" >
				</div>
				<p class="h3 film-title">{{ $myClipMovie->title }}</p>
				<p class="description">cliped {{ $myClipMovie->updated_at->format('Y-m-d') }}</p>
				<a href="{{ route('show', ['id' => $myClipMovie->movie_id, 'search-movie' => $searchWord] ) }}" class="btn btn-secondary detail-btn">詳細を読む</a>
			</div>
		</div>
	</div>
	@empty
	  <p class="text-white mt-5">clipした映画はありません</p>
	@endforelse
</div>
{{ $myClipMovies->links() }}
@endsection