$(document).ready(function () {
  // ============ Session Timeout ============ //
  const settingSessionForm = $('#frmSettingSession');
  const settingSessionSaveBtn = $('#btnSettingSaveSession');

  settingSessionForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(settingSessionSaveBtn, true);

    const settingSessionFormData = new FormData(settingSessionForm[0]);

    $.ajax({
      url: '/system-settings',
      method: 'POST',
      data: settingSessionFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(settingSessionSaveBtn, false);
          showResponseAlert(response, 'success');
        } else {
          handleValidationErrors(response, 'Setting');
          toggleButtonState(settingSessionSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Session Timeout ============ //
});
