$(document).ready(function () {
  const userDatatable = $("#userDatatable").DataTable();

  // ============ Create a User ============ //
  const userAddModal = $("#addUserModal");
  const userAddForm = $("#frmAddUser");

  handleUnsavedChanges(userAddModal, userAddForm);

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
          userAddModal.modal("hide");
          showSuccessAlert(response, userAddModal, userAddForm);
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, userAddModal, userAddForm);
      },
    });
  });
  // ============ End Create a User ============ //
});
