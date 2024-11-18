$(document).ready(function () {
  // ============ Add a Stock Variant ============ //
  const childDatatable = $('#propertyChildDatatable').DataTable();
  const childAddModal = $('#addPropertyChild');
  const childAddForm = $('#frmAddVarProperty');
  const childAddSaveBtn = $('#btnAddSaveChild');

  handleUnsavedChanges(childAddModal, childAddForm, childAddSaveBtn);

  childAddForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(childAddSaveBtn, true);

    const addFormData = new FormData(childAddForm[0]);

    $.ajax({
      url: childAddForm.attr('action'),
      method: 'POST',
      data: addFormData,
      dataType: 'json',
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', childAddModal, childAddForm);
        } else {
          toggleButtonState(childAddSaveBtn, false);
          if (response.errors.VarQuantity) {
            $('#txtVarQuantity').addClass('is-invalid');
            $('#valAddChildQty').text(response.errors.VarQuantity[0]);
          }
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', childAddModal, childAddForm);
      },
    });
  });
  // ============ End Add a Stock Variant ============ //

  // ============ Update a Stock Variant ============ //

  const childEditModal = $('#editPropChildModal');
  const childEditForm = $('#frmEditPropChild');
  const childEditSaveBtn = $('#btnEditSaveChild');

  const parentId = $('.page-header-title span').text().trim();

  handleUnsavedChanges(childEditModal, childEditForm, childEditSaveBtn);

  childDatatable.on('click', '.btnEditPropChild', function () {
    const childId = $(this).closest('tr').find('td[data-child-id]').data('child-id');

    $.ajax({
      url: '/properties-assets/' + parentId + '/child-stocks/edit',
      method: 'GET',
      data: { id: childId },
      success: function (response) {
        childEditModal.modal('toggle');
        $('#txtEditChildId').val(response.id);
        $('#editPropCode').text(response.propCode);
        $('#txtEditSerialNumber').val(response.serialNumber);
        $('#txtEditRemarks').val(response.remarks);
        $('#cbxEditAcquiredType')[0].tomselect.setValue(response.type_id);
        $('#cbxEditCondition')[0].tomselect.setValue(response.condi_id);
        $('#txtEditDateAcquired').val(response.acquiredDate);
        $('#txtEditWarrantyDate').val(response.warrantyDate);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });

  childEditForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(childEditSaveBtn, true);

    const editFormData = new FormData(childEditForm[0]);

    editFormData.append('_method', 'PATCH');
    editFormData.append('id', $('#txtEditChildId').val());
    editFormData.append('serialNumber', $('#txtEditSerialNumber').val());
    editFormData.append('remarks', $('#txtEditRemarks').val());
    editFormData.append('acquiredType', $('#cbxEditAcquiredType').val());
    editFormData.append('condition', $('#cbxEditCondition').val());
    editFormData.append('acquiredDate', $('#txtEditDateAcquired').val());
    editFormData.append('warranty', $('#txtEditWarrantyDate').val());

    $.ajax({
      url: '/properties-assets/' + parentId + '/child-stocks/',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', childEditModal, childEditForm);
        } else {
          toggleButtonState(childEditSaveBtn, false);
          if (response.errors.serialNumber) {
            $('#txtEditSerialNumber').addClass('is-invalid');
            $('#valEditSerial').text(response.errors.serialNumber[0]);
          }
          if (response.errors.remarks) {
            $('#txtEditRemarks').addClass('is-invalid');
            $('#valEditRemarks').text(response.errors.remarks[0]);
          }
          if (response.errors.acquiredType) {
            $('#cbxEditAcquiredType').next('.ts-wrapper').addClass('is-invalid');
            $('#valEditAcquired').text(response.errors.acquiredType[0]);
          }
          if (response.errors.condition) {
            $('#cbxEditCondition').next('.ts-wrapper').addClass('is-invalid');
            $('#valEditCondition').text(response.errors.condition[0]);
          }
          if (response.errors.acquiredDate) {
            $('#txtEditDateAcquired').addClass('is-invalid');
            $('#valEditDateAcq').text(response.errors.acquiredDate[0]);
          }
          if (response.errors.warranty) {
            $('#txtEditWarrantyDate').addClass('is-invalid');
            $('#valEditWarranty').text(response.errors.warranty[0]);
          }
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', childEditModal, childEditForm);
      },
    });
  });

  childDatatable.on('click', '.btnStatusChild', function () {
    const childId = $(this).closest('tr').find('td[data-child-id]').data('child-id');
    const childSetStatus = $(this).data('status');
    let statusName;

    if (childSetStatus === 1) {
      statusName = 'active';
    } else {
      statusName = 'inactive';
    }

    Swal.fire({
      title: 'Change status?',
      text: 'Are you sure you want to set it to ' + statusName + '?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, set it to ' + statusName + '!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        popup: 'bg-light rounded-3 shadow fs-4',
        title: 'fs-1',
        htmlContainer: 'text-muted text-center fs-4',
        confirmButton: 'btn btn-sm btn-primary',
        cancelButton: 'btn btn-sm btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/properties-assets/' + parentId + '/child-stocks/',
          method: 'PATCH',
          data: {
            id: childId,
            status: childSetStatus,
          },
          success: function (response) {
            showResponseAlert(response, 'success');
          },
          error: function (response) {
            showResponseAlert(response, 'error');
          },
        });
      }
    });
  });

  // ============ End Update a Stock Variant ============ //

  // ============ View a Stock Item ============ //
  childDatatable.on('click', '.btnViewChild', function () {
    const childId = $(this).closest('tr').find('td[data-child-id]').data('child-id');

    $.ajax({
      url: '/properties-assets/' + parentId + '/child-stocks/view',
      method: 'GET',
      data: { id: childId },
      success: function (response) {
        $('#viewChildModal').modal('toggle');

        $('#lblViewPropCode').text(response.propcode);
        $('#lblViewSerialNum').text(response.serialNum);
        $('#lblViewDepartment').text(response.department);
        $('#lblViewDesignation').text(response.designation);
        $('#lblViewCondition').text(response.condition);
        const childStatus =
          response.status === 1
            ? `<span class="badge bg-soft-success text-success"><span class="legend-indicator bg-success"></span>Active</span>`
            : `<span class="badge bg-soft-danger text-danger"><span class="legend-indicator bg-danger"></span>Inactive</span>`;
        $('#lblViewStatus').html(childStatus);
        $('#lblViewRemarks').text(response.remarks || '-');
        $('#lblViewAcquiredType').text(response.acquiredType);
        $('#lblViewItemStatus').text(response.itemStatus);
        $('#lblViewAcquiredDate').text(response.acquiredDate);
        $('#lblViewInvDate').text(response.inventoryDate);
        $('#lblViewWarrantyDate').text(response.warrantyDate);
        $('#lblViewDateCreated').text(response.dateCreated);
        $('#lblViewDateUpdated').text(response.dateUpdated);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End View a Stock Item ============ //

  // ============ Delete a Stock Variant ============ //
  childDatatable.on('click', '.btnDeleteChild', function () {
    const childId = $(this).data('childdel-id');

    Swal.fire({
      title: 'Delete Record?',
      text: 'Are you sure you want to delete the item?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        popup: 'bg-light rounded-3 shadow fs-4',
        title: 'fs-1',
        htmlContainer: 'text-muted text-center fs-4',
        confirmButton: 'btn btn-sm btn-danger',
        cancelButton: 'btn btn-sm btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/properties-assets/' + parentId + '/child-stocks/',
          method: 'DELETE',
          data: { id: [childId] },
          success: function (response) {
            showResponseAlert(response, 'success');
          },
          error: function (response) {
            showResponseAlert(response, 'error');
          },
        });
      }
    });
  });

  $('#btnMultiDeleteChild').on('click', function () {
    let checkedCheckboxes = childDatatable.rows().nodes().to$().find('input.form-check-input:checked');

    let childIds = checkedCheckboxes
      .map(function () {
        return $(this).closest('tr').find('[data-childdel-id]').data('childdel-id');
      })
      .get();

    if (childIds.length === 0) {
      Swal.fire({
        title: 'No Items Selected',
        text: 'Please select at least one item to delete.',
        icon: 'info',
        confirmButtonText: 'OK',
        customClass: {
          popup: 'bg-light rounded-3 shadow fs-4',
          title: 'fs-1',
          htmlContainer: 'text-muted text-center fs-4',
          confirmButton: 'btn btn-sm btn-info',
        },
      });
      return;
    }

    Swal.fire({
      title: 'Delete Records?',
      text: 'Are you sure you want to delete all the selected items?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        popup: 'bg-light rounded-3 shadow fs-4',
        title: 'fs-1',
        htmlContainer: 'text-muted text-center fs-4',
        confirmButton: 'btn btn-sm btn-danger',
        cancelButton: 'btn btn-sm btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/properties-assets/' + parentId + '/child-stocks/',
          method: 'DELETE',
          data: { id: childIds },
          success: function (response) {
            showResponseAlert(response, 'success');
          },
          error: function (response) {
            showResponseAlert(response, 'error');
          },
        });
      }
    });
  });

  // ============ End Delete a Stock Variant ============ //

  // ============ Move Stock to Inventory ============ //
  const childMoveModal = $('#movePropChildModal');
  const childMoveForm = $('#frmMovePropChild');
  const childMoveSaveBtn = $('#btnMoveChildSave');

  handleUnsavedChanges(childMoveModal, childMoveForm, childMoveSaveBtn);

  let selectedPropertyChildIds = [];

  $('#propertyStockDatatableCheckAll').change(function () {
    $('.child-checkbox').prop('checked', this.checked);

    selectedPropertyChildIds = [];
    if (this.checked) {
      $('.child-checkbox:checked').each(function () {
        selectedPropertyChildIds.push($(this).val());
      });
    }
  });

  $(document).on('change', '.child-checkbox', function () {
    let propertyChildId = $(this).val();
    if (this.checked) {
      selectedPropertyChildIds.push(propertyChildId);
    } else {
      let index = selectedPropertyChildIds.indexOf(propertyChildId);
      if (index > -1) {
        selectedPropertyChildIds.splice(index, 1);
      }
    }
  });

  childDatatable.on('click', '.btnMoveToInventory', function () {
    const childId = $(this).data('childmove-id');
    selectedPropertyChildIds = [childId];
    childMoveModal.data('selectedCount', 1);
    childMoveModal.modal('show');
  });

  $('#btnMoveToInventory').on('click', function () {
    if (selectedPropertyChildIds.length === 0) {
      Swal.fire({
        title: 'No Items Selected',
        text: 'Please select at least one item to move.',
        icon: 'info',
        confirmButtonText: 'OK',
        customClass: {
          popup: 'bg-light rounded-3 shadow fs-4',
          title: 'fs-1',
          htmlContainer: 'text-muted text-center fs-4',
          confirmButton: 'btn btn-sm btn-info',
        },
      });
    } else {
      childMoveModal.data('selectedCount', selectedPropertyChildIds.length);
      childMoveModal.modal('show');
    }
  });

  childMoveModal.on('show.bs.modal', function () {
    const selectedCount = childMoveModal.data('selectedCount') || 0;
    $('#movePropIds').text(`${selectedCount} item${selectedCount > 1 ? 's' : ''}`);
  });

  childMoveForm.on('submit', function (e) {
    e.preventDefault();

    toggleButtonState(childMoveSaveBtn, true);
    const editFormData = new FormData(childMoveForm[0]);

    editFormData.append('_method', 'PATCH');
    editFormData.append('movePropIds', selectedPropertyChildIds);
    editFormData.append('remarks', $('#txtMoveRemarks').val());
    editFormData.append('designation', $('#cbxMoveDesignation').val());

    $.ajax({
      url: '/properties-assets/' + parentId + '/child-stocks/move',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', childMoveModal, childMoveForm);
        } else {
          toggleButtonState(childMoveSaveBtn, false);
          if (response.errors.designation) {
            $('#cbxMoveDesignation').next('.ts-wrapper').addClass('is-invalid');
            $('#valMoveDesignation').text(response.errors.designation[0]);
          }
          if (response.errors.remarks) {
            $('#txtMoveRemarks').addClass('is-invalid');
            $('#valMoveRemarks').text(response.errors.remarks[0]);
          }
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', childMoveModal, childMoveForm);
      },
    });
  });

  // ============ End Move Stock to Inventory ============ //

  // ============ Dispose a Item ============ //

  childDatatable.on('click', '.btnDisposed', function () {
    const childId = $(this).closest('tr').find('td[data-child-id]').data('child-id');
    console.log('Dispose Child ID:', childId);
    Swal.fire({
      title: 'Dispose Item Variation?',
      text: 'Are you sure you want to dispose this item?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, dispose it!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        popup: 'bg-light rounded-3 shadow fs-4',
        title: 'fs-1',
        htmlContainer: 'text-muted text-center fs-4',
        confirmButton: 'btn btn-sm btn-danger',
        cancelButton: 'btn btn-sm btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/properties-assets/' + parentId + '/child-stocks/dispose',
          method: 'PATCH',
          data: {
            id: childId,
          },
          success: function (response) {
            showResponseAlert(response, 'success');
          },
          error: function (response) {
            showResponseAlert(response, 'error');
          },
        });
      }
    });
  });

  // ============ End Dispose a Item ============ //
});
document.addEventListener('DOMContentLoaded', function () {
  new TomSelect('#cbxEditAcquiredType', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
    onChange: function (value) {
      const warrantyDateInput = document.getElementById('txtEditWarrantyDate');

      const PURCHASED_ID = '1';
      const DONATION_ID = '2';

      if (value === DONATION_ID) {
        warrantyDateInput.disabled = true;
        warrantyDateInput.value = '';
        warrantyDateInput.classList.add('bg-light');
      } else if (value === PURCHASED_ID) {
        warrantyDateInput.disabled = false;
        warrantyDateInput.classList.remove('bg-light');
      }
    },
  });

  new TomSelect('#cbxEditCondition', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
  });

  new TomSelect('#propertyStockDatatableEntries', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
  });

  new TomSelect('#cbxMoveDesignation', {
    controlInput: false,
    hideSearch: true,
    allowEmptyOption: true,
  });

  document.querySelectorAll('.tom-select input[type="text"]').forEach(function (input) {
    input.addEventListener('keydown', function (event) {
      event.preventDefault();
    });
  });
});
