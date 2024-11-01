$(document).ready(function () {
  const brandsDatatable = $('#brandsDatatable').DataTable();

  // ============ Create a Brand ============ //
  const brandAddModal = $('#modalAddBrand');
  const brandAddForm = $('#frmAddBrand');
  const brandAddSaveBtn = $('#btnAddSaveBrand');

  handleUnsavedChanges(brandAddModal, brandAddForm, brandAddSaveBtn);

  brandAddForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(brandAddSaveBtn, true);

    const addFormData = new FormData(brandAddForm[0]);

    $.ajax({
      url: '/file-maintenance/brands',
      method: 'POST',
      data: addFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', brandAddModal, brandAddForm);
        } else {
          handleValidationErrors(response, 'Add');
          toggleButtonState(brandAddSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', brandAddModal, brandAddForm);
      },
    });
  });
  // ============ End Create a Brand ============ //

  // ============ View a Brand ============ //
  brandsDatatable.on('click', '.btnViewBrand', function () {
    const brandId = $(this).closest('tr').find('td[data-brand-id]').data('brand-id');

    $.ajax({
      url: '/file-maintenance/brands/show',
      method: 'GET',
      data: { id: brandId },
      success: function (response) {
        $('#modalViewBrand').modal('toggle');

        $('#lblViewBrand').text(response.brand);

        const subcategories = response.subcategories;
        const dropdownSubcategory = $('#subcategoriesDropdownMenu').empty();
        let totalSubcategories = subcategories.length;
        $('#lblViewTotalSubcategories').text(`${totalSubcategories} subcategories in this brand`);

        if (totalSubcategories > 0) {
          subcategories.forEach((subcategory) => {
            dropdownSubcategory.append($('<span>').addClass('dropdown-item').text(subcategory));
          });
        } else {
          dropdownSubcategory.append('<span class="dropdown-item text-muted">No subcategories available.</span>');
        }

        const statusClass = response.status === 1 ? 'success' : 'danger';
        const statusText = response.status === 1 ? 'Active' : 'Inactive';
        $('#lblViewStatus').html(
          `<span class="badge bg-soft-${statusClass} text-${statusClass}"><span class="legend-indicator bg-${statusClass}"></span>${statusText}</span>`,
        );

        $('#imgViewCreatedByImage').attr('src', response.created_img);
        $('#lblViewCreatedBy').text(response.created_by);
        $('#lblViewCreatedAt').text(response.created_at);
        $('#imgViewUpdatedByImage').attr('src', response.updated_img);
        $('#lblViewUpdatedBy').text(response.updated_by);
        $('#lblViewUpdatedAt').text(response.updated_at);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End View a Brand ============ //

  // ============ Edit a Brand ============ //
  brandsDatatable.on('click', '.btnEditBrand', function () {
    const brandId = $(this).closest('tr').find('td[data-brand-id]').data('brand-id');

    $.ajax({
      url: '/file-maintenance/brands/edit',
      method: 'GET',
      data: { id: brandId },
      success: function (response) {
        brandEditModal.modal('toggle');

        $('#txtEditBrandId').val(response.id);
        $('#txtEditBrand').val(response.brand);
        $('#selEditSubcategories')[0].tomselect.setValue(response.subcategories);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Edit a Brand ============ //

  // ============ Update a Brand ============ //
  const brandEditModal = $('#modalEditBrand');
  const brandEditForm = $('#frmEditBrand');
  const brandEditSaveBtn = $('#btnEditSaveBrand');

  handleUnsavedChanges(brandEditModal, brandEditForm, brandEditSaveBtn);

  brandEditForm.on('submit', function (e) {
    e.preventDefault();

    toggleButtonState(brandEditSaveBtn, true);
    const editFormData = new FormData(brandEditForm[0]);

    editFormData.append('_method', 'PATCH');
    editFormData.append('action', 'update');
    editFormData.append('id', $('#txtEditBrandId').val());
    editFormData.append('brand', $('#txtEditBrand').val());
    editFormData.append('subcategories', $('#selEditSubcategories').val());

    $.ajax({
      url: '/file-maintenance/brands',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', brandEditModal, brandEditForm);
        } else {
          handleValidationErrors(response, 'Edit');
          toggleButtonState(brandEditSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', brandEditModal, brandEditForm);
      },
    });
  });

  brandsDatatable.on('click', '.btnSetBrand', function () {
    const brandId = $(this).closest('tr').find('td[data-brand-id]').data('brand-id');
    const brandSetStatus = $(this).data('status');
    let statusName;

    if (brandSetStatus === 1) {
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
        confirmButton: 'btn btn-sm btn-white',
        cancelButton: 'btn btn-sm btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/file-maintenance/brands',
          method: 'PATCH',
          data: {
            id: brandId,
            status: brandSetStatus,
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

  $('#btnMultiSetBrand').on('click', function () {
    let checkedCheckboxes = brandsDatatable.rows().nodes().to$().find('input.form-check-input:checked');

    let brandIds = checkedCheckboxes
      .map(function () {
        return $(this).closest('tr').find('[data-brand-id]').data('brand-id');
      })
      .get();

    if (brandIds.length === 0) {
      Swal.fire({
        title: 'No brand selected!',
        text: 'Please select at least one brand to change status.',
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
      Swal.fire({
        title: 'Change the status?',
        text: 'Are you sure you want to change the status of all the selected brands?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Set to Active!',
        cancelButtonText: 'Set to Inactive!',
        customClass: {
          popup: 'bg-light rounded-3 shadow fs-4',
          title: 'fs-1',
          htmlContainer: 'text-muted text-center fs-4',
          confirmButton: 'btn btn-sm btn-success',
          cancelButton: 'btn btn-sm btn-danger',
        },
      }).then((result) => {
        let status;
        if (result.isConfirmed) {
          status = 1;
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          status = 0;
        }
        if (status !== undefined) {
          $.ajax({
            url: '/file-maintenance/brands',
            method: 'PATCH',
            data: { id: brandIds, status: status },
            success: function (response) {
              showResponseAlert(response, 'success');
            },
            error: function (response) {
              showResponseAlert(response, 'error');
            },
          });
        }
      });
    }
  });
  // ============ End Update a Brand ============ //

  // ============ Delete a Brand ============ //
  brandsDatatable.on('click', '.btnDeleteBrand', function () {
    const brandId = $(this).closest('tr').find('td[data-brand-id]').data('brand-id');

    Swal.fire({
      title: 'Delete Record?',
      text: 'Are you sure you want to delete the brand?',
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
          url: '/file-maintenance/brands',
          method: 'DELETE',
          data: { id: brandId },
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

  $('#btnMultiDeleteBrand').on('click', function () {
    let checkedCheckboxes = brandsDatatable.rows().nodes().to$().find('input.form-check-input:checked');

    let brandIds = checkedCheckboxes
      .map(function () {
        return $(this).closest('tr').find('[data-brand-id]').data('brand-id');
      })
      .get();

    if (brandIds.length === 0) {
      Swal.fire({
        title: 'No brand selected!',
        text: 'Please select at least one brand to delete.',
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
      Swal.fire({
        title: 'Delete Records?',
        text: 'Are you sure you want to delete all the selected brands?',
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
            url: '/file-maintenance/brands',
            method: 'DELETE',
            data: { id: brandIds },
            success: function (response) {
              showResponseAlert(response, 'success');
            },
            error: function (response) {
              showResponseAlert(response, 'error');
            },
          });
        }
      });
    }
  });
  // ============ End Delete a Brand ============ //
});
