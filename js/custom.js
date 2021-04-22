jQuery( function( $ ) {
  // console.log('hoge');
  // ==================================
 // Navigation gets smaller when scroll down
 //  ==================================
   var header = $('#masthead .sticky-bar');
   // var logo = $('.site-branding');
   // var navi = $('.site-navigation');
   $scroll = $(window).scrollTop();
   var headerH = header.outerHeight(true);

   $(window).on('scroll', function() {
       $scroll = $(window).scrollTop();
       if ($scroll >= headerH) {
         header.addClass('is-scroll');
       } else if ($scroll <= headerH) {
         header.removeClass('is-scroll');
       }
   });

});
