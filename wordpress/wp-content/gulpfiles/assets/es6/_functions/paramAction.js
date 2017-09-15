import '../_libs/jquery.easing.1.3'
import UA from '../_init/userAgent'

const paramScroll = () => {

  let GET = {
    init: () => {
      GET.settings = {
        scr: {
          easing: 'easeInOutCirc',
          delay: 300,
          duration: 800,
        },
      };

      GET.getParamater();
    },

    getParamater: () => {
      GET.url   = location.href;
      GET.split = GET.url.split('?');

      // パラメータがない場合はスルー
      if ( GET.split.length < 2 ) return;

      // パラメータがある場合は各パラメータを分離して格納
      GET.gets   = GET.split[1].split('&');

      GET.getValues();
    },

    getValues: () => {
      GET.params = {};

      let i = 0;
      for ( i; i < GET.gets.length; i++ ) {
        let get = GET.gets[i].split('=');
        let key = get[0];
        let val = get[1];
        GET.params[key] = val
      }

      GET.actions();
    },

    actions: () => {
      for ( let key in GET.params ) {
        // console.log(key, GET.params[key]);
        if ( key === 'anchor' ) GET.anchorScroll(GET.params[key]);
      }
    },

    anchorScroll: (tgtName) => {

      setTimeout(() => {
        let $tgt = $(`#${tgtName}`).length > 0 ? $(`#${tgtName}`) :
                   $(`.${tgtName}`).length > 0 ? $(`.${tgtName}`) :
                   '';
        if ( !$tgt ) {
          console.log('指定されたアンカーリンクは存在しません');
          return;
        }

        let pos    = $tgt.offset().top;
        let buffer = $('.fixed-area').outerHeight() + 10;

        buffer = UA.SP && $('body').hasClass('lineup') ?
                 buffer + $('.sp-scroll-triggers').outerHeight() :
                 buffer ;

        $('body, html').animate({
          scrollTop: pos - buffer,
        }, GET.settings.scr.duration, GET.settings.scr.easing );

      }, GET.settings.scr.delay);
    },
  };

  GET.init();
};


export default paramScroll;