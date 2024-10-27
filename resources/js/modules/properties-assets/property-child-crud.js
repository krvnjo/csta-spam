$(document).ready(function() {

  // ============ Add a Stock Variant ============ //
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
  // ============ End Add a Stock Variant ============ //

  // ============ Update a Stock Variant ============ //

  const childEditModal = $("#editPropChildModal");
  const childEditForm = $("#frmEditPropChild");

  const parentId = $(".page-header-title span").text().trim();

  handleUnsavedChanges(childEditModal, childEditForm, $("#btnEditSaveChild"));

  childDatatable.on("click", ".btnEditPropChild", function () {
    const childId = $(this).closest("tr").find("td[data-child-id]").data("child-id");

    $.ajax({
      url: "/properties-assets/"+ parentId + "/child-stocks/edit",
      method: "GET",
      data: { id: childId },
      success: function (response) {
        childEditModal.modal("toggle");
        $("#txtEditChildId").val(response.id);
        $("#editPropCode").text(response.propCode);
        $("#txtEditSerialNumber").val(response.serialNumber);
        $("#txtEditRemarks").val(response.remarks);
        $("#cbxEditAcquiredType")[0].tomselect.setValue(response.type_id);
        $("#cbxEditCondition")[0].tomselect.setValue(response.condi_id);
        $("#txtEditDateAcquired").val(response.acquiredDate);
        $("#txtEditWarrantyDate").val(response.warrantyDate);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, childEditModal, childEditForm);
      },
    });
  });


  // ============ End Update a Stock Variant ============ //
});
document.addEventListener('DOMContentLoaded', function() {
  new TomSelect('#cbxEditAcquiredType', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    onChange: function(value) {
      const warrantyDateInput = document.getElementById('txtEditWarrantyDate');

      const PURCHASED_ID = "1";
      const DONATION_ID = "2";

      if (value === DONATION_ID) {
        warrantyDateInput.disabled = true;
        warrantyDateInput.value = '';
        warrantyDateInput.classList.add('bg-light');
      } else if (value === PURCHASED_ID) {
        warrantyDateInput.disabled = false;
        warrantyDateInput.classList.remove('bg-light');
      }
    }
  });

  new TomSelect('#cbxEditCondition', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true
  });

  document.querySelectorAll('.tom-select input[type="text"]').forEach(function(input) {
    input.addEventListener('keydown', function(event) {
      event.preventDefault();
    });
  });
});
