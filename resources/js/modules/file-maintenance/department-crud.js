$(document).ready(function () {
  const departmentDatatable = $("#departmentDatatable").DataTable();

  // Create a Department
  const departmentAddModal = $("#addDepartmentModal");
  const departmentAddForm = $("#frmAddDepartment");
  const departmentAddText = $("#txtAddDepartment");
  const departmentAddValid = $("#valAddDepartment");
  const deptCodeAddText = $("#txtAddDeptCode");
  const deptCodeAddValid = $("#valAddDeptCode");

  handleUnsavedChanges(departmentAddModal, departmentAddForm);

  departmentAddForm.on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "/file-maintenance/departments/create",
      method: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        department: departmentAddText.val(),
        deptcode: deptCodeAddText.val(),
      },
      success: function (response) {
        if (response.success) {
          departmentAddModal.modal("hide");
          showSuccessAlert(response, departmentAddModal, departmentAddForm);
        } else {
          if (response.errors.department) {
            departmentAddText.addClass("is-invalid");
            departmentAddValid.text(response.errors.department[0]);
          }

          if (response.errors.deptcode) {
            deptCodeAddText.addClass("is-invalid");
            deptCodeAddValid.text(response.errors.deptcode[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, departmentAddModal, departmentAddForm);
      },
    });
  });
  // End Create a Department

  // Edit a Department
  const departmentEditModal = $("#editDepartmentModal");
  const departmentEditForm = $("#frmEditDepartment");
  const departmentEditId = $("#txtEditDepartmentId");
  const departmentEditText = $("#txtEditDepartment");
  const departmentEditValid = $("#valEditDepartment");
  const deptCodeEditText = $("#txtEditDeptCode");
  const deptCodeEditValid = $("#valEditDeptCode");

  handleUnsavedChanges(departmentEditModal, departmentEditForm);

  departmentDatatable.on("click", "#btnEditDepartment", function () {
    const departmentId = $(this).closest("tr").find("td[data-department-id]").data("department-id");

    $.ajax({
      url: "/file-maintenance/departments/edit",
      method: "GET",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: departmentId,
      },
      success: function (response) {
        departmentEditModal.modal("toggle");
        departmentEditId.val(response.id);
        departmentEditText.val(response.name);
        deptCodeEditText.val(response.deptcode);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, departmentAddModal, departmentAddForm);
      },
    });
  });
  // End Edit a Department

  // Update a Department
  departmentEditForm.on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "/file-maintenance/departments/update",
      method: "PATCH",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        id: departmentEditId.val(),
        department: departmentEditText.val(),
        deptcode: deptCodeEditText.val(),
      },
      success: function (response) {
        if (response.success) {
          departmentAddModal.modal("hide");
          showSuccessAlert(response, departmentEditModal, departmentEditForm);
        } else {
          if (response.errors.department) {
            departmentEditText.addClass("is-invalid");
            departmentEditValid.text(response.errors.department[0]);
          }

          if (response.errors.deptcode) {
            deptCodeEditText.addClass("is-invalid");
            deptCodeEditValid.text(response.errors.deptcode[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, departmentAddModal, departmentAddForm);
      },
    });
  });

  $(".btnStatusDepartment").on("click", function () {
    const departmentId = $(this).closest("tr").find("td[data-department-id]").data("department-id");
    const status = $(this).data("status");
    let statusName;

    if (status === 1) {
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
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: departmentId,
            status: status,
          },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON, departmentAddModal, departmentAddForm);
          },
        });
      }
    });
  });
  // End Update a Department

  // Delete a Department
  departmentDatatable.on("click", "#btnDeleteDepartment", function () {
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
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: departmentId,
          },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON, departmentAddModal, departmentAddForm);
          },
        });
      }
    });
  });

  $("#btnMultiDeleteDepartment").on("click", function () {
    let checkedCheckboxes = departmentDatatable.rows().nodes().to$().find("input.form-check-input:checked");

    let ids = checkedCheckboxes
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
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            id: ids,
          },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON, departmentAddModal, departmentAddForm);
          },
        });
      }
    });
  });
  // End Delete a Department
});
