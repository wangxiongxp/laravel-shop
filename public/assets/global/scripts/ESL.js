window.ESL || (window.ESL = {});
ESL = {
	isFunction : function(a) {
		if (!a) {
			return false
		}
		return Object.prototype.toString.call(a) === "[object Function]"
	},
	isArray : function(a) {
		if (!a) {
			return false
		}
		return Object.prototype.toString.call(a) === "[object Array]"
	},
	isObject : function(a) {
		if (!a) {
			return false
		}
		return Object.prototype.toString.call(a) === "[object Object]"
	},
	isNumeric: function( obj ) {
		return !ESL.isArray( obj ) && obj - parseFloat( obj ) >= 0;
	},
	sprintf : function(a) {
		var d = {
			b: function(a) {
				return parseInt(a, 10).toString(2)
			},
			c: function(a) {
				return String.fromCharCode(parseInt(a, 10))
			},
			d: function(a) {
				return parseInt(a, 10)
			},
			u: function(a) {
				return Math.abs(a)
			},
			f: function(a, b) {
				b = parseInt(b, 10);
				a = parseFloat(a);
				if (isNaN(b && a)) return NaN;
				return b && a.toFixed(b) || a
			},
			o: function(a) {
				return parseInt(a, 10).toString(8)
			},
			s: function(a) {
				return a
			},
			x: function(a) {
				return ("" + parseInt(a, 10).toString(16)).toLowerCase()
			},
			X: function(a) {
				return ("" + parseInt(a, 10).toString(16)).toUpperCase()
			}
		},
		e = /%(?:(\d+)?(?:\.(\d+))?|\(([^)]+)\))([%bcdufosxX])/g,
		h = function(a) {
			if (a.length == 1 && typeof a[0] == "object") {
				a = a[0];
				return function(j, k, f, g, c) {
					return d[c](a[g])
				}
			} else {
				var b = 0;
				return function(j, k, f, g, c) {
					if (c == "%") return "%";
					return d[c](a[b++], f)
				}
			}
		};
		var b = Array.apply(null, arguments).slice(1);
		return a.replace(e, h(b));
	},
	formatMoney : function (number) {
		number = number || 0;
		places = 2;
		symbol = "";
		thousand = ",";
		decimal = ".";
		var negative = number < 0 ? "-" : "",
			i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
			j = (j = i.length) > 3 ? j % 3 : 0;
		return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
	},
	isNull : function(exp) {
		return (!exp && typeof(exp)!="undefined" && exp!=0);
	}
}
ESL.pkg = function(f, n, o) {
	var q, p, r;
	if (arguments.length == 3) {
		q = f;
		p = n;
		r = o
	} else {
		q = window;
		p = f;
		r = n
	}
	if (!p || !p.length) {
		return null
	}
	var a = p.split(".");
	for (var c = q, e = 0; e < a.length - 1; e++) {
		c[a[e]] || (c[a[e]] = {});
		c = c[a[e]]
	}
	c = (c[a[a.length - 1]] = r || c[a[a.length - 1]] || {});
	return c
};
ESL.cookie = {
	get: function(a) {
		var f = null;
		if (document.cookie && document.cookie != "") {
			var d = document.cookie.split(";");
			for (var c = 0; c < d.length; c++) {
				var b = (d[c] || "").replace(/^(\s|\u00A0)+|(\s|\u00A0)+$/g, "");
				if (b.substring(0, a.length + 1) == (a + "=")) {
					var e = function(j) {
							j = j.replace(/\+/g, " ");
							var h = '()<>@,;:\\"/[]?={}';
							for (var g = 0; g < h.length; g++) {
								if (j.indexOf(h.charAt(g)) != -1) {
									if (j.startWith('"')) {
										j = j.substring(1);
									}
									if (j.endWith('"')) {
										j = j.substring(0, j.length - 1);
									}
									break;
								}
							}
							return decodeURIComponent(j);
						};
					f = e(b.substring(a.length + 1));
					break;
				}
			}
		}
		return f;
	},
	set: function(d, f, c) {
		c = c || {};
		if (f === null) {
			f = "";
			c.expires = -1;
		}
		var a = "";
		if (c.expires && (typeof c.expires == "number" || c.expires.toUTCString)) {
			var b;
			if (typeof c.expires == "number") {
				b = new Date();
				b.setTime(b.getTime() + (c.expires * 24 * 60 * 60 * 1000));
			} else {
				b = c.expires;
			}
			a = "; expires=" + b.toUTCString();
		}
		var h = "; path=" + (c.path || "/");
		var e = c.domain ? "; domain=" + (c.domain) : "";
		var g = c.secure ? "; secure" : "";
		document.cookie = [d, "=", encodeURIComponent(f), a, h, e, g].join("");
	},
	remove: function(a) {
		this.set(a, null);
	}
};
/*-----------------------------------------------------------------------------*/
ESL.pkg('ESL.Url');
ESL.Url.parse = function (url, fliter) {
	var theRequest = new Object();
	if (url.indexOf("?") != -1) {
	  theRequest.script_name = url.substr(0, url.indexOf("?"));
	  theRequest.params = [];
	  var str = url.substr(url.indexOf("?") + 1);
	  strs = str.split("&");
	  for(var i = 0; i < strs.length; i ++) {
	      var a = strs[i].split("=")[0], 
	      	  b = unescape(strs[i].split("=")[1]);
	      if( a == fliter ) { continue; }
	     theRequest.params.push({ 'key': a , 'val' : b });
	  }
	} else {
	  theRequest.script_name = url;
	  theRequest.params = [];
	}
	return theRequest;
};
ESL.Url.build = function ( obj ) {
	var param = '';
	if(obj.params.length) {
		$.each(obj.params, function(k ,v ){
			param += '&' + v.key + '=' + v.val;
		});
		param = param.substr(1);
	}
	return obj.script_name + (obj.params.length ? '?' + param : '');
};
ESL.Url.get = function ( url , name ) {
	var obj = ESL.Url.parse(url, '');
	var f = null;
	if(obj.params.length) {
		$.each(obj.params, function(k ,v ){
			if(v.key == name ) { f = v.val; return false; }
		});
	}
	return f;
};
ESL.Url.set = function ( url, name, value) {
	var v = ESL.Url.get(url, name);
	var obj = ESL.Url.parse(url, '');
	if(ESL.isNull(v)) {
		obj.params.push({ 'key': name , 'val' : value });
	} else {
		if(obj.params.length) {
			$.each(obj.params, function(k ,v ){
				if(v.key == name ) { v.val = value; return false; }
			});
		}
	}
	return ESL.Url.build(obj);
};
/*-----------------------------------------------------------------------------*/
Array.prototype.distinct = function(){
	var arr = [],
		obj = {},
		i = 0,
		len = this.length,
		result;

	for( ; i < len; i++ ){
		result = this[i];
		if( obj[result] !== result ){
			arr.push( result );
			obj[result] = result;
		}
	}

	return arr;
};