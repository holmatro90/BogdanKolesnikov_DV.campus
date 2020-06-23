define([
    'jquery',
    'Magento_Customer/js/customer-data',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {
    'use strict';

    $.widget('bogdankAskAboutThisProduct.form', {
        options: {
            chatButton: '.bogdank-ask-about-this-product-button'
        },

        /**
         * @private
         */
        _create: function () {
            var self = this;
            this.modal = $(this.element).modal({
                closed: function (e) {
                    $(self.options.chatButton).trigger('bogdank_AskAboutThisProduct_closeForm.bogdank_AskAboutThisProduct');
                },
                buttons: []
            });

            $(this.element).on('submit.bogdank_AskAboutThisProduct', $.proxy(this.saveForm, this));

        },
        /**
         * @private
         */
        _destroy: function () {
            $(document).off('bogdank_AskAboutThisProduct_closeForm.bogdank_AskAboutThisProduct');
            this.clearForm();
        },


        saveForm: function () {
            if (!this.validateForm()) {
                validationAlert();
                return;
            }

            this.ajaxSubmit();
        },

        clearForm: function () {
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
                }
            });
        }
    });

    return $.bogdankAskAboutThisProduct.form;
});