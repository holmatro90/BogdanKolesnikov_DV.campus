define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'Bogdank_SupportChat/js/action/send-message',
    'Magento_Ui/js/modal/modal'
], function ($, ko, Component, customerData, sendMessage) {
    'use strict';

    return Component.extend({
        defaults: {
            customerMessage: customerData.get('customer-message'),
            messages: [],
            action: ''
        },

        message: ko.observable(),
        customername: ko.observable(),

        /** @inheritDoc */
        initialize: function () {
            this._super();

            $(document).on(
                $.proxy(this.openModal, this)
            );

            this.messages.forEach(function (messageData) {
                messageData.value = ko.observable('');
            });

        },


        /**
         * Init modal from the component HTML
         */
        initModal: function (formSection) {
            this.modal = $(formSection).modal({
                buttons: []
            });
        },

        /**
         * Open modal form with chat for message
         */
        openModal: function () {
            this.modal.modal('openModal');
        },

        /**
         * Send message
         */
        sendMessage: function () {
            var payload = {
                message: this.message,
                name: this.customername,
                'form_key': $.mage.cookies.get('form_key'),
                'isAjax': 1
            };
            sendMessage(payload, this.action)

        }
    });
});