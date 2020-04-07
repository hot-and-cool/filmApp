@extends('layouts.app')

@section('content')
<p>仮仮仮</p>
<div class="row justify-content-center">
	<div class="col-md-4">
		<div class="card mb50">
			<div class="card-body">
				<div class="image-wrapper"><img src="{{ asset('images/sample-movie.png')}}" alt="" class="film-image" width="300",height="300"></div>
				<h3 class="h3 film-title">タイトル</h3>
				<p class="description">
					レビュー本文
				</p>
				<a href="" class="btn btn-secondary detail-btn">詳細を読む</a>
			</div>
		</div>
	</div>
</div>

@endsection