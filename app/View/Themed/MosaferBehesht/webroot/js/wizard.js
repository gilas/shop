$(function(){
$.fn.equalHeights = function(c, b) {
		tallest = c ? c : 0;
		this.each(function() {
			$(this).height() > tallest && (tallest = $(this).height())
		});
		b && tallest > b && (tallest = b);
		return this.each(function() {
			$(this).height(tallest).css("overflow", "auto")
		})
	};
    
var b = function(b, c) {
		var d = $(".steps li", c).length;
		return b < 1 || b > d ? !0 : ($(".wizard").find(".steps").find("li").removeClass("current").eq(b - 1).addClass("current"), c.data("step", parseInt(b)), c.find(".wiz_page").stop(!0, !0).fadeOut(), c.find(".step_" + b).stop(!0, !0).delay(400).fadeIn(), !1)
	},
		c = function(c, d) {
			var e = a(c).parents(".wizard"),
				h = e.data("step");
			b(h + d, e)
		};
	$(".wizard").find(".steps").find("a").click(function() {
		var c = $(this).attr("href").replace("#step_", ""),
			d = $(this).parents(".wizard");
		b(c, d)
	});
	var d = $(".wizard").find(".actions");
	d.find(".prev").click(function() {
		c(this, -1)
	});
	d.find(".next").click(function() {
		c(this, 1)
	});
	var e =
	1,
		d = window.location.hash;
	d.indexOf("#step-") == 0 && (e = parseInt(d.substr(1).replace("step-", "")));
	$(".wizard").each(function() {
		var c = $(this);
		b(e, c)
	});
	$(".wizard").find(".wiz_page").equalHeights().not(":first").hide()
   })