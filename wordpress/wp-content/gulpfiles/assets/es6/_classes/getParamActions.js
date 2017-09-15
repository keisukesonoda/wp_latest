
class GETParamActions {
  constructor(args = {}) {
    this.args = args;
  }

  init() {
    // パラメータを格納するオブジェクト
    this.params = {};
    // パラメータから先頭の?を削除
    this.search = location.search.substr(1);
    // パラメータがない場合はスルー
    if (this.search) {
      // &で区切る（複数パラメータ）
      this.splits = this.search.split('&');
      // それぞれのパラメータを配列に格納
      for (let i = 0; i < this.splits.length; i += 1) {
        const ary = this.splits[i].split('=');
        const key = ary[0];
        const val = ary[1];
        this.params[key] = val;
      }
    }
  }

  returnParams() {
    this.init();
    return this.params;
  }
}

export default GETParamActions;
