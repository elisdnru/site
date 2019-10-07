(function() {
  var cloud = document.querySelector('#tag_cloud');
  if (cloud) {
    var tags = JSON.parse(cloud.dataset.tags);
    var links = document.createElement('span');
    tags.forEach(function (tag) {
      var a = document.createElement('a');
      var size = tag.frequency + 8;
      if (size < 8) size = 9;
      if (size > 16) size = 16;
      a.href = tag.url;
      a.style['font-size'] = size + 'pt';
      a.innerHTML = tag.title;
      links.append(a);
      links.append(' ');
    })
    cloud.append(links);
  }
})();
