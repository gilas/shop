$.fn.createTabs = function() {
	var c = $(this),
		d = 0;
	c.find(".tab-content").hide();
	if (window.location.hash.indexOf("#tab") == 0) {
		var b = window.location.hash.substr(1);
		console.log(b);
		typeof b == "number" ? (b = parseInt(window.location.hash.substr(1), 10), b > 0 && b < c.find(".tab-content").size() && (d = b - 1)) : (b = c.find("#" + b.replace("tab-", "") + ".tab-content"), b.size() && b.not(":visible") && (d = b.index()))
	}
	c.find(".header").find("li").eq(d).addClass("current").show();
	c.find(".tab-content").eq(d).show();
	c.find(".header").find("li").click(function() {
		c.find(".header").find("li").removeClass("current");
		$(this).addClass("current");
		c.find(".tab-content").hide();
		var b = $(this).find("a").attr("href");
		$(b).fadeIn();
		return !1
	})
}