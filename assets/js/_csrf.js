window.getCSRFToken = function () {
  return document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};
