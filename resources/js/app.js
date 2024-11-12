import './bootstrap';
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

// ============ Toggle Button State Function ============ //
function toggleButtonState(button, isLoading) {
  const spinner = button.find('.spinner-border');
  const spinnerLabel = button.find('.spinner-label');

  if (isLoading) {
    spinner.removeClass('d-none');
    spinnerLabel.addClass('d-none');
    button.prop('disabled', true);
  } else {
    spinner.addClass('d-none');
    spinnerLabel.removeClass('d-none');
    button.prop('disabled', false);
  }
}

window.toggleButtonState = toggleButtonState;
// ============ End Toggle Button State Function ============ //

// ============ Show Alerts Function ============ //
// Response Alert
function showResponseAlert(response, type, modal = null, form = null) {
  const data = response.responseJSON ? response.responseJSON : response;

  if (modal && form) {
    cleanModalForm(modal, form);
  }

  Swal.fire({
    title: data.title,
    text: data.text,
    icon: type,
    confirmButtonText: type === 'success' ? 'Done' : 'Ok, got it!',
    focusCancel: true,
    customClass: {
      popup: 'bg-light rounded-3 shadow fs-4',
      title: 'text-dark fs-1',
      htmlContainer: 'text-body text-center fs-4',
      confirmButton: 'btn btn-sm btn-secondary',
    },
  }).then((result) => {
    if (type !== 'info' && result.isConfirmed) {
      location.reload();
    }
  });
}

window.showResponseAlert = showResponseAlert;

// Unsaved Changes Alert
function handleUnsavedChanges(modal, form, saveButton) {
  let initialFormValues = {};
  let initialImageSrc = '';
  let unsavedChanges = false;
  let timeout;

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
      unsavedChanges = false;
    }, 100);
  });

  modal.on('shown.bs.modal', function () {
    form.find('input[type="text"]').first().focus();
  });

  modal.on('hide.bs.modal', function (e) {
    if (unsavedChanges) {
      e.preventDefault();

      Swal.fire({
        title: 'Unsaved Changes!',
        text: 'You have unsaved changes. Are you sure you want to close the modal?',
        icon: 'warning',
        showCancelButton: true,
        focusCancel: true,
        confirmButtonText: 'Yes, close it!',
        cancelButtonText: 'No, keep editing',
        customClass: {
          popup: 'bg-light rounded-3 shadow fs-4',
          title: 'text-dark fs-1',
          htmlContainer: 'text-body text-center fs-4',
          confirmButton: 'btn btn-sm btn-danger',
          cancelButton: 'btn btn-sm btn-secondary',
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
// ============ End Show Alerts Function ============ //

// ============ Clean Modal Form Function ============ //
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
// ============ End Clean Modal Form Function ============ //

// ============ Handle Validation Errors Function ============ //
function handleValidationErrors(response, mode = 'Add') {
  $.each(response.errors, function (field, messages) {
    const inputSelector = '#txt' + mode + capitalizeFirstLetter(field);
    const selectWrapperSelector = '#sel' + mode + capitalizeFirstLetter(field);
    const errorTextSelector = '#val' + mode + capitalizeFirstLetter(field);

    if ($(inputSelector).length) {
      $(inputSelector).addClass('is-invalid');
      $(errorTextSelector).text(messages[0]);
    } else if ($(selectWrapperSelector).length) {
      $(selectWrapperSelector).next('.ts-wrapper').addClass('is-invalid');
      $(errorTextSelector).text(messages[0]);
    } else if (field === 'image' && $(errorTextSelector).length) {
      $(errorTextSelector).removeClass('d-none').text(messages[0]);
    }
  });

  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
}

window.handleValidationErrors = handleValidationErrors;
// ============ End Handle Validation Errors Function ============ //

// ============ Display View Response Data Function ============ //
function displayViewResponseData(response, config) {
  if (config.textFields) {
    config.textFields.forEach((field) => {
      if (response[field.key] !== undefined) {
        $(field.selector).text(response[field.key]);
      }
    });
  }

  if (config.dropdownFields) {
    config.dropdownFields.forEach((dropdownConfig) => {
      const dropdownContainer = $(dropdownConfig.container).empty();
      const items = response[dropdownConfig.key];
      const itemCount = items ? items.length : 0;
      $(dropdownConfig.countSelector).text(`${itemCount} ${dropdownConfig.label}`);

      if (itemCount > 0) {
        items.forEach((item) => {
          dropdownContainer.append($('<span>').addClass('dropdown-item').text(item));
        });
      } else {
        dropdownContainer.append('<span class="dropdown-item text-body">No records available.</span>');
      }
    });
  }

  if (config.statusFields) {
    const statusClass = response[config.statusFields.key] === 1 ? 'success' : 'danger';
    const statusText = response[config.statusFields.key] === 1 ? 'Active' : 'Inactive';
    $(config.statusFields.selector).html(
      `<span class="badge bg-soft-${statusClass} text-${statusClass}"><span class="legend-indicator bg-${statusClass}"></span>${statusText}</span>`,
    );
  }

  if (config.imageFields) {
    config.imageFields.forEach((field) => {
      if (response[field.key]) {
        $(field.selector).attr('src', response[field.key]);
      }
    });
  }
}

window.displayViewResponseData = displayViewResponseData;
// ============ End Display View Response Data Function ============ //

// ============ Populate Edit Form Data Function ============ //
function populateEditForm(response) {
  $.each(response, function (key, value) {
    const inputSelector = '#txtEdit' + capitalizeFirstLetter(key);
    const selectWrapperSelector = '#selEdit' + capitalizeFirstLetter(key);

    if ($(inputSelector).length) {
      $(inputSelector).val(value);
    } else if ($(selectWrapperSelector).length) {
      $(selectWrapperSelector)[0].tomselect.setValue(value);
    }
  });

  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
}

window.populateEditForm = populateEditForm;
// ============ End Populate Edit Form Data Function ============ //

// ============ Filter DataTable and Filter Count Function ============ //
function filterDatatableAndCount(filterDatatable, filterCount) {
  const filterElements = $('.js-datatable-filter');
  const badge = $(filterCount);
  let selectedFilterCount = 0;

  $.fn.dataTable.ext.search = [];

  filterElements.each(function () {
    const $this = $(this);
    const filterVal = $this.val();
    const targetColumnIndex = $this.data('target-column-index');

    if (!filterVal || (Array.isArray(filterVal) && filterVal.length === 0)) return;

    if (Array.isArray(filterVal)) {
      selectedFilterCount += filterVal.length;
    } else if (filterVal !== '') {
      selectedFilterCount++;
    }

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
      const cell = filterDatatable.cell(dataIndex, targetColumnIndex).node();
      const fullValue = $(cell).attr('data-full-value') || data[targetColumnIndex].trim();

      if (Array.isArray(filterVal)) {
        return filterVal.some((val) => fullValue.includes(val));
      }

      return fullValue.includes(filterVal);
    });
  });

  filterDatatable.draw();

  if (selectedFilterCount > 0) {
    badge.text(selectedFilterCount).show();
  } else {
    badge.hide();
  }
}

window.filterDatatableAndCount = filterDatatableAndCount;
// ============ End Filter DataTable and Filter Count Function ============ //
