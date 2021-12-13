define([
    'uiComponent',
    'mage/storage'
], function (Component, storage) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Convert_PhysicalStock/product/view/physical-stock',
            productId: null,
            availability: [],
            tracks: {
                availability: true
            },
        },

        initialize: function() {
            this._super();
            storage.get(`/physicalstock/availability/index?product_id=${this.productId}`)
                .done(response => this.availability = response.items);
        },
    })
});
