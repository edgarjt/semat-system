 /*Skip to content

    Explore
    Features
    Enterprise
    Blog

    3,841
    749

public jschr/bootstrap-modal

bootstrap-modal / js / bootstrap-modal.js
Jordan Schroter jschr on 22 May
Merge pull request #124 from montrezorro/master

5 contributors
Jordan Schroter Marc Roberto DigTheDoug Dominic Martineau
file 378 lines (287 sloc) 9.659 kb
1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27 28 29 30 31 32 33 34 35 36 37 38 39 40 41 42 43 44 45 46 47 48 49 50 51 52 53 54 55 56 57 58 59 60 61 62 63 64 65 66 67 68 69 70 71 72 73 74 75 76 77 78 79 80 81 82 83 84 85 86 87 88 89 90 91 92 93 94 95 96 97 98 99 100 101 102 103 104 105 106 107 108 109 110 111 112 113 114 115 116 117 118 119 120 121 122 123 124 125 126 127 128 129 130 131 132 133 134 135 136 137 138 139 140 141 142 143 144 145 146 147 148 149 150 151 152 153 154 155 156 157 158 159 160 161 162 163 164 165 166 167 168 169 170 171 172 173 174 175 176 177 178 179 180 181 182 183 184 185 186 187 188 189 190 191 192 193 194 195 196 197 198 199 200 201 202 203 204 205 206 207 208 209 210 211 212 213 214 215 216 217 218 219 220 221 222 223 224 225 226 227 228 229 230 231 232 233 234 235 236 237 238 239 240 241 242 243 244 245 246 247 248 249 250 251 252 253 254 255 256 257 258 259 260 261 262 263 264 265 266 267 268 269 270 271 272 273 274 275 276 277 278 279 280 281 282 283 284 285 286 287 288 289 290 291 292 293 294 295 296 297 298 299 300 301 302 303 304 305 306 307 308 309 310 311 312 313 314 315 316 317 318 319 320 321 322 323 324 325 326 327 328 329 330 331 332 333 334 335 336 337 338 339 340 341 342 343 344 345 346 347 348 349 350 351 352 353 354 355 356 357 358 359 360 361 362 363 364 365 366 367 368 369 370 371 372 373 374 375 376 377 378   
*/
/* ===========================================================
* bootstrap-modal.js v2.2.5
* ===========================================================
* Copyright 2012 Jordan Schroter
*
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
* http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
* ========================================================== */


