$(function() {
	$('.sort-wrapper').children('input').on('click', function(e) {
		// e.preventDefault();
		var sortName = $(this).attr('name');
		console.log(sortName);
		// $.ajax({
		// 	url:'/',
		// 	type:'get',
		// 	dataType:'json',
		// 	data: {
		// 		'sort_name':sortName,
		// 	},
		// }).done(function() {
		// 	console.log('sucecess');
		// }).fail(function(XMLHttpRequest, textStatus, errorThrown){
		//     console.log(XMLHttpRequest.status);
		//     console.log(textStatus);
		//     console.log(errorThrown);
		//     alert('無効な処理です');
		// })
	});
});