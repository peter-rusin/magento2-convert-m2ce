define([
    'jquery',
    'uiRegistry',
    'Magento_Ui/js/modal/confirm',
    'loader'
], function ($, registry, confirmation) {
    'use strict';

    return function (config, element) {
        const modalOptions = Object.assign(config, {
            buttons: [
                {
                    text: $.mage.__('Place Order'),
                    class: 'action',
                    click: function () {
                        $('[data-role=preorder] .content').trigger('processStart');
                        const promise = registry.get('preorderForm').placeOrder()
                        const $parent = this;

                        promise.done(response => {
                            confirmation({
                                title: $.mage.__('Preorder placement'),
                                content: response.error ? response.error : `Order was placed. ID: ${response.order_id}`,
                                buttons: [{
                                    text: $.mage.__('OK'),
                                    class: 'action-primary action-accept',
                                    click: function (event) {
                                        $('[data-role=preorder] .content').trigger('processStop');
                                        this.closeModal(event, true);
                                        $parent.closeModal();
                                    }
                                }]
                            });
                        })
                    }
                }
            ]
        })

        $(element).modal(modalOptions);
    };
}
);
