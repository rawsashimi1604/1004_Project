function remove_rows($num_of_rows) {
  document.addEventListener("DOMContentLoaded", function () {
    var tb = document.getElementById("browsing_list");
    while (tb.rows.length > $num_of_rows + 1) {
      tb.deleteRow(1);
    }
  });
}

$(document).ready(function () {

  $('.logout').click(function () {
    var clickBtnValue = $(this).val();
    var ajaxurl = 'logout.php',
      data = {
        'action': clickBtnValue
      };
    $.post(ajaxurl, data, function (response) {
      // Response div goes here.
      //alert("action performed successfully");
      location.reload();
    });
  });
  $('body').on('click', function (e) {
    $('[data-bs-toggle="popover"]').each(function () {
      // hide any open popovers when the anywhere else in the body is clicked
      if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
        $(this).popover('hide');
      }
    });
  });
  // Event handler for active navbar state
  activateNav();

});

function activateNav() {
  var current_page_URL = location.href;

  $(".navbar-nav a").each(function () {
    var target_URL = $(this).prop("href");
    if (target_URL === current_page_URL) {
      $('nav a').removeClass('active');
      $(this).addClass('active');
      return false;
    }
  })
}