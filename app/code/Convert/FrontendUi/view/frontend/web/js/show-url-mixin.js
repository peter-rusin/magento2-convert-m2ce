define([], function () {
    'use strict';
    return function (Component) {
        return Component.extend({
            toggleVisibility: function() {
                console.log('click')
                return this._super()
            }
        });
    }
});
