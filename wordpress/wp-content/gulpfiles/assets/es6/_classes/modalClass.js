class ModalClass {
  constructor(args) {
    this.args = args;
    this.body = $('body');
    this.delay = 100;
  }

  open(content) {
    /**
     * モーダル要素の生成
     */
    this.body.prepend(`
      <div class="modal-wrap">
        <div class="modal-overlay"></div>
        <div class="modal-content">
          <a href="#" class="modal-close">close</a>
        </div>
      </div>
    `);
    this.elms = {
      wrap: $('.modal-wrap'),
      overlay: $('.modal-overlay'),
      content: $('.modal-content'),
      close: $('.modal-close'),
    };
    // コンテンツを挿入
    this.elms.content.append(content.clone(true).addClass('clone'));

    /**
     * 表示
     */
    setTimeout(() => {
      this.elms.wrap.addClass('isView');
    }, this.delay);
  }


  /**
   * クローズ
   */
  close() {
    this.elms.wrap.removeClass('isView');
    setTimeout(() => {
      this.elms.wrap.remove();
    }, this.delay * 10);
  }


  /**
   * スクロール禁止
   */
  disableScroll() {
    this.scrTop = $(window).scrollTop();
    this.disableScrollFlg = true;
    $('.wrapper').css({
      position: 'fixed',
      top: -this.scrTop,
      left: 0,
    });
  }


  /**
   * スクロール復活
   */
  enableScroll() {
    this.disableScrollFlg = false;
    $('.wrapper').css({
      position: 'static',
      top: 'auto',
      left: 'auto',
    });
    $('body, html').scrollTop(this.scrTop);
  }
}

export default ModalClass;
