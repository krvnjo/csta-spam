$(document).ready(function () {
  const designationsDatatable = $("#designationsDatatable").DataTable();

  // ============ Create a Designation ============ //
  const designationAddModal = $("#modalAddDesignation");
  const designationAddForm = $("#frmAddDesignation");

  handleUnsavedChanges(designationAddModal, designationAddForm);

  designationAddForm.on("submit", function (e) {
    e.preventDefault();

    const addFormData = new FormData(designationAddForm[0]);

    $.ajax({
      url: "/file-maintenance/designations",
      method: "POST",
      data: addFormData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, designationAddModal, designationAddForm);
        } else {
          if (response.errors.designation) {
            $("#txtAddDesignation").addClass("is-invalid");
            $("#valAddDesignation").text(response.errors.designation[0]);
          }

          if (response.errors.department) {
            $("#selAddDepartment").next(".ts-wrapper").addClass("is-invalid");
            $("#valAddDepartment").text(response.errors.department[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, designationAddModal, designationAddForm);
      },
    });
  });
  // ============ End Create a Designation ============ //

  // ============ View a Designation ============ //
  $(".btnViewDesignation").on("click", function () {
    const designationId = $(this).closest("tr").find("td[data-designation-id]").data("designation-id");

    $.ajax({
      url: "/file-maintenance/designations/show",
      method: "GET",
      data: { id: designationId },
      success: function (response) {
        $("#modalViewDesignation").modal("toggle");

        $("#lblViewDesignation").text(response.designation);
        $("#lblViewDepartment").text(response.department);
        $("#lblViewDateCreated").text(response.created);
        $("#lblViewDateUpdated").text(response.updated);

        if (response.status === 1) {
          $("#lblViewStatus").html(`
              <span class="badge bg-soft-success text-success">
                  <span class="legend-indicator bg-success"></span>Active
              </span>
          `);
        } else {
          $("#lblViewStatus").html(`
              <span class="badge bg-soft-danger text-danger">
                  <span class="legend-indicator bg-danger"></span>Inactive
              </span>
          `);
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON);
      },
    });
  });
  // ============ End View a Designation ============ //

  // ============ Update a Designation ============ //
  const designationEditModal = $("#modalEditDesignation");
  const designationEditForm = $("#frmEditDesignation");
  const designationSaveButton = $("#btnEditSaveDesignation");

  handleUnsavedChanges(designationEditModal, designationEditForm, designationSaveButton);

  $(".btnEditDesignation").on("click", function () {
    const designationId = $(this).closest("tr").find("td[data-designation-id]").data("designation-id");

    $.ajax({
      url: "/file-maintenance/designations/edit",
      method: "GET",
      data: { id: designationId },
      success: function (response) {
        designationEditModal.modal("toggle");

        $("#txtEditDesignationId").val(response.id);
        $("#txtEditDesignation").val(response.designation);
        $("#selEditDepartment")[0].tomselect.setValue(response.department);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, designationEditModal, designationEditForm);
      },
    });
  });

  designationEditForm.on("submit", function (e) {
    e.preventDefault();

    const editFormData = new FormData(designationEditForm[0]);

    editFormData.append("_method", "PATCH");
    editFormData.append("id", $("#txtEditDesignationId").val());
    editFormData.append("designation", $("#txtEditDesignation").val());
    editFormData.append("department", $("#selEditDepartment").val());

    $.ajax({
      url: "/file-maintenance/designations/update",
      method: "POST",
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, designationEditModal, designationEditForm);
        } else {
          if (response.errors.designation) {
            $("#txtEditDesignation").addClass("is-invalid");
            $("#valEditDesignation").text(response.errors.designation[0]);
          }

          if (response.errors.department) {
            $("#selEditDepartment").next(".ts-wrapper").addClass("is-invalid");
            $("#valEditDepartment").text(response.errors.department[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, designationEditModal, designationEditForm);
      },
    });
  });

  $(".btnStatusDesignation").on("click", function () {
    const designationId = $(this).closest("tr").find("td[data-designation-id]").data("designation-id");
    const designationSetStatus = $(this).data("status");
    let statusName;

    if (designationSetStatus === 1) {
      statusName = "active";
    } else {
      statusName = "inactive";
    }

    Swal.fire({
      title: "Change status?",
      text: "Are you sure you want to set it to " + statusName + "?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, set it to " + statusName + "!",
      cancelButtonText: "No, cancel!",
      customClass: {
        confirmButton: "btn btn-primary",
        cancelButton: "btn btn-secondary",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/file-maintenance/designations/update",
          method: "PATCH",
          data: {
            id: designationId,
            status: designationSetStatus,
          },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON);
          },
        });
      }
    });
  });
  // ============ End Update a Designation ============ //

  // ============ Delete a Designation ============ //
  $(".btnDeleteDesignation").on("click", function () {
    const designationId = $(this).closest("tr").find("td[data-designation-id]").data("designation-id");

    Swal.fire({
      title: "Delete Record?",
      text: "Are you sure you want to delete the designation?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      customClass: {
        confirmButton: "btn btn-danger",
        cancelButton: "btn btn-secondary",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/file-maintenance/designations/delete",
          method: "DELETE",
          data: { id: designationId },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON);
          },
        });
      }
    });
  });

  $("#btnMultiDeleteDesignation").on("click", function () {
    let checkedCheckboxes = designationsDatatable.rows().nodes().to$().find("input.form-check-input:checked");

    let designationIds = checkedCheckboxes
      .map(function () {
        return $(this).closest("tr").find("[data-designation-id]").data("designation-id");
      })
      .get();

    Swal.fire({
      title: "Delete Records?",
      text: "Are you sure you want to delete all the selected designations?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      customClass: {
        confirmButton: "btn btn-danger",
        cancelButton: "btn btn-secondary",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/file-maintenance/designations/delete",
          method: "DELETE",
          data: { id: designationIds },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON);
          },
        });
      }
    });
  });
  // ============ End Delete a Designation ============ //
});
