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

// ============ Show Alerts in File Maintenance Function ============ //
function showSuccessAlert(response, modal, form) {
  cleanModalForm(modal, form);
  Swal.fire({
    title: response.title,
    text: response.text,
    icon: "success",
    confirmButtonText: "OK",
  }).then(() => {
    location.reload();
  });
}

function showErrorAlert(customMessage, jqXHR, textStatus, errorThrown, modal, form) {
  let errorMessage = customMessage || "An unexpected error occurred. Please try again later.";

  if (jqXHR && jqXHR.responseJSON && jqXHR.responseJSON.message) {
    errorMessage = jqXHR.responseJSON.message;
  } else if (jqXHR && jqXHR.responseText) {
    errorMessage = jqXHR.responseText;
  } else if (errorThrown) {
    errorMessage = "Error: " + errorThrown;
  }

  cleanModalForm(modal, form);
  Swal.fire({
    title: "Oops... Something went wrong!",
    text: errorMessage,
    icon: "error",
    confirmButtonText: "OK",
  }).then(() => {
    location.reload();
  });
}

function cleanModalForm(modal, form) {
  form.trigger("reset");
  form.find(":input").removeClass("is-invalid").siblings(".invalid-feedback").empty();

  form.find('select').each(function() {
    const tomSelectInstance = this.tomselect;
    if (tomSelectInstance) {
      tomSelectInstance.clear();
      tomSelectInstance.setValue('');
    } else {
      $(this).val('');
    }
  });

  form.find('.js-dropzone').each(function() {
    const dropzoneElement = this;
    const dropzoneInstance = Dropzone.forElement(dropzoneElement);
    if (dropzoneInstance) {
      dropzoneInstance.removeAllFiles(true);
    }
  });

  modal.hide();
}



window.showSuccessAlert = showSuccessAlert;
window.showErrorAlert = showErrorAlert;
window.cleanModalForm = cleanModalForm;
// ============ End Show Alerts in File Maintenance Function ============ //
