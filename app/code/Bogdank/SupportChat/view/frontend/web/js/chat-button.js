define([
    'jquery',
    'jquery/ui',
    'Bogdank_SupportChat/js/view/chat-form'
], function ($) {
    'use strict';

    $.widget('bogdankSupportChat.openButton', {
        options: {
            hideButton: false,
            form: '#bogdank-support-chat-form',
            closeChatMessage: '.chat-destroy'
        },

        /**
         * @private
         */
        _create: function () {
            $(this.element).on('click.bogdank_SupportChat', $.proxy(this.openChat, this));
            $(this.element).on('bogdank_SupportChat_closeChat.bogdank_SupportChat', $.proxy(this.closeChat, this));
            $(this.options.closeChatMessage).on('click.bogdank_SupportChat', $.proxy(this.destroyChat, this));
            $(this.element).show();
        },

        /**
         * @private
         */
        _destroy: function () {
            $(this.element).off('click.bogdank_SupportChat');
            $(this.element).off('bogdank_SupportChat_closeChat.bogdank_SupportChat');
            $(this.options.closeChatMessage).off('click.bogdank_SupportChat');
        },

        /**
         * Hide chat button
         */
        openChat: function () {
            $(document).trigger('bogdank_SupportChat_openModal');
            $(this.options.form).data('mage-modal').openModal();
        },

        destroyChat: function () {
            $(this.options.form).data('bogdankSupportChatForm')._destroy();
        }
    });

    return $.bogdankSupportChat.openButton;
});
