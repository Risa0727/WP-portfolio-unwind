jQuery( function( $ ) {

  $('.moving-text').children().addBack().contents().each(function() {
    $(this).replaceWith($(this).text().replace(/(\S)/g, '<span class="text-move">$&</span>'));
  });
   setTimeout(function(){
      $(".moving-text").addClass("active");
  },100);


  // console.log('hoge');
  // ==================================
 // Navigation gets smaller when scroll down
 //  ==================================
   var header = $('#masthead .sticky-bar');
   // var logo = $('.site-branding');
   // var navi = $('.site-navigation');
   // $scroll = $(window).scrollTop();
   var headerH = header.outerHeight(true);


   $(window).on('scroll', function() {
       $scroll = $(window).scrollTop();
       if ($scroll >= headerH) {
         header.addClass('is-scroll');
       } else if ($scroll <= headerH) {
         header.removeClass('is-scroll');
       }

       // ==================================
      // Progress Bar
      //  ==================================
       let triggerClass = $('.show-trigger');
       let animateClass = ('is-show');

       $(triggerClass).each(function() {
         let triggerTop = $(this).offset().top,
             windowHeight = $(window).height();

       // スクロースして特定の要素の高さまで来たらアニメーション実行
        if ($scroll > triggerTop - (windowHeight / 2)) {
          $(this).addClass(animateClass);

          var meter = $('.progress-bars.show-trigger .meter');
            // meter.length: プログレスバーの数
            for (var i=0; i<meter.length; i++) {
              a(i);
            }
          function a(i) {
            var meterClass = meter.eq(i).attr('class');
            var classArray = meterClass.split(' ');
            var classMatch = [];

            // パーセンテージ取得
            for (var n=0; n<classArray.length; n++) {
              if (classArray[n].match(/meter-/)) {
                classMatch.push(classArray[n]);
              }
            }

            var num = classMatch.join(',');
                // console.log(num);
            var meterNum = num.slice(-2);// ％数値
            if (meterNum == 00) {
              var meterNum = 100;
            }
            // %バーと矢印の位置
            function action() {
              $('.meter-line-inner').eq(i).animate({
                width: meterNum + '%'
              }, 1000, 'swing');

              // 矢印▼の移動
              // $('.meter-percent').eq(i).animate({
              //   left: meterNum + '%'
              // }, 1000, 'swing');
            }
            action();
            // ％数値
            function numCount() {
              var num = 0;
              var speed = 10;
              var count = setInterval(function() {
                $('.meter-number').eq(i).text(num);
                num++;
                if (num > meterNum) {
                  clearInterval(count);
                }
              }, speed);
            }
            // numCount();
          }


        }
      });
   });




   /**
    * This is for test @r-test-toggle
    * http://localhost/00/portfolio/about-me/
    */
    $('.about-doctor-section input[type="checkbox"]').change(function(){
      // console.log($(this));
      $(this).next().toggleClass('is-show');
      // $('.toggle-content').toggleClass('is-show');
      $(this).parent().parent().parent().parent().find('.toggle-content').toggleClass('is-show');
    });

});
