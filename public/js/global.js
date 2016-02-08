/**
 * Created by Kévin on 20/01/2016.
 */

$(function() {

    /** CONSTANTS **/
    const NOTIF_SUCCESS = "success",
          NOTIF_ERROR = "error",
          NOTIF_WARNING = "warning",
          NOTIF_WRAPPER = $('#notification-wrapper');

    /** VARIABLES **/
    var notifErrorBtn = $('#notif-error'),
        notifSuccessBtn = $('#notif-success'),
        notifWarningBtn = $('#notif-warning');

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

    function notificationExist(name) {
        return NOTIF_WRAPPER.find('[data-name="'+name+'"]').length;
    }

    function addNotification(type, message, name) {
        if (!notificationExist(name)) {
            var notification = '';

            switch (type) {
                case NOTIF_SUCCESS:
                    notification =  $.parseHTML('<div class="notification notification-success" data-name="'+name+'">' +
                        '<i class="fa fa-close notification-close"></i>' +
                        '<p class="text"><i class="fa fa-check-circle"></i> '+message+'</p>' +
                        '</div>');
                    break;
                case NOTIF_WARNING:
                    notification =  $.parseHTML('<div class="notification notification-warning" data-name="'+name+'">' +
                        '<i class="fa fa-close notification-close"></i>' +
                        '<p class="text"><i class="fa fa-exclamation-circle"></i> '+message+'</p>' +
                        '</div>');
                    break;
                case NOTIF_ERROR:
                    notification =  $.parseHTML('<div class="notification notification-error" data-name="'+name+'">' +
                        '<i class="fa fa-close notification-close"></i>' +
                        '<p class="text"><i class="fa fa-times-circle"></i> '+message+'</p>' +
                        '</div>');
                    break;
                default:
                    console.log('if you see this, is not good');
            }

            NOTIF_WRAPPER.append(notification);
            addEventToNewNotification(notification);
        }
    }

    function addSuccessNotification(message, name) {
        addNotification(NOTIF_SUCCESS, message, name);
    }

    function addErrorNotification(message, name) {
        addNotification(NOTIF_ERROR, message, name);
    }

    function addWarningNotification(message, name) {
        addNotification(NOTIF_WARNING, message, name);
    }

    function addEventToNewNotification(obj) {
        $(obj).find('.notification-close').click(function() {
            hideNotification(obj, 0);
        });
        hideNotification(obj, 5000);
    }

    /** APP **/
    notifErrorBtn.click(function() {
        addErrorNotification("Error message", "btn-test-error")
    });
    notifSuccessBtn.click(function() {
        addSuccessNotification("Success message", "btn-test-success")
    });
    notifWarningBtn.click(function() {
        addWarningNotification("Warning message", "btn-test-warning")
    });

    /** /entity/create **/

    /** VARS **/
    var entityAddForm = $('form[name="entityCreate"]');

    entityAddForm.on('submit', function(e) {
        var name = $(this).find('input[name="entityName"]').val();
        var table = $(this).find('input[name="tableName"]').val();

        if (!(name.length && table.length)) {
            addErrorNotification("Au moins l'un des champs du formulaire est vide", 'form-entity-error');
            return false;
        }
    });


    /** /module/create **/
    var moduleAddForm = $('form[name="moduleCreate"]');

    moduleAddForm.on('submit', function(e) {
        var name = $(this).find('input[name="moduleName"]').val();

        if (!name.length) {
            addErrorNotification("Veuillez renseigner un nom pour votre module", 'form-entity-error');
            return false;
        }
    });

});
