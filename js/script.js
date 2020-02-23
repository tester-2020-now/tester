if (window.devicePixelRatio !== 1) { // Костыль для определения иных устройств, с коэффициентом отличным от 1     
    var dpt = window.devicePixelRatio;
    var widthM = window.screen.width * dpt;
    document.write('<meta name="viewport" content="width=' + 480 + '">');
}

$(function(){


    $('.beforAfter__wrap').owlCarousel({
        items: 1,
        dots: false,
        nav: true,
        loop:true,
        autoplay: true,
        navText: '',
        navContainer: '.reviews__nav'
    });

    $('.zakaz').click(function(){
          var el = '#zakaz';
          $('html, body').animate({
              scrollTop: $(el).offset().top
          }, 500);
          return false; 
  });

    // $('.reviews__conteiner').owlCarousel({
    //     mouseDrag: false,
    //     touchDrag: false,
    //     pullDrag: false,
    //     freeDrag: false,
    //     items: 1,
    //     dots: true,
    //     nav: false,
    //     autoplay: false,
    //     navText: '',
    //     dotsContainer: '.reviews__conteiner__nav'
    // });

    $('.reviews__conteiner__nav > *').eq(0).text('Аудио');
    $('.reviews__conteiner__nav > *').eq(1).text('Видео');
    $('.reviews__conteiner__nav > *').eq(2).text('Отзывы');

    $('.reviews__text').owlCarousel({
        items: 1,
        dots: false,
        loop:true,
        nav: true,
        autoplay: true,
        navText: '',
        navContainer: '.reviews__text-nav'
    });
    // $('.reviews__audio').owlCarousel({
    //     items: 1,
    //     dots: false,
    //     nav: true,
    //     autoplay: true,
    //     navText: '',
    //     navContainer: '.reviews__audio-nav'
    // });
    // $('.reviews__video').owlCarousel({
    //     items: 1,
    //     dots: false,
    //     nav: true,
    //     autoplay: true,
    //     navText: '',
    //     navContainer: '.reviews__video-nav'
    // });

});