export default {

    handleValidationErrors(response, callback) {

        this.hideLoader();

        if( response.status == 422 ) {
            this.showValidationErrors(response);
        }

        if( typeof callback !== 'undefined') {
            callback();
        }

    },


    showValidationErrors(response) {

        this.hideLoader();

        for (let [key, value] of Object.entries(response.data)) {

            $('[name="' + key + '"]').parent()
                .addClass('md-input-invalid')
                .find('.md-error').text(value);

        }

    },


    redirectUserIfRequired(response) {

        if( ! response.data.redirect )
            return;

        var redirect = function (location) {
            window.location.replace(location);
        }

        if( response.data.delay ) {

            setTimeout(function () {
                redirect(response.data.redirect);
            }, response.data.delay)

        } else {

            redirect(response.data.redirect);

        }

    },


    showAlert(response, callback) {

        this.hideLoader();

        swal({
            title: response.data.title,
            text: response.data.text,
            type: response.data.status,
            html: true
        }, function () {

            if( typeof callback == 'function')
                callback();

        });

    },


    handleServerError(response, customText = "") {

        this.hideLoader();

        if( response.status == 500 ) {
            swal({
                title: 'Whoops!',
                text: customText == "" ? 'Hier ist etwas schief gelaufen. <br>Bitte versuche es erneut.' : customText,
                type: 'error',
                html: true
            });
        }

    },

    showInfoModal(title, text) {
        swal({
            title: title,
            text: text,
            type: 'info',
            html: true
        });
    },


    showLoader() {
        $('#auth-card-loader').fadeIn("slow");
        $('#auth-panel').find('form').addClass('inactive');
    },


    hideLoader() {
        $('#auth-card-loader').fadeOut("slow");
        $('#auth-panel').find('form').removeClass('inactive');
    }


};