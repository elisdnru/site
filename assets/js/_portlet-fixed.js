(function () {
  const portlet = document.querySelector('.sidebar .portlet-fixed')
  const marker = document.querySelector('.bottom-marker')
  const wrapper = document.querySelector('#wrapper')
  if (portlet && marker) {
    window.addEventListener('scroll', function () {
      const offset = marker.offsetTop
      const scrollYpos = window.pageYOffset
      const width = wrapper.offsetWidth
      if (scrollYpos > offset && width >= 780) {
        portlet.style.width = '258px'
        portlet.style.top = '10px'
        portlet.style.position = 'fixed'
      } else {
        portlet.style.width = '258px'
        portlet.style.top = 'auto'
        portlet.style.position = 'relative'
      }
    })
  }
})();
