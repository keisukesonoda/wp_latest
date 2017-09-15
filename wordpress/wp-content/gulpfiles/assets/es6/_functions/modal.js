import $ from 'jquery';


class modalFunc {
  constructor(args) {
    this.args = args;
  }
  init () {
    this.body = $('body');
    this.margin = 10;
    this.firstflg = true;
    this.openflg = false;

    this.openAction();
  }

  openAction () {
    this.args.trg.on('click', (e) => {
      e.preventDefault();

      // スクロール禁止処理
      this.disableScroll();

      // クリックしたタイミングでflg変更
      this.openflg = true;
      this.index = this.args.trg.index(event.currentTarget);
      this.createElements();
    });
  }

  createElements () {
    this.body.prepend('<div class="modal-wrap">');
    this.wrap = $('.modal-wrap');
    this.wrap.append('<div class="modal-overlay">')
             .append('<div class="modal-content">');
    this.overlay = $('.modal-overlay');
    this.content = $('.modal-content');
    this.content.append('<a href="#" class="modal-close">close</a>');
    this.closeBtn = $('.modal-close');

    // タイプによって振り分け
    if ( this.args.type === 'target' )
      this.cloneContent();

    else if ( this.args.type === 'iframe' )
      this.insertIframe();
  }

  cloneContent () {
    this.args.tgt.eq(this.index).clone(true)
                 .appendTo(this.content)
                 .css('display', 'block');

    // 引数にbeforeOpen関数があれば起動
    if ( this.args.beforeOpen ) this.args.beforeOpen(this);

    this.setStyle()
  }

  insertIframe () {
    this.content.append(`<iframe src="${this.args.path}" class="pc" name="opinion_if" frameborder="0" scrolling="auto" width="${this.args.width}" height="${this.args.height}" allowtransparency="true"></iframe>`);

    // 引数にbeforeOpen関数があれば起動
    if ( this.args.beforeOpen ) this.args.beforeOpen(this);

    this.setStyle()
  }

  setStyle () {
    this.winWidth   = $(window).width();
    this.winHeight  = $(window).height();
    this.contWidth  = this.content.outerWidth();
    this.contHeight = this.content.outerHeight();

    // 縦レイアウト
    if ( this.winHeight > this.contHeight ) {
      this.content.css({
        top: (this.winHeight - this.contHeight) / 2,
        'max-height': 'none',
        'overflow-y': 'visible',
      });

    } else {
      this.content.css({
        top: this.margin,
        'max-height': this.winHeight - (this.margin*2),
        'overflow-y': 'scroll',
      });
    }

    // 横レイアウト
    if ( this.winWidth > this.contWidth ) {
      this.content.css({
        left: (this.winWidth - this.contWidth) / 2,
      });
    } else {
      this.content.css({
        left: this.margin,
        'max-width': '94%',
      });
    }

    // 最初のみリサイズ時の処理を起動
    if ( this.firstflg ) this.resize();
    // フラグがあれば開く
    if ( this.openflg ) this.open();
  }

  resize() {
    $(window).on('resize', () => {
      this.setStyle();
    });
  }

  open () {
    // 開いたタイミングでflg変更
    this.firstflg = false;
    this.openflg = false;
    // モーダル要素表示
    this.wrap.fadeTo(this.args.duration, 1, () => {

      // 引数にafterOpen関数があれば起動
      if ( this.args.afterOpen ) this.args.afterOpen(this);

    });

    this.closeAction();
  }

  closeAction () {
    this.closeTrg = [this.closeBtn, this.overlay]

    $.each(this.closeTrg, (i, trg) => {
      trg.on('click', (e) => {
        e.preventDefault();

        this.close();
      });

    });
  }

  close () {
    this.wrap.fadeTo(this.args.duration, 0, () => {
      this.wrap.remove();
      this.enableScroll();
    });
  }

  disableScroll () {
    this.scrTop = $(window).scrollTop();

    window.disableScrollFlg = true;

    $('.wrapper').css({
      position: 'fixed',
      'top': -this.scrTop,
      'left': 0,
    });
  }

  enableScroll () {

    window.disableScrollFlg = false;

    $('.wrapper').css({
      position: 'static',
      top: 'auto',
      left: 'auto',
    });

    $('body, html').scrollTop(this.scrTop);
  }
}


export default modalFunc;
