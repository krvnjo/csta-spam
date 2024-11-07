$(document).ready(function () {
  // ============ Login a User ============ //
  const userLoginForm = $('#frmLoginUser');
  const userLoginBtn = $('#btnLoginUser');

  userLoginForm.find('input[type="text"]').first().focus();

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

  forgotPasswordForm.find('input[type="email"]').first().focus();

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
          $('#forgotPasswordContainer').html(`
          <div class="pb-5 text-center">
            <h1 class="display-5">${response.title}</h1>
            <p class="mt-5">${response.text}</p>
          </div>
          <div class="d-grid">
            <a class="btn btn-primary btn-lg" href="/login">
              <i class="bi-chevron-left"></i> Back to log in
            </a>
          </div>
        `);
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

  resetPasswordForm.find('input[type="text"]').first().focus();

  resetPasswordForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(resetPasswordBtn, true);

    const resetPasswordFormData = new FormData(resetPasswordForm[0]);
    const token = resetPasswordFormData.get('token');

    $.ajax({
      url: '/reset-password/' + token,
      method: 'POST',
      data: resetPasswordFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(resetPasswordBtn, false);
          Swal.fire({
            title: response.title,
            text: response.text,
            icon: 'success',
            confirmButtonText: 'Done',
            focusCancel: true,
            customClass: {
              popup: 'bg-light rounded-3 shadow fs-4',
              title: 'fs-1',
              htmlContainer: 'text-muted text-center fs-4',
              confirmButton: 'btn btn-sm btn-secondary',
            },
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = response.redirect;
            }
          });
        } else {
          handleValidationErrors(response, 'Reset');
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Reset Password ============ //
});
