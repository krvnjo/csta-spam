(function () {
  const $dropdownBtn = document.getElementById('themeDropdown');
  const $variants = document.querySelectorAll('.theme-dropdown [data-icon]');

  // Function to set active style in the dropdown menu and set icon for dropdown trigger
  const setActiveStyle = function () {
    $variants.forEach(($item) => {
      if ($item.getAttribute('data-value') === HSThemeAppearance.getOriginalAppearance()) {
        $dropdownBtn.innerHTML = `<i class="${$item.getAttribute('data-icon')}" />`;
        return $item.classList.add('active');
      }

      $item.classList.remove('active');
    });
  };

  // Add a click event to all items of the dropdown to set the style
  $variants.forEach(function ($item) {
    $item.addEventListener('click', function () {
      HSThemeAppearance.setAppearance($item.getAttribute('data-value'));
    });
  });

  // Call the setActiveStyle on load page
  setActiveStyle();

  // Add event listener on change style to call the setActiveStyle function
  window.addEventListener('on-hs-appearance-change', function () {
    setActiveStyle();
  });
})();
