//instafeed
$.fn.func_instafeed = function(new_obj) {
  var $this = $(this);

  if (!$this.length) return;

  var new_obj = new_obj || {},
    set_obj = {
      get: 'user',
      userId: '5479786510',
      clientId: 'ede82b534d604f089beffd75353ff44f',
      limit: 6,
      sortBy: 'most-liked',
      resolution: "standard_resolution",
      accessToken: '5479786510.ede82b5.32885449218644e59b3d9655846d6d3b',
      template: '<a href="{{link}}" target="_blank"><img src="{{image}}" /></a>'
    };

  $.extend(set_obj, new_obj);

  var feed = new Instafeed(set_obj);
  feed.run();
};

$(document).ready(function() {
  $('.instafeed').func_instafeed({
    limit: 6
  });
  $('.instafeed-fluid').func_instafeed({
    limit: 10
  });
});