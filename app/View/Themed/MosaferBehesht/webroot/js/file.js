/* Form */
(function(){
$.fn.customFileInput = function() {
	return $(this).each(function() {
		var a = $(this).addClass("customfile-input").hover(function() {
			b.addClass("customfile-hover")
		}, function() {
			b.removeClass("customfile-hover")
		}).focus(function() {
			b.addClass("customfile-focus");
			a.data("val", a.val())
		}).blur(function() {
			b.removeClass("customfile-focus");
			$(this).trigger("checkChange")
		}).bind("disable", function() {
			a.attr("disabled", !0);
			b.addClass("customfile-disabled")
		}).bind("enable", function() {
			a.removeAttr("disabled");
			b.removeClass("customfile-disabled")
		}).bind("checkChange", function() {
			a.val() && a.val() != a.data("val") && a.trigger("change")
		}).bind("change", function() {
			var a = $(this).val().split(/\\/).pop(),
				b = "customfile-ext-" + a.split(".").pop().toLowerCase();
			c.text(a).removeClass(c.data("fileExt") || "").addClass(b).data("fileExt", b).addClass("customfile-feedback-populated");
			d.text("تعویض");
			c.ellipsis(!0)
		}).click(function() {
			a.data("val", a.val());
			setTimeout(function() {
				a.trigger("checkChange")
			}, 100);
			b.removeClass("customfile-focus")
		}),
			b = $('<div class="customfile"></div>'),
			d =
			$('<button class="customfile-button" aria-hidden="true">جستجو</button>').appendTo(b),
			c = $('<span class="customfile-feedback" aria-hidden="true">فایل خود را انتخاب کنید</span>').appendTo(b);
		a.is("[disabled]") && a.trigger("disable");
		b.mousemove(function(c) {
			a.css({
				left: c.pageX - b.offset().left - a.outerWidth() + 150,
				top: c.pageY - b.offset().top - 55,
				margin: 0
			})
		}).insertAfter(a);
		a.appendTo(b)
	})
};
})(jQuery);

$(function(){$('input[type="file"]').customFileInput()})