!function ($) {

"use strict"; // jshint ;_;

/* MODAL CLASS DEFINITION
* ====================== */

var Modal = function (element, options) {
this.init(element, options);
};

Modal.prototype = {

constructor: Modal,

init: function (element, options) {
var that = this;

this.options = options;

this.$element = $(element)
.delegate('[data-dismiss="modal"]', 'click.dismiss.modal', $.proxy(this.hide, this));

this.options.remote && this.$element.find('.modal-body').load(this.options.remote, function () {
var e = $.Event('loaded');
that.$element.trigger(e);
});

var manager = typeof this.options.manager === 'function' ?
this.options.manager.call(this) : this.options.manager;

manager = manager.appendModal ?
manager : $(manager).modalmanager().data('modalmanager');

manager.appendModal(this);
},

toggle: function () {
return this[!this.isShown ? 'show' : 'hide']();
},

show: function () {
var e = $.Event('show');

if (this.isShown) return;

this.$element.trigger(e);

if (e.isDefaultPrevented()) return;

this.escape();

this.tab();

this.options.loading && this.loading();
},

hide: function (e) {
e && e.preventDefault();

e = $.Event('hide');

this.$element.trigger(e);

if (!this.isShown || e.isDefaultPrevented()) return;

this.isShown = false;

this.escape();

this.tab();

this.isLoading && this.loading();

$(document).off('focusin.modal');

this.$element
.removeClass('in')
.removeClass('animated')
.removeClass(this.options.attentionAnimation)
.removeClass('modal-overflow')
.attr('aria-hidden', true);

$.support.transition && this.$element.hasClass('fade') ?
this.hideWithTransition() :
this.hideModal();
},

layout: function () {
var prop = this.options.height ? 'height' : 'max-height',
value = this.options.height || this.options.maxHeight;

if (this.options.width){
this.$element.css('width', this.options.width);

var that = this;
this.$element.css('margin-left', function () {
if (/%/ig.test(that.options.width)){
return -(parseInt(that.options.width) / 2) + '%';
} else {
return -($(this).width() / 2) + 'px';
}
});
} else {
this.$element.css('width', '');
this.$element.css('margin-left', '');
}

this.$element.find('.modal-body')
.css('overflow', '')
.css(prop, '');

if (value){
this.$element.find('.modal-body')
.css('overflow', 'auto')
.css(prop, value);
}

var modalOverflow = $(window).height() - 10 < this.$element.height();
            
if (modalOverflow || this.options.modalOverflow) {
this.$element
.css('margin-top', 0)
.addClass('modal-overflow');
} else {
this.$element
.css('margin-top', 0 - this.$element.height() / 2)
.removeClass('modal-overflow');
}
},

tab: function () {
var that = this;

if (this.isShown && this.options.consumeTab) {
this.$element.on('keydown.tabindex.modal', '[data-tabindex]', function (e) {
if (e.keyCode && e.keyCode == 9){
var elements = [],
tabindex = Number($(this).data('tabindex'));

that.$element.find('[data-tabindex]:enabled:visible:not([readonly])').each(function (ev) {
elements.push(Number($(this).data('tabindex')));
});
elements.sort(function(a,b){return a-b});

var arrayPos = $.inArray(tabindex, elements);
if (!e.shiftKey){
arrayPos < elements.length-1 ?
that.$element.find('[data-tabindex='+elements[arrayPos+1]+']').focus() :
that.$element.find('[data-tabindex='+elements[0]+']').focus();
} else {
arrayPos == 0 ?
that.$element.find('[data-tabindex='+elements[elements.length-1]+']').focus() :
that.$element.find('[data-tabindex='+elements[arrayPos-1]+']').focus();
}

e.preventDefault();
}
});
} else if (!this.isShown) {
this.$element.off('keydown.tabindex.modal');
}
},

escape: function () {
var that = this;
if (this.isShown && this.options.keyboard) {
if (!this.$element.attr('tabindex')) this.$element.attr('tabindex', -1);

this.$element.on('keyup.dismiss.modal', function (e) {
e.which == 27 && that.hide();
});
} else if (!this.isShown) {
this.$element.off('keyup.dismiss.modal')
}
},

hideWithTransition: function () {
var that = this
, timeout = setTimeout(function () {
that.$element.off($.support.transition.end);
that.hideModal();
}, 500);

this.$element.one($.support.transition.end, function () {
clearTimeout(timeout);
that.hideModal();
});
},

hideModal: function () {
var prop = this.options.height ? 'height' : 'max-height';
var value = this.options.height || this.options.maxHeight;

if (value){
this.$element.find('.modal-body')
.css('overflow', '')
.css(prop, '');
}

this.$element
.hide()
.trigger('hidden');
},

removeLoading: function () {
this.$loading.remove();
this.$loading = null;
this.isLoading = false;
},

loading: function (callback) {
callback = callback || function () {};

var animate = this.$element.hasClass('fade') ? 'fade' : '';

if (!this.isLoading) {
var doAnimate = $.support.transition && animate;

this.$loading = $('<div class="loading-mask ' + animate + '">')
.append(this.options.spinner)
.appendTo(this.$element);

if (doAnimate) this.$loading[0].offsetWidth; // force reflow

this.$loading.addClass('in');

this.isLoading = true;

doAnimate ?
this.$loading.one($.support.transition.end, callback) :
callback();

} else if (this.isLoading && this.$loading) {
this.$loading.removeClass('in');

var that = this;
$.support.transition && this.$element.hasClass('fade')?
this.$loading.one($.support.transition.end, function () { that.removeLoading() }) :
that.removeLoading();

} else if (callback) {
callback(this.isLoading);
}
},

focus: function () {
var $focusElem = this.$element.find(this.options.focusOn);

$focusElem = $focusElem.length ? $focusElem : this.$element;

$focusElem.focus();
},

attention: function (){
// NOTE: transitionEnd with keyframes causes odd behaviour

if (this.options.attentionAnimation){
this.$element
.removeClass('animated')
.removeClass(this.options.attentionAnimation);

var that = this;

setTimeout(function () {
that.$element
.addClass('animated')
.addClass(that.options.attentionAnimation);
}, 0);
}


this.focus();
},


destroy: function () {
var e = $.Event('destroy');

this.$element.trigger(e);

if (e.isDefaultPrevented()) return;

this.$element
.off('.modal')
.removeData('modal')
.removeClass('in')
.attr('aria-hidden', true);

if (this.$parent !== this.$element.parent()) {
this.$element.appendTo(this.$parent);
} else if (!this.$parent.length) {
// modal is not part of the DOM so remove it.
this.$element.remove();
this.$element = null;
}

this.$element.trigger('destroyed');
}
};


/* MODAL PLUGIN DEFINITION
* ======================= */

$.fn.modal = function (option, args) {
return this.each(function () {
var $this = $(this),
data = $this.data('modal'),
options = $.extend({}, $.fn.modal.defaults, $this.data(), typeof option == 'object' && option);

if (!data) $this.data('modal', (data = new Modal(this, options)));
if (typeof option == 'string') data[option].apply(data, [].concat(args));
else if (options.show) data.show()
})
};

$.fn.modal.defaults = {
keyboard: true,
backdrop: true,
loading: false,
show: true,
width: null,
height: null,
maxHeight: null,
modalOverflow: false,
consumeTab: true,
focusOn: null,
replace: false,
resize: false,
attentionAnimation: 'shake',
manager: 'body',
spinner: '<div class="loading-spinner" style="width: 200px; margin-left: -100px;"><div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div></div>',
backdropTemplate: '<div class="modal-backdrop" />'
};

$.fn.modal.Constructor = Modal;


/* MODAL DATA-API
* ============== */

$(function () {
$(document).off('click.modal').on('click.modal.data-api', '[data-toggle="modal"]', function ( e ) {
var $this = $(this),
href = $this.attr('href'),
$target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))), //strip for ie7
option = $target.data('modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data());

e.preventDefault();
$target
.modal(option)
.one('hide', function () {
$this.focus();
})
});
});

}(window.jQuery);

  /*  Status
    API
    Training
    Shop
    Blog
    About

    © 2014 GitHub, Inc.
    Terms
    Privacy
    Security
    Contact

*/