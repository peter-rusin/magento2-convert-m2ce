define([
    'uiComponent',
    'mage/storage'
], function (Component, storage) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Convert_Preorder/product/view/preorder/form',
            formId: 'preorder-form',
            countryOptions: [],
            form: {
                email: null,
                firstname: null,
                lastname: null,
                street1: null,
                street2: null,
                street3: null,
                city: null,
                country: null,
                region: null,
                regionId: null,
                postcode: null,
                telephone: null,
                productId: null,
                isLoggedIn: false
            }
        },

        initialize: function() {
            this._super();
        },

        placeOrder: function() {
            storage.post(
                '/rest/V1/place-preorder',
                JSON.stringify(this.form)
            ).done(response => {
                if(response.error) {
                    alert(response.error);
                } else {
                    alert(`Order ID: ${response.order_id}`);
                }
            })
        }
    })
});
