/**
 * Created by Kévin on 21/01/2016.
 */

$(function() {

    /** VARS **/
    var entityAddForm = $('form[name="entityCreate"]');

    entityAddForm.on('submit', function(e) {
        var name = $(this).find('input[name="entityName"]').val();
        var table = $(this).find('input[name="tableName"]').val();

        if (!(name.length && table.length)) {
            addSuccessNotification("Au moins l'un des champs du formulaire est vide");
        } else {
            addSuccessNotification("L'entité vas être créée!");
        }

        return false;
    });

    function tableExist(name) {
        return false;
    }
});