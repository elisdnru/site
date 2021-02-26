(function () {
  var forms = document.querySelectorAll('form[data-action]');
  [].forEach.call(forms, function (form) {
    form.action = form.dataset.action;
  })
})();
