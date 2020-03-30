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
            template: 'Bogdank_SupportChat/chat-form',
            customerMessage: customerData.get('customer-message'),
            action: ''
        },

        message: ko.observable(),
        customername: ko.observable(),



        /**
         * Init modal from the component HTML
         */
        initModal: function (formSection) {
            this.modal = $(formSection).modal({
                buttons: []
            });
        },

        /** @inheritDoc */
        initialize: function () {
            this._super();

            $(document).on(
                $.proxy(this.openModal, this)
            );
        },


        /** @inheritDoc */
        initObservable: function () {
            var customerMessages = customerData.get('customer-message')();
            this._super();
            customerData.get('customer-message').subscribe(function (value) {
                console.log(value);
            });

            return this;
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
// debugger;
            sendMessage(payload, this.action)

        }
    });
    // Start rewriting form into the Knockout component
    // $.widget('bogdankSupportChat.form', {
    //     options: {
    //         chatButton: '.bogdank-support-chat-button',
    //         chatMessage: '#chat-messages'
    //     },
    //
    //     /**
    //      * @private
    //      */
    //     _create: function () {
    //         var self = this;
    //         this.modal = $(this.element).modal({
    //             closed: function (e) {
    //                 $(self.options.chatButton).trigger('bogdank_SupportChat_closeChat.bogdank_SupportChat');
    //             },
    //             buttons: []
    //         });
    //
    //         $(this.element).on('submit.bogdank_SupportChat', $.proxy(this.saveChat, this));
    //
    //         console.log(customerData.get('customer-message')());
    //         customerData.get('customer-message').subscribe(function (value) {
    //             console.log(value);
    //         });
    //     },
    //     /**
    //      * @private
    //      */
    //     _destroy: function () {
    //         $(document).off('bogdank_SupportChat_closeChat.bogdank_SupportChat');
    //         this.clearChat();
    //     },
    //
    //
    //     saveChat: function () {
    //         if (!this.validateForm()) {
    //             validationAlert();
    //             return;
    //         }
    //
    //         this.ajaxSubmit();
    //     },
    //
    //     clearChat: function () {
    //         $(this.options.chatMessage).empty();
    //     },
    //     /**
    //      * Validate request form
    //      */
    //     validateForm: function () {
    //         return $(this.element).validation().valid();
    //     },
    //
    //     renderMessage: function (messageData) {
    //         var today = new Date();
    //         var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    //         var $messageList = $('#chat-messages');
    //         var $messageItem = $('<li>').addClass('message-item customer');
    //         var $customerName = $('<p>').addClass('customer-name').text(messageData.customerName + ' ' + time);
    //         var $customerMessage = $('<p>').addClass('customer-message-body').text(messageData.chatMessage);
    //         var $messageItemAdmin = $('<li>').addClass('message-item admin-message');
    //         var $adminMessage = $('<p>').addClass('admin-message-body').text('Our admins will contact you shortly');
    //         $messageItem.append($customerName);
    //         $messageItem.append($customerMessage);
    //         $messageList.append($messageItem);
    //         $messageItemAdmin.append($adminMessage);
    //         $messageList.append($messageItemAdmin);
    //     }
    // });

    return $.bogdankSupportChat.form;
});