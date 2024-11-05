$(document).ready(function () {
  // ============ Login a User ============ //
  const userLoginForm = $('#frmLoginUser');
  const userLoginBtn = $('#btnLoginUser');

  userLoginForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(userLoginBtn, true);

    const loginFormData = new FormData(userLoginForm[0]);

    $.ajax({
      url: '/login',
      method: 'POST',
      data: loginFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          window.location.href = response.redirect;
        } else {
          handleValidationErrors(response, 'Login');
          toggleButtonState(userLoginBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Login a User ============ //

  // ============ Forgot Password ============ //
  const forgotPasswordForm = $('#frmForgotPassword');
  const forgotPasswordBtn = $('#btnForgotPassword');

  forgotPasswordForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(forgotPasswordBtn, true);

    const forgotPasswordFormData = new FormData(forgotPasswordForm[0]);

    $.ajax({
      url: '/forgot-password',
      method: 'POST',
      data: forgotPasswordFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success');
          console.log(response.status);
        } else {
          handleValidationErrors(response, 'Forgot');
          toggleButtonState(forgotPasswordBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Forgot Password ============ //

  // ============ Reset Password ============ //
  const resetPasswordForm = $('#frmResetPassword');
  const resetPasswordBtn = $('#btnResetPassword');

  resetPasswordForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(resetPasswordBtn, true);

    const resetPasswordFormData = new FormData(resetPasswordForm[0]);

    $.ajax({
      url: '/reset-password/',
      method: 'POST',
      data: resetPasswordFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success');
          window.location.href = response.redirect;
        } else {
          console.log(response);
          toggleButtonState(resetPasswordBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Reset Password ============ //
});
