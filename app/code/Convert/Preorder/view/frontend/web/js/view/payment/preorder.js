define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';

        rendererList.push(
            {
                type: 'preorder',
                component: 'Convert_Preorder/js/view/payment/method-renderer/preorder-method'
            }
        );
        return Component.extend({});
    }
);
