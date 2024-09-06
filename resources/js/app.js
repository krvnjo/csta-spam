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
