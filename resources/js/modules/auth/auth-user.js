$(document).ready(function () {
  // ============ Login a User ============ //
  const userLoginForm = $('#frmLoginUser');

  userLoginForm.on('submit', function (e) {
    e.preventDefault();

    const loginFormData = userLoginForm.serialize();

    $.ajax({
      url: '/login',
      method: 'POST',
      data: loginFormData,
      success: function (response) {
        if (response.success) {
          userLoginForm[0].reset();
          window.location.href = response.redirect;
        } else {
          if (response.errors.user) {
            $('#txtLoginUsername').addClass('is-invalid');
            $('#valLoginUsername').text(response.errors.user[0]);
          }

          if (response.errors.pass) {
            $('#txtLoginPassword').addClass('is-invalid');
            $('#valLoginPassword').text(response.errors.pass[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON);
      },
    });
  });
  // ============ End Login a User ============ //
});
