$(document).ready(function () {
  const categoriesDatatable = $('#categoriesDatatable').DataTable();

  // ============ Create a Category ============ //
  const categoryAddModal = $('#modalAddCategory');
  const categoryAddForm = $('#frmAddCategory');

  handleUnsavedChanges(categoryAddModal, categoryAddForm, $('#btnAddSaveCategory'));

  categoryAddForm.on('submit', function (e) {
    e.preventDefault();

    const addFormData = new FormData(categoryAddForm[0]);

    $.ajax({
      url: '/file-maintenance/categories',
      method: 'POST',
      data: addFormData,
      dataType: 'json',
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, categoryAddModal, categoryAddForm);
        } else {
          if (response.errors.category) {
            $('#txtAddCategory').addClass('is-invalid');
            $('#valAddCategory').text(response.errors.category[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, categoryAddModal, categoryAddForm);
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
        const dropdownSubcategory = $('#subcategoriesDropdownMenu').empty();

        $('#lblViewTotalSubcategories').text(`${subcategories.length} subcategories in this category`);

        if (subcategories.length) {
          subcategories.forEach((subcategory) => {
            dropdownSubcategory.append($('<span>').addClass('dropdown-item').text(subcategory));
          });
        } else {
          dropdownSubcategory.append('<span class="dropdown-item text-muted">No subcategories available.</span>');
        }

        const categoryStatus =
          response.status === 1
            ? `<span class="badge bg-soft-success text-success"><span class="legend-indicator bg-success"></span>Active</span>`
            : `<span class="badge bg-soft-danger text-danger"><span class="legend-indicator bg-danger"></span>Inactive</span>`;

        $('#lblViewStatus').html(categoryStatus);
        $('#lblViewDateCreated').text(response.created);
        $('#lblViewDateUpdated').text(response.updated);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON);
      },
    });
  });
  // ============ End View a Category ============ //

  // ============ Update a Category ============ //
  const categoryEditModal = $('#modalEditCategory');
  const categoryEditForm = $('#frmEditCategory');

  handleUnsavedChanges(categoryEditModal, categoryEditForm, $('#btnEditSaveCategory'));

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
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, categoryEditModal, categoryEditForm);
      },
    });
  });

  categoryEditForm.on('submit', function (e) {
    e.preventDefault();

    const editFormData = new FormData(categoryEditForm[0]);

    editFormData.append('_method', 'PATCH');
    editFormData.append('id', $('#txtEditCategoryId').val());
    editFormData.append('category', $('#txtEditCategory').val());

    $.ajax({
      url: '/file-maintenance/categories',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, categoryEditModal, categoryEditForm);
        } else {
          if (response.errors.category) {
            $('#txtEditCategory').addClass('is-invalid');
            $('#valEditCategory').text(response.errors.category[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, categoryEditModal, categoryEditForm);
      },
    });
  });

  categoriesDatatable.on('click', '.btnStatusCategory', function () {
    const categoryId = $(this).closest('tr').find('td[data-category-id]').data('category-id');
    const categorySetStatus = $(this).data('status');
    let statusName;

    if (categorySetStatus === 1) {
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
          url: '/file-maintenance/categories',
          method: 'PATCH',
          data: {
            id: categoryId,
            status: categorySetStatus,
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
  // ============ End Update a Category ============ //

  // ============ Delete a Category ============ //
  categoriesDatatable.on('click', '.btnDeleteCategory', function () {
    const categoryId = $(this).closest('tr').find('td[data-category-id]').data('category-id');

    Swal.fire({
      title: 'Delete Record?',
      text: 'Are you sure you want to delete the category?',
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
          url: '/file-maintenance/categories',
          method: 'DELETE',
          data: { id: categoryId },
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

  $('#btnMultiDeleteCategory').on('click', function () {
    let checkedCheckboxes = categoriesDatatable.rows().nodes().to$().find('input.form-check-input:checked');

    let categoryIds = checkedCheckboxes
      .map(function () {
        return $(this).closest('tr').find('[data-category-id]').data('category-id');
      })
      .get();

    Swal.fire({
      title: 'Delete Records?',
      text: 'Are you sure you want to delete all the selected categories?',
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
          url: '/file-maintenance/categories',
          method: 'DELETE',
          data: { id: categoryIds },
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
  // ============ End Delete a Category ============ //
});
