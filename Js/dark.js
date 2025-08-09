document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('darkModeToggle').addEventListener('change', function () {
    if (this.checked) {
      document.documentElement.setAttribute('data-theme', 'dark');
    } else {
      document.documentElement.removeAttribute('data-theme');
    }
  });
});
