$(function () {
	
// more表示
  var moreNum = 10;
  $('.movies-container').fadeIn(0);
  $('.movie-list:nth-child(n + ' + (moreNum + 1) + ')').addClass('is-hidden');
  $('.more').on('click', function() {
    $('.movie-list.is-hidden').slice(0, moreNum).removeClass('is-hidden');
    $('html, body').animate({
      scrollTop: $(document).height()
    },1000); //height()でdocumentの高さを取得
    if ($('.movie-list.is-hidden').length == 0) {
        $('.more').fadeOut();
    }
  })
  
//clip機能
	var movieId = $('.clip-container').children('a').data('movie_id');
	console.log(movieId);
	$('.clip').on('click', function(e) {
		e.preventDefault(); //リンク無効化
		$.ajax({
			headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	},
			url:movieId+'/clip',
			type:'post',
			dataType:'json',
			data: {
				'movie_id': movieId,
			},
		}).done(function() { 
			console.log('success!');
			$('#clip-icon').toggleClass('fas fa-clipboard-check fa-3x is-active');
			$('#clip-icon').toggleClass('fas fa-clipboard fa-3x');

		}).fail(function(XMLHttpRequest, textStatus, errorThrown){
		    console.log(XMLHttpRequest.status);
		    console.log(textStatus);
		    console.log(errorThrown);
		    alert('無効な処理です');
		})
	});
});
