$(function() {
	var b = function(a) {
		a.stopPropagation()
	};
	$(document).click(function() {
		$(".toolbox:visible").fadeOut();
		$(".toolbar_large").find(".dropdown:visible").each(function() {
			var b = $(this);
			b.slideUp();
			b.parent().find(".toolcaption").removeClass("active")
		})
	});
	$(".toolbutton").each(function() {
		var c = $(this);
		c.next().hasClass("toolbox") && (c.click(function(c) {
			b(c);
			$(this).next().fadeToggle()
		}), c.next().click(b), c.next().hide())
	});
	$(".toolbar_large").each(function() {
		var c = $(this),
			d = c.find(".dropdown");
		c.find(".toolcaption").css("min-width", d.width() - 5 + "px");
		c.find(".toolcaption").click(function(e) {
			d.css("width", parseFloat(c.find(".toolcaption").css("widthExact")) + 2 + "px");
			b(e);
			$(this).toggleClass("active");
			d.slideToggle();
			d.click(b)
		});
		d.hide()
	})
});