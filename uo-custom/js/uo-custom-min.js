/**
 * Genesis Sample entry point.
 *
 * @package GenesisSample\JS
 * @author  StudioPress
 * @license GPL-2.0+
 */
var genesisSample=function(e){"use strict";var n=function(){var i=0;"fixed"===e(".site-header").css("position")&&(i=e(".site-header").outerHeight()),e(".site-inner").css("margin-top",i)},i;return{init:function(){n(),e(window).resize(function(){n()}),void 0!==wp.customize&&wp.customize.bind("change",function(i){setTimeout(function(){n()},1500)})}}}(jQuery);jQuery(window).on("load",genesisSample.init);