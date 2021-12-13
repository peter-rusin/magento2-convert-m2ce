define([
    'uiComponent',
    'mage/storage'
], function (Component, storage) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Convert_WeatherWidget/weather-widget',
            endpoint: '/rest/V1/current-weather',
            data: null,
            tracks: {
                data: true
            }
        },

        initialize: function() {
            this._super();
            storage.get(this.endpoint).done(response => this.data = response);
        }
    })
});
