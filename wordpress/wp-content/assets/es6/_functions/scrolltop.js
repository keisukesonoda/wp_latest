import '../_libs/jquery.easing.1.3'
import UA from '../_init/userAgent'

const scrollTop = () => {
  const scr = {
    init: () => {
      // パラメータ設定
      scr.params = {
        viewStart: 300,
        x: !UA.SP ? 30 : 5,
        y: !UA.SP ? 10 : 5,
        fade: 'fast',
        speed: 300,
        timing: 100,
        easing: 'easeInOutQuad',
      };
      // トリガー作成
      $('body').append(
        `<div class="pagetop">
          <a href="#" class="trg-scroll-top" style="display: none;">pagetop</a>
        </div>`
      );

      scr.wrap = $('.pagetop');
      scr.trg  = $('.trg-scroll-top');

      scr.styleSet();
      scr.viewControl();
      scr.action();
    },

    styleSet: () => {
      scr.wrap.css({
        position: 'fixed',
        bottom: scr.params.y,
        right: scr.params.x,
        'z-index': 10,
      });
    },

    viewControl: () => {
      scr.val = $(window).scrollTop();

      let fade = () => {
        if ( scr.val > scr.params.viewStart )
          scr.trg.fadeIn('fast');
        else
          scr.trg.fadeOut('fast');
      };

      // ロード時
      fade();
      // スクロール時
      let timer = false;
      $(window).on('scroll', () => {
        if ( timer !== false ) clearTimeout(timer);

        timer = setTimeout(() => {
          scr.val = $(window).scrollTop();
          fade();

        }, scr.params.timing);
      });
    },

    action: () => {
      scr.trg.on('click', (e) => {
        e.preventDefault();

        $('body, html').animate({
          scrollTop: 0,
        }, scr.params.speed, scr.params.easing);
      });
    },

  };

  scr.init();
};


export default scrollTop;