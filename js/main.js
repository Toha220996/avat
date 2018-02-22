$(function () {
	var li_portfolio = $("#nav-menu-item-portfolio")
	if($("body").hasClass("tax-brand") || $("body").hasClass("single-portfolio")) {
		li_portfolio = li_portfolio.addClass("current-menu-item");
	}
		var SinglePost = $(".single-project").outerWidth();
		for (var i = 0; i <  $(".single-project").length; i++) {
			$('article.single-project').css('height' , SinglePost);
		};
		$(window).resize(function(){
			var SinglePost = $(".single-project").outerWidth();
			for (var i = 0; i <  $(".single-project").length; i++) {
				$('article.single-project').css('height' , SinglePost);
			};
		});

});
