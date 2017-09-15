class anchorLink {
  constructor(args) {
    this.args = args;
  }
  init() {
    if (this.args.trg.length === 0) return false;
    this.opt = {
      speed: this.args.speed ? this.args.speed : 400,
      buffer: this.args.buffer ? this.args.buffer : 0,
      easing: this.args.easing ? this.args.easing : 'swing',
    };

    this.args.trg = $('.js-anchorTrg');
    return this;
  }

  pc() {
    this.init();

    this.args.trg.on('click', (e) => {
      e.preventDefault();

      // アンカー先（ターゲット）の定義
      const $trg = $(e.target).hasClass('js-anchorTrg') ?
                   $(e.target) :
                   $(e.target).parents('.js-anchorTrg');
      let href = $trg.attr('href');
      if (href.match(/#/) === null) href = `#${href}`;

      const $tgt = $(href);

      // ターゲットが見つからない
      if ($tgt.length === 0) {
        console.log('アンカー先の設定がおかしいです。');
        return;
      }

      const pos = $tgt.offset().top;

      $('body, html').animate({
        scrollTop: pos - this.opt.buffer,
      }, this.opt.speed, this.opt.easing);
    });
  }

  sp() {
    this.init();

    this.args.trg.on('click', (e) => {
      e.preventDefault();

      // アンカー先（ターゲット）の定義
      const $trg = $(e.target).hasClass('js-anchorTrg') ?
                   $(e.target) :
                   $(e.target).parents('.js-anchorTrg');
      let href = $trg.attr('href');
      if (href.match(/#/) === null) href = `#${href}`;

      const $tgt = $(href);

      // ターゲットが見つからない
      if ($tgt.length === 0) {
        console.log('アンカー先の設定がおかしいです。');
        return;
      }

      const pos = $tgt.offset().top;
      // console.log(pos, window.spMenu);

      if (window.spMenu.flg) {
        // トグルメニューが開いているため閉じてから処理
        const $tglTrg = $('#menu-btn');
        const $tglTgt = $('.header').find('.container');
        const $tglCnt = $('.sp-header-contents');

        $tglTgt.slideToggle('fast', () => {
          $tglTrg.removeClass('menu-close');
          $tglCnt.children().not('.wrap-menu-btn').fadeIn(100);
          window.spMenu.flg = false;

          // スライド処理
          $('body, html').animate({
            scrollTop: pos - this.opt.buffer,
          }, this.opt.speed, this.opt.easing);
        });
      } else {
        // トグルメニュー以外のトリガーが発火
        $('body, html').animate({
          scrollTop: pos - this.opt.buffer,
        }, this.opt.speed, this.opt.easing);
      }
    });
  }
}

export default anchorLink;
