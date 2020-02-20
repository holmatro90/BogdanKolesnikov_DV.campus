define([
    'jquery',
    'jquery/ui',
    'bogdank_supportChat_chatForm'
], function ($) {
    'use strict';

    $.widget('bogdankSupportChat.openButton', {
        options: {
            hideButton: true,
            form: '#bogdank-support-chat-form'
        },

        /**
         * @private
         */
        _create: function () {
            $(this.element).on('click.bogdank_SupportChat', $.proxy(this.openPreferences, this));
            $(this.element).on('bogdank_SupportChat_closePreferences.bogdank_SupportChat', $.proxy(this.closePreferences, this));
            $('.bogdank-support-chat-button').on('click.bogdank_SupportChat', $.proxy(this.editPreferences, this));

            $(this.element).show();
        },

        /**
         * jQuery(jQuery('.dv-campus-customer-preferences-open-button').get(0)).data('dvCampusCustomerPreferencesOpenButton').destroy()
         * @private
         */
        _destroy: function () {
            $(this.element).off('click.bogdank_SupportChat');
            $(this.element).off('bogdank_SupportChat_closePreferences.bogdank_SupportChat');

        },

        /**
         * Open preferences sidebar
         */
        openPreferences: function () {
            $(document).trigger('bogdank_SupportChat_openPreferences');

            if (this.options.hideButton) {
                $(this.element).removeClass('active');
            }
        },

        /**
         * Close preferences sidebar
         */
        closePreferences: function () {
            $(this.element).addClass('active');
        },
        editPreferences: function () {
            $(this.options.form).data('mage-modal').openModal();
        }
    });

    return $.bogdankSupportChat.openButton;
});
