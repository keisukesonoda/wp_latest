import UA from '../_general/getUserAgent';
import ROOTPATH from '../_general/getRootPath';

class includes {
  constructor(args) {
    this.args = args;
  }

  setTarget() {
    this.tgt = $(`${this.args.selecter}`);
  }

  replaceLinkURL() {
    this.tgt.find('a').each((i, link) => {
      const dataHref = $(link).data('href');

      if (dataHref) {
        const myPath = dataHref.indexOf('/') === 0 ? dataHref.replace('/', ROOTPATH) : dataHref;
        $(link).attr('href', myPath);
      }
    });
  }

  replaceImagePath() {
    this.tgt.find('img').each((i, img) => {
      const urlSrc = $(img).attr('src').replace(`http://${location.host}`, '');
      const newurl = urlSrc.replace('/', ROOTPATH);
      $(img).attr('src', newurl);
    });
  }


  ajax() {
    this.setTarget();
    if (this.tgt.length === 0) return;

    $.ajax({
      url: `${ROOTPATH}${this.args.dir}/${this.args.fileName}.html`,
    })
      .done((res) => {
        this.tgt.html(res);
        this.replaceLinkURL();
        this.replaceImagePath();

        // コールバックがあれば実行
        if (this.args.callback) this.args.callback(this);
      })
      .fail((jqXHR, textStatus, errorThrown) => {
        console.log('ファイルの読み込みに失敗しました', errorThrown);
      });
  }

  iframe() {
    // console.log('iframe');
    this.setTarget();
    if (this.tgt.length === 0) return;

    if (UA.SP) {
      if (this.args.fileName.includes('pc')) return;
    } else {
      if (this.args.fileName.includes('sp')) return;
    }

    // iframe埋め込み
    this.tgt.append(`
      <iframe width="${this.args.width}" height="${this.args.height}" src="${ROOTPATH}${this.args.dir}/${this.args.fileName}.html" class="inq-iframe" frameborder="0" allowfullscreen></iframe>`);

    // iframeの高さに合わせて要素の高さを指定
    this.iframe = this.tgt.find('iframe');
    this.iframe.on('load', (e) => {
      try {
        $(e.target).height(0);
        $(e.target).height(e.target.contentWindow.document.documentElement.scrollHeight);
      } catch (e) {
        console.log(e);
      }
    })
      .trigger('load');

    // コールバックがあれば実行
    if (this.args.callback) this.args.callback(this);
  }
}


export default includes;
