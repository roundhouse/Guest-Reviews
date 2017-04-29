/**
 * Guest Reviews plugin for Craft CMS
 *
 * GuestReviewsFieldType JS
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2017 Vadim Goncharov
 * @link      http://roundhouseagency.com/
 * @package   GuestReviews
 * @since     1.0.0
 */

 ;(function ( $, window, document, undefined ) {

    var pluginName = "GuestReviewsFieldType",
        defaults = {
        };

    // Plugin constructor
    function Plugin( element, options ) {
        this.element = element;

        this.options = $.extend( {}, defaults, options) ;

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    Plugin.prototype = {

        init: function(id) {
            var _this = this;

            $(function () {

/* -- _this.options gives us access to the $jsonVars that our FieldType passed down to us */

            });
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName,
                new Plugin( this, options ));
            }
        });
    };

})( jQuery, window, document );
