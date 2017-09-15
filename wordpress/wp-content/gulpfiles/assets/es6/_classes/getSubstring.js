/**
 * 文字列省略
 */
class GetSubString {
  constructor(args = {}) {
    this.args = args;
  }

  init() {
    // デフォルト値設定
    this.args.selector = this.args.selector ? this.args.selector : '.abbr';
    this.args.suffix = this.args.suffix ? this.args.suffix : '...';
    this.args.max = this.args.max ? this.args.max : 40;
    this.args.str = this.args.str ? this.args.str : '';
  }

  /**
   * クラスで一括指定（実行は一度だけ）
   * （未検証）
   */
  bundle() {
    $(`${this.args.selector}`).each((index, tgt) => {
      let str = $(tgt).text();
      let b = 0;
      for (let i = 0; i < str.length; i += 1) {
        b += str.charCodeAt(i) <= 255 ? 0.5 : 1;
        if (b > this.args.max) {
          str = str.substr(0, i) + this.args.suffix;
          break;
        }
      }

      $(tgt).text(str);
    });
  }

  /**
   * ループ内
   */
  inLoop() {
    this.init();

    if (!this.args.str) return '';

    let str = this.args.str;
    let b = 0;
    for (let i = 0; i < str.length; i += 1) {
      b += str.charCodeAt(i) <= 255 ? 0.5 : 1;
      if (b > this.args.max) {
        str = str.substr(0, i) + this.args.suffix;
        break;
      }
    }
    return str;
  }
}

export default GetSubString;
