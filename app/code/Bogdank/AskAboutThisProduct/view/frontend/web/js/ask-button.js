define([
    'jquery',
    'jquery/ui',
    'Bogdank_AskAboutThisProduct/js/ask-form'
], function ($) {
    'use strict';

    $.widget('bogdankAskAboutThisProduct.openButton', {
        options: {
            form: '#bogdank-ask-about-this-product-form',
            closeChatMessage: '.chat-destroy'
        },

        /**
         * @private
         */
        _create: function () {
            $(this.element).on('click.bogdank_AskAboutThisProduct', $.proxy(this.openForm, this));
            $(this.options.closeChatMessage).on('click.bogdank_AskAboutThisProduct', $.proxy(this.destroyForm, this));
            $(this.element).show();
        },

        /**
         * @private
         */
        _destroy: function () {
            $(this.element).off('click.bogdank_AskAboutThisProduct');
            $(this.element).off('bogdank_AskAboutThisProduct_closeForm.bogdank_AskAboutThisProduct');
            $(this.options.closeChatMessage).off('click.bogdank_AskAboutThisProduct');
        },

        /**
         * Hide form button
         */
        openForm: function () {
            $(document).trigger('bogdank_AskAboutThisProduct_openChat');
            $(this.options.form).data('mage-modal').openModal();
        },


        destroyForm: function () {
            $(this.options.form).data('bogdankAskAboutThisProduct')._destroy();
        }
    });

    return $.bogdankAskAboutThisProduct.openButton;
});
