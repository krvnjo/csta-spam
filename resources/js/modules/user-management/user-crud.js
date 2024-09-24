$(document).ready(function () {
  const usersDatatable = $("#usersDatatable").DataTable();

  // ============ Create a User ============ //
  const userAddModal = $("#modalAddUser");
  const userAddForm = $("#frmAddUser");

  handleUnsavedChanges(userAddModal, userAddForm, $("#btnAddSaveUser"));

  userAddForm.on("submit", function (e) {
    e.preventDefault();

    const addFormData = new FormData(userAddForm[0]);

    $.ajax({
      url: "/user-management/users",
      method: "POST",
      data: addFormData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, userAddModal, userAddForm);
        } else {
          if (response.errors.fname) {
            $("#txtAddUserFname").addClass("is-invalid");
            $("#valAddUserFname").text(response.errors.fname[0]);
          }

          if (response.errors.mname) {
            $("#txtAddUserMname").addClass("is-invalid");
            $("#valAddUserMname").text(response.errors.mname[0]);
          }

          if (response.errors.lname) {
            $("#txtAddUserLname").addClass("is-invalid");
            $("#valAddUserLname").text(response.errors.lname[0]);
          }

          if (response.errors.role) {
            $("#selAddUserRole").next(".ts-wrapper").addClass("is-invalid");
            $("#valAddUserRole").text(response.errors.role[0]);
          }

          if (response.errors.dept) {
            $("#selAddUserDept").next(".ts-wrapper").addClass("is-invalid");
            $("#valAddUserDept").text(response.errors.dept[0]);
          }

          if (response.errors.email) {
            $("#txtAddUserEmail").addClass("is-invalid");
            $("#valAddUserEmail").text(response.errors.email[0]);
          }

          if (response.errors.phone) {
            $("#txtAddUserPhone").addClass("is-invalid");
            $("#valAddUserPhone").text(response.errors.phone[0]);
          }

          if (response.errors.user) {
            $("#txtAddUsername").addClass("is-invalid");
            $("#valAddUsername").text(response.errors.user[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, userAddModal, userAddForm);
      },
    });
  });
  // ============ End Create a User ============ //

  // ============ View a User ============ //
  usersDatatable.on("click", ".btnViewUser", function () {
    const userId = $(this).closest("tr").find("td[data-user-id]").data("user-id");

    $.ajax({
      url: "/user-management/users/show",
      method: "GET",
      data: { id: userId },
      success: function (response) {
        $("#modalViewUser").modal("toggle");

        $("#lblViewUsername").text(response.user);
        $("#lblViewUserFname").text(response.fname);
        $("#lblViewUserMname").text(response.mname);
        $("#lblViewUserLname").text(response.lname);
        $("#lblViewUserRole").text(response.role);
        $("#lblViewUserDept").text(response.dept);
        $("#lblViewUserEmail").text(response.email);
        $("#lblViewUserPhone").text(response.phone);
        $("#imgViewUserImage").attr("src", "/img/uploads/user-images/" + response.image);
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
  // ============ End View a User ============ //

  // ============ Update a User ============ //
  const userEditModal = $("#modalEditUser");
  const userEditForm = $("#frmEditUser");

  handleUnsavedChanges(userEditModal, userEditForm, $("#btnEditSaveUser"));

  usersDatatable.on("click", ".btnEditUser", function () {
    const userId = $(this).closest("tr").find("td[data-user-id]").data("user-id");

    $.ajax({
      url: "/user-management/users/edit",
      method: "GET",
      data: { id: userId },
      success: function (response) {
        userEditModal.modal("toggle");

        $("#txtEditUserId").val(response.id);
        $("#txtEditUsername").val(response.user);
        $("#txtEditUserFname").val(response.fname);
        $("#txtEditUserMname").val(response.mname);
        $("#txtEditUserLname").val(response.lname);
        $("#selEditUserRole")[0].tomselect.setValue(response.role);
        $("#selEditUserDept")[0].tomselect.setValue(response.dept);
        $("#txtEditUserEmail").val(response.email);
        $("#txtEditUserPhone").val(response.phone);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, userEditModal, userEditForm);
      },
    });
  });

  userEditForm.on("submit", function (e) {
    e.preventDefault();

    const editFormData = new FormData(userEditForm[0]);

    editFormData.append("_method", "PATCH");
    editFormData.append("id", $("#txtEditUserId").val());
    editFormData.append("user", $("#txtEditUser").val());
    editFormData.append("department", $("#selEditDepartment").val());

    $.ajax({
      url: "/user-management/users/update",
      method: "POST",
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, userEditModal, userEditForm);
        } else {
          if (response.errors.user) {
            $("#txtEditUser").addClass("is-invalid");
            $("#valEditUser").text(response.errors.user[0]);
          }

          if (response.errors.department) {
            $("#selEditDepartment").next(".ts-wrapper").addClass("is-invalid");
            $("#valEditDepartment").text(response.errors.department[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, userEditModal, userEditForm);
      },
    });
  });

  usersDatatable.on("click", ".btnStatusUser", function () {
    const userId = $(this).closest("tr").find("td[data-user-id]").data("user-id");
    const userSetStatus = $(this).data("status");
    let statusName;

    if (userSetStatus === 1) {
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
          url: "/user-management/users/update",
          method: "PATCH",
          data: {
            id: userId,
            status: userSetStatus,
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
  // ============ End Update a User ============ //

  // ============ Delete a User ============ //
  usersDatatable.on("click", ".btnDeleteUser", function () {
    const userId = $(this).closest("tr").find("td[data-user-id]").data("user-id");

    Swal.fire({
      title: "Delete Record?",
      text: "Are you sure you want to delete the user?",
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
          url: "/user-management/users/delete",
          method: "DELETE",
          data: { id: userId },
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

  $("#btnMultiDeleteUser").on("click", function () {
    let checkedCheckboxes = usersDatatable.rows().nodes().to$().find("input.form-check-input:checked");

    let userIds = checkedCheckboxes
      .map(function () {
        return $(this).closest("tr").find("[data-user-id]").data("user-id");
      })
      .get();

    Swal.fire({
      title: "Delete Records?",
      text: "Are you sure you want to delete all the selected users?",
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
          url: "/user-management/users/delete",
          method: "DELETE",
          data: { id: userIds },
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
  // ============ End Delete a User ============ //
});
