define([
    'jquery',
    'jquery/ui',
    'Bogdank_SupportChat/js/chat-form'
], function ($, bogdankSupportChatForm) {
    'use strict';

    $.widget('bogdankSupportChat.openButton', {
        options: {
            hideButton: true,
            form: '#bogdank-support-chat-form',
            closeChat: '.chat-destroy'
        },

        /**
         * @private
         */
        _create: function () {
            $(this.element).on('click.bogdank_SupportChat', $.proxy(this.openChat, this));
            $(this.element).on('bogdank_SupportChat_closeChat.bogdank_SupportChat', $.proxy(this.closeChat, this));
            $('.bogdank-support-chat-button').on('click.bogdank_SupportChat', $.proxy(this.editChat, this));
            $(this.options.closeChat).on('click.bogdank_SupportChat', $.proxy(this.destroyChat, this));
            $(this.element).show();
        },

        /**
         * jQuery(jQuery('.dv-campus-customer-preferences-open-button').get(0)).data('dvCampusCustomerPreferencesOpenButton').destroy()
         * @private
         */
        _destroy: function () {
            $(this.element).off('click.bogdank_SupportChat');
            $(this.element).off('bogdank_SupportChat_closeChat.bogdank_SupportChat');
            $('.bogdank-support-chat-button').on('click.bogdank_SupportChat');
            $(this.options.closeChat).on('click.bogdank_SupportChat');
        },

        /**
         * Open preferences sidebar
         */
        openChat: function () {
            $(document).trigger('bogdank_SupportChat_openChat');
            if (this.options.hideButton) {
                $(this.element).removeClass('active');
            }
        },

        /**
         * Close preferences sidebar
         */
        closeChat: function () {
            if (this.options.hideButton) {
                $(this.element).addClass('active');
            }

        },

        destroyChat: function () {
            $(this.options.form).data('bogdankSupportChatForm').destroy();
            bogdankSupportChatForm({}, $(this.options.closeChat));
        },

        editChat: function () {
            $(this.options.form).data('mage-modal').openModal();
        }
    });

    return $.bogdankSupportChat.openButton;
});
