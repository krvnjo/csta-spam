$(document).ready(function() {
  const childDatatable = $("#propertyChildDatatable").DataTable();
  const childAddModal = $("#addPropertyChild");
  const childAddForm = $("#frmAddVarProperty");
  const submitBtn = $("#btnAddSaveChild");
  const btnLoader = $("#btnLoader");

  handleUnsavedChanges(childAddModal, childAddForm, submitBtn);

  childAddForm.on("submit", function(e) {
    e.preventDefault();

    // Start loading
    submitBtn.prop('disabled', true);
    btnLoader.removeClass('d-none');

    const addFormData = new FormData(childAddForm[0]);

    $.ajax({
      url: childAddForm.attr('action'),
      method: "POST",
      data: addFormData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function(response) {
        if (response.success) {
          showSuccessAlert(response, childAddModal, childAddForm);
        } else {
          if (response.errors.VarQuantity) {
            $("#txtVarQuantity").addClass("is-invalid");
            $("#valAddChildQty").text(response.errors.VarQuantity[0]);
          }
        }
      },
      error: function(response) {
        showErrorAlert(response.responseJSON, childAddModal, childAddForm);
      },
      complete: function() {
        // Stop loading
        submitBtn.prop('disabled', false);
        btnLoader.addClass('d-none');
      }
    });
  });
});
