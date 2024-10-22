import 'bootstrap-icons/font/bootstrap-icons.css';
import Swal from 'sweetalert2';

window.Swal = Swal;

$(document).ready(function () {
  // ============ Ajax CSRF Token ============ //
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
  });
  // ============ End Ajax CSRF Token ============ //

  // ============ Show Active Links JS ============ //
  const navLinks = $('#navbarVerticalMenu .nav-link');
  const currentRouteName = $('meta[name="current-route"]').attr('content');

  navLinks.each(function () {
    const link = $(this);
    const routeName = link.data('route');

    if (currentRouteName === routeName) {
      link.addClass('active');

      let currentCollapse = link.closest('.nav-collapse');

      while (currentCollapse.length) {
        currentCollapse.addClass('show');
        const dropdownToggle = currentCollapse.prev();
        if (dropdownToggle.hasClass('dropdown-toggle')) {
          currentCollapse = currentCollapse.parent().closest('.nav-collapse');

          if (currentCollapse.length) {
            dropdownToggle.removeClass('active');
          } else {
            dropdownToggle.addClass('active');
          }
        }
      }
    }
  });
  // ============ End Show Active Links JS ============ //

  // ============ Remove invalid validation on keydown JS ============ //
  $('input, textarea, select').on('keydown change', function () {
    $(this).removeClass('is-invalid');
    $(this).siblings('.invalid-feedback').html('');
    $(this).next('.ts-wrapper').removeClass('is-invalid');
  });

  $('.avatar-img-user, .avatar-img-remove').on('change click', function () {
    $('.avatar-img-val').addClass('d-none').text('');
  });
  // ============ End Remove invalid validation on keydown JS ============ //
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
    icon: 'success',
    confirmButtonText: 'OK',
    customClass: {
      confirmButton: 'btn btn-secondary',
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
    icon: 'error',
    confirmButtonText: 'Got it',
    customClass: {
      confirmButton: 'btn btn-secondary',
    },
  }).then(() => {
    location.reload();
  });
}

window.showErrorAlert = showErrorAlert;

// Unsaved Changes Alert
function handleUnsavedChanges(modal, form, saveButton) {
  let initialFormValues = {};
  let initialImageSrc = '';
  let unsavedChanges = false;
  let timeout; // For throttling

  function getFormValues() {
    let values = {};
    form.find(':input').each(function () {
      const name = $(this).attr('name');

      if ($(this).hasClass('dropdown-input') || !name) {
        return;
      }

      if ($(this).attr('type') === 'checkbox') {
        values[name] = $(this).is(':checked');
      } else if ($(this).is('select[multiple]')) {
        values[name] = $(this).val() || [];
      } else {
        values[name] = $(this).val();
      }
    });
    return values;
  }

  function hasChanges() {
    const currentFormValues = getFormValues();
    const currentImageSrc = form.find('label .avatar-img').attr('src');

    if (currentImageSrc !== initialImageSrc) {
      return true;
    }

    for (let key in initialFormValues) {
      const initialValue = initialFormValues[key];
      const currentValue = currentFormValues[key];

      if (Array.isArray(initialValue) && Array.isArray(currentValue)) {
        if (!arraysEqual(initialValue, currentValue)) {
          return true;
        }
      } else if (initialValue !== currentValue) {
        return true;
      }
    }
    return false;
  }

  function arraysEqual(arr1, arr2) {
    if (arr1.length !== arr2.length) return false;
    arr1 = arr1.sort();
    arr2 = arr2.sort();
    for (let i = 0; i < arr1.length; i++) {
      if (arr1[i] !== arr2[i]) return false;
    }
    return true;
  }

  $('.avatar-img-remove').on('click', function () {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
      const fileInput = form.find('input[type="file"]');
      fileInput.trigger('change');
      unsavedChanges = initialImageSrc !== 'http://127.0.0.1:8000/storage/img/user-images/default.jpg';
      saveButton.prop('disabled', !unsavedChanges);
    }, 100);
  });

  form.on('input change', ':input', function () {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
      unsavedChanges = hasChanges();
      saveButton.prop('disabled', !unsavedChanges);
    }, 100);
  });

  modal.on('show.bs.modal', function () {
    setTimeout(() => {
      initialFormValues = getFormValues();
      initialImageSrc = form.find('label .avatar-img').attr('src');
      saveButton.prop('disabled', true);
      unsavedChanges = false;
    }, 100);
  });

  modal.on('hide.bs.modal', function (e) {
    if (unsavedChanges) {
      e.preventDefault();

      Swal.fire({
        title: 'Unsaved Changes!',
        text: 'You have unsaved changes. Are you sure you want to close the modal?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, close it!',
        cancelButtonText: 'No, keep editing',
        customClass: {
          confirmButton: 'btn btn-danger',
          cancelButton: 'btn btn-secondary',
        },
      }).then((result) => {
        if (result.isConfirmed) {
          cleanModalForm(modal, form);
          unsavedChanges = false;
          modal.modal('hide');
        }
      });
    } else {
      cleanModalForm(modal, form, 'edit');
    }
  });
}

window.handleUnsavedChanges = handleUnsavedChanges;

// Clean Modal Form
function cleanModalForm(modal, form, flag = 'add') {
  form.find(':input').removeClass('is-invalid');
  form.find('.invalid-feedback').empty();

  form.find('select').each(function () {
    const tsWrapper = $(this).next('.ts-wrapper');
    if (tsWrapper.length) {
      tsWrapper.removeClass('is-invalid');
    }
  });

  if (flag === 'add') {
    form.trigger('reset');

    form.find('select').each(function () {
      const tomSelectInstance = this.tomselect;
      if (tomSelectInstance) {
        tomSelectInstance.clear();
        tomSelectInstance.setValue('');
      } else {
        $(this).val('');
      }
    });

    form.find('.js-dropzone').each(function () {
      const dropzoneElement = this;
      const dropzoneInstance = Dropzone.forElement(dropzoneElement);
      if (dropzoneInstance) {
        dropzoneInstance.removeAllFiles(true);
      }
    });

    const defaultImageSrc = 'http://127.0.0.1:8000/storage/img/user-images/default.jpg';
    form.find('.avatar-img').attr('src', defaultImageSrc);
    $('.avatar-img-val').addClass('d-none').text('');
  }
  modal.hide();
}

window.cleanModalForm = cleanModalForm;
// ============ End Show Alerts Function ============ //

// ============ Update Filter Count Function ============ //
function updateFilterCountBadge(filterCountId) {
  let selectedFilterCount = 0;

  $('.js-datatable-filter').each(function () {
    const $this = $(this);

    if ($this.is('select[multiple]')) {
      selectedFilterCount += $this.find('option:selected').length;
    } else if ($this.val() !== '') {
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
