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
        const dropdownSubcategory = $('#dropdownMenuViewSubcategories').empty();
        let totalSubcategories = subcategories.length;
        $('#lblViewSubcategories').text(`${totalSubcategories} subcategories in this brand`);

        if (totalSubcategories > 0) {
          subcategories.forEach((subcategory) => {
            dropdownSubcategory.append($('<span>').addClass('dropdown-item').text(subcategory));
          });
        } else {
          dropdownSubcategory.append('<span class="dropdown-item text-muted">No subcategories available.</span>');
        }

        const statusClass = response.status === 1 ? 'success' : 'danger';
        const statusText = response.status === 1 ? 'Active' : 'Inactive';
        $('#lblViewSetStatus').html(
          `<span class="badge bg-soft-${statusClass} text-${statusClass}"><span class="legend-indicator bg-${statusClass}"></span>${statusText}</span>`,
        );

        $('#imgViewCreatedBy').attr('src', response.created_img);
        $('#lblViewCreatedBy').text(response.created_by);
        $('#lblViewCreatedAt').text(response.created_at);
        $('#imgViewUpdatedBy').attr('src', response.updated_img);
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
    editFormData.append('id', $('#txtEditBrandId').val());
    editFormData.append('brand', $('#txtEditBrand').val());
    editFormData.append('subcategories', $('#selEditSubcategories').val());
    editFormData.append('action', 'update');

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
    const brandName = $(this).closest('tr').find('a.btnViewBrand').text().trim();
    const brandStatus = $(this).data('status');
    const statusName = brandStatus === 1 ? 'active' : 'inactive';

    Swal.fire({
      title: 'Update brand status?',
      text: `Are you sure you want to set the brand "${brandName}" to ${statusName}?`,
      icon: 'warning',
      showCancelButton: true,
      focusCancel: true,
      confirmButtonText: `Yes, set it to ${statusName}!`,
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
            status: brandStatus,
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
    let brandIds = brandsDatatable
      .rows()
      .nodes()
      .to$()
      .find('input.form-check-input:checked')
      .map(function () {
        return $(this).closest('tr').find('[data-brand-id]').data('brand-id');
      })
      .get();

    if (brandIds.length === 0) {
      showResponseAlert(
        {
          title: 'No record selected!',
          text: 'Please select at least one brand to change status.',
        },
        'info',
      );
    } else {
      Swal.fire({
        title: 'Update brands status?',
        text: 'Are you sure you want to change the status of the selected brands?',
        icon: 'warning',
        showDenyButton: true,
        showCancelButton: true,
        focusCancel: true,
        confirmButtonText: 'Set to Active!',
        denyButtonText: 'Set to Inactive!',
        cancelButtonText: 'No, cancel!',
        customClass: {
          popup: 'bg-light rounded-3 shadow fs-4',
          title: 'fs-1',
          htmlContainer: 'text-muted text-center fs-4',
          confirmButton: 'btn btn-sm btn-soft-success',
          denyButton: 'btn btn-sm btn-soft-danger',
          cancelButton: 'btn btn-sm btn-secondary',
        },
      }).then((result) => {
        const status = result.isConfirmed ? 1 : result.isDenied ? 0 : undefined;

        if (status !== undefined) {
          $.ajax({
            url: '/file-maintenance/brands',
            method: 'PATCH',
            data: {
              id: brandIds,
              status: status,
            },
            success: function (response) {
              showResponseAlert(response, response.type ?? 'success');
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
    const brandName = $(this).closest('tr').find('a.btnViewBrand').text().trim();

    Swal.fire({
      title: 'Delete Record?',
      text: `Are you sure you want to delete the brand "${brandName}"?`,
      icon: 'warning',
      showCancelButton: true,
      focusCancel: true,
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
    let brandIds = brandsDatatable
      .rows()
      .nodes()
      .to$()
      .find('input.form-check-input:checked')
      .map(function () {
        return $(this).closest('tr').find('[data-brand-id]').data('brand-id');
      })
      .get();

    if (brandIds.length === 0) {
      showResponseAlert(
        {
          title: 'No record selected!',
          text: 'Please select at least one brand to delete.',
        },
        'info',
      );
    } else {
      Swal.fire({
        title: 'Delete Records?',
        text: 'Are you sure you want to delete all the selected brands?',
        icon: 'warning',
        showCancelButton: true,
        focusCancel: true,
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
