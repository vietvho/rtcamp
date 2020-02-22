!function(l){"use strict";var d=wp.customize,i=(l(document),function(){var o=l(".WAN_ICONs"),t=l(document),s=o.find(".item-properties"),c=o.parent().find('input[type="hidden"]'),r=c.data("customize-setting-link");l().sortable&&t.find(".WAN_ICONs").sortable({stop:function(t,e){o=e.item.parent(),c=o.parent().find('input[type="hidden"]'),i()}});var i=function(){var t=[],e={};o.find("> li[data-id]").each(function(){t.push(l(this).attr("data-id")),void 0!==l(this).attr("data-link")&&(e[l(this).attr("data-id")]=l(this).attr("data-link"))}),e.__ordering__=t,c.val(JSON.stringify(e)),d(r)&&d.instance(r).set(JSON.stringify(e))},e=function(){s.removeClass("property_active"),o.children().removeClass("active")},p=function(){(s=o.find(".item-properties").first()).removeClass("property_active"),""!=s.find(".input-field").val().trim()?o.find("li.active").attr("data-link",s.find(".input-field").val()):o.find("li.active").removeAttr("data-link"),i(o),e()};t.on("click","button.cancel",e),t.on("click","button.confirm",p),t.on("keydown","input.input-field",function(t){13==t.keyCode&&(t.preventDefault(),p()),27==t.keyCode&&(t.preventDefault(),e())}),t.on("click",".WAN_ICONs .item",function(){var t=l(this),e=function(t){for(var e=t.prevAll(".item").length+1;7<e;)e-=7;return e}(t),i=t.nextAll(".item"),n=7-e,a=l.makeArray(i).slice(0,n);o=t.parent(),c=o.parent().find('input[type="hidden"]'),r=c.data("customize-setting-link"),s=o.find(".item-properties"),l().sortable&&o.sortable(),t.hasClass("active")?p():(s.addClass("property_active"),o.children().removeClass("active"),t.addClass("active"),0==a.length?t.after(s):l(a.pop()).after(s),s.find(".input-title").text(t.attr("data-title")),s.find(".input-field").val(t.attr("data-link")),s.find(".input-field").get(0).focus())})}),t=function(s,t){if(0!=l(s).length){l().choosen&&l(".select-choosen").chosen();var i=l(s),c=i.find("#typography-value").attr("data-customize-setting-link"),r=JSON.parse(i.find("#datas").attr("data_variants")),p=JSON.parse(i.find("#datas").attr("data_subsets"));i.find(".typography-font select").on("change",function(){var t=l(this).find("option:selected").attr("data_variants"),i=l(this).closest(s).find(".typography-style select"),e=i.val();i.empty(),console.log(t),void 0!==t&&l.each(JSON.parse(t),function(t,e){e=e.trim(),i.append(l("<option />",{value:e}).text(void 0!==r[e]?r[e]:e))}),i.val(e);var n,a=l(this).find("option:selected").attr("data_subsets"),o=l(this).closest(s).find(".typography-subsets .wan-options-control-inputs");o.empty(),void 0!==a&&l.each(JSON.parse(a),function(t,e){e=e.trim();var i=void 0!==p[e]?p[e]:e;n='                        <label class="_options-switcher-subsets">                            <span class="wan-options-control-title">'+i+'</span>                            <input type="checkbox" value="'+e+'" name="_wan-options-control-typography-'+c+'[subsets]">                            <span class="wan-options-control-indicator">                                <span></span>                            </span>                        </label>',o.append(n)})}),i.on("change","select, input",function(){!function(t){if(c=t.find("#typography-value").attr("data-customize-setting-link"),wp.customize&&c){var e=[];i.find('._options-switcher-subsets input[type="checkbox"]:checked').each(function(){e.push(l(this).val())}),wp.customize.instance(c).set(JSON.stringify({family:t.find(".typography-font select").val(),size:t.find(".typography-size input").val(),line_height:t.find(".typography-line_height input").val(),style:t.find(".typography-style select").val(),color:t.find(".typography-color .wan-color-picker").val(),subsets:e}))}}(l(this).closest(".wan-options-control-typography"))})}};l(document).on("widget-updated",function(t,e){i()});l(function(){i(),t(".wan-options-control-typography"),l(".wan-options-control-box-controls input[type=text]").on("change",function(){var t=l(this).parents(".wan-options-control-box-controls"),e=t.find("input[type=hidden]"),i=e.data("customize-setting-link"),n={};t.find("input[type=text]").each(function(){var t=l(this);n[t.data("position")]=t.val()}),e.val(JSON.stringify(n)),d(i)&&d.instance(i).set(JSON.stringify(n))}),l().wpColorPicker&&l(".wan-color-picker").wpColorPicker({change:function(t,e){var i=l(this).parents(".wan-options-control-color-picker"),n=i.find(".wan-color-picker"),a=i.find(".wan-color-picker").data("customize-setting-link"),o=e.color.toString();n.attr("value",o),d.instance(a).set(o)}}),l(document).on("click",".widget-content input[type=radio]",function(){var t=l(this);console.log(t.parents(".widget-content").eq(0)),console.log(t.parents(".widget-content").eq(0).find("input[type=radio][checked=checked]")),t.parents(".widget-content").eq(0).find("input[type=radio][checked=checked]").removeAttr("checked").prop("checked",!0),t.prop("checked",!0)})})}(jQuery);var functest=function(){};
jQuery(document).ready(function(u){
	var v = wp.customize;
	u(".form_local_font ").on("click", ".wie-remove-font", function(t) {
		t.preventDefault();
		var e = u(this).parents(".font_file_upload"),
			n = e.find(".font_preview"),
			i = e.find(".font_file_url");
		n.remove(), i.val("")
	}), u(".form_local_font .browse-media").on("click", function(t) {
		t.preventDefault();
		var n, e = u(this).parents(".font_file_upload"),
			i = e.find(".button.remove "),
			a = e.find(".font_preview"),
			o = e.find(".font_file_url"),
			s = wp.media.controller.Library.extend({
				defaults: _.defaults({
					id: "insert-ttf",
					title: "Select or Upload Font",
					allowLocalEdits: !0,
					displaySettings: !0,
					displayUserSettings: !0,
					multiple: !1,
					type: "application/x-font-ttf"
				}, wp.media.controller.Library.prototype.defaults)
			});
		(n = wp.media({
			state: "insert-ttf",
			states: [new s],
			multiple: !1
		})).open(), n.on("select", function() {
			n.state().get("selection").length;
			var t, e = n.state().get("selection").models;
			t = e[0].changed.url, a.html(""), a.append('<label> <span class="dashicons dashicons-format-aside"></span>' + e[0].changed.title + '</label><a href="#" url="' + t + '" class="wie-remove-font" title="Remove"> <span class="dashicons dashicons-no-alt"></span> </a>'), u(this).parent().hide(), o.val(t), i.show()
		})
	}), u(".font_local_submit").on("click", function(t) {
		t.preventDefault();
		var e, n = u(this).parents(".form_local_font"),
			i = n.find(".font_name"),
			a = n.find(".font_file_url"),
			o = n.find(".font_weight option:selected"),
			s = n.find(".font_local_value"),
			l = s.data("customize-setting-link"),
			r = u.parseJSON(s.val());
		if (u.isEmptyObject(r) && (r = {}), "" == i.val() || "" == a) alert("Font Name and Font File could not be empty");
		else {
			var c = (e = i.val(), u.trim(e).replace(/[^a-z0-9-]/gi, "-").replace(/-+/g, "-").replace(/^-|-$/g, "").toLowerCase() + "_" + o.val());
			if (c in r) alert("Font exist!");
			else {
				var p = "<tr>",
					d = "<td>" + i.val() + "</td>";
				d += "<td>" + o.text() + "</td>", p += (d += '<td><a href="#" class="remove_item"  data-fontid="' + c + '">x</a></td>') + "</tr>", u(".font_list table tbody").append(u(p));
				var f = {
					font_name: u.trim(i.val()),
					font_weight: o.val(),
					font_url: a.val()
				};
				r[c] = f, s.val(JSON.stringify(r)), v(l) && v.instance(l).set(JSON.stringify(r))
			}
		}
	}), u(".font_list").on("click", ".remove_item", function(t) {
		t.preventDefault();
		var e = u(this).parents(".form_local_font"),
			n = u(this),
			i = e.find(".font_local_value"),
			a = i.data("customize-setting-link"),
			o = u.parseJSON(i.val());
		delete o[n.data("fontid")], i.val(JSON.stringify(o)), v(a) && v.instance(a).set(JSON.stringify(o)), n.parents("tr").remove()
	})
})
