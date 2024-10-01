$(document).ready(function () {
  // ============ Update a User Account Information ============ //
  const accountBasicInfoForm = $("#frmAccountBasicInfo");

  accountBasicInfoForm.on("submit", function (e) {
    e.preventDefault();

    const accountBasicInfoFormData = new FormData(accountBasicInfoForm[0]);
    accountBasicInfoFormData.append("_method", "PATCH");
    accountBasicInfoFormData.append("avatar", $("#imgDisplayAccountImage").attr("src").split("/").pop());

    $.ajax({
      url: "/account-settings/update",
      method: "POST",
      data: accountBasicInfoFormData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response);
        } else {
          if (response.errors.email) {
            $("#txtAccountEmail").addClass("is-invalid");
            $("#valAccountEmail").text(response.errors.email[0]);
          }

          if (response.errors.phone) {
            $("#txtAccountPhone").addClass("is-invalid");
            $("#valAccountPhone").text(response.errors.phone[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON);
      },
    });
  });
  // ============ End Update a User Account Information ============ //

  // ============ Update Account Password ============ //
  const accountPasswordForm = $("#frmAccountChangePass");

  accountPasswordForm.on("submit", function (e) {
    e.preventDefault();

    const accountPasswordFormData = new FormData(accountPasswordForm[0]);
    accountPasswordFormData.append("_method", "PATCH");

    $.ajax({
      url: "/account-settings/update",
      method: "POST",
      data: accountPasswordFormData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response);
        } else {
          if (response.errors.currentpass) {
            $("#txtAccountCurrentPass").addClass("is-invalid");
            $("#valAccountCurrentPass").text(response.errors.currentpass[0]);
          }

          if (response.errors.newpass) {
            $("#txtAccountNewPass").addClass("is-invalid");
            $("#valAccountNewPass").text(response.errors.newpass[0]);
          }

          if (response.errors.confirmpass) {
            $("#txtAccountConfirmPass").addClass("is-invalid");
            $("#valAccountConfirmPass").text(response.errors.confirmpass[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON);
      },
    });
  });
  // ============ End Update Account Password ============ //
});
