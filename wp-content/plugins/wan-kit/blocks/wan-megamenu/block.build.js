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

var _wp$i18n = wp.i18n,
    __ = _wp$i18n.__,
    setLocaleData = _wp$i18n.setLocaleData;
var registerBlockType = wp.blocks.registerBlockType;
var _wp$editor = wp.editor,
    RichText = _wp$editor.RichText,
    InspectorControls = _wp$editor.InspectorControls,
    InnerBlocks = _wp$editor.InnerBlocks,
    MediaUpload = _wp$editor.MediaUpload;
var _wp$components = wp.components,
    ToggleControl = _wp$components.ToggleControl,
    ServerSideRender = _wp$components.ServerSideRender,
    TextControl = _wp$components.TextControl,
    SelectControl = _wp$components.SelectControl,
    Panel = _wp$components.Panel,
    PanelBody = _wp$components.PanelBody,
    PanelRow = _wp$components.PanelRow,
    ColorPicker = _wp$components.ColorPicker,
    ColorPalette = _wp$components.ColorPalette,
    RangeControl = _wp$components.RangeControl,
    ColorIndicator = _wp$components.ColorIndicator,
    Placeholder = _wp$components.Placeholder;
var _wp$data = wp.data,
    dispatch = _wp$data.dispatch,
    select = _wp$data.select;
var withState = wp.compose.withState;
// import { ServerSideRender } from '@wordpress/components';

var MyToggleControl = withState({
	hasFixedBackground: false
})(function (_ref) {
	var hasFixedBackground = _ref.hasFixedBackground,
	    setState = _ref.setState;
	return wp.element.createElement(ToggleControl, {
		label: 'Fixed Background',
		help: hasFixedBackground ? 'Has fixed background.' : 'No fixed background.',
		checked: hasFixedBackground,
		onChange: function onChange() {
			return setState(function (state) {
				return { hasFixedBackground: !state.hasFixedBackground };
			});
		}
	});
});
var MyServerSideRender = function MyServerSideRender() {
	return wp.element.createElement(ServerSideRender, {
		block: 'core/archives',
		attributes: {
			showPostCounts: true,
			displayAsDropdown: false
		}
	});
};
var attributes = {};
if (wan_megamenu_atr) {
	attributes = wan_megamenu_atr;
}
function choose_category(post_type) {
	var cat_name = post_type == 'post' ? 'category' : post_type + '_category';
	return wan_megamenu_atr.category.data[cat_name];
}

registerBlockType('wan-gutenberg/megamenu', {
	title: __('savit: MegaMenu', 'savit'),
	icon: 'universal-access-alt',
	category: 'layout',
	// category: 'savit Kits',
	attributes: attributes,
	edit: function edit(_ref2) {
		var attributes = _ref2.attributes,
		    setAttributes = _ref2.setAttributes;
		var product_cat = attributes.product_cat;


		return wp.element.createElement(
			'div',
			null,
			wp.element.createElement(
				'div',
				null,
				wp.element.createElement(ServerSideRender, {
					block: 'wan-gutenberg/megamenu',
					attributes: attributes
				})
			),
			wp.element.createElement(
				InspectorControls,
				null,
				wp.element.createElement(SelectControl, {
					label: __("Categories", 'savit'),
					value: product_cat,
					options: wan_megamenu_atr.product_cat.data['product_cat'],
					onChange: function onChange(newValue) {
						setAttributes({ product_cat: newValue });
					}
				})
			)
		);
	},
	save: function save() {
		return null;
		// return <div style={ blockStyle }>Basic example with JSX! (front)</div>;
	}
});

// const { createHigherOrderComponent } = wp.compose;
// const { Fragment } = wp.element;
// // const { InspectorControls } = wp.editor;
// // const { PanelBody } = wp.components;

// const withInspectorControls =  createHigherOrderComponent( ( BlockEdit ) => {
//     return ( props ) => {
//         return (
//             <Fragment>
//                 <BlockEdit { ...props } />
//                 <InspectorControls>
//                     <PanelBody>
//                         My custom control
// 						console.log()
//                     </PanelBody>
//                 </InspectorControls>
//             </Fragment>
//         );
//     };
// }, "withInspectorControl" );
// wp.hooks.addFilter( 'editor.BlockEdit', 'core/columns', withInspectorControls );

/***/ })
/******/ ]);