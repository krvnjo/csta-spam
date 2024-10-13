$(document).ready(function () {
  const brandsDatatable = $('#brandsDatatable').DataTable();

  // ============ Create a Brand ============ //
  const brandAddModal = $('#modalAddBrand');
  const brandAddForm = $('#frmAddBrand');

  handleUnsavedChanges(brandAddModal, brandAddForm, $('#btnAddSaveBrand'));

  brandAddForm.on('submit', function (e) {
    e.preventDefault();

    const addFormData = new FormData(brandAddForm[0]);

    $.ajax({
      url: '/file-maintenance/brands',
      method: 'POST',
      data: addFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, brandAddModal, brandAddForm);
        } else {
          if (response.errors.brand) {
            $('#txtAddBrand').addClass('is-invalid');
            $('#valAddBrand').text(response.errors.brand[0]);
          }
          if (response.errors.subcategories) {
            $('#selAddSubcategories').next('.ts-wrapper').addClass('is-invalid');
            $('#valAddSubcategories').text(response.errors.subcategories[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, brandAddModal, brandAddForm);
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

        let totalSubcategories = 0;
        subcategories.forEach((category) => (totalSubcategories += category.subcategories.length));

        $('#lblViewTotalSubcategories').text(`${totalSubcategories} subcategories in this brand`);

        if (totalSubcategories) {
          subcategories.forEach((category) => {
            dropdownSubcategory.append($('<h5>').addClass('dropdown-header').text(category.category));

            category.subcategories.forEach((subcategory) => {
              dropdownSubcategory.append($('<span>').addClass('dropdown-item').text(subcategory));
            });
          });
        } else {
          dropdownSubcategory.append('<span class="dropdown-item text-muted">No subcategories available.</span>');
        }

        const brandStatus =
          response.status === 1
            ? `<span class="badge bg-soft-success text-success"><span class="legend-indicator bg-success"></span>Active</span>`
            : `<span class="badge bg-soft-danger text-danger"><span class="legend-indicator bg-danger"></span>Inactive</span>`;

        $('#lblViewStatus').html(brandStatus);
        $('#lblViewDateCreated').text(response.created);
        $('#lblViewDateUpdated').text(response.updated);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON);
      },
    });
  });
  // ============ End View a Brand ============ //

  // ============ Update a Brand ============ //
  const brandEditModal = $('#modalEditBrand');
  const brandEditForm = $('#frmEditBrand');

  handleUnsavedChanges(brandEditModal, brandEditForm, $('#btnEditSaveBrand'));

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
        showErrorAlert(response.responseJSON, brandEditModal, brandEditForm);
      },
    });
  });

  brandEditForm.on('submit', function (e) {
    e.preventDefault();

    const editFormData = new FormData(brandEditForm[0]);

    editFormData.append('_method', 'PATCH');
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
          showSuccessAlert(response, brandEditModal, brandEditForm);
        } else {
          if (response.errors.brand) {
            $('#txtEditBrand').addClass('is-invalid');
            $('#valEditBrand').text(response.errors.brand[0]);
          }

          if (response.errors.subcategories) {
            $('#selEditSubcategories').next('.ts-wrapper').addClass('is-invalid');
            $('#valEditSubcategories').text(response.errors.subcategories[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, brandEditModal, brandEditForm);
      },
    });
  });

  brandsDatatable.on('click', '.btnStatusBrand', function () {
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
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-secondary',
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
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON);
          },
        });
      }
    });
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
        confirmButton: 'btn btn-danger',
        cancelButton: 'btn btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/file-maintenance/brands',
          method: 'DELETE',
          data: { id: brandId },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON);
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

    Swal.fire({
      title: 'Delete Records?',
      text: 'Are you sure you want to delete all the selected brands?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        confirmButton: 'btn btn-danger',
        cancelButton: 'btn btn-secondary',
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/file-maintenance/brands',
          method: 'DELETE',
          data: { id: brandIds },
          success: function (response) {
            showSuccessAlert(response);
          },
          error: function (response) {
            showErrorAlert(response.responseJSON);
          },
        });
      }
    });
  });
  // ============ End Delete a Brand ============ //
});
