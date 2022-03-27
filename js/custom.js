jQuery( function( $ ) {
  /**
   * -@r-test-modal
   */
  // モーダルウィンドウを開く
  $('.modal-item__open').on('click', function(){
    var target = $(this).data('target');
    var modal = document.getElementById(target);
    scrollPosition = $(window).scrollTop();

    $('body').addClass('fixed').css({'top': -scrollPosition});
    // $(modal).fadeIn();
    $(modal).show();
    return false;
  });

  // モーダルウィンドウを閉じる
  $('.modal-item__close').on('click', function(){
    $('body').removeClass('fixed');
    window.scrollTo( 0 , scrollPosition );
    // $('.js-modal').fadeOut();
    $('.modal-item__js').hide();
    return false;
  });
// -- end-modal



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
   // console.log(headerH);


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
  * @r-tab-function
  * Switch display by clicking tab
  */

 // All screen is shown as default
 $('.tab-fuction-wrap .panel-0').parent().addClass('is-show');

 $('.tab-fuction-wrap .tab').on('click',function(){
   var idx=$('.tab').index(this);

   // tab
   $(this).addClass('is-active').siblings('.tab').removeClass('is-active');

   // panel
   var targetPanel = 'panel-' + idx;
   $('.tab-fuction-wrap .panel').each(function(index, element){
     if ($(element).hasClass('is-show')) {
       $(element).removeClass('is-show');
       $(element).parent().removeClass('is-show');

     }
   })
   $('.' + targetPanel).addClass('is-show');
   $('.' + targetPanel).parent().addClass('is-show');
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

    // $(".home .home-banner").bgSwitcher({
    //     images: [
    //       'http://localhost/00/portfolio/wp-content/uploads/2021/03/heroImage_clear.jpg',
    //       'http://localhost/00/portfolio/wp-content/uploads/2021/03/Memory-Game.jpg',
    //       'http://localhost/00/portfolio/wp-content/uploads/2021/04/under-construction02.jpg'
    //     ], // 切り替え画像
    //     Interval: 5000, //切り替えの間隔 1000=1秒
    //     start: true, //$.fn.bgswitcher(config)をコールした時に切り替えを開始する
    //     loop: true, //切り替えをループする
    //     shuffle: false, //背景画像の順番をシャッフルする
    //     effect: "fade", //エフェクトの種類 "fade" "blind" "clip" "slide" "drop" "hide"
    //     duration: 1000, //エフェクトの時間 1000=1秒
    //     easing: "swing", //エフェクトのイージング "swing" "linear"
    // });



});
