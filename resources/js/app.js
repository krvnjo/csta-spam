import "./bootstrap";
import "bootstrap-icons/font/bootstrap-icons.css";
import Swal from "sweetalert2";

window.Swal = Swal;

$(document).ready(function () {
  // ============ Show Active Links JS ============ //
  const navLinks = $("#navbarVerticalMenu .nav-link");
  const currentPath = window.location.pathname;

  navLinks.each(function () {
    const link = $(this);
    if (currentPath === link.attr("href")) {
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
  $("input").on("keydown", function () {
    $(this).removeClass("is-invalid");
    $(this).siblings(".invalid-feedback").html("");
  });
  // ============ End Remove invalid validation on keydown JS ============ //
});

// ============ Show Alerts Function ============ //
function showSuccessAlert(response, modal, form) {
  if (modal && form) {
    cleanModalForm(modal, form);
  }

  Swal.fire({
    title: response.title,
    text: response.text,
    icon: "success",
    confirmButtonText: "OK",
  }).then(() => {
    location.reload();
  });
}

window.showSuccessAlert = showSuccessAlert;

function showErrorAlert(customMessage, jqXHR, textStatus, errorThrown) {
  let errorMessage = customMessage || "Something went wrong. Please try again or contact support.";

  if (jqXHR && jqXHR.responseJSON && jqXHR.responseJSON.message) {
    errorMessage = jqXHR.responseJSON.message;
  } else if (jqXHR && jqXHR.responseText) {
    errorMessage = "It looks like there's a problem. Please try again.";
  } else if (errorThrown) {
    errorMessage = "Oops! Something went wrong. Please refresh the page or try again later.";
  }

  Swal.fire({
    title: "Uh-oh! Something went wrong.",
    text: errorMessage,
    icon: "error",
    confirmButtonText: "Got it",
  }).then(() => {
    location.reload();
  });
}

window.showErrorAlert = showErrorAlert;
// ============ End Show Alerts Function ============ //

// ============ Clean Modal Form Function ============ //
function cleanModalForm(modal, form) {
  form.trigger("reset");
  form.find(":input").removeClass("is-invalid").siblings(".invalid-feedback").empty();

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

  modal.hide();
}

window.cleanModalForm = cleanModalForm;
// ============ End Clean Modal Form Function ============ //

function handleUnsavedChanges(modal, form, unsavedChanges, formSubmitted) {
  let initialFormValues = {};

  function getFormValues() {
    let values = {};
    form.find(":input").each(function () {
      values[$(this).attr("name")] = $(this).val();
    });
    return values;
  }

  modal.on("show.bs.modal", function () {
    initialFormValues = getFormValues();
    unsavedChanges = formSubmitted = false;
  });

  form.on("input change", ":input", function () {
    const currentFormValues = getFormValues();

    for (let key in initialFormValues) {
      if (initialFormValues[key] !== currentFormValues[key]) {
        unsavedChanges = true;
        break;
      }
    }
  });

  modal.on("hide.bs.modal", function (e) {
    if (!formSubmitted && unsavedChanges) {
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
          unsavedChanges = false;
          cleanModalForm(modal, form);
          modal.modal("hide");
        }
      });
    } else {
      cleanModalForm(modal, form);
    }
  });
}

window.handleUnsavedChanges = handleUnsavedChanges;
