$(document).ready(function () {
  const accountUsername = $('#txtAccountUsername').val();

  // ============ Update a User Account Information ============ //
  const accountImageForm = $('#frmAccountImage');
  const accountBasicInfoForm = $('#frmAccountBasicInfo');

  $('#btnAccountSave').on('click', function (e) {
    e.preventDefault();

    const accountImageFormData = new FormData(accountImageForm[0]);
    accountImageFormData.append('_method', 'PATCH');
    accountImageFormData.append('avatar', $('#imgDisplayAccountImage').attr('src').split('/').pop());
    accountImageFormData.append('email', accountBasicInfoForm.find('input[name="email"]').val());
    accountImageFormData.append('phone', accountBasicInfoForm.find('input[name="phone"]').val());

    $.ajax({
      url: '/account/' + accountUsername,
      method: 'POST',
      data: accountImageFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response);
        } else {
          if (response.errors.email) {
            $('#txtAccountEmail').addClass('is-invalid');
            $('#valAccountEmail').text(response.errors.email[0]);
          }

          if (response.errors.phone) {
            $('#txtAccountPhone').addClass('is-invalid');
            $('#valAccountPhone').text(response.errors.phone[0]);
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
  const accountPasswordForm = $('#frmAccountChangePass');

  accountPasswordForm.on('submit', function (e) {
    e.preventDefault();

    const accountPasswordFormData = new FormData(accountPasswordForm[0]);
    accountPasswordFormData.append('_method', 'PATCH');

    $.ajax({
      url: '/account/' + accountUsername,
      method: 'POST',
      data: accountPasswordFormData,
      dataType: 'json',
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response);
        } else {
          if (response.errors.currentpass) {
            $('#txtAccountCurrentPass').addClass('is-invalid');
            $('#valAccountCurrentPass').text(response.errors.currentpass[0]);
          }

          if (response.errors.newpass) {
            $('#txtAccountNewPass').addClass('is-invalid');
            $('#valAccountNewPass').text(response.errors.newpass[0]);
          }

          if (response.errors.confirmpass) {
            $('#txtAccountConfirmPass').addClass('is-invalid');
            $('#valAccountConfirmPass').text(response.errors.confirmpass[0]);
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
