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
          toggleButtonState(categoryAddSaveBtn, false);
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

        const categoryConfig = {
          textFields: [
            { key: 'category', selector: '#lblViewCategory' },
            { key: 'created_by', selector: '#lblViewCreatedBy' },
            { key: 'updated_by', selector: '#lblViewUpdatedBy' },
            { key: 'created_at', selector: '#lblViewCreatedAt' },
            { key: 'updated_at', selector: '#lblViewUpdatedAt' },
          ],

          statusFields: { key: 'status', selector: '#lblViewStatus' },

          imageFields: [
            { key: 'created_img', selector: '#imgViewCreatedBy' },
            { key: 'updated_img', selector: '#imgViewUpdatedBy' },
          ],
        };

        displayViewResponseData(response, categoryConfig);
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
        populateEditForm(response);
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

    $.ajax({
      url: '/file-maintenance/categories',
      method: 'POST',
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toggleButtonState(categoryEditSaveBtn, false);
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
        title: 'text-dark fs-1',
        htmlContainer: 'text-body text-center fs-4',
        confirmButton: `btn btn-sm ${categoryName === 1 ? 'btn-success' : 'btn-danger'}`,
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
  // ============ End Update a Category ============ //

  // ============ Delete a Category ============ //
  categoriesDatatable.on('click', '.btnDeleteCategory', function () {
    const categoryId = $(this).closest('tr').find('td[data-category-id]').data('category-id');
    const categoryName = $(this).closest('tr').find('a.btnViewCategory').text().trim();

    Swal.fire({
      title: 'Delete Record?',
      text: `Are you sure you want to permanently delete the brand "${categoryName}"? This action cannot be undone.`,
      icon: 'warning',
      showCancelButton: true,
      focusCancel: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      customClass: {
        popup: 'bg-light rounded-3 shadow fs-4',
        title: 'text-dark fs-1',
        htmlContainer: 'text-body text-center fs-4',
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
  // ============ End Delete a Category ============ //
});
