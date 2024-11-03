$(document).ready(function () {
  const categoriesDatatable = $('#categoriesDatatable').DataTable();

  // ============ Create a Category ============ //
  const categoryAddModal = $('#modalAddCategory');
  const categoryAddForm = $('#frmAddCategory');
  const categoryAddSaveBtn = $('#btnAddSaveCategory');

  handleUnsavedChanges(categoryAddModal, categoryAddForm, categoryAddSaveBtn);

  categoryAddForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(categoryAddSaveBtn, true);

    const addFormData = new FormData(categoryAddForm[0]);

    $.ajax({
      url: '/file-maintenance/categories',
      method: 'POST',
      data: addFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', categoryAddModal, categoryAddForm);
        } else {
          handleValidationErrors(response, 'Add');
          toggleButtonState(categoryAddSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', categoryAddModal, categoryAddForm);
      },
    });
  });
  // ============ End Create a Category ============ //

  // ============ View a Category ============ //
  categoriesDatatable.on('click', '.btnViewCategory', function () {
    const categoryId = $(this).closest('tr').find('td[data-category-id]').data('category-id');

    $.ajax({
      url: '/file-maintenance/categories/show',
      method: 'GET',
      data: { id: categoryId },
      success: function (response) {
        $('#modalViewCategory').modal('toggle');

        $('#lblViewCategory').text(response.category);

        const subcategories = response.subcategories;
        const dropdownSubcategory = $('#dropdownMenuViewSubcategories').empty();
        let totalSubcategories = subcategories.length;
        $('#lblViewSubcategories').text(`${totalSubcategories} subcategories in this category`);

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
  // ============ End View a Category ============ //

  // ============ Edit a Category ============ //
  categoriesDatatable.on('click', '.btnEditCategory', function () {
    const categoryId = $(this).closest('tr').find('td[data-category-id]').data('category-id');

    $.ajax({
      url: '/file-maintenance/categories/edit',
      method: 'GET',
      data: { id: categoryId },
      success: function (response) {
        categoryEditModal.modal('toggle');

        $('#txtEditCategoryId').val(response.id);
        $('#txtEditCategory').val(response.category);
        $('#selEditSubcategories')[0].tomselect.setValue(response.subcategories);
      },
      error: function (response) {
        showResponseAlert(response, 'error');
      },
    });
  });
  // ============ End Edit a Category ============ //

  // ============ Update a Category ============ //
  const categoryEditModal = $('#modalEditCategory');
  const categoryEditForm = $('#frmEditCategory');
  const categoryEditSaveBtn = $('#btnEditSaveCategory');

  handleUnsavedChanges(categoryEditModal, categoryEditForm, categoryEditSaveBtn);

  categoryEditForm.on('submit', function (e) {
    e.preventDefault();
    toggleButtonState(categoryEditSaveBtn, true);

    const editFormData = new FormData(categoryEditForm[0]);

    editFormData.append('_method', 'PATCH');
    editFormData.append('id', $('#txtEditCategoryId').val());
    editFormData.append('category', $('#txtEditCategory').val());
    editFormData.append('subcategories', $('#selEditSubcategories').val());
    editFormData.append('action', 'update');

    $.ajax({
      url: '/file-maintenance/categories',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showResponseAlert(response, 'success', categoryEditModal, categoryEditForm);
        } else {
          handleValidationErrors(response, 'Edit');
          toggleButtonState(categoryEditSaveBtn, false);
        }
      },
      error: function (response) {
        showResponseAlert(response, 'error', categoryEditModal, categoryEditForm);
      },
    });
  });

  categoriesDatatable.on('click', '.btnSetCategory', function () {
    const categoryId = $(this).closest('tr').find('td[data-category-id]').data('category-id');
    const categoryName = $(this).closest('tr').find('a.btnViewCategory').text().trim();
    const categoryStatus = $(this).data('status');
    const statusName = categoryStatus === 1 ? 'active' : 'inactive';

    Swal.fire({
      title: 'Update category status?',
      text: `Are you sure you want to set the category "${categoryName}" to ${statusName}?`,
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
          url: '/file-maintenance/categories',
          method: 'PATCH',
          data: {
            id: categoryId,
            status: categoryStatus,
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

  $('#btnMultiSetCategory').on('click', function () {
    let categoryIds = categoriesDatatable
      .rows()
      .nodes()
      .to$()
      .find('input.form-check-input:checked')
      .map(function () {
        return $(this).closest('tr').find('[data-category-id]').data('category-id');
      })
      .get();

    if (categoryIds.length === 0) {
      showResponseAlert(
        {
          title: 'No record selected!',
          text: 'Please select at least one category to change status.',
        },
        'info',
      );
    } else {
      Swal.fire({
        title: 'Update categories status?',
        text: 'Are you sure you want to change the status of the selected categories?',
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
            url: '/file-maintenance/categories',
            method: 'PATCH',
            data: {
              id: categoryIds,
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
  // ============ End Update a Category ============ //

  // ============ Delete a Category ============ //
  categoriesDatatable.on('click', '.btnDeleteCategory', function () {
    const categoryId = $(this).closest('tr').find('td[data-category-id]').data('category-id');
    const categoryName = $(this).closest('tr').find('a.btnViewCategory').text().trim();

    Swal.fire({
      title: 'Delete Record?',
      text: `Are you sure you want to delete the category "${categoryName}"?`,
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
          url: '/file-maintenance/categories',
          method: 'DELETE',
          data: { id: categoryId },
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

  $('#btnMultiDeleteCategory').on('click', function () {
    let categoryIds = categoriesDatatable
      .rows()
      .nodes()
      .to$()
      .find('input.form-check-input:checked')
      .map(function () {
        return $(this).closest('tr').find('[data-category-id]').data('category-id');
      })
      .get();

    if (categoryIds.length === 0) {
      showResponseAlert(
        {
          title: 'No record selected!',
          text: 'Please select at least one category to delete.',
        },
        'info',
      );
    } else {
      Swal.fire({
        title: 'Delete Records?',
        text: 'Are you sure you want to delete all the selected categories?',
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
            url: '/file-maintenance/categories',
            method: 'DELETE',
            data: { id: categoryIds },
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
  // ============ End Delete a Category ============ //
});
