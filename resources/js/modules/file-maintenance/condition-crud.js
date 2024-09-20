$(document).ready(function () {
  const conditionsDatatable = $("#conditionsDatatable").DataTable();

  // ============ Create a Condition ============ //
  const conditionAddModal = $("#modalAddCondition");
  const conditionAddForm = $("#frmAddCondition");

  handleUnsavedChanges(conditionAddModal, conditionAddForm, $("#btnAddSaveCondition"));

  conditionAddForm.on("submit", function (e) {
    e.preventDefault();

    const addFormData = new FormData(conditionAddForm[0]);

    $.ajax({
      url: "/file-maintenance/conditions",
      method: "POST",
      data: addFormData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, conditionAddModal, conditionAddForm);
        } else {
          if (response.errors.condition) {
            $("#txtAddCondition").addClass("is-invalid");
            $("#valAddCondition").text(response.errors.condition[0]);
          }

          if (response.errors.description) {
            $("#txtAddDescription").addClass("is-invalid");
            $("#valAddDescription").text(response.errors.description[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, conditionAddModal, conditionAddForm);
      },
    });
  });
  // ============ End Create a Condition ============ //

  // ============ View a Condition ============ //
  conditionsDatatable.on("click", ".btnViewCondition", function () {
    const conditionId = $(this).closest("tr").find("td[data-condition-id]").data("condition-id");

    $.ajax({
      url: "/file-maintenance/conditions/show",
      method: "GET",
      data: { id: conditionId },
      success: function (response) {
        $("#modalViewCondition").modal("toggle");

        $("#lblViewCondition").text(response.condition);
        $("#lblViewDescription").text(response.description);

        const conditionStatus =
          response.status === 1
            ? `<span class="badge bg-soft-success text-success"><span class="legend-indicator bg-success"></span>Active</span>`
            : `<span class="badge bg-soft-danger text-danger"><span class="legend-indicator bg-danger"></span>Inactive</span>`;

        $("#lblViewStatus").html(conditionStatus);
        $("#lblViewDateCreated").text(response.created);
        $("#lblViewDateUpdated").text(response.updated);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON);
      },
    });
  });
  // ============ End View a Condition ============ //

  // ============ Update a Condition ============ //
  const conditionEditModal = $("#modalEditCondition");
  const conditionEditForm = $("#frmEditCondition");

  handleUnsavedChanges(conditionEditModal, conditionEditForm, $("#btnEditSaveCondition"));

  conditionsDatatable.on("click", ".btnEditCondition", function () {
    const conditionId = $(this).closest("tr").find("td[data-condition-id]").data("condition-id");

    $.ajax({
      url: "/file-maintenance/conditions/edit",
      method: "GET",
      data: { id: conditionId },
      success: function (response) {
        conditionEditModal.modal("toggle");

        $("#txtEditConditionId").val(response.id);
        $("#txtEditCondition").val(response.condition);
        $("#txtEditDescription").val(response.description);
        $("#countCharactersConditionDesc").text(response.description.length + " / 80");
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, conditionEditModal, conditionEditForm);
      },
    });
  });

  conditionEditForm.on("submit", function (e) {
    e.preventDefault();

    const editFormData = new FormData(conditionEditForm[0]);

    editFormData.append("_method", "PATCH");
    editFormData.append("id", $("#txtEditConditionId").val());
    editFormData.append("condition", $("#txtEditCondition").val());
    editFormData.append("description", $("#txtEditDescription").val());

    $.ajax({
      url: "/file-maintenance/conditions/update",
      method: "POST",
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, conditionEditModal, conditionEditForm);
        } else {
          if (response.errors.condition) {
            $("#txtEditCondition").addClass("is-invalid");
            $("#valEditCondition").text(response.errors.condition[0]);
          }

          if (response.errors.description) {
            $("#txtEditDescription").addClass("is-invalid");
            $("#valEditDescription").text(response.errors.description[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, conditionEditModal, conditionEditForm);
      },
    });
  });

  conditionsDatatable.on("click", ".btnStatusCondition", function () {
    const conditionId = $(this).closest("tr").find("td[data-condition-id]").data("condition-id");
    const conditionSetStatus = $(this).data("status");
    let statusName;

    if (conditionSetStatus === 1) {
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
          url: "/file-maintenance/conditions/update",
          method: "PATCH",
          data: {
            id: conditionId,
            status: conditionSetStatus,
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
  // ============ End Update a Condition ============ //

  // ============ Delete a Condition ============ //
  conditionsDatatable.on("click", ".btnDeleteCondition", function () {
    const conditionId = $(this).closest("tr").find("td[data-condition-id]").data("condition-id");

    Swal.fire({
      title: "Delete Record?",
      text: "Are you sure you want to delete the condition?",
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
          url: "/file-maintenance/conditions/delete",
          method: "DELETE",
          data: { id: conditionId },
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

  $("#btnMultiDeleteCondition").on("click", function () {
    let checkedCheckboxes = conditionsDatatable.rows().nodes().to$().find("input.form-check-input:checked");

    let conditionIds = checkedCheckboxes
      .map(function () {
        return $(this).closest("tr").find("[data-condition-id]").data("condition-id");
      })
      .get();

    Swal.fire({
      title: "Delete Records?",
      text: "Are you sure you want to delete all the selected conditions?",
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
          url: "/file-maintenance/conditions/delete",
          method: "DELETE",
          data: { id: conditionIds },
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
  // ============ End Delete a Condition ============ //
});
