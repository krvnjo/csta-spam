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
          const fields = {
            brand: '#txtAddBrand',
            subcategories: '#selAddSubcategories',
          };

          Object.keys(fields).forEach((key) => {
            if (response.errors[key]) {
              const element = $(fields[key]);
              element.addClass('is-invalid');
              if (key === 'subcategories') {
                element.next('.ts-wrapper').addClass('is-invalid');
              }
              $(`#valAdd${key.charAt(0).toUpperCase() + key.slice(1)}`).text(response.errors[key][0]);
            }
          });
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
        let totalSubcategories = subcategories.reduce((total, category) => total + category.subcategories.length, 0);
        $('#lblViewTotalSubcategories').text(`${totalSubcategories} subcategories in this brand`);

        if (totalSubcategories > 0) {
          subcategories.forEach((category) => {
            dropdownSubcategory.append($('<h5>').addClass('dropdown-header').text(category.category));
            category.subcategories.forEach((subcategory) => {
              dropdownSubcategory.append($('<span>').addClass('dropdown-item').text(subcategory));
            });
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
        $('#lblViewDateCreated').text(response.created);
        $('#imgViewUpdatedByImage').attr('src', response.updated_img);
        $('#lblViewUpdatedBy').text(response.updated_by);
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
        confirmButton: 'btn btn-white',
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

    if (brandIds.length === 0) {
      Swal.fire({
        title: 'No brand selected!',
        text: 'Please select at least one brand to delete.',
        icon: 'info',
        confirmButtonText: 'OK',
        customClass: {
          confirmButton: 'btn btn-info',
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
    }
  });
  // ============ End Delete a Brand ============ //
});
