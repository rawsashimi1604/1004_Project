//$(function() {
//  alert( "ready!" );
//});

//function remove_table()
//{
//    document.addEventListener("DOMContentLoaded", function()
//    {
//        var browse_search = document.getElementById("browse_search_button");
//        
//        if (browse_search !== null)
//        {
//            browse_search.addEventListener("click", function()
//            {
//                var tb = document.getElementById("browsing_list"); 
//                while(tb.rows.length > 1) { tb.deleteRow(1); } 
//            });
//        }
//        else
//        {
//            alert("Error!");
//        }
//    });
//}

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

var checkpw = function () {

  if (document.getElementById('pwd').value === document.getElementById('cfm_pwd').value) {
    document.getElementById('errMsg').style.color = 'green';
    document.getElementById('errMsg').innerHTML = 'Password match';
  } else {
    document.getElementById('errMsg').style.color = 'red';
    document.getElementById('errMsg').innerHTML = 'Password does not match';
  }
};

function checkpassword(password) {
  var strength = 0;
  if (password.match(/[a-z]+/)) {
    strength += 1;
  }
  if (password.match(/[A-Z]+/)) {
    strength += 1;
  }
  if (password.match(/[0-9]+/)) {
    strength += 1;
  }
  if (password.match(/[$@#&!]+/)) {
    strength += 1;
  }

  switch (strength) {
    case 0:
      strengthbar.value = 0;
      break;

    case 1:
      strengthbar.value = 25;
      break;

    case 2:
      strengthbar.value = 50;
      break;

    case 3:
      strengthbar.value = 75;
      break;

    case 4:
      strengthbar.value = 100;
      break;
  }
}

var code = document.getElementById("pwd");
var strengthbar = document.getElementById("meter");
console.log("triggered");
code.addEventListener("keyup", function () {
  checkpassword(code.value);
  console.log("triggered");
});