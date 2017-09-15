import './_libs/jquery.bxslider';
import './_libs/jquery.easing.1.3';

/**
 * メインビジュアルスライダー
 */
const mvSlider = () => {
  const mv = {
    init: () => {
      mv.tgt = $('#mv-slider');

      if (mv.tgt.length === 0) return;

      mv.sizes = {
        break: 768,
        window: $(window).width(),
      };
      mv.elm = {
        tgt: mv.tgt,
        area: $('.mainvisual'),
        wrap: $('.mv-wrap'),
        loader: $('.mainvisual').find('.loader-simple'),
      };
      mv.param = {
        mode: 'fade',
        pager: true,
        controls: false,
        auto: true,
        autoDelay: 1000,
        pause: 5000,
        speed: 600,
        useCSS: false,
        easing: 'easeInOutQuint',
        // touch: false,
        touch: true,
        fadetime: 500,
        viewDelay: 1000,
      };

      mv.length = mv.elm.tgt.find('li').length;

      if (mv.length < 2) {
        // 1枚の場合
        setTimeout(() => {
          mv.elm.loader.fadeOut(mv.param.fadetime, () => {
            mv.elm.tgt.addClass('noSlide');
            mv.elm.wrap.addClass('isView');
          });
        }, mv.param.viewDelay);
      } else {
        // 複数枚の場合
        mv.elm.area.addClass(`length-${mv.length}`);
        // window load時の起動選択
        if (mv.sizes.window >= mv.sizes.break) mv.pcSet();
        else mv.spSet();
        // resize時のスイッチ
        $(window).on('resize', () => {
          mv.sizes.window = $(window).width();

          if (mv.sizes.window < mv.sizes.break && mv.status === 'pc') {
            // pcからspにスイッチ
            mv.pcSlider.destroySlider();
            mv.elm.loader.show();
            mv.elm.wrap.removeClass('isView');
            mv.spSet();
            // リサイズイベントをオフ
            if (mv.resizeEvent) $(window).off(mv.resizeEvent);
          } else if (mv.sizes.window >= mv.sizes.break && mv.status === 'sp') {
            // spからpcにスイッチ
            mv.spSlider.destroySlider();
            mv.elm.loader.show();
            mv.elm.wrap.removeClass('isView');
            mv.pcSet();
          }
        });
      }
    },

    pcSet: () => {
      mv.pcSlider = mv.elm.tgt.bxSlider({
        mode: mv.param.mode,
        auto: mv.param.auto,
        autoStart: mv.param.auto,
        autoDelay: mv.param.autoDelay,
        pause: mv.param.pause,
        speed: mv.param.speed,
        pager: mv.param.pager,
        controls: mv.param.controls,
        useCSS: mv.param.useCSS,
        easing: mv.param.easing,
        touchEnabled: mv.param.touch,
        onSliderLoad: () => {
          setTimeout(() => {
            mv.elm.loader.fadeOut(mv.param.fadetime, () => {
              // 表示
              mv.elm.wrap.addClass('isView');
              mv.status = 'pc';
            });
          }, mv.param.viewDelay);
        },
        onSlideBefore: () => {
          mv.pcSlider.stopAuto();
        },
        onSlideAfter: () => {
          mv.pcSlider.startAuto();
        },
      });
    },

    spSet: () => {
      mv.spSlider = mv.elm.tgt.bxSlider({
        mode: mv.param.mode,
        auto: mv.param.auto,
        autoStart: mv.param.auto,
        autoDelay: mv.param.autoDelay,
        pause: mv.param.pause,
        speed: mv.param.speed,
        pager: mv.param.pager,
        controls: mv.param.controls,
        useCSS: mv.param.useCSS,
        easing: mv.param.easing,
        touchEnabled: mv.param.touch,
        onSliderLoad: () => {
          setTimeout(() => {
            mv.elm.loader.fadeOut(mv.param.fadetime, () => {
              // 表示
              mv.elm.wrap.addClass('isView');
              mv.status = 'sp';
            });
          }, mv.param.viewDelay);
        },
        onSlideBefore: () => {
          mv.spSlider.stopAuto();
        },
        onSlideAfter: () => {
          mv.spSlider.startAuto();
        },
      });
    },
  };
  mv.init();
};

$(window).on('load', () => {
  mvSlider();
});
