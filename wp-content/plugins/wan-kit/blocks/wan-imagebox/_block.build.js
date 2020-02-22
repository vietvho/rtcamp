/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

    var _defaultLayerSet;

    function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
    
    var _wp$i18n = wp.i18n,
        __ = _wp$i18n.__,
        setLocaleData = _wp$i18n.setLocaleData;
    var registerBlockType = wp.blocks.registerBlockType;
    var _wp$components = wp.components,
        TextControl = _wp$components.TextControl,
        TextareaControl = _wp$components.TextareaControl,
        SelectControl = _wp$components.SelectControl,
        Button = _wp$components.Button,
        TabPanel = _wp$components.TabPanel,
        PanelBody = _wp$components.PanelBody,
        RangeControl = _wp$components.RangeControl,
        ColorPicker = _wp$components.ColorPicker,
        ColorIndicator = _wp$components.ColorIndicator,
        Dropdown = _wp$components.Dropdown;
    var _wp$editor = wp.editor,
        RichText = _wp$editor.RichText,
        InspectorControls = _wp$editor.InspectorControls,
        MediaUpload = _wp$editor.MediaUpload,
        PlainText = _wp$editor.PlainText;
    var _wp$element = wp.element,
        Fragment = _wp$element.Fragment,
        RawHTML = _wp$element.RawHTML;
    // import ColorPicker from "../wan-components"
    
    var defaultAtts = {
        sliders: {
            slider1: { img_url: '', img_alt: '', title: '', desc: '', img_thumb: '' }
        }
    };
    var sliderTabs = [{
        name: 'slide1',
        title: __('Slide 1'),
        className: 'wan-control-tabs-tab'
    }, {
        name: 'slde2',
        title: __('Slide 2'),
        className: 'wan-control-tabs-tab'
    }];
    wp.components.wancreateopts = function (value, options) {
        var opts = [];
        for (groupkey in options) {
            var optgroup = options[groupkey];
            var optitems = [];
            optgroup.forEach(function (item) {
                var selected = value == item ? 'selected:selected' : '';
                optitems.push(wp.element.createElement(
                    'option',
                    { value: item, selected: true },
                    item
                ));
            });
            opts.push(wp.element.createElement(
                'optgroup',
                { label: groupkey },
                optitems
            ));
        }
        return opts;
    };
    var defaultLayerSet = (_defaultLayerSet = {
        width: '60', scale: '', text_align: 'text-left', color: '', background_color: '', background_radius: '', padding_top: '', padding_left: '', padding_bottom: '', padding_right: '', rotate: '', animate: 'fadeInRight', 'animate_delay(ms)': '0', pos_horizontal: '20px', pos_vertical: '20px' }, _defineProperty(_defaultLayerSet, 'rotate', ''), _defineProperty(_defaultLayerSet, 'border_top_width', ''), _defineProperty(_defaultLayerSet, 'border_left_width', ''), _defineProperty(_defaultLayerSet, 'border_bottom_width', ''), _defineProperty(_defaultLayerSet, 'border_right_width', ''), _defineProperty(_defaultLayerSet, 'border_style', 'solid'), _defineProperty(_defaultLayerSet, 'border_color', ''), _defineProperty(_defaultLayerSet, 'border_radius', ''), _defineProperty(_defaultLayerSet, 'border_margin_top', ''), _defineProperty(_defaultLayerSet, 'border_margin_left', ''), _defineProperty(_defaultLayerSet, 'border_margin_bottom', ''), _defineProperty(_defaultLayerSet, 'border_margin_right', ''), _defaultLayerSet);
    var defaultButtonSet = {
        value: 'Button', animate: 'fadeInRight', 'animate_delay(ms)': '0', color: 'primary', button_style: 'background', radius: '0', size: 'normal', icon_font: ''
    };
    var fontawesome4_7 = ['fa-address-book', 'fa-address-book-o', 'fa-address-card', 'fa-address-card-o', 'fa-adjust', 'fa-adn', 'fa-align-center', 'fa-align-justify', 'fa-align-left', 'fa-align-right', 'fa-amazon', 'fa-ambulance', 'fa-american-sign-language-interpreting', 'fa-anchor', 'fa-android', 'fa-angellist', 'fa-angle-double-down', 'fa-angle-double-left', 'fa-angle-double-right', 'fa-angle-double-up', 'fa-angle-down', 'fa-angle-left', 'fa-angle-right', 'fa-angle-up', 'fa-apple', 'fa-archive', 'fa-area-chart', 'fa-arrow-circle-down', 'fa-arrow-circle-left', 'fa-arrow-circle-o-down', 'fa-arrow-circle-o-left', 'fa-arrow-circle-o-right', 'fa-arrow-circle-o-up', 'fa-arrow-circle-right', 'fa-arrow-circle-up', 'fa-arrow-down', 'fa-arrow-left', 'fa-arrow-right', 'fa-arrow-up', 'fa-arrows', 'fa-arrows-alt', 'fa-arrows-h', 'fa-arrows-v', 'fa-asl-interpreting', 'fa-assistive-listening-systems', 'fa-asterisk', 'fa-at', 'fa-audio-description', 'fa-automobile', 'fa-backward', 'fa-balance-scale', 'fa-ban', 'fa-bandcamp', 'fa-bank', 'fa-bar-chart', 'fa-bar-chart-o', 'fa-barcode', 'fa-bars', 'fa-bath', 'fa-bathtub', 'fa-battery', 'fa-battery-0', 'fa-battery-1', 'fa-battery-2', 'fa-battery-3', 'fa-battery-4', 'fa-battery-empty', 'fa-battery-full', 'fa-battery-half', 'fa-battery-quarter', 'fa-battery-three-quarters', 'fa-bed', 'fa-beer', 'fa-behance', 'fa-behance-square', 'fa-bell', 'fa-bell-o', 'fa-bell-slash', 'fa-bell-slash-o', 'fa-bicycle', 'fa-binoculars', 'fa-birthday-cake', 'fa-bitbucket', 'fa-bitbucket-square', 'fa-bitcoin', 'fa-black-tie', 'fa-blind', 'fa-bluetooth', 'fa-bold', 'fa-bolt', 'fa-bomb', 'fa-book', 'fa-bookmark', 'fa-bookmark-o', 'fa-braille', 'fa-briefcase', 'fa-btc', 'fa-bug', 'fa-building', 'fa-building-o', 'fa-bullhorn', 'fa-bullseye', 'fa-bus', 'fa-buysellads', 'fa-cab', 'fa-calculator', 'fa-calendar', 'fa-calendar-check-o', 'fa-calendar-minus-o', 'fa-calendar-o', 'fa-calendar-plus-o', 'fa-calendar-times-o', 'fa-camera', 'fa-camera-retro', 'fa-car', 'fa-caret-down', 'fa-caret-left', 'fa-caret-right', 'fa-caret-square-o-down', 'fa-caret-square-o-left', 'fa-caret-square-o-right', 'fa-caret-square-o-up', 'fa-caret-up', 'fa-cart-arrow-down', 'fa-cart-plus', 'fa-cc', 'fa-cc-amex', 'fa-cc-diners-club', 'fa-cc-discover', 'fa-cc-jcb', 'fa-cc-mastercard', 'fa-cc-paypal', 'fa-cc-stripe', 'fa-cc-visa', 'fa-certificate', 'fa-chain', 'fa-chain-broken', 'fa-check', 'fa-check-circle', 'fa-check-circle-o', 'fa-check-square', 'fa-check-square-o', 'fa-chevron-circle-down', 'fa-chevron-circle-left', 'fa-chevron-circle-right', 'fa-chevron-circle-up', 'fa-chevron-down', 'fa-chevron-left', 'fa-chevron-right', 'fa-chevron-up', 'fa-child', 'fa-chrome', 'fa-circle', 'fa-circle-o', 'fa-circle-o-notch', 'fa-circle-thin', 'fa-clipboard', 'fa-clock-o', 'fa-clone', 'fa-close', 'fa-cloud', 'fa-cloud-download', 'fa-cloud-upload', 'fa-cny', 'fa-code', 'fa-code-fork', 'fa-codepen', 'fa-codiepie', 'fa-coffee', 'fa-cog', 'fa-cogs', 'fa-columns', 'fa-comment', 'fa-comment-o', 'fa-commenting', 'fa-commenting-o', 'fa-comments', 'fa-comments-o', 'fa-compass', 'fa-compress', 'fa-connectdevelop', 'fa-contao', 'fa-copy', 'fa-copyright', 'fa-creative-commons', 'fa-credit-card', 'fa-credit-card-alt', 'fa-crop', 'fa-crosshairs', 'fa-css3', 'fa-cube', 'fa-cubes', 'fa-cut', 'fa-cutlery', 'fa-dashboard', 'fa-dashcube', 'fa-database', 'fa-deaf', 'fa-deafness', 'fa-dedent', 'fa-delicious', 'fa-desktop', 'fa-deviantart', 'fa-diamond', 'fa-digg', 'fa-dollar', 'fa-dot-circle-o', 'fa-download', 'fa-dribbble', 'fa-drivers-license', 'fa-drivers-license-o', 'fa-dropbox', 'fa-drupal', 'fa-edge', 'fa-edit', 'fa-eercast', 'fa-eject', 'fa-ellipsis-h', 'fa-ellipsis-v', 'fa-empire', 'fa-envelope', 'fa-envelope-o', 'fa-envelope-open', 'fa-envelope-open-o', 'fa-envelope-square', 'fa-envira', 'fa-eraser', 'fa-etsy', 'fa-eur', 'fa-euro', 'fa-exchange', 'fa-exclamation', 'fa-exclamation-circle', 'fa-exclamation-triangle', 'fa-expand', 'fa-expeditedssl', 'fa-external-link', 'fa-external-link-square', 'fa-eye', 'fa-eye-slash', 'fa-eyedropper', 'fa-fa', 'fa-facebook', 'fa-facebook-f', 'fa-facebook-official', 'fa-facebook-square', 'fa-fast-backward', 'fa-fast-forward', 'fa-fax', 'fa-feed', 'fa-female', 'fa-fighter-jet', 'fa-file', 'fa-file-archive-o', 'fa-file-audio-o', 'fa-file-code-o', 'fa-file-excel-o', 'fa-file-image-o', 'fa-file-movie-o', 'fa-file-o', 'fa-file-pdf-o', 'fa-file-photo-o', 'fa-file-picture-o', 'fa-file-powerpoint-o', 'fa-file-sound-o', 'fa-file-text', 'fa-file-text-o', 'fa-file-video-o', 'fa-file-word-o', 'fa-file-zip-o', 'fa-files-o', 'fa-film', 'fa-filter', 'fa-fire', 'fa-fire-extinguisher', 'fa-firefox', 'fa-first-order', 'fa-flag', 'fa-flag-checkered', 'fa-flag-o', 'fa-flash', 'fa-flask', 'fa-flickr', 'fa-floppy-o', 'fa-folder', 'fa-folder-o', 'fa-folder-open', 'fa-folder-open-o', 'fa-font', 'fa-font-awesome', 'fa-fonticons', 'fa-fort-awesome', 'fa-forumbee', 'fa-forward', 'fa-foursquare', 'fa-free-code-camp', 'fa-frown-o', 'fa-futbol-o', 'fa-gamepad', 'fa-gavel', 'fa-gbp', 'fa-ge', 'fa-gear', 'fa-gears', 'fa-genderless', 'fa-get-pocket', 'fa-gg', 'fa-gg-circle', 'fa-gift', 'fa-git', 'fa-git-square', 'fa-github', 'fa-github-alt', 'fa-github-square', 'fa-gitlab', 'fa-gittip', 'fa-glass', 'fa-glide', 'fa-glide-g', 'fa-globe', 'fa-google', 'fa-google-plus', 'fa-google-plus-circle', 'fa-google-plus-official', 'fa-google-plus-square', 'fa-google-wallet', 'fa-graduation-cap', 'fa-gratipay', 'fa-grav', 'fa-group', 'fa-h-square', 'fa-hacker-news', 'fa-hand-grab-o', 'fa-hand-lizard-o', 'fa-hand-o-down', 'fa-hand-o-left', 'fa-hand-o-right', 'fa-hand-o-up', 'fa-hand-paper-o', 'fa-hand-peace-o', 'fa-hand-pointer-o', 'fa-hand-rock-o', 'fa-hand-scissors-o', 'fa-hand-spock-o', 'fa-hand-stop-o', 'fa-handshake-o', 'fa-hard-of-hearing', 'fa-hashtag', 'fa-hdd-o', 'fa-header', 'fa-headphones', 'fa-heart', 'fa-heart-o', 'fa-heartbeat', 'fa-history', 'fa-home', 'fa-hospital-o', 'fa-hotel', 'fa-hourglass', 'fa-hourglass-1', 'fa-hourglass-2', 'fa-hourglass-3', 'fa-hourglass-end', 'fa-hourglass-half', 'fa-hourglass-o', 'fa-hourglass-start', 'fa-houzz', 'fa-html5', 'fa-i-cursor', 'fa-id-badge', 'fa-id-card', 'fa-id-card-o', 'fa-ils', 'fa-image', 'fa-imdb', 'fa-inbox', 'fa-indent', 'fa-industry', 'fa-info', 'fa-info-circle', 'fa-inr', 'fa-instagram', 'fa-institution', 'fa-internet-explorer', 'fa-intersex', 'fa-ioxhost', 'fa-italic', 'fa-joomla', 'fa-jpy', 'fa-jsfiddle', 'fa-key', 'fa-keyboard-o', 'fa-krw', 'fa-language', 'fa-laptop', 'fa-lastfm', 'fa-lastfm-square', 'fa-leaf', 'fa-leanpub', 'fa-legal', 'fa-lemon-o', 'fa-level-down', 'fa-level-up', 'fa-life-bouy', 'fa-life-buoy', 'fa-life-ring', 'fa-life-saver', 'fa-lightbulb-o', 'fa-line-chart', 'fa-link', 'fa-linkedin', 'fa-linkedin-square', 'fa-linode', 'fa-linux', 'fa-list', 'fa-list-alt', 'fa-list-ol', 'fa-list-ul', 'fa-location-arrow', 'fa-lock', 'fa-long-arrow-down', 'fa-long-arrow-left', 'fa-long-arrow-right', 'fa-long-arrow-up', 'fa-low-vision', 'fa-magic', 'fa-magnet', 'fa-mail-forward', 'fa-mail-reply', 'fa-mail-reply-all', 'fa-male', 'fa-map', 'fa-map-marker', 'fa-map-o', 'fa-map-pin', 'fa-map-signs', 'fa-mars', 'fa-mars-double', 'fa-mars-stroke', 'fa-mars-stroke-h', 'fa-mars-stroke-v', 'fa-maxcdn', 'fa-meanpath', 'fa-medium', 'fa-medkit', 'fa-meetup', 'fa-meh-o', 'fa-mercury', 'fa-microchip', 'fa-microphone', 'fa-microphone-slash', 'fa-minus', 'fa-minus-circle', 'fa-minus-square', 'fa-minus-square-o', 'fa-mixcloud', 'fa-mobile', 'fa-mobile-phone', 'fa-modx', 'fa-money', 'fa-moon-o', 'fa-mortar-board', 'fa-motorcycle', 'fa-mouse-pointer', 'fa-music', 'fa-navicon', 'fa-neuter', 'fa-newspaper-o', 'fa-object-group', 'fa-object-ungroup', 'fa-odnoklassniki', 'fa-odnoklassniki-square', 'fa-opencart', 'fa-openid', 'fa-opera', 'fa-optin-monster', 'fa-outdent', 'fa-pagelines', 'fa-paint-brush', 'fa-paper-plane', 'fa-paper-plane-o', 'fa-paperclip', 'fa-paragraph', 'fa-paste', 'fa-pause', 'fa-pause-circle', 'fa-pause-circle-o', 'fa-paw', 'fa-paypal', 'fa-pencil', 'fa-pencil-square', 'fa-pencil-square-o', 'fa-percent', 'fa-phone', 'fa-phone-square', 'fa-photo', 'fa-picture-o', 'fa-pie-chart', 'fa-pied-piper', 'fa-pied-piper-alt', 'fa-pied-piper-pp', 'fa-pinterest', 'fa-pinterest-p', 'fa-pinterest-square', 'fa-plane', 'fa-play', 'fa-play-circle', 'fa-play-circle-o', 'fa-plug', 'fa-plus', 'fa-plus-circle', 'fa-plus-square', 'fa-plus-square-o', 'fa-podcast', 'fa-power-off', 'fa-print', 'fa-product-hunt', 'fa-puzzle-piece', 'fa-qq', 'fa-qrcode', 'fa-question', 'fa-question-circle', 'fa-question-circle-o', 'fa-quora', 'fa-quote-left', 'fa-quote-right', 'fa-ra', 'fa-random', 'fa-ravelry', 'fa-rebel', 'fa-recycle', 'fa-reddit', 'fa-reddit-alien', 'fa-reddit-square', 'fa-refresh', 'fa-registered', 'fa-remove', 'fa-renren', 'fa-reorder', 'fa-repeat', 'fa-reply', 'fa-reply-all', 'fa-resistance', 'fa-retweet', 'fa-rmb', 'fa-road', 'fa-rocket', 'fa-rotate-left', 'fa-rotate-right', 'fa-rouble', 'fa-rss', 'fa-rss-square', 'fa-rub', 'fa-ruble', 'fa-rupee', 'fa-s15', 'fa-safari', 'fa-save', 'fa-scissors', 'fa-scribd', 'fa-search', 'fa-search-minus', 'fa-search-plus', 'fa-sellsy', 'fa-send', 'fa-send-o', 'fa-server', 'fa-share', 'fa-share-alt', 'fa-share-alt-square', 'fa-share-square', 'fa-share-square-o', 'fa-shekel', 'fa-sheqel', 'fa-shield', 'fa-ship', 'fa-shirtsinbulk', 'fa-shopping-bag', 'fa-shopping-basket', 'fa-shopping-cart', 'fa-shower', 'fa-sign-in', 'fa-sign-language', 'fa-sign-out', 'fa-signal', 'fa-signing', 'fa-simplybuilt', 'fa-sitemap', 'fa-skyatlas', 'fa-skype', 'fa-slack', 'fa-sliders', 'fa-slideshare', 'fa-smile-o', 'fa-snapchat', 'fa-snapchat-ghost', 'fa-snapchat-square', 'fa-snowflake-o', 'fa-soccer-ball-o', 'fa-sort', 'fa-sort-alpha-asc', 'fa-sort-alpha-desc', 'fa-sort-amount-asc', 'fa-sort-amount-desc', 'fa-sort-asc', 'fa-sort-desc', 'fa-sort-down', 'fa-sort-numeric-asc', 'fa-sort-numeric-desc', 'fa-sort-up', 'fa-soundcloud', 'fa-space-shuttle', 'fa-spinner', 'fa-spoon', 'fa-spotify', 'fa-square', 'fa-square-o', 'fa-stack-exchange', 'fa-stack-overflow', 'fa-star', 'fa-star-half', 'fa-star-half-empty', 'fa-star-half-full', 'fa-star-half-o', 'fa-star-o', 'fa-steam', 'fa-steam-square', 'fa-step-backward', 'fa-step-forward', 'fa-stethoscope', 'fa-sticky-note', 'fa-sticky-note-o', 'fa-stop', 'fa-stop-circle', 'fa-stop-circle-o', 'fa-street-view', 'fa-strikethrough', 'fa-stumbleupon', 'fa-stumbleupon-circle', 'fa-subscript', 'fa-subway', 'fa-suitcase', 'fa-sun-o', 'fa-superpowers', 'fa-superscript', 'fa-support', 'fa-table', 'fa-tablet', 'fa-tachometer', 'fa-tag', 'fa-tags', 'fa-tasks', 'fa-taxi', 'fa-telegram', 'fa-television', 'fa-tencent-weibo', 'fa-terminal', 'fa-text-height', 'fa-text-width', 'fa-th', 'fa-th-large', 'fa-th-list', 'fa-themeisle', 'fa-thermometer', 'fa-thermometer-0', 'fa-thermometer-1', 'fa-thermometer-2', 'fa-thermometer-3', 'fa-thermometer-4', 'fa-thermometer-empty', 'fa-thermometer-full', 'fa-thermometer-half', 'fa-thermometer-quarter', 'fa-thermometer-three-quarters', 'fa-thumb-tack', 'fa-thumbs-down', 'fa-thumbs-o-down', 'fa-thumbs-o-up', 'fa-thumbs-up', 'fa-ticket', 'fa-times', 'fa-times-circle', 'fa-times-circle-o', 'fa-times-rectangle', 'fa-times-rectangle-o', 'fa-tint', 'fa-toggle-down', 'fa-toggle-left', 'fa-toggle-off', 'fa-toggle-on', 'fa-toggle-right', 'fa-toggle-up', 'fa-trademark', 'fa-train', 'fa-transgender', 'fa-transgender-alt', 'fa-trash', 'fa-trash-o', 'fa-tree', 'fa-trello', 'fa-tripadvisor', 'fa-trophy', 'fa-truck', 'fa-try', 'fa-tty', 'fa-tumblr', 'fa-tumblr-square', 'fa-turkish-lira', 'fa-tv', 'fa-twitch', 'fa-twitter', 'fa-twitter-square', 'fa-umbrella', 'fa-underline', 'fa-undo', 'fa-universal-access', 'fa-university', 'fa-unlink', 'fa-unlock', 'fa-unlock-alt', 'fa-unsorted', 'fa-upload', 'fa-usb', 'fa-usd', 'fa-user', 'fa-user-circle', 'fa-user-circle-o', 'fa-user-md', 'fa-user-o', 'fa-user-plus', 'fa-user-secret', 'fa-user-times', 'fa-users', 'fa-vcard', 'fa-vcard-o', 'fa-venus', 'fa-venus-double', 'fa-venus-mars', 'fa-viacoin', 'fa-viadeo', 'fa-viadeo-square', 'fa-video-camera', 'fa-vimeo', 'fa-vimeo-square', 'fa-vine', 'fa-vk', 'fa-volume-control-phone', 'fa-volume-down', 'fa-volume-off', 'fa-volume-up', 'fa-warning', 'fa-wechat', 'fa-weibo', 'fa-weixin', 'fa-whatsapp', 'fa-wheelchair', 'fa-wheelchair-alt', 'fa-wifi', 'fa-wikipedia-w', 'fa-window-close', 'fa-window-close-o', 'fa-window-maximize', 'fa-window-minimize', 'fa-window-restore', 'fa-windows', 'fa-won', 'fa-wordpress', 'fa-wpbeginner', 'fa-wpexplorer', 'fa-wpforms', 'fa-wrench', 'fa-xing', 'fa-xing-square', 'fa-y-combinator', 'fa-y-combinator-square', 'fa-yahoo', 'fa-yc', 'fa-yc-square', 'fa-yelp', 'fa-yen', 'fa-yoast', 'fa-youtube', 'fa-youtube-play', 'fa-youtube-square'];
    var layersettings = Object.assign({ title: 'Layer Settings', type: 'settings' }, defaultLayerSet);
    var slideObjs = {
        slide1: {
            title: 'Slide 1',
            layers: {
                layer1: {
                    title: 'Layer 1',
                    elements: {
                        settings: layersettings,
                        textbox1: { title: 'Text Box 1', value: 'Textbox 1 slide1 l1', type: 'text' },
                        textbox2: { title: 'Text Box 2', value: 'Textbox 2 slide1 l1', type: 'text' },
                        button1: { title: 'Button 1', value: 'Buttno1 slide1', animate: '', delay: '', type: 'button' }
                    }
                },
                layer2: {
                    title: 'Layer 2',
                    elements: {
                        settings: layersettings,
                        textbox1: { title: 'Text Box 1', value: 'Textbox 1 slide1 l2', type: 'text' },
                        textbox2: { title: 'Text Box 2', value: 'Textbox 2 slide1 l2', type: 'text' },
                        button1: { title: 'Button 1', value: '', animate: '', delay: '', type: 'button' }
                    }
                }
            }
        },
        slide2: {
            title: 'Slide 2',
            layers: {
                layer1: {
                    title: 'Layer 1 Slide2',
                    elements: {
                        settings: layersettings,
                        textbox1: { title: 'Text Box 1', value: 'Text box 1', type: 'text' },
                        textbox2: { title: 'Text Box 2', value: 'Text Box 1', type: 'text' },
                        button1: { title: 'Button 1', value: 'Text Box1', animate: '', delay: '', type: 'button' }
                    }
                },
                layer2: {
                    title: 'Layer 2 slide2',
                    elements: {
                        settings: layersettings,
                        textbox1: { title: 'Text Box 1', value: 'Text Box1', type: 'text' },
                        textbox2: { title: 'Text Box 2', value: 'Text Box2', type: 'text' },
                        button1: { title: 'Button 1', value: 'Buton 1', animate: '', delay: '', type: 'button' }
                    }
                }
            }
        }
    };
    function create_tabs(objs) {
        var tabs = [];
        for (x in objs) {
            tabs.push({ name: x, title: objs[x].title, className: 'wan-control-tabs-tab' });
        }
        return tabs;
    }
    function update_hero_sliders(newvl, objs, props) {
        var _props$attributes = props.attributes,
            curslide = _props$attributes.curslide,
            curlayer = _props$attributes.curlayer,
            curelement = _props$attributes.curelement,
            curoption = _props$attributes.curoption,
            slide_strobj = _props$attributes.slide_strobj,
            setAttributes = props.setAttributes;
    
        objs[curslide].layers[curlayer].elements[curelement][curoption] = newvl;
        setAttributes({ slide_strobj: JSON.stringify(objs) });
    }
    var handleClick = function handleClick(event, props) {
        var _props$attributes2 = props.attributes,
            curslide = _props$attributes2.curslide,
            curlayer = _props$attributes2.curlayer,
            curelement = _props$attributes2.curelement,
            curoption = _props$attributes2.curoption,
            setAttributes = props.setAttributes;
    
        if (event.target.getAttribute('slide')) {
            setAttributes({ curslide: event.target.getAttribute('slide') });
            setAttributes({ curlayer: event.target.getAttribute('layer') });
            setAttributes({ curelement: event.target.getAttribute('element') });
            setAttributes({ curoption: event.target.getAttribute('keyoption') });
        }
    };
    function wan_create_slide_range(slidekey, layerkey, elementkey, keysettings, pel, objs, props, min, max) {
        return wp.element.createElement(RangeControl, {
            label: autoname(keysettings),
            value: pel[elementkey][keysettings],
            layer: layerkey,
            slide: slidekey,
            element: elementkey,
            keyoption: keysettings
            // onClick={(event)=>handleClick(event,props)}
            , onMouseDown: function onMouseDown(event) {
                return handleClick(event, props);
            },
            onChange: function onChange(newvl) {
                return update_hero_sliders(newvl, objs, props);
            },
            min: min,
            max: max
        });
    }
    function get_rgba(color) {
        if (color.rgb) {
            return 'rgba(' + color.rgb.r + ',' + color.rgb.g + ',' + color.rgb.b + ',' + color.rgb.a + ')';
        }
    }
    var animateoptions = { "Attention Seekers": ["bounce", "flash", "pulse", "rubberBand", "shake", "swing", "tada", "wobble", "jello", "heartBeat"], "Bouncing Entrances": ["bounceIn", "bounceInDown", "bounceInLeft", "bounceInRight", "bounceInUp"], "Bouncing Exits": ["bounceOut", "bounceOutDown", "bounceOutLeft", "bounceOutRight", "bounceOutUp"], "Fading Entrances": ["fadeIn", "fadeInDown", "fadeInDownBig", "fadeInLeft", "fadeInLeftBig", "fadeInRight", "fadeInRightBig", "fadeInUp", "fadeInUpBig"], "Fading Exits": ["fadeOut", "fadeOutDown", "fadeOutDownBig", "fadeOutLeft", "fadeOutLeftBig", "fadeOutRight", "fadeOutRightBig", "fadeOutUp", "fadeOutUpBig"], "Flippers": ["flip", "flipInX", "flipInY", "flipOutX", "flipOutY"], "Lightspeed": ["lightSpeedIn", "lightSpeedOut"], "Rotating Entrances": ["rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight"], "Rotating Exits": ["rotateOut", "rotateOutDownLeft", "rotateOutDownRight", "rotateOutUpLeft", "rotateOutUpRight"], "Sliding Entrances": ["slideInUp", "slideInDown", "slideInLeft", "slideInRight"], "Sliding Exits": ["slideOutUp", "slideOutDown", "slideOutLeft", "slideOutRight"], "Zoom Entrances": ["zoomIn", "zoomInDown", "zoomInLeft", "zoomInRight", "zoomInUp"], "Zoom Exits": ["zoomOut", "zoomOutDown", "zoomOutLeft", "zoomOutRight", "zoomOutUp"], "Specials": ["hinge", "jackInTheBox", "rollIn", "rollOut"] };
    function render_slide_field_settings(slidekey, layerkey, elementkey, keysettings, pel, objs, props) {
        switch (keysettings) {
            case 'rotate':
                return wan_create_slide_range(slidekey, layerkey, elementkey, keysettings, pel, objs, props, -180, 180);
                break;
            case 'pos_horizontal':
                return wan_create_slide_range(slidekey, layerkey, elementkey, keysettings, pel, objs, props, 0, 100);
                break;
            case 'pos_vertical':
                return wan_create_slide_range(slidekey, layerkey, elementkey, keysettings, pel, objs, props, 0, 100);
                break;
            case 'scale':
                return wan_create_slide_range(slidekey, layerkey, elementkey, keysettings, pel, objs, props, 0, 600);
                break;
            case 'color':
            case 'border_color':
            case 'background_color':
                return wp.element.createElement(
                    Fragment,
                    null,
                    wp.element.createElement(Dropdown, {
                        className: 'my-container-class-name',
                        contentClassName: 'my-popover-content-classname',
                        position: 'bottom right',
    
                        renderToggle: function renderToggle(_ref) {
                            var isOpen = _ref.isOpen,
                                onToggle = _ref.onToggle;
                            return wp.element.createElement(
                                'p',
                                null,
                                wp.element.createElement(
                                    'span',
                                    null,
                                    autoname(keysettings),
                                    ': '
                                ),
                                wp.element.createElement(
                                    Button,
                                    { className: 'border text-white', onClick: onToggle, 'aria-expanded': isOpen,
                                        label: autoname(keysettings),
                                        color: pel[elementkey][keysettings],
                                        layer: layerkey,
                                        slide: slidekey,
                                        style: { backgroundColor: pel[elementkey][keysettings] },
                                        element: elementkey,
                                        keyoption: keysettings,
                                        onMouseDown: function onMouseDown(event) {
                                            return handleClick(event, props);
                                        } },
                                    'Toggle Popover'
                                )
                            );
                        },
                        renderContent: function renderContent() {
                            return wp.element.createElement(ColorPicker, {
                                onChangeComplete: function onChangeComplete(color) {
                                    return update_hero_sliders(get_rgba(color), objs, props);
                                },
                                alpha: true
                            });
                        }
                    })
                );
                break;
            case 'animate':
                return wp.element.createElement(
                    'p',
                    null,
                    wp.element.createElement(
                        'select',
                        {
                            layer: layerkey,
                            slide: slidekey,
                            element: elementkey,
                            keyoption: keysettings,
                            onMouseDown: function onMouseDown(event) {
                                return handleClick(event, props);
                            },
                            onChange: function onChange(newvl) {
                                return update_hero_sliders(newvl.target.value, objs, props);
                            }
                        },
                        wp.components.wancreateopts(pel[elementkey][keysettings], animateoptions)
                    )
                );
                break;
            case 'icon_font':
                return wp.element.createElement(
                    'p',
                    null,
                    wp.element.createElement(
                        'select',
                        {
                            layer: layerkey,
                            slide: slidekey,
                            element: elementkey,
                            keyoption: keysettings,
                            onMouseDown: function onMouseDown(event) {
                                return handleClick(event, props);
                            },
                            onChange: function onChange(newvl) {
                                return update_hero_sliders(newvl.target.value, objs, props);
                            }
                        },
                        wp.components.wancreateopts(pel[elementkey][keysettings], fontawesome4_7)
                    )
                );
                break;
            case 'text_align':
                return wp.element.createElement(SelectControl, {
                    label: autoname(keysettings),
                    layer: layerkey,
                    slide: slidekey,
                    element: elementkey,
                    keyoption: keysettings,
                    onMouseDown: function onMouseDown(event) {
                        return handleClick(event, props);
                    },
                    onChange: function onChange(newvl) {
                        return update_hero_sliders(newvl, objs, props);
                    },
                    value: pel[elementkey][keysettings],
                    options: [{ label: 'Left', value: 'text-left' }, { label: 'Center', value: 'text-center' }, { label: 'Right', value: 'text-right' }]
                });
                break;
            case 'border_style':
                return wp.element.createElement(SelectControl, {
                    label: autoname(keysettings),
                    layer: layerkey,
                    slide: slidekey,
                    element: elementkey,
                    keyoption: keysettings,
                    onMouseDown: function onMouseDown(event) {
                        return handleClick(event, props);
                    },
                    onChange: function onChange(newvl) {
                        return update_hero_sliders(newvl, objs, props);
                    },
                    value: pel[elementkey][keysettings],
                    options: [{ label: 'Solid', value: 'solid' }, { label: 'Dashed', value: 'dashed' }, { label: 'Dotted', value: 'dotted' }]
                });
                break;
            case 'width':
                return wp.element.createElement(RangeControl, {
                    label: autoname(keysettings),
                    value: pel[elementkey][keysettings],
                    layer: layerkey,
                    slide: slidekey,
                    element: elementkey,
                    keyoption: keysettings
                    // onClick={(event)=>handleClick(event,props)}
                    , onMouseDown: function onMouseDown(event) {
                        return handleClick(event, props);
                    },
                    onChange: function onChange(newvl) {
                        return update_hero_sliders(newvl, objs, props);
                    },
                    min: 0,
                    max: 100
                });
                break;
    
            default:
                var controlCls = ['padding_top', 'padding_bottom', 'padding_left', 'padding_right', 'border_margin_bottom', 'border_margin_left', 'border_margin_right', 'border_margin_top', 'border_bottom_width', 'border_top_width', 'border_left_width', 'border_right_width'].indexOf(keysettings) != -1 ? 'd-inline-block w-25' : '';
                return wp.element.createElement(TextControl, {
                    className: controlCls,
                    label: autoname(keysettings),
                    value: pel[elementkey][keysettings],
                    layer: layerkey,
                    slide: slidekey,
                    element: elementkey,
                    keyoption: keysettings,
                    onClick: function onClick(event) {
                        return handleClick(event, props);
                    },
                    onChange: function onChange(newvl) {
                        return update_hero_sliders(newvl, objs, props);
                    }
                });
                break;
        }
    }
    
    function render_panel(objs, props) {
        var output = {};
        for (slidekey in objs) {
            var slide = objs[slidekey];
            var layers = slide.layers;
            var slideelements = [];
            for (layerkey in layers) {
                var layer = layers[layerkey];
                var pel = layer.elements;
                var elements = [];
                for (elementkey in pel) {
                    switch (pel[elementkey].type) {
                        case 'button':
                            var elsettings = [];
                            for (keysettings in defaultButtonSet) {
                                elsettings.push(render_slide_field_settings(slidekey, layerkey, elementkey, keysettings, pel, objs, props));
                            }
                            elements.push(wp.element.createElement(
                                Fragment,
                                null,
                                elsettings
                            ));
                            elements.push(wp.element.createElement(
                                'button',
                                null,
                                pel[elementkey].value
                            ));
                            break;
                        case 'settings':
                            var elsettings = [];
                            for (keysettings in defaultLayerSet) {
                                elsettings.push(render_slide_field_settings(slidekey, layerkey, elementkey, keysettings, pel, objs, props));
                            }
                            elements.push(wp.element.createElement(
                                PanelBody,
                                { title: pel[elementkey].title, initialOpen: false },
                                elsettings
                            ));
                            break;
                        default:
                            elements.push(wp.element.createElement(TextareaControl, {
                                label: pel[elementkey].title,
                                value: pel[elementkey].value,
                                layer: layerkey,
                                slide: slidekey,
                                element: elementkey,
                                keyoption: 'value',
                                onClick: function onClick(event) {
                                    return handleClick(event, props);
                                },
                                onChange: function onChange(newvl) {
                                    return update_hero_sliders(newvl, objs, props);
                                }
                            }));
                            break;
                    }
                }
                slideelements.push(wp.element.createElement(
                    PanelBody,
                    { title: layer.title, initialOpen: false },
                    elements
                ));
            }
            output[slidekey] = slideelements;
        }
        return output;
    }
    function autoname(string) {
        var newstr = string.charAt(0).toUpperCase() + string.slice(1);
        return newstr.split('_').join(' ');
    }
    wp.cleanObj = function (obj) {
        for (var propName in obj) {
            if (obj[propName] === null || obj[propName] === undefined || obj[propName] == '') {
                delete obj[propName];
            }
        }
        return obj;
    };
    var wan_border_layer_render = function wan_border_layer_render(attr) {
        if (attr) {
            var tmp_attr = {
    
                // backgroundImage: "url(" + attr.bg_img + ")",
                // backgroundSize: attr.bg_size,
                // backgroundRepeat: attr.bg_repeat,
    
                borderTopWidth: attr.border_top_width,
                borderBottomWidth: attr.border_bottom_width,
                borderLeftWidth: attr.border_left_width,
                borderRightWidth: attr.border_right_width,
                borderStyle: attr.border_style,
                borderColor: attr.border_color,
                borderRadius: attr.border_radius,
    
                top: attr.border_margin_top,
                left: attr.border_margin_left,
                bottom: attr.border_margin_bottom,
                right: attr.border_margin_right
            };
            return wp.cleanObj(tmp_attr);
        };
    };
    var wan_style_layer_render = function wan_style_layer_render(attr) {
        if (attr) {
            var tmp_attr = {
                color: attr.color,
                backgroundColor: attr.background_color,
                paddingTop: attr.padding_top,
                paddingBottom: attr.padding_bottom,
                paddingLeft: attr.padding_left,
                paddingRight: attr.padding_right,
                fontSize: attr.scale + "%",
                borderRadius: attr.background_radius
            };
            return wp.cleanObj(tmp_attr);
        }
    };
    function wan_render_sliders(edit_slideobj) {
        var output = [];
        var slihtml = [];
        for (slidekey in edit_slideobj) {
            var slide = edit_slideobj[slidekey];
            var layers = slide.layers;
            var lahtml = [];
            for (layerkey in layers) {
                var elements = layers[layerkey].elements;
                var elsettings = elements.settings;
                var elhtml = [];
                for (elkey in elements) {
                    var cls = "slide-" + elements[elkey].type;
                    switch (elements[elkey].type) {
                        case 'text':
                            elhtml.push(wp.element.createElement(
                                'div',
                                { className: cls },
                                wp.element.createElement(
                                    RawHTML,
                                    null,
                                    elements[elkey].value
                                )
                            ));
                            break;
                        case 'button':
                            cls += ' btn';
                            elhtml.push(wp.element.createElement(
                                'a',
                                { className: cls, href: '#' },
                                elements[elkey].value
                            ));
                            break;
                    }
                }
    
                // animate nam rieng 1 div (de rotate ko anh huong animate)
                // style & rotate 1 div
                // border nam rieng 1 div
    
                var border = wan_border_layer_render(elsettings);
                var clsrotate = "style rotate-" + elsettings.rotate + ' ' + elsettings.text_align;
                var style = wan_style_layer_render(elsettings);
                var clslayer = "slide-layer pw-" + elsettings.width + ' posx-' + elsettings.pos_horizontal + ' posy-' + elsettings.pos_vertical;
                lahtml.push(wp.element.createElement(
                    'div',
                    { className: clslayer },
                    wp.element.createElement(
                        'div',
                        { className: elsettings.animate + " animated" },
                        wp.element.createElement(
                            'div',
                            { className: clsrotate, style: style },
                            wp.element.createElement('div', { className: 'layer_border', style: border }),
                            elhtml
                        )
                    )
                ));
            }
            slihtml.push(wp.element.createElement(
                'div',
                { className: 'wan-slide' },
                lahtml
            ));
        }
        output.push(wp.element.createElement(
            'div',
            { className: 'wan-hero-sliders' },
            slihtml
        ));
        return output;
    }
    registerBlockType('wan-gutenberg/wan-hero-sliders', {
        title: __('wan Hero Slider', 'wan'),
        icon: 'images-alt2',
        category: 'wan-blocks',
        attributes: {
            slider_height: {
                type: 'string',
                default: '200px'
            },
            slide_strobj: {
                type: 'string',
                default: JSON.stringify(slideObjs)
            },
            curslide: {
                type: 'string',
                default: 'slide1'
            },
            curlayer: {
                type: 'string',
                default: 'layer1'
            },
            curelement: {
                type: 'string',
                default: 'textbox1'
            },
            curoption: {
                type: 'string',
                default: 'value'
            }
        },
        edit: function edit(props) {
            var slide_strobj = props.attributes.slide_strobj;
    
            var edit_slideobj = JSON.parse(slide_strobj);
            return wp.element.createElement(
                Fragment,
                null,
                wan_render_sliders(edit_slideobj),
                wp.element.createElement(
                    InspectorControls,
                    null,
                    wp.element.createElement(
                        TabPanel,
                        {
                            className: 'wan-control-tabs',
                            tabs: create_tabs(edit_slideobj) },
                        function (tab) {
                            var slides = render_panel(edit_slideobj, props);
                            return wp.element.createElement(
                                Fragment,
                                null,
                                slides[tab.name]
                            );
                        }
                    )
                )
            );
        },
        save: function save(props) {}
    });
    registerBlockType('wan-gutenberg/wan-easy-sliders', {
        title: __('wan Easy Slider', 'wan'),
        icon: 'images-alt2',
        category: 'layout',
        attributes: {
            content: {
                type: 'array',
                source: 'children',
                selector: 'p'
            },
    
            slider_height: {
                type: 'string',
                default: '200px'
            },
            navitem_height: {
                type: 'string',
                default: '80px'
            },
            thumbitems: {
                type: 'string',
                default: 5
            },
            stringSliders: {
                type: 'string',
                default: JSON.stringify(defaultAtts.sliders)
            },
            current_slider: {
                type: 'string',
                default: 'slider1'
            },
            curtitle: {
                type: 'string',
                default: ''
            },
            curdesc: {
                type: 'string',
                default: ''
            },
            privatecls: {
                type: 'string',
                default: ''
            }
        },
        edit: function edit(props) {
            var _props$attributes3 = props.attributes,
                thumbitems = _props$attributes3.thumbitems,
                navitem_height = _props$attributes3.navitem_height,
                privatecls = _props$attributes3.privatecls,
                content = _props$attributes3.content,
                slider_height = _props$attributes3.slider_height,
                current_slider = _props$attributes3.current_slider,
                curtitle = _props$attributes3.curtitle,
                curdesc = _props$attributes3.curdesc,
                stringSliders = _props$attributes3.stringSliders,
                setAttributes = props.setAttributes,
                className = props.className;
    
            var objkeys = [],
                slider_choose = [];
    
            var sliders = JSON.parse(stringSliders);
            if (privatecls == '') {
                setAttributes({ privatecls: Math.round(Math.random() * 1000) + "-" + Date.now() });
            }
            if (sliders) {
                objkeys = Object.keys(sliders);
                objkeys.forEach(function (vl) {
                    slider_choose.push({ label: vl, value: vl });
                });
            }
            slider_choose.push({ label: __("New Slider", 'wan'), value: 'new' });
            function update_img(media) {
                var thumb = media['sizes']['thumbnail'] ? media['sizes']['thumbnail']['url'] : media['url'];
                sliders[current_slider].img_url = media['url'];
                sliders[current_slider].img_alt = media['alt'];
                sliders[current_slider].img_thumb = thumb;
                setAttributes({ stringSliders: JSON.stringify(sliders) });
            }
            function update_info(key, value) {
                sliders[current_slider][key] = value;
                setAttributes({ stringSliders: JSON.stringify(sliders) });
            }
            function update_curSldier(value) {
                if (value == 'new') {
                    var index = objkeys.length + 1;
                    var tmp = 'slide' + index;
                    sliders[tmp] = { title: '', desc: '', img_url: '', img_alt: '', img_thumb: '' };
                    setAttributes({ stringSliders: JSON.stringify(sliders) });
                    setAttributes({ current_slider: tmp });
                } else {
                    setAttributes({ current_slider: value });
                }
            }
            function render_image() {
                return wp.element.createElement('img', { src: sliders[current_slider].img_url, alt: sliders[current_slider].img_alt });
            }
            function render_bg() {
                var style = {
                    backgroundImage: "url(" + sliders[current_slider].img_url + ")",
                    height: slider_height
                };
    
                return wp.element.createElement(
                    'div',
                    { className: 'item' },
                    wp.element.createElement('div', { className: 'wanbg-slide', alt: sliders[current_slider].img_alt, style: style })
                );
            }
    
            return wp.element.createElement(
                'div',
                null,
                render_bg(),
                wp.element.createElement(
                    InspectorControls,
                    null,
                    wp.element.createElement(TextControl, {
                        label: __('Slide Height', 'wan'),
                        value: slider_height,
                        onChange: function onChange(newvl) {
                            return setAttributes({ slider_height: newvl });
                        }
                    }),
                    wp.element.createElement(TextControl, {
                        label: __('Nav Height', 'wan'),
                        value: navitem_height,
                        onChange: function onChange(newvl) {
                            return setAttributes({ navitem_height: newvl });
                        }
                    }),
                    wp.element.createElement(TextControl, {
                        label: __('Thumb Items', 'wan'),
                        value: thumbitems,
                        onChange: function onChange(newvl) {
                            return setAttributes({ thumbitems: newvl });
                        }
                    }),
                    wp.element.createElement(MediaUpload, {
                        onSelect: function onSelect(media) {
                            return update_img(media);
                        },
                        render: function render(_ref2) {
                            var open = _ref2.open;
                            return wp.element.createElement(
                                'div',
                                null,
                                render_image(),
                                wp.element.createElement(
                                    Button,
                                    { onClick: open },
                                    'Open Media Library'
                                )
                            );
                        }
                    }),
                    wp.element.createElement(SelectControl, {
                        label: __('Select Slider Item', 'wan'),
                        value: current_slider // e.g: value = [ 'a', 'c' ]
                        , onChange: function onChange(vl) {
                            return update_curSldier(vl);
                        },
                        options: slider_choose
                    }),
                    wp.element.createElement(TextControl, {
                        label: __('Slide Title', 'wan'),
                        value: sliders[current_slider]['title'],
                        onChange: function onChange(newvl) {
                            return update_info('title', newvl);
                        }
                    }),
                    wp.element.createElement(TextareaControl, {
                        label: __('Slide Content', 'wan'),
                        value: sliders[current_slider]['desc'],
                        onChange: function onChange(newvl) {
                            return update_info('desc', newvl);
                        }
                    })
                )
            );
        },
        save: function save(props) {
            var _props$attributes4 = props.attributes,
                thumbitems = _props$attributes4.thumbitems,
                navitem_height = _props$attributes4.navitem_height,
                privatecls = _props$attributes4.privatecls,
                content = _props$attributes4.content,
                slider_height = _props$attributes4.slider_height,
                current_slider = _props$attributes4.current_slider,
                curtitle = _props$attributes4.curtitle,
                curdesc = _props$attributes4.curdesc,
                stringSliders = _props$attributes4.stringSliders,
                setAttributes = props.setAttributes,
                className = props.className;
    
            var objkeys = [];
            var sliders = JSON.parse(stringSliders);
            objkeys = Object.keys(sliders);
            function render_bg() {
                var output = [];
                objkeys.forEach(function (item) {
                    var style = {
                        backgroundImage: "url(" + sliders[item].img_url + ")",
                        height: slider_height
                    };
                    output.push(wp.element.createElement(
                        'div',
                        { className: 'item' },
                        wp.element.createElement('div', { className: 'wanbg-slide', alt: sliders[item].img_alt, style: style })
                    ));
                });
                return output;
            }
            function render_nav() {
                var output = [];
                objkeys.forEach(function (item) {
                    var style = {
                        height: navitem_height + "!important"
                    };
                    output.push(wp.element.createElement(
                        'div',
                        { className: 'thumb-item', style: style },
                        wp.element.createElement('img', { src: sliders[item].img_thumb, alt: sliders[item].img_alt }),
                        wp.element.createElement(
                            'div',
                            { className: 'thumb-detail' },
                            wp.element.createElement(
                                'h5',
                                null,
                                sliders[item]['title']
                            ),
                            wp.element.createElement(
                                'p',
                                null,
                                sliders[item]['desc']
                            )
                        )
                    ));
                });
                return output;
            }
            var herocls = "wan-sliders wan-hero-slider wan-hero-slider-" + privatecls,
                navcls = "wan-sliders slider-nav slider-nav-" + privatecls;
            var heroslick = '{"asNavFor": ".slider-nav-' + privatecls + '"}';
            var navslick = '{"asNavFor": ".wan-hero-slider-' + privatecls + '", "slidesToScroll":1, "vertical": true, "verticalSwiping": true, "focusOnSelect": true,"autoplay":false}';
            return wp.element.createElement(
                'div',
                { className: 'wan-easy-slider' },
                wp.element.createElement(
                    'div',
                    { className: herocls, 'data-items': '1', 'data-slick': heroslick },
                    render_bg()
                ),
                wp.element.createElement(
                    'div',
                    { className: navcls, 'data-items': thumbitems, 'data-dots': '', 'data-nav': '', 'data-slick': navslick },
                    render_nav()
                )
            );
        }
    });
    
    registerBlockType('wan-gutenberg/wan-clients', {
        title: __('wan Clients', 'wan'),
        icon: 'images-alt2',
        category: 'layout',
        attributes: {
            gallery: {
                type: "array",
                default: []
            }
        },
        edit: function edit(props) {
            var gallery = props.attributes.gallery,
                setAttributes = props.setAttributes,
                className = props.className;
    
            function render_gallery() {
                var output = [];
                gallery.forEach(function (item) {
                    output.push(wp.element.createElement('img', { src: item.url, alt: item.alt }));
                });
                return output;
            }
            return wp.element.createElement(
                'div',
                null,
                render_gallery(),
                wp.element.createElement(
                    InspectorControls,
                    null,
                    wp.element.createElement(MediaUpload, {
                        onSelect: function onSelect(media) {
                            return setAttributes({ gallery: media });
                        },
                        multiple: true,
                        render: function render(_ref3) {
                            var open = _ref3.open;
                            return wp.element.createElement(
                                'div',
                                null,
                                wp.element.createElement(
                                    Button,
                                    { onClick: open },
                                    'Open Media Library'
                                )
                            );
                        }
                    })
                )
            );
        },
        save: function save(attributes, setAttributes) {}
    });
    
    /***/ })
    /******/ ]);