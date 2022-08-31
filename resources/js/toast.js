import toastr from 'toastr';
window.$(document).ready(function () {
    toastr.options = {
    "positionClass": "toast-bottom-right",
    "progressBar": true
    };
    window.addEventListener('data-added', function (event) {
        toastr.success(event.detail.message, 'Validation');
        $('#formSectionModal').modal('hide');
        $('#formOptionModal').modal('hide');
        $('#formScolaryYearModal').modal('hide');
        $('#formclasseModal').modal('hide');
        $('#formCostModal').modal('hide');
        $('#formCostotherModal').modal('hide');
        $('#formCostotherModal').modal('hide');
        $('#formInscriptionModal').modal('hide');
        $('#CreateRoleModal').modal('hide');
        $('#CreateUserModal').modal('hide');
        $('#CreatePermissionModal').modal('hide');
        $('#formPaiementModal').modal('hide');
        $('#formDepenseModal').modal('hide');
        $('#formDepotBankModal').modal('hide');
        $('#formDeviseModal').modal('hide');
    });
    window.addEventListener('data-updated', function (event) {
        toastr.info(event.detail.message, 'Validation');
        $('#formSectionModal').modal('hide');
        $('#formOptionModal').modal('hide');
        $('#formScolaryYearModal').modal('hide');
        $('#formclasseModal').modal('hide');
        $('#formCostModal').modal('hide');
        $('#formCostotherModal').modal('hide');
        $('#formCostotherModal').modal('hide');
        $('#formEditInscriptionModal').modal('hide');
        $('#EditRoleModal').modal('hide');
        $('#EditUserModal').modal('hide');
        $('#EditPermissionModal').modal('hide');
        $('#AssignPermisionModal').modal('hide');
        $('#DetachPermisionModal').modal('hide');
        $('#formEditDepotBankModal').modal('hide');
        $('#formDeviseModal').modal('hide');
    });
    window.addEventListener('data-deleted', function (event) {
        toastr.error(event.detail.message, 'Alert !');
        $('#formEditInscriptionModal').modal('hide');
    });


});

$("input[data-bootstrap-switch]").each(function(){
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  });

