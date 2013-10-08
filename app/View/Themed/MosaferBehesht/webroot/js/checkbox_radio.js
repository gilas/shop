$(function(){
	var h = function(e) {
		if (!e) e = window.event;
		e.cancelBubble = !0;
		e.stopPropagation && e.stopPropagation()
	};
    $.fn.checkbox = function(e) {
		try {
			document.execCommand("BackgroundImageCache", !1, !0)
		} catch (j) {}
		var b = {
			cls: "jquery-checkbox",
			empty: "empty.png"
		},
			b = $.extend(b, e || {}),
			i = function(a) {
				var b = a.checked,
					c = a.disabled,
					f = $(a);
				a.stateInterval && clearInterval(a.stateInterval);
				a.stateInterval = setInterval(function() {
					a.disabled != c && f.trigger((c = !! a.disabled) ? "disable" : "enable");
					a.checked != b && f.trigger((b = !! a.checked) ? "check" : "uncheck")
				}, 10);
				return f
			};
		return this.each(function() {
			var a = this,
				d = i(a);
			a.wrapper && a.wrapper.remove();
			a.wrapper = $('<span class="' + b.cls + '"><span class="mark"><img src="' + b.empty + '" /></span></span>');
			a.wrapperInner = a.wrapper.children("span:eq(0)");
			a.wrapper.hover(function(f) {
				a.wrapperInner.addClass(b.cls + "-hover");
				h(f)
			}, function(f) {
				a.wrapperInner.removeClass(b.cls + "-hover");
				h(f)
			});
			d.addClass("hidden").after(a.wrapper);
			var c = !1;
			d.attr("id") && (c = $("label[for=" + d.attr("id") + "]"), c.length || (c = !1));
			c || (c = d.closest ? d.closest("label") : d.parents("label:eq(0)"), c.length || (c = !1));
			c && (c.hover(function(b) {
				a.wrapper.trigger("mouseover", [b])
			}, function(b) {
				a.wrapper.trigger("mouseout", [b])
			}), c.click(function(a) {
				d.trigger("click", [a]);
				h(a);
				return !1
			}), c.mousedown(function() {
				a.wrapperInner.addClass(b.cls + "-clicked")
			}).mouseup(function() {
				a.wrapperInner.removeClass(b.cls + "-clicked")
			}));
			a.wrapper.click(function(a) {
				d.trigger("click", [a]);
				h(a);
				return !1
			});
			d.click(function(a) {
				h(a)
			});
			d.bind("disable", function() {
				a.wrapperInner.addClass(b.cls + "-disabled")
			}).bind("enable", function() {
				a.wrapperInner.removeClass(b.cls + "-disabled")
			});
			d.bind("check", function() {
				a.wrapper.addClass(b.cls + "-checked")
			}).bind("uncheck", function() {
				a.wrapper.removeClass(b.cls + "-checked")
			});
			$("img", a.wrapper).bind("dragstart", function() {
				return !1
			});
			a.wrapper.mousedown(function() {
				a.wrapperInner.addClass(b.cls + "-clicked")
			}).mouseup(function() {
				a.wrapperInner.removeClass(b.cls + "-clicked")
			});
			window.getSelection && a.wrapper.css("MozUserSelect", "none");
			a.checked && a.wrapper.addClass(b.cls + "-checked");
			a.disabled && a.wrapperInner.addClass(b.cls + "-disabled")
		})
	};
})