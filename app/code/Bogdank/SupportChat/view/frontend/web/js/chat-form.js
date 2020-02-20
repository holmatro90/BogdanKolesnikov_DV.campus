define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/modal'
], function ($, alert) {
    'use strict';

    $.widget('bogdankSupportChat.form', {
        options: {
            action: ''
        },

        /**
         * @private
         */
        _create: function () {
            this.modal = $(this.element).modal({
                buttons: []
            });

            $(this.element).on('submit.bogdank_SupportChat', $.proxy(this.savePreferences, this));
        },

        _destroy: function () {
            this.modal.closeModal();
            $(this.element).off('closeBtn.bogdank_SupportChat');
            this.modal.destroy();
        },

        savePreferences: function () {
            if (!this.validateForm()) {
                validationAlert();
                return;
            }

            this.ajaxSubmit();
        },
        closed: function (){

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
                },

                /** @inheritdoc */
                error: function () {
                    $('body').trigger('processStop');
                    alert({
                        title: $.mage.__('Error'),
                        content: $.mage.__('Your message can\'t be send. Please, contact us if you see this message another way.')
                    });
                }
            });
        },
        renderMessage: function (messageData) {
            var today = new Date();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            var $messageList = $('#chat-messages');
            var $messageItem = $('<li>').addClass('message-item customer-message');
            var $customerName = $('<p>').addClass('customer-name').text(messageData.customerName +' '+ time);
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