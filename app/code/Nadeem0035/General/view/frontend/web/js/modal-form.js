define(
    [
        'jquery',
        'Magento_Ui/js/modal/modal'
    ],
    function($) {
        "use strict";
        //creating jquery widget
        $.widget('Vendor.modalForm', {
            options: {
                modalForm: '#quote-form-modal',
                modalButton: '.open-modal-form',
                modalClass: 'pdp-contact-us-form',
            },
            _create: function() {
                this.options.modalOption = this._getModalOptions();
                this._bind();
            },
            _getModalOptions: function() {
                /**
                 * Modal options
                 */
                var options = {
                    type: 'popup',
                    responsive: true,
                    title: '',
                    modalClass: 'pdp-contact-us-form',
                    buttons: [{
                        text: $.mage.__('Continue'),
                        class: '',
                        click: function () {
                            this.closeModal();
                        }
                    }]
                };

                return options;
            },
            _bind: function(){
                var modalOption = this.options.modalOption;
                var modalForm = this.options.modalForm;

                $(document).on('click', this.options.modalButton,  function(){
                    //Initialize modal
                    $(modalForm).modal(modalOption);
                    //open modal
                    $(modalForm).trigger('openModal');
                });
            }
        });

        return $.Vendor.modalForm;
    }
);