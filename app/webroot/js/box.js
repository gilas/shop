/* Message */
(function(a) {
	var l = {
		buttons: {
			button1: {
				text: "OK",
				danger: !1,
				onclick: function() {
					a.fallr("hide")
				}
			}
		},
		icon: "check",
		content: "Hello",
		position: "center",
		closeKey: !1,
		closeOverlay: !1,
		useOverlay: !0,
		autoclose: !1,
		easingDuration: 300,
		easingIn: "swing",
		easingOut: "swing",
		height: "auto",
		width: "360px",
		zIndex: 100
	},
		d, n, f = a(window),
		g = {
			hide: function(b, j, i) {
				if (g.isActive()) {
					a("#fallr-wrapper").stop(!0, !0);
					var c = a("#fallr-wrapper"),
						b = c.css("position"),
						h = 0;
					switch (d.position) {
					case "bottom":
					case "center":
						h = (b === "fixed" ? f.height() : c.offset().top + c.height()) + 10;
						break;
					default:
						h = (b === "fixed" ? -1 * c.outerHeight() : c.offset().top) - 10
					}
					c.animate({
						top: h
					}, d.easingDuration || d.duration, d.easingOut, function() {
						a.browser.msie ? a("#fallr-overlay").css("display", "none") : a("#fallr-overlay").fadeOut("fast");
						c.remove();
						clearTimeout(n);
						typeof j === "function" && j.call(i)
					});
					a(document).unbind("keydown", e.enterKeyHandler).unbind("keydown", e.closeKeyHandler).unbind("keydown", e.tabKeyHandler)
				}
			},
			resize: function(b, d, f) {
				var c = a("#fallr-wrapper"),
					h = parseInt(b.width, 10),
					m = parseInt(b.height, 10),
					b = Math.abs(c.outerWidth() - h),
					o = Math.abs(c.outerHeight() - m);
				if (g.isActive() && (b > 5 || o > 5)) c.animate({
					width: h
				}, function() {
					a(this).animate({
						height: m
					}, function() {
						e.fixPos()
					})
				}), a("#fallr").animate({
					width: h - 94
				}, function() {
					a(this).animate({
						height: m - 131
					}, function() {
						typeof d === "function" && d.call(f)
					})
				})
			},
			show: function(b, j, i) {
				if (g.isActive()) a.error("Can't create new message with content: \"" + b.content + '", past message with content "' + d.content + '" is still active');
				else {
					d = a.extend({}, l, b);
					a('<div id="fallr-wrapper"></div>').appendTo("body");
					var c = a("#fallr-wrapper"),
						h = a("#fallr-overlay");
					c.css({
						width: d.width,
						height: d.height,
						position: "absolute",
						top: "-9999px",
						left: "-9999px"
					}).html('<div id="fallr-icon"></div><div id="fallr"></div><div id="fallr-buttons"></div>').find("#fallr-icon").addClass("icon-" + d.icon).end().find("#fallr").html(d.content).css({
						height: d.height == "auto" ? "auto" : c.height() - 131,
						width: c.width() - 94
					}).end().find("#fallr-buttons").html(function() {
						var a = "",
							b;
						for (b in d.buttons) d.buttons.hasOwnProperty(b) && (a = a + '<a href="#" class="fallr-button ' + (d.buttons[b].danger ? "fallr-button-danger" : "") + '" id="fallr-button-' + b + '">' + d.buttons[b].text + "</a>");
						return a
					}()).find(".fallr-button").bind("click", function() {
						var b = a(this).attr("id").substring(13);
						if (typeof d.buttons[b].onclick === "function" && d.buttons[b].onclick != !1) {
							var c = document.getElementById("fallr");
							d.buttons[b].onclick.apply(c)
						} else g.hide();
						return !1
					});
					b = function() {
						c.show();
						var b = (f.width() - c.outerWidth()) / 2 + f.scrollLeft(),
							a, e, k = f.height() > c.height() && f.width() > c.width() ? "fixed" : "absolute";
						switch (d.position) {
						case "bottom":
							a = k === "fixed" ? f.height() : f.scrollTop() + f.height();
							e = a - c.outerHeight();
							break;
						case "center":
							a = k === "fixed" ? -1 * c.outerHeight() : h.offset().top - c.outerHeight();
							e = a + c.outerHeight() + (f.height() - c.outerHeight()) / 2;
							break;
						default:
							e = k === "fixed" ? 0 : f.scrollTop(), a = e - c.outerHeight()
						}
						c.css({
							left: b,
							position: k,
							top: a,
							"z-index": d.zIndex + 1
						}).animate({
							top: e
						}, d.easingDuration, d.easingIn, function() {
							typeof j === "function" && j.call(i);
							d.autoclose && (n = setTimeout(g.hide, d.autoclose))
						})
					};
					d.useOverlay ? a.browser.msie && a.browser.version < 9 ? (h.css({
						display: "block",
						"z-index": d.zIndex
					}), b()) : h.css({
						"z-index": d.zIndex
					}).fadeIn(b) : b();
					a(document).bind("keydown", e.enterKeyHandler).bind("keydown", e.closeKeyHandler).bind("keydown", e.tabKeyHandler);
					a("#fallr-buttons").children().eq(-1).bind("focus", function() {
						a(this).bind("keydown", e.tabKeyHandler)
					});
					c.find(":input").bind("keydown", function(b) {
						e.unbindKeyHandler();
						b.keyCode === 13 && (console.log(1), a(".fallr-button").eq(0).trigger("click"))
					})
				}
			},
			set: function(b, a, e) {
				for (var c in b) l.hasOwnProperty(c) && (l[c] = b[c], d && d[c] && (d[c] = b[c]));
				typeof a === "function" && a.call(e)
			},
			isActive: function() {
				return !!(a("#fallr-wrapper").length > 0)
			},
			blink: function() {
				a("#fallr-wrapper").fadeOut(100, function() {
					a(this).fadeIn(100)
				})
			},
			shake: function() {
				a("#fallr-wrapper").stop(!0, !0).animate({
					left: "+=20px"
				}, 50, function() {
					a(this).animate({
						left: "-=40px"
					}, 50, function() {
						a(this).animate({
							left: "+=30px"
						}, 50, function() {
							a(this).animate({
								left: "-=20px"
							}, 50, function() {
								a(this).animate({
									left: "+=10px"
								}, 50)
							})
						})
					})
				})
			}
		},
		e = {
			fixPos: function() {
				var b = a("#fallr-wrapper"),
					e = b.css("position");
				if (f.width() > b.outerWidth() && f.height() > b.outerHeight()) {
					var i = (f.width() - b.outerWidth()) / 2,
						c = f.height() - b.outerHeight();
					switch (d.position) {
					case "center":
						c /= 2;
						break;
					case "bottom":
						break;
					default:
						c = 0
					}
					e == "fixed" ? b.animate({
						left: i
					}, function() {
						a(this).animate({
							top: c
						})
					}) : b.css({
						position: "fixed",
						left: i,
						top: c
					})
				} else i = (f.width() - b.outerWidth()) / 2 + f.scrollLeft(), c = f.scrollTop(), e != "fixed" ? b.animate({
					left: i
				}, function() {
					a(this).animate({
						top: c
					})
				}) : b.css({
					position: "absolute",
					top: c,
					left: i > 0 ? i : 0
				})
			},
			enterKeyHandler: function(b) {
				b.keyCode === 13 && (a("#fallr-buttons").children().eq(0).focus(), e.unbindKeyHandler())
			},
			tabKeyHandler: function(b) {
				b.keyCode === 9 && (a("#fallr-wrapper").find(":input, .fallr-button").eq(0).focus(), e.unbindKeyHandler(), b.preventDefault())
			},
			closeKeyHandler: function(a) {
				a.keyCode === 27 && d.closeKey && g.hide()
			},
			unbindKeyHandler: function() {
				a(document).unbind("keydown", e.enterKeyHandler).unbind("keydown", e.tabKeyHandler)
			}
		};
	a(document).ready(function() {
		a("body").append('<div id="fallr-overlay"></div>');
		a("#fallr-overlay").bind("click", function() {
			d.closeOverlay ? g.hide() : g.blink()
		})
	});
	a(window).resize(function() {
		g.isActive() && e.fixPos()
	});
	a.fallr = function(b, d, e) {
		var c = window;
		typeof b === "object" && (d = b, b = "show");
		g[b] ? (typeof d === "function" && (e = d, d = null), g[b](d, e, c)) : a.error('Method "' + b + '" does not exist in $.fallr')
	}
})(jQuery);