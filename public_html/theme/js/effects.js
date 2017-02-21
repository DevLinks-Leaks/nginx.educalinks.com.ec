$(document).ready(function(){
   

	$('.dropdown-toggle').dropdown();

	$('img').tooltip();


	$('.collapse').collapse();

	 $('#tab a:last').tab('show');


	$('#btn').click(function(){
		$(this).toggleClass("active");
		$("#mainPanel").toggleClass("section_main expanded", 700, "easeOutExpo");
	});

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
