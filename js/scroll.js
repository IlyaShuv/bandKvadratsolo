function scrollAnimate() {
	$(window).scroll(function() {
	$('.mov').each(function() {
		var contentPos = $(this).offset().top;
		var topOfWindow = $(window).scrollTop();
		if (contentPos < topOfWindow+600) {
			$(this).addClass('animated fadeIn');
			$(this).removeClass('hidden');
		}
	});
});
}