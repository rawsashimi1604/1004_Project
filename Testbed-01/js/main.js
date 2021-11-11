/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
* This function toggles the nav menu active/inactive status as
* different pages are selected. It should be called from $(document).ready()
* or whenever the page loads.
*/

//function activateMenu()
//{
// var current_page_URL = location.href;
// $(".navbar-nav a").each(function()
// {
// var target_URL = $(this).prop("href");
// if (target_URL === current_page_URL)
// {
// $('nav a').parents('li, ul').removeClass('active');
// $(this).parent('li').addClass('active');
// return false;
// }
// });
//}

/*Function for adding dynamic popup images*/
function togglepopup()
{
    /*Listens for if document content loaded = execute function*/
    document.addEventListener("DOMContentLoaded", function()
    {
        /*Create a list of all image elements using the specified class, 
         * and create span*/
        var thumbnails = document.getElementsByClassName("img-class-thumbnail");
        var img = document.createElement('span'); 
        
        if (thumbnails !== null)
        {
            /*Iterating through the list of thumbnails*/
            for (var i = 0; i < thumbnails.length; i++) 
            {
                /*Listens for clicks on the thumbnail images = execute function*/
                thumbnails[i].addEventListener("click", function()
                {
                    /*Adding image tag, src, class, and inserting adjacent 
                     * to thumbnail*/
                    img.innerHTML = "<img class=popup src=\"" + this.src + "\">";
                    /*Setting class for span tag and setting display on*/
                    img.setAttribute("class","image-popup");
                    img.style.display = "inline-block";
                    var thumbnail = this;
                    thumbnail.insertAdjacentElement("afterend", img);
                });

                /*Listens for clicks on popup image, if clicked = remove element*/
                img.addEventListener("click", function()
                {
                    img.remove();
                });
            }
        }
            
    });
}