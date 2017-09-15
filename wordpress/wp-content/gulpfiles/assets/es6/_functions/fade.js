import '../_libs/jquery.cookie';

/**
 * metrock lineup
 * サムネとリスト表示を切り替えるフェード
 * @args
 * trg: トリガー要素
 * tgt: ターゲット要素
 * defaultTgt: cookieがない場合の初期表示エリア,
 * params: {
 *   in: フェードインスピード
 *   out: フェードアウトスピード
 * }
 * cookieName: cookieに保存するキー
 */
class fade {
  constructor(args) {
    this.args = args;
  }

  getCorrectTarget(tgt, eventTarget) {
    let tgtClass = tgt.attr('class').split(' ')[0];
    this.crctTgt = $(eventTarget).hasClass(tgtClass) ?
                   $(eventTarget) :
                   $(eventTarget).parents(`.${this.params.tgtClass}`);
  }

  init() {
    this.params = {
      in: this.args.params.in ? this.args.params.in : 300,
      out: this.args.params.out ? this.args.params.out : 200,
    };

    const COOKIE = $.cookie(this.args.cookieName);

    if ( COOKIE ) {
      // cookieが保存されている
      if ( typeof COOKIE === 'string' && COOKIE === 'list-area' || COOKIE === 'thumbnail-area' )
        $(`.${COOKIE}`).addClass('active');
      else
        this.args.defaultTgt.addClass('active');
    } else {
      // cookieが保存されていない
      this.args.defaultTgt.addClass('active');
    }

    // ロード時のアクティブターゲットを表示
    this.args.tgt.filter('.active').css('display', 'block');
    this.action();
  }

  action() {
    this.args.trg.on('click', (e) => {
      e.preventDefault();

      this.getCorrectTarget(this.args.trg, e.target);
      this.index = this.args.trg.index(e.target);

      if ( this.crctTgt.hasClass('active') ) return;

      let $next = this.index % 2 === 0 ?
                  this.args.tgt.filter(':nth-child(even)') :
                  this.args.tgt.filter(':nth-child(odd)');

      this.args.tgt.filter('.active').fadeOut(this.params.out, () => {
        // トリガーのアクティブ切り替え
        this.args.trg.filter('.active').removeClass('active');
        this.args.trg.eq(this.index).addClass('active');

        // ターゲットのアクティブ切り替え
        this.args.tgt.filter('.active').removeClass('active');
        $next.addClass('active').fadeIn(this.params.in);

        // 現在開いてるエリア名をcookieに保存
        const cName = this.args.tgt.filter('.active').attr('class').split(' ')[0];
        $.cookie(this.args.cookieName, cName, {
          expires: 1,
          path: '/',
        });
      });

    });
  }

}

export default fade;