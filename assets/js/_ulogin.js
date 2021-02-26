(function () {
  var widget = document.querySelector('#uLogin');
  if (!widget) {
    return;
  }

  var config = {
    rootMargin: '50px 0px',
    threshold: 0.01
  };

  var loadWidget = function () {
    var s = document.createElement('script');
    s.src = '//ulogin.ru/js/ulogin.js';
    s.async = true;
    document.querySelector('body').appendChild(s);
  }

  var onChange = function (changes, observer) {
    changes.forEach(function (change) {
      if (change.intersectionRatio > 0) {
        loadWidget();
        observer.unobserve(change.target);
      }
    });
  }

  if (window.IntersectionObserver) {
    var observer = new IntersectionObserver(onChange, config);
    observer.observe(widget);
  } else {
    console.log('%cIntersection Observers not supported');
    loadWidget();
  }
})();
