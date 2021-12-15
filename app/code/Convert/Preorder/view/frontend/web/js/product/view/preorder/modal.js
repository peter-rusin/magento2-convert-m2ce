define([
    'jquery',
    'uiRegistry',
], function ($, registry) {
    'use strict';

    return function (config, element) {
        const modalOptions = Object.assign(config, {
            buttons: [
                {
                    text: $.mage.__('Place Order'),
                    class: 'action',
                    click: function () {
                        registry.get('preorderForm').placeOrder()
                        this.closeModal()
                    }
                }
            ]
        })

        $(element).modal(modalOptions);
    };
}
);
