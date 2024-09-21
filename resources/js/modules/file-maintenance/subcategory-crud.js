$(document).ready(function () {
  const subcategoriesDatatable = $("#subcategoriesDatatable").DataTable();

  // ============ Create a Subcategory ============ //
  const subcategoryAddModal = $("#modalAddSubcategory");
  const subcategoryAddForm = $("#frmAddSubcategory");

  handleUnsavedChanges(subcategoryAddModal, subcategoryAddForm, $("#btnAddSaveSubcategory"));

  subcategoryAddForm.on("submit", function (e) {
    e.preventDefault();

    const addFormData = new FormData(subcategoryAddForm[0]);

    $.ajax({
      url: "/file-maintenance/subcategories",
      method: "POST",
      data: addFormData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, subcategoryAddModal, subcategoryAddForm);
        } else {
          if (response.errors.subcategory) {
            $("#txtAddSubcategory").addClass("is-invalid");
            $("#valAddSubcategory").text(response.errors.subcategory[0]);
          }

          if (response.errors.category) {
            $("#selAddCategory").next(".ts-wrapper").addClass("is-invalid");
            $("#valAddCategory").text(response.errors.category[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, subcategoryAddModal, subcategoryAddForm);
      },
    });
  });
  // ============ End Create a Subcategory ============ //

  // ============ View a Subcategory ============ //
  subcategoriesDatatable.on("click", ".btnViewSubcategory", function () {
    const subcategoryId = $(this).closest("tr").find("td[data-subcategory-id]").data("subcategory-id");

    $.ajax({
      url: "/file-maintenance/subcategories/show",
      method: "GET",
      data: { id: subcategoryId },
      success: function (response) {
        $("#modalViewSubcategory").modal("toggle");

        $("#lblViewSubcategory").text(response.subcategory);
        $("#lblViewCategory").text(response.category);
        $("#lblViewDateCreated").text(response.created);
        $("#lblViewDateUpdated").text(response.updated);

        if (response.status === 1) {
          $("#lblViewStatus").html(`
            <span class="badge bg-soft-success text-success">
              <span class="legend-indicator bg-success"></span>Active
            </span>
          `);
        } else {
          $("#lblViewStatus").html(`
            <span class="badge bg-soft-danger text-danger">
              <span class="legend-indicator bg-danger"></span>Inactive
            </span>
          `);
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON);
      },
    });
  });
  // ============ End View a Subcategory ============ //

  // ============ Update a Subcategory ============ //
  const subcategoryEditModal = $("#modalEditSubcategory");
  const subcategoryEditForm = $("#frmEditSubcategory");

  handleUnsavedChanges(subcategoryEditModal, subcategoryEditForm, $("#btnEditSaveSubcategory"));

  subcategoriesDatatable.on("click", ".btnEditSubcategory", function () {
    const subcategoryId = $(this).closest("tr").find("td[data-subcategory-id]").data("subcategory-id");

    $.ajax({
      url: "/file-maintenance/subcategories/edit",
      method: "GET",
      data: { id: subcategoryId },
      success: function (response) {
        subcategoryEditModal.modal("toggle");

        $("#txtEditSubcategoryId").val(response.id);
        $("#txtEditSubcategory").val(response.subcategory);
        $("#selEditCategory")[0].tomselect.setValue(response.category);
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, subcategoryEditModal, subcategoryEditForm);
      },
    });
  });

  subcategoryEditForm.on("submit", function (e) {
    e.preventDefault();

    const editFormData = new FormData(subcategoryEditForm[0]);

    editFormData.append("_method", "PATCH");
    editFormData.append("id", $("#txtEditSubcategoryId").val());
    editFormData.append("subcategory", $("#txtEditSubcategory").val());
    editFormData.append("department", $("#selEditCategory").val());

    $.ajax({
      url: "/file-maintenance/subcategories/update",
      method: "POST",
      data: editFormData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          showSuccessAlert(response, subcategoryEditModal, subcategoryEditForm);
        } else {
          if (response.errors.subcategory) {
            $("#txtEditSubcategory").addClass("is-invalid");
            $("#valEditSubcategory").text(response.errors.subcategory[0]);
          }

          if (response.errors.category) {
            $("#selEditDepartment").next(".ts-wrapper").addClass("is-invalid");
            $("#valEditDepartment").text(response.errors.category[0]);
          }
        }
      },
      error: function (response) {
        showErrorAlert(response.responseJSON, subcategoryEditModal, subcategoryEditForm);
      },
    });
  });

  subcategoriesDatatable.on("click", ".btnStatusSubcategory", function () {
    const subcategoryId = $(this).closest("tr").find("td[data-subcategory-id]").data("subcategory-id");
    const subcategorySetStatus = $(this).data("status");
    let statusName;

    if (subcategorySetStatus === 1) {
      statusName = "active";
    } else {
      statusName = "inactive";
    }

    Swal.fire({
      title: "Change status?",
      text: "Are you sure you want to set it to " + statusName + "?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, set it to " + statusName + "!",
      cancelButtonText: "No, cancel!",
      customClass: {
        confirmButton: "btn btn-primary",
        cancelButton: "btn btn-secondary",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/file-maintenance/subcategories/update",
          method: "PATCH",
          data: {
            id: subcategoryId,
            status: subcategorySetStatus,
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
  // ============ End Update a Subcategory ============ //

  // ============ Delete a Subcategory ============ //
  subcategoriesDatatable.on("click", ".btnDeleteSubcategory", function () {
    const subcategoryId = $(this).closest("tr").find("td[data-subcategory-id]").data("subcategory-id");

    Swal.fire({
      title: "Delete Record?",
      text: "Are you sure you want to delete the subcategory?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      customClass: {
        confirmButton: "btn btn-danger",
        cancelButton: "btn btn-secondary",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/file-maintenance/subcategories/delete",
          method: "DELETE",
          data: { id: subcategoryId },
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

  $("#btnMultiDeleteSubcategory").on("click", function () {
    let checkedCheckboxes = subcategoriesDatatable.rows().nodes().to$().find("input.form-check-input:checked");

    let subcategoryIds = checkedCheckboxes
      .map(function () {
        return $(this).closest("tr").find("[data-subcategory-id]").data("subcategory-id");
      })
      .get();

    Swal.fire({
      title: "Delete Records?",
      text: "Are you sure you want to delete all the selected subcategories?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      customClass: {
        confirmButton: "btn btn-danger",
        cancelButton: "btn btn-secondary",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/file-maintenance/subcategories/delete",
          method: "DELETE",
          data: { id: subcategoryIds },
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
  // ============ End Delete a Subcategory ============ //
});
