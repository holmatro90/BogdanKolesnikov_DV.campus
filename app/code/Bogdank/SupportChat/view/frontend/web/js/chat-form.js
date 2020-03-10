define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {
    'use strict';

    $.widget('bogdankSupportChat.form', {
        options: {
            chatButton: '.bogdank-support-chat-button',
            chatMessage: '#chat-messages'
        },

        /**
         * @private
         */
        _create: function () {
            var self = this;
            this.modal = $(this.element).modal({
                closed: function (e) {
                    $(self.options.chatButton).trigger('bogdank_SupportChat_closeChat.bogdank_SupportChat');
                },
                buttons: []
            });

            $(this.element).on('submit.bogdank_SupportChat', $.proxy(this.saveChat, this));
        },
        /**
         * @private
         */
        _destroy: function () {
            $(document).off('bogdank_SupportChat_closeChat.bogdank_SupportChat');
            this.clearChat();
        },


        saveChat: function () {
            if (!this.validateForm()) {
                validationAlert();
                return;
            }

            this.ajaxSubmit();
        },

        clearChat: function () {
            $(this.options.chatMessage).empty();
        },
        /**
         * Validate request form
         */
        validateForm: function () {
            return $(this.element).validation().valid();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            var formData = new FormData($(this.element).get(0));

            formData.append('form_key', $.mage.cookies.get('form_key'));
            formData.append('isAjax', 1);

            $.ajax({
                url: this.options.action,
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                beforeSend: function () {
                    $('body').trigger('processStart');
                },

                /** @inheritdoc */
                success: function (response) {
                    $('body').trigger('processStop');
                    this.renderMessage(response);
                }
            });
        },
        renderMessage: function (messageData) {
            var today = new Date();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            var $messageList = $('#chat-messages');
            var $messageItem = $('<li>').addClass('message-item customer');
            var $customerName = $('<p>').addClass('customer-name').text(messageData.customerName + ' ' + time);
            var $customerMessage = $('<p>').addClass('customer-message-body').text(messageData.message);
            var $messageItemAdmin = $('<li>').addClass('message-item admin-message');
            var $adminMessage = $('<p>').addClass('admin-message-body').text('Our admins will contact you shortly');
            $messageItem.append($customerName);
            $messageItem.append($customerMessage);
            $messageList.append($messageItem);
            $messageItemAdmin.append($adminMessage);
            $messageList.append($messageItemAdmin);
        }
    });

    return $.bogdankSupportChat.form;
});