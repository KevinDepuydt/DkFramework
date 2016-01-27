/**
 * Created by Kévin on 20/01/2016.
 */

$(function() {
    /** CONSTANTS **/
    const NOTIF_SUCCESS = "success",
          NOTIF_ERROR = "error",
          NOTIF_WARNING = "warning";

    /** FUNCTIONS **/
    function hideNotification(obj, time) {
        if (time == 0) {
            $(obj).remove();
        } else {
            setTimeout(function() {
                $(obj).fadeOut(600, function() {
                    $(obj).remove();
                });
            }, time);
        }
    }

    function addNotification(type, message) {

        var notification = '';

        switch (type) {
            case NOTIF_SUCCESS:
                notification =  $.parseHTML('<div>' +
                    '<div class="notification notification-success">' +
                    '<i class="fa fa-close notification-close"></i>' +
                    '<p class="text"><i class="fa fa-check-circle"></i> '+message+'</p>' +
                    '</div>' +
                    '</div>');
                break;
            case NOTIF_WARNING:
                notification =  $.parseHTML('<div>' +
                    '<div class="notification notification-warning">' +
                    '<i class="fa fa-close notification-close"></i>' +
                    '<p class="text"><i class="fa fa-exclamation-circle"></i> '+message+'</p>' +
                    '</div>' +
                    '</div>');
                break;
            case NOTIF_ERROR:
                notification =  $.parseHTML('<div>' +
                    '<div class="notification notification-error">' +
                    '<i class="fa fa-close notification-close"></i>' +
                    '<p class="text"><i class="fa fa-times-circle"></i> '+message+'</p>' +
                    '</div>' +
                    '</div>');
                break;
            default:
                console.log('if you see this, is not good');
        }

        noficationsWrapper.append(notification);
        addEventToNewNotification(notification);
    }

    function addSuccessNotification(message) {
        addNotification(NOTIF_SUCCESS, message);
    }

    function addErrorNotification(message) {
        addNotification(NOTIF_ERROR, message);
    }

    function addWarningNotification(message) {
        addNotification(NOTIF_WARNING, message);
    }

    function addEventToNewNotification(obj) {
        $(obj).find('.notification-close').click(function() {
            hideNotification(obj, 0);
        });
        hideNotification(obj, 5000);
    }

    /** VARIABLES **/
    var noficationsWrapper = $('#notification-wrapper'),
        notifErrorBtn = $('#notif-error'),
        notifSuccessBtn = $('#notif-success'),
        notifWarningBtn = $('#notif-warning');

    /** APP **/
    notifErrorBtn.click(function() {
        addErrorNotification("Error message")
    });
    notifSuccessBtn.click(function() {
        addSuccessNotification("Success message")
    });
    notifWarningBtn.click(function() {
        addWarningNotification("Warning message")
    });

    /** /entity-create **/

    /** VARS **/
    var entityAddForm = $('form[name="entityCreate"]');

    entityAddForm.on('submit', function(e) {
        var name = $(this).find('input[name="entityName"]').val();
        var table = $(this).find('input[name="tableName"]').val();

        if (!(name.length && table.length)) {
            addErrorNotification("Au moins l'un des champs du formulaire est vide");
        } else {
            addSuccessNotification("L'entité vas être créée! Quand doctrine sera fonctionnel ...");
        }

        return false;
    });

});
