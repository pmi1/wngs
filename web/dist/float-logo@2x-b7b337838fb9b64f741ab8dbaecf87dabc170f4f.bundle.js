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
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
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
/******/ 	__webpack_require__.p = "/dist/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 39);
/******/ })
/************************************************************************/
/******/ ({

/***/ 28:
/***/ (function(module, exports, __webpack_require__) {

eval("module.exports = __webpack_require__.p + \"float-logo@2x.3d811f41364b6e34372408c67d32325b.png\";\n\n//////////////////\n// WEBPACK FOOTER\n// ./src/images/float-logo@2x.png\n// module id = 28\n// module chunks = 9\n\n//# sourceURL=webpack:///./src/images/float-logo@2x.png?");

/***/ }),

/***/ 39:
/***/ (function(module, exports, __webpack_require__) {

eval("module.exports = __webpack_require__(28);\n\n//////////////////\n// WEBPACK FOOTER\n// ./~/extract-file-loader?q=%2Fhome%2Fwww%2Fwings%2Fdata%2Fwww%2Fwings.dev.adlabs.ru%2Fwebpack%2Fsrc%2Fimages%2Ffloat-logo%402x.png!\n// module id = 39\n// module chunks = 9\n\n//# sourceURL=webpack:///?./~/extract-file-loader?q=%252Fhome%252Fwww%252Fwings%252Fdata%252Fwww%252Fwings.dev.adlabs.ru%252Fwebpack%252Fsrc%252Fimages%252Ffloat-logo%25402x.png");

/***/ })

/******/ });