$(document).ready(function(){
  

$('.alumnos_foto').tooltip({
  container: 'body'
 });

    $('#btn_profiles a').tooltip({
      container: 'body'
    });

    $('#btn_profiles a' ).click(
         //$('#profile').stop(true).animate({'background-position': '50% -55px'}, 500);
        function () {

          var element = $(this).attr("value");
          //alert(element);
         

         $('#profile').stop().animate(
            { opacity: 0 }, 'fast',
            function () { 
              //$(this).css({'background-position': '50% -35px'}).fadeTo(300, 1); 
              $(this).html(element).fadeTo(300, 1);
            }
          )
        
        }
    ); 


   $('#CoursematesSlider').bxSlider({
    slideWidth: 100,
    minSlides: 5,
    maxSlides: 10,
    slideMargin: 0,
    moveSlides: 5,

    onSlideAfter: function (currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
            console.log(currentSlideHtmlObject);
            $('.active-slide').removeClass('active-slide');
            $('.bxslider > li').eq(currentSlideHtmlObject + 7).addClass('active-slide')
        },
        onSliderLoad: function () {
            $('.bxslider > li').eq(7).addClass('active-slide')
        },

          //breaks: [{screen:0, slides:1, pager:false},{screen:460, slides:2},{screen:768, slides:3}]
        });

   $('.select').fancySelect();

   
   $('#accordion-agendas').collapse()





/*
  var slider=$('#myslider').bxSlider({
     pager: 'true',
   onBeforeSlide: function(currentSlide, totalSlides, currentSlideHtmlObject){
        $('.pager').removeClass('active-slide');   
         $(currentSlideHtmlObject).addClass('active-slide');
 //     $('#sddf').html('<p class="check">Slide index ' + currentSlide + ' of ' + totalSlides + ' total slides has completed.');
    }

});
    */



   /*
        To add class on the first visible slide you have to call onSliderLoad. Then you continue adding and removing active-slide class with onSlideAfter call.
        */
/*
        onSlideAfter: function (currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
            console.log(currentSlideHtmlObject);
            $('.active-slide').removeClass('active-slide');
            $('.bxslider > li').eq(currentSlideHtmlObject + 1).addClass('active-slide')
        },
        onSliderLoad: function () {
            $('.bxslider > li').eq(1).addClass('active-slide')
        },
  */    






/*
  $('.dropdown-toggle').dropdown();

  $('img').tooltip();


  $('.collapse').collapse();

   $('#tab a:last').tab('show');


  $('#btn').click(function(){
    $(this).toggleClass("active");
    $("#mainPanel").toggleClass("section_main expanded", 700, "easeOutExpo");
  });
  /*

//$('#myModalLabel').modal(options)

	// SCROLLER
/*
	 $(document).ready(function() {
        $(window).on("snap", function() {
          console.log('snap');
          $(".scrollbar").scroller("reset");
        });

        $(".scrollbar").scroller();

        // Reset
        $(".reset_click").on("click", function() {
          $(".scrollbar_reset .scroller-content").append("<p>Suspendisse eu nibh in libero euismod condimentum eget nec enim. Suspendisse nec ligula nec augue tristique semper sed suscipit erat. Integer et nunc a augue pellentesque fringilla. Nullam leo ligula, mattis id pretium ac, suscipit sed nunc. Duis ac lorem nec velit malesuada tempus hendrerit ut metus. Quisque a lacus vel lectus rhoncus luctus. Aliquam ornare, nunc sit amet porttitor ornare, libero lectus congue enim, vitae tincidunt sapien justo et ligula. Proin vestibulum blandit fringilla.</p>");
          $(".scrollbar_reset").scroller("reset");
          return false;
        });

        // Scroll To Position
        $(".scroll_top").on("click", function(e) {
          e.preventDefault();
          e.stopPropagation();
          $(".scrollbar_scroll").scroller("scroll", 0);
        });
        $(".scroll_mid").on("click", function(e) {
          e.preventDefault();
          e.stopPropagation();
          $(".scrollbar_scroll").scroller("scroll", 200);
        });
        $(".scroll_target").on("click", function(e) {
          e.preventDefault();
          e.stopPropagation();
          $(".scrollbar_scroll").scroller("scroll", $(this).attr("href"));
        });
                $(".scroll_animate").on("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(".scrollbar_scroll").scroller("scroll", 300, 500);
                });
      }); 
*/

}); 
