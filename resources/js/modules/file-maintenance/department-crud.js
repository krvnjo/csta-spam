$(document).ready(function () {
  const departmentsDatatable = $("#departmentsDatatable").DataTable();

  // ============ Create a Department ============ //
  const departmentAddModal = $("#modalAddDepartment");
  const departmentAddForm = $("#frmAddDepartment");

  handleUnsavedChanges(departmentAddModal, departmentAddForm, $("#btnAddSaveDepartment"));

  departmentAddForm.on("submit", function (e) {
    e.preventDefault();

    const addFormData = new FormData(departmentAddForm[0]);

    $.ajax({
      url: "/file-maintenance/departments",
      method: "POST",
      data: addFormData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, departmentAddModal, departmentAddForm);
        } else {
          if (response.errors.department) {
            $("#txtAddDepartment").addClass("is-invalid");
            $("#valAddDepartment").text(response.errors.department[0]);
          }

          if (response.errors.deptcode) {
            $("#txtAddDeptCode").addClass("is-invalid");
            $("#valAddDeptCode").text(response.errors.deptcode[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, departmentAddModal, departmentAddForm);
      },
    });
  });
  // ============ End Create a Department ============ //

  // ============ View a Department ============ //
  departmentsDatatable.on("click", ".btnViewDepartment", function () {
    const departmentId = $(this).closest("tr").find("td[data-department-id]").data("department-id");

    $.ajax({
      url: "/file-maintenance/departments/show",
      method: "GET",
      data: { id: departmentId },
      success: function (response) {
        $("#modalViewDepartment").modal("toggle");

        $("#lblViewDepartment").text(response.department);
        $("#lblViewDeptCode").text(response.deptcode);

        const designations = response.designations;
        const dropdownDesignation = $("#designationsDropdownMenu").empty();

        $("#lblViewTotalDesignations").text(`${designations.length} designations in this department`);

        if (designations.length) {
          designations.forEach((designation) => {
            dropdownDesignation.append($("<span>").addClass("dropdown-item").text(designation));
          });
        } else {
          dropdownDesignation.append('<span class="dropdown-item text-muted">No designations available.</span>');
        }

        const departmentStatus =
          response.status === 1
            ? `<span class="badge bg-soft-success text-success"><span class="legend-indicator bg-success"></span>Active</span>`
            : `<span class="badge bg-soft-danger text-danger"><span class="legend-indicator bg-danger"></span>Inactive</span>`;

        $("#lblViewStatus").html(departmentStatus);
        $("#lblViewDateCreated").text(response.created);
        $("#lblViewDateUpdated").text(response.updated);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON);
      },
    });
  });
  // ============ End View a Department ============ //

  // ============ Update a Department ============ //
  const departmentEditModal = $("#modalEditDepartment");
  const departmentEditForm = $("#frmEditDepartment");

  handleUnsavedChanges(departmentEditModal, departmentEditForm, $("#btnEditSaveDepartment"));

  departmentsDatatable.on("click", ".btnEditDepartment", function () {
    const departmentId = $(this).closest("tr").find("td[data-department-id]").data("department-id");

    $.ajax({
      url: "/file-maintenance/departments/edit",
      method: "GET",
      data: { id: departmentId },
      success: function (response) {
        departmentEditModal.modal("toggle");

        $("#txtEditDepartmentId").val(response.id);
        $("#txtEditDepartment").val(response.department);
        $("#txtEditDeptCode").val(response.deptcode);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, departmentEditModal, departmentEditForm);
      },
    });
  });

  departmentEditForm.on("submit", function (e) {
    e.preventDefault();

    const editFormData = new FormData(departmentEditForm[0]);

    editFormData.append("_method", "PATCH");
    editFormData.append("id", $("#txtEditDepartmentId").val());
    editFormData.append("department", $("#txtEditDepartment").val());
    editFormData.append("deptcode", $("#txtEditDeptCode").val());

    $.ajax({
      url: "/file-maintenance/departments/update",
      method: "POST",
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, departmentEditModal, departmentEditForm);
        } else {
          if (response.errors.department) {
            $("#txtEditDepartment").addClass("is-invalid");
            $("#valEditDepartment").text(response.errors.department[0]);
          }

          if (response.errors.deptcode) {
            $("#txtEditDeptCode").addClass("is-invalid");
            $("#valEditDeptCode").text(response.errors.deptcode[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, departmentEditModal, departmentEditForm);
      },
    });
  });

  departmentsDatatable.on("click", ".btnStatusDepartment", function () {
    const departmentId = $(this).closest("tr").find("td[data-department-id]").data("department-id");
    const departmentSetStatus = $(this).data("status");
    let statusName;

    if (departmentSetStatus === 1) {
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
          url: "/file-maintenance/departments/update",
          method: "PATCH",
          data: {
            id: departmentId,
            status: departmentSetStatus,
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
  // ============ End Update a Department ============ //

  // ============ Delete a Department ============ //
  departmentsDatatable.on("click", ".btnDeleteDepartment", function () {
    const departmentId = $(this).closest("tr").find("td[data-department-id]").data("department-id");

    Swal.fire({
      title: "Delete Record?",
      text: "Are you sure you want to delete the department?",
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
          url: "/file-maintenance/departments/delete",
          method: "DELETE",
          data: { id: departmentId },
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

  $("#btnMultiDeleteDepartment").on("click", function () {
    let checkedCheckboxes = departmentsDatatable.rows().nodes().to$().find("input.form-check-input:checked");

    let departmentIds = checkedCheckboxes
      .map(function () {
        return $(this).closest("tr").find("[data-department-id]").data("department-id");
      })
      .get();

    Swal.fire({
      title: "Delete Records?",
      text: "Are you sure you want to delete all the selected departments?",
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
          url: "/file-maintenance/departments/delete",
          method: "DELETE",
          data: { id: departmentIds },
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
  // ============ End Delete a Department ============ //
});
