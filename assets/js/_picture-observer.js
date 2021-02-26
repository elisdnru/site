(function () {
  const images = document.querySelectorAll('img[data-src]')

  const config = {
    rootMargin: '50px 0px',
    threshold: 0.01
  }

  const loadImage = function (image) {
    if (image.src !== image.dataset.src) {
      image.src = image.dataset.src
    }
    const sources = image.parentNode.querySelectorAll('source');
    [].forEach.call(sources, function (source) {
      source.srcset = source.dataset.srcset
    })
  }

  const onChange = function (changes, observer) {
    changes.forEach(function (change) {
      if (change.intersectionRatio > 0) {
        loadImage(change.target)
        observer.unobserve(change.target)
      }
    })
  }

  if (window.IntersectionObserver) {
    const observer = new IntersectionObserver(onChange, config);
    [].forEach.call(images, function (image) {
      observer.observe(image)
    })
  } else {
    console.log('%cIntersection Observers not supported');
    [].forEach.call(images, function (image) {
      loadImage(image)
    })
  }
})();
