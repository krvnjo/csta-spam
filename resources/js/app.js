import "./bootstrap";
import "bootstrap-icons/font/bootstrap-icons.css";
import Swal from "sweetalert2";

window.Swal = Swal;

$(document).ready(function () {
  // ============ Ajax CSRF Token ============ //
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  // ============ End Ajax CSRF Token ============ //

  // ============ Show Active Links JS ============ //
  const navLinks = $("#navbarVerticalMenu .nav-link");
  const currentRouteName = $('meta[name="current-route"]').attr("content");

  navLinks.each(function () {
    const link = $(this);
    const routeName = link.data("route");

    if (currentRouteName === routeName) {
      link.addClass("active");

      let currentCollapse = link.closest(".nav-collapse");

      while (currentCollapse.length) {
        currentCollapse.addClass("show");
        const dropdownToggle = currentCollapse.prev();
        if (dropdownToggle.hasClass("dropdown-toggle")) {
          currentCollapse = currentCollapse.parent().closest(".nav-collapse");

          if (currentCollapse.length) {
            dropdownToggle.removeClass("active");
          } else {
            dropdownToggle.addClass("active");
          }
        }
      }
    }
  });
  // ============ End Show Active Links JS ============ //

  // ============ Remove invalid validation on keydown JS ============ //
  $("input, textarea, select").on("keydown change", function () {
    $(this).removeClass("is-invalid");
    $(this).siblings(".invalid-feedback").html("");
    $(this).next(".ts-wrapper").removeClass("is-invalid");
  });
  // ============ End Remove invalid validation on keydown JS ============ //

  // ============ Dropdown Menu Show Outside ============ //
  const dropdownToggle = $(".dropdown-toggle");

  dropdownToggle.on("shown.bs.dropdown", function () {
    $(this).next(".dropdown-menu").appendTo("body").css({
      position: "absolute",
      zIndex: 1050,
    });
  });

  dropdownToggle.on("hidden.bs.dropdown", function () {
    $(this).next(".dropdown-menu").appendTo($(this).parent());
  });
  // ============ End Dropdown Menu Show Outside ============ //
});

// ============ Show Alerts Function ============ //
// Success Alert
function showSuccessAlert(response, modal, form) {
  if (modal && form) {
    cleanModalForm(modal, form);
  }

  Swal.fire({
    title: response.title,
    text: response.text,
    icon: "success",
    confirmButtonText: "OK",
    customClass: {
      confirmButton: "btn btn-secondary",
    },
  }).then(() => {
    location.reload();
  });
}

window.showSuccessAlert = showSuccessAlert;

// Error Alert
function showErrorAlert(response, modal = null, form = null) {
  if (modal && form) {
    cleanModalForm(modal, form);
  }

  Swal.fire({
    title: response.title,
    text: response.text,
    icon: "error",
    confirmButtonText: "Got it",
    customClass: {
      confirmButton: "btn btn-secondary",
    },
  }).then(() => {
    location.reload();
  });
}

window.showErrorAlert = showErrorAlert;

// Unsaved Changes Alert
function handleUnsavedChanges(modal, form, saveButton) {
  let initialFormValues = {};
  let unsavedChanges = false;

  function getFormValues() {
    let values = {};
    form.find(":input").each(function () {
      if ($(this).attr("type") === "checkbox") {
        values[$(this).attr("name")] = $(this).is(":checked");
      } else {
        values[$(this).attr("name")] = $(this).val();
      }
    });
    return values;
  }

  function hasChanges() {
    const currentFormValues = getFormValues();
    for (let key in initialFormValues) {
      if (initialFormValues[key] !== currentFormValues[key]) {
        saveButton.prop("disabled", false);
        return true;
      }
    }
    saveButton.prop("disabled", true);
    return false;
  }

  modal.on("show.bs.modal", function () {
    setTimeout(() => {
      initialFormValues = getFormValues();
      saveButton.prop("disabled", true);
      unsavedChanges = false;
    }, 100);
  });

  form.on("input change", ":input", function () {
    unsavedChanges = hasChanges();
  });

  modal.on("hide.bs.modal", function (e) {
    if (unsavedChanges) {
      e.preventDefault();

      Swal.fire({
        title: "Unsaved Changes!",
        text: "You have unsaved changes. Are you sure you want to close the modal?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, close it!",
        cancelButtonText: "No, keep editing",
        customClass: {
          confirmButton: "btn btn-danger",
          cancelButton: "btn btn-secondary",
        },
      }).then((result) => {
        if (result.isConfirmed) {
          cleanModalForm(modal, form);
          unsavedChanges = false;
          modal.modal("hide");
        }
      });
    } else {
      cleanModalForm(modal, form, "edit");
    }
  });
}

window.handleUnsavedChanges = handleUnsavedChanges;

// Clean Modal Form
function cleanModalForm(modal, form, flag = "add") {
  form.find(":input").removeClass("is-invalid").siblings(".invalid-feedback").empty();

  form.find("select").each(function () {
    const tsWrapper = $(this).next(".ts-wrapper");
    if (tsWrapper.length) {
      tsWrapper.removeClass("is-invalid");
    }
  });

  if (flag === "add") {
    form.trigger("reset");

    form.find("select").each(function () {
      const tomSelectInstance = this.tomselect;
      if (tomSelectInstance) {
        tomSelectInstance.clear();
        tomSelectInstance.setValue("");
      } else {
        $(this).val("");
      }
    });

    form.find(".js-dropzone").each(function () {
      const dropzoneElement = this;
      const dropzoneInstance = Dropzone.forElement(dropzoneElement);
      if (dropzoneInstance) {
        dropzoneInstance.removeAllFiles(true);
      }
    });
  }
  modal.hide();
}

window.cleanModalForm = cleanModalForm;
// ============ End Show Alerts Function ============ //

// ============ Update Filter Count Function ============ //
function updateFilterCountBadge(filterCountId) {
  let selectedFilterCount = 0;

  $(".js-datatable-filter").each(function () {
    if ($(this).val() !== "") {
      selectedFilterCount++;
    }
  });

  const $badge = filterCountId;
  if (selectedFilterCount > 0) {
    $badge.text(selectedFilterCount).show();
  } else {
    $badge.hide();
  }
}

window.updateFilterCountBadge = updateFilterCountBadge;
// ============ End Update Filter Count Function ============ //
