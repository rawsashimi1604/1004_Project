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

function remove_rows($num_of_rows)
{
    document.addEventListener("DOMContentLoaded", function()
    {
        var tb = document.getElementById("browsing_list"); 
        while(tb.rows.length > $num_of_rows) { tb.deleteRow(1); }
    });
}

$(document).ready(function(){
    
    $('.logout').click(function(){
        var clickBtnValue = $(this).val();
        var ajaxurl = 'logout.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            //alert("action performed successfully");
            location.reload();
        });
    });
});
