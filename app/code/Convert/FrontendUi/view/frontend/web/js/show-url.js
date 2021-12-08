define([
    'uiComponent',
], function (Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Convert_FrontendUi/show-url',
            isVisible: false,
            url: null,
            tracks: {
                isVisible: true
            },
        },

        initialize: function() {
            this._super();
        },

        toggleVisibility: function () {
            this.isVisible = !this.isVisible;
        }
    })
});
