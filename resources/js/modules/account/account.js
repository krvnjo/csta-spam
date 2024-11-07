$(document).ready(function () {
  const accountUsername = $('#txtAccountUsername').val();

  // ============ Update a User Account Information ============ //
  const accountImageForm = $('#frmAccountImage');
  const accountBasicInfoForm = $('#frmAccountBasicInfo');
  const accountBasicInfoBtn = $('#btnAccountSave');

  accountBasicInfoBtn.on('click', function (e) {
    e.preventDefault();
    toggleButtonState(accountBasicInfoBtn, true);

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
          showResponseAlert(response, 'success');
        } else {
          handleValidationErrors(response, 'Account');
          toggleButtonState(accountBasicInfoBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Update a User Account Information ============ //

  // ============ Update Account Password ============ //
  const accountPasswordForm = $('#frmAccountPass');
  const accountPasswordSaveBtn = $('#btnAccountSavePass');

  accountPasswordForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(accountPasswordSaveBtn, true);

    const accountPasswordFormData = new FormData(accountPasswordForm[0]);

    $.ajax({
      url: '/account/' + accountUsername,
      method: 'POST',
      data: accountPasswordFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success');
        } else {
          handleValidationErrors(response, 'Account');
          toggleButtonState(accountPasswordSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Update Account Password ============ //
});
