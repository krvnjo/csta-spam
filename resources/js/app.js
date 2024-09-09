import "./bootstrap";
import Swal from "sweetalert2";
import "bootstrap-icons/font/bootstrap-icons.css";

window.Swal = Swal;

// ============ Show Active Links JS ============ //
const navLinks = document.querySelectorAll("#navbarVerticalMenu .nav-link");
const currentPath = window.location.pathname;

navLinks.forEach((link) => {
  if (currentPath === link.getAttribute("href")) {
    link.classList.add("active");

    // Find and open all ancestor 'nav-collapse' elements
    let currentCollapse = link.closest(".nav-collapse");

    while (currentCollapse) {
      currentCollapse.classList.add("show");

      // If it's a dropdown, mark the toggle as active
      const dropdownToggle = currentCollapse.previousElementSibling;
      if (dropdownToggle.classList.contains("dropdown-toggle")) {
        // Move up to the next parent collapse
        currentCollapse = currentCollapse.parentNode.closest(".nav-collapse");
        if (currentCollapse) {
          dropdownToggle.classList.remove("active");
        } else {
          dropdownToggle.classList.add("active");
        }
      }
    }
  }
});
// ============ End Show Active Links JS ============ //

// ============ Remove invalid validation on focus JS ============ //
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll("input").forEach((input) => {
    input.addEventListener("keydown", () => {
      input.classList.remove("is-invalid");
    });
  });
});
// ============ End Remove invalid validation on focus JS ============ //

// ============ Show Success Alert in File Maintenance Function ============ //
function showSuccessAlert(response, modal, form) {
  form[0].reset();
  modal.modal("hide");
  Swal.fire({
    title: response.title,
    text: response.text,
    icon: "success",
    confirmButtonText: "OK",
  }).then((r) => {
    location.reload();
  });
}

window.showSuccessAlert = showSuccessAlert;
// ============ End Show Success Alert in File Maintenance Function ============ //

// ============ Show Error Alert in File Maintenance Function ============ //
function showErrorAlert(customMessage, jqXHR, textStatus, errorThrown, modal, form) {
  let errorMessage = customMessage || "An unexpected error occurred. Please try again later.";

  if (jqXHR && jqXHR.responseJSON && jqXHR.responseJSON.message) {
    errorMessage = jqXHR.responseJSON.message;
  } else if (jqXHR && jqXHR.responseText) {
    errorMessage = jqXHR.responseText;
  } else if (errorThrown) {
    errorMessage = "Error: " + errorThrown;
  }

  Swal.fire({
    title: "Oops... Something went wrong!",
    text: errorMessage,
    icon: "error",
    confirmButtonText: "OK",
  }).then((result) => {
    form[0].reset();
    modal.modal("hide");
    location.reload();
  });
}

window.showErrorAlert = showErrorAlert;
// ============ End Show Error Alert in File Maintenance Function ============ //
