$(document).ready(function () {
  const subcategoriesDatatable = $('#subcategoriesDatatable').DataTable();

  // ============ Create a Subcategory ============ //
  const subcategoryAddModal = $('#modalAddSubcategory');
  const subcategoryAddForm = $('#frmAddSubcategory');
  const subcategoryAddSaveBtn = $('#btnAddSaveSubcategory');

  handleUnsavedChanges(subcategoryAddModal, subcategoryAddForm, subcategoryAddSaveBtn);

  subcategoryAddForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(subcategoryAddSaveBtn, true);

    const addFormData = new FormData(subcategoryAddForm[0]);

    $.ajax({
      url: '/file-maintenance/subcategories',
      method: 'POST',
      data: addFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', subcategoryAddModal, subcategoryAddForm);
        } else {
          handleValidationErrors(response, 'Add');
          toggleButtonState(subcategoryAddSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', subcategoryAddModal, subcategoryAddForm);
      },
    });
  });
  // ============ End Create a Subcategory ============ //

  // ============ View a Subcategory ============ //
  subcategoriesDatatable.on('click', '.btnViewSubcategory', function () {
    const subcategoryId = $(this).closest('tr').find('td[data-subcategory-id]').data('subcategory-id');

    $.ajax({
      url: '/file-maintenance/subcategories/show',
      method: 'GET',
      data: { id: subcategoryId },
      success: function (response) {
        $('#modalViewSubcategory').modal('toggle');

        $('#lblViewSubcategory').text(response.subcategory);

        const categories = response.categories;
        const dropdownCategory = $('#dropdownMenuViewCategories').empty();
        let totalCategories = categories.length;
        $('#lblViewCategories').text(`${totalCategories} categories in this subcategory`);

        if (totalCategories > 0) {
          categories.forEach((category) => {
            dropdownCategory.append($('<span>').addClass('dropdown-item').text(category));
          });
        } else {
          dropdownCategory.append('<span class="dropdown-item text-muted">No categories available.</span>');
        }

        const brands = response.brands;
        const dropdownBrand = $('#dropdownMenuViewBrands').empty();
        let totalBrands = brands.length;
        $('#lblViewBrands').text(`${totalBrands} brands in this subcategory`);

        if (totalBrands > 0) {
          brands.forEach((brand) => {
            dropdownBrand.append($('<span>').addClass('dropdown-item').text(brand));
          });
        } else {
          dropdownBrand.append('<span class="dropdown-item text-muted">No brands available.</span>');
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
  // ============ End View a Subcategory ============ //

  // ============ Edit a Subcategory ============ //
  subcategoriesDatatable.on('click', '.btnEditSubcategory', function () {
    const subcategoryId = $(this).closest('tr').find('td[data-subcategory-id]').data('subcategory-id');

    $.ajax({
      url: '/file-maintenance/subcategories/edit',
      method: 'GET',
      data: { id: subcategoryId },
      success: function (response) {
        subcategoryEditModal.modal('toggle');

        $('#txtEditSubcategoryId').val(response.id);
        $('#txtEditSubcategory').val(response.subcategory);
        $('#selEditCategories')[0].tomselect.setValue(response.categories);
        $('#selEditBrands')[0].tomselect.setValue(response.brands);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Edit a Subcategory ============ //

  // ============ Update a Subcategory ============ //
  const subcategoryEditModal = $('#modalEditSubcategory');
  const subcategoryEditForm = $('#frmEditSubcategory');
  const subcategoryEditSaveBtn = $('#btnEditSaveSubcategory');

  handleUnsavedChanges(subcategoryEditModal, subcategoryEditForm, subcategoryEditSaveBtn);

  subcategoryEditForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(subcategoryEditSaveBtn, true);

    const editFormData = new FormData(subcategoryEditForm[0]);

    editFormData.append('_method', 'PATCH');
    editFormData.append('id', $('#txtEditSubcategoryId').val());
    editFormData.append('subcategory', $('#txtEditSubcategory').val());
    editFormData.append('categories', $('#selEditCategories').val());
    editFormData.append('brands', $('#selEditBrands').val());
    editFormData.append('action', 'update');

    $.ajax({
      url: '/file-maintenance/subcategories',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', subcategoryEditModal, subcategoryEditForm);
        } else {
          handleValidationErrors(response, 'Edit');
          toggleButtonState(subcategoryEditSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', subcategoryEditModal, subcategoryEditForm);
      },
    });
  });

  subcategoriesDatatable.on('click', '.btnSetSubcategory', function () {
    const subcategoryId = $(this).closest('tr').find('td[data-subcategory-id]').data('subcategory-id');
    const subcategoryName = $(this).closest('tr').find('a.btnViewSubcategory').text().trim();
    const subcategoryStatus = $(this).data('status');
    const statusName = subcategoryStatus === 1 ? 'active' : 'inactive';

    Swal.fire({
      title: 'Update subcategory status?',
      text: `Are you sure you want to set the subcategory "${subcategoryName}" to ${statusName}?`,
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
          url: '/file-maintenance/subcategories',
          method: 'PATCH',
          data: {
            id: subcategoryId,
            status: subcategoryStatus,
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

  $('#btnMultiSetSubcategory').on('click', function () {
    let subcategoryIds = subcategoriesDatatable
      .rows()
      .nodes()
      .to$()
      .find('input.form-check-input:checked')
      .map(function () {
        return $(this).closest('tr').find('[data-subcategory-id]').data('subcategory-id');
      })
      .get();

    if (subcategoryIds.length === 0) {
      showResponseAlert(
        {
          title: 'No record selected!',
          text: 'Please select at least one subcategory to change status.',
        },
        'info',
      );
    } else {
      Swal.fire({
        title: 'Update subcategories status?',
        text: 'Are you sure you want to change the status of the selected subcategories?',
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
            url: '/file-maintenance/subcategories',
            method: 'PATCH',
            data: {
              id: subcategoryIds,
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
  // ============ End Update a Subcategory ============ //

  // ============ Delete a Subcategory ============ //
  subcategoriesDatatable.on('click', '.btnDeleteSubcategory', function () {
    const subcategoryId = $(this).closest('tr').find('td[data-subcategory-id]').data('subcategory-id');
    const subcategoryName = $(this).closest('tr').find('a.btnViewSubcategory').text().trim();

    Swal.fire({
      title: 'Delete Record?',
      text: `Are you sure you want to delete the subcategory "${subcategoryName}"?`,
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
          url: '/file-maintenance/subcategories',
          method: 'DELETE',
          data: { id: subcategoryId },
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

  $('#btnMultiDeleteSubcategory').on('click', function () {
    let subcategoryIds = subcategoriesDatatable
      .rows()
      .nodes()
      .to$()
      .find('input.form-check-input:checked')
      .map(function () {
        return $(this).closest('tr').find('[data-subcategory-id]').data('subcategory-id');
      })
      .get();

    if (subcategoryIds.length === 0) {
      showResponseAlert(
        {
          title: 'No record selected!',
          text: 'Please select at least one subcategory to delete.',
        },
        'info',
      );
    } else {
      Swal.fire({
        title: 'Delete Records?',
        text: 'Are you sure you want to delete all the selected subcategories?',
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
            url: '/file-maintenance/subcategories',
            method: 'DELETE',
            data: { id: subcategoryIds },
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
  // ============ End Delete a Subcategory ============ //
});
