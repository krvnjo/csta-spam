$(document).ready(function () {
  const ongoingsDatatable = $('#ongoingsDatatable').DataTable();

  // ============ View Ongoing Request ============ //
  ongoingsDatatable.on('click', '.btnViewOngoing', function () {
    const ongoingId = $(this).closest('tr').find('td[data-ongoing-id]').data('ongoing-id');

    $.ajax({
      url: '/repair-maintenance/ongoing-maintenance/view',
      method: 'GET',
      data: { id: ongoingId },
      success: function (response) {
        $('#modalViewRequest').modal('toggle');

        const ongoingConfig = {
          textFields: [
            { key: 'num', selector: '#lblViewNum' },
            { key: 'ticket', selector: '#lblViewTicket' },
            { key: 'description', selector: '#lblViewDescription' },
            { key: 'cost', selector: '#lblViewCost' },
            { key: 'created_by', selector: '#lblViewCreatedBy' },
            { key: 'updated_by', selector: '#lblViewUpdatedBy' },
            { key: 'created_at', selector: '#lblViewCreatedAt' },
            { key: 'updated_at', selector: '#lblViewUpdatedAt' },
          ],

          dropdownFields: [
            {
              key: 'items',
              container: '#dropdownMenuViewItems',
              countSelector: '#lblViewItems',
              label: 'items in this ticket',
            },
          ],

          progressFields: { key: 'progress', selector: '#lblViewProgress' },

          imageFields: [
            { key: 'image', selector: '#imgViewUser' },
            { key: 'created_img', selector: '#imgViewCreatedBy' },
            { key: 'updated_img', selector: '#imgViewUpdatedBy' },
          ],
        };

        displayViewResponseData(response, ongoingConfig);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End View Ticket Request ============ //

  // ============ Edit Ticket Request ============ //
  ongoingsDatatable.on('click', '.btnEditOngoing', function () {
    const ongoingId = $(this).closest('tr').find('td[data-ongoing-id]').data('ongoing-id');

    $.ajax({
      url: '/repair-maintenance/ongoing-maintenance/edit',
      method: 'GET',
      data: { id: ongoingId },
      success: function (response) {
        ongoingEditModal.modal('toggle');
        $('#lblEditTicketNumber').text(response.num);
        populateEditForm(response);

        const itemsContainer = $('#itemsContainer');
        itemsContainer.empty();

        response.items.forEach((item) => {
          const itemTemplate = `
            <div class="item mb-4">
                <span class="col col-form-label form-label fw-semibold">Item Name: ${item.name}</span>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col col-form-label form-label" for="selCondition${item.id}">Condition</label>
                            <div class="tom-select-custom">
                                <select class="js-select form-select" id="selCondition${item.id}" name="condition${item.id}" required
                                    data-hs-tom-select-options='{
                                        "hideSearch": "true",
                                        "placeholder": "Select a condition"
                                    }'>
                                    <option value=""></option>
                                    <option value="1">Fully Functional</option>
                                    <option value="2">Working with Minor Issues</option>
                                    <option value="3">Working with Major Issues</option>
                                    <option value="4">Not Working</option>
                                </select>
                                <span class="invalid-feedback" id="valEditCondition${item.id}"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col col-form-label form-label" for="selStatus${item.id}">Status</label>
                            <div class="tom-select-custom">
                                <select class="js-select form-select" id="selStatus${item.id}" name="status${item.id}" required
                                    data-hs-tom-select-options='{
                                        "hideSearch": "true",
                                        "placeholder": "Select a status"
                                    }'>
                                    <option value=""></option>
                                    <option value="1">Available</option>
                                    <option value="8">For Replacement</option>
                                    <option value="9">For Disposal</option>
                                </select>
                                <span class="invalid-feedback" id="valAddStatus"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

          itemsContainer.append(itemTemplate);

          // Get the condition and status elements
          const conditionSelect = $(`#selCondition${item.id}`);
          const statusSelect = $(`#selStatus${item.id}`);

          // Event listener for condition change to hide/show status options
          conditionSelect.on('change', function () {
            const selectedCondition = conditionSelect.val();

            if (selectedCondition == '4') {
              // "Not Working" condition
              statusSelect.find('option[value="1"]').hide(); // Hide "Available"
            } else {
              statusSelect.find('option[value="1"]').show(); // Show "Available"
            }
          });

          // Event listener for status change to restrict conditions based on status
          statusSelect.on('change', function () {
            const selectedStatus = statusSelect.val();

            if (selectedStatus == '8' || selectedStatus == '9') {
              // "For Replacement" or "For Disposal"
              conditionSelect.val('4'); // Automatically set to "Not Working"
              conditionSelect.prop('disabled', true); // Disable condition select
            } else {
              conditionSelect.prop('disabled', false); // Enable condition select
            }
          });
        });
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Edit Ticket Request ============ //

  // ============ Update a Ticket Request ============ //
  const ongoingEditModal = $('#modalEditOngoing');
  const ongoingEditForm = $('#frmEditOngoing');
  const ongoingEditSaveBtn = $('#btnEditSaveOngoing');

  handleUnsavedChanges(ongoingEditModal, ongoingEditForm, ongoingEditSaveBtn);

  ongoingEditForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(ongoingEditSaveBtn, true);

    const editFormData = new FormData(ongoingEditForm[0]);

    $.ajax({
      url: '/repair-maintenance/ongoing-maintenance',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(ongoingEditSaveBtn, false);
          showResponseAlert(response, 'success', ongoingEditModal, ongoingEditForm);
        } else {
          handleValidationErrors(response, 'Edit');
          toggleButtonState(ongoingEditSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', ongoingEditModal, ongoingEditForm);
      },
    });
  });
  // ============ End Update Ticket Request ============ //
});
