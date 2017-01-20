import $ from 'jquery';
import UA from '../_init/userAgent';
import ROOT from '../_init/rootPath';

class includes {
  constructor(args) {
    this.args = args;
  }


  setTarget() {
    this.tgt = $(`${this.args.selecter}`);
  }


  replaceLinkURL() {
    this.tgt.find('a').each((i, link) => {
      let data_href = $(link).data('href');

      if ( data_href ) {
        let mypath = data_href.indexOf('/') === 0 ?
                     data_href.replace('/', ROOT) :
                     data_href;
        $(link).attr('href', mypath)

      }

    });
  }

  replaceImagePath() {
    this.tgt.find('img').each((i, img) => {
      let url_src = $(img).attr('src').replace(`http://${location.host}`, '');
      let newurl  = url_src.replace('/', ROOT);
      $(img).attr('src', newurl);
    });
  }


  ajax() {
    this.setTarget();
    if ( this.tgt.length === 0 ) return;

    // if ( this.args.file === 'nav-list' ) {
    //   console.log(this.tgt);
    // }

    $.ajax({
      url: `${ROOT}${this.args.dir}/${this.args.file}.html`
    })
    .done( (res) => {

      this.tgt.html(res);

      this.replaceLinkURL();

      this.replaceImagePath();

      // コールバックがあれば実行
      if ( this.args.callback ) this.args.callback(this);

    })
    .fail( (jqXHR, textStatus, errorThrown) => {
      console.log('ファイルの読み込みに失敗しました');
    });
  }


  iframe() {
    // console.log('iframe');
    this.setTarget();
    if ( this.tgt.length === 0 ) return;

    if (UA.SP)
      if ( this.args.file.includes('pc') ) return;
    else
      if ( this.args.file.includes('sp') ) return;

    // iframe埋め込み
    this.tgt.append(`<iframe width="${this.args.width}" height="${this.args.height}" src="${ROOT}${this.args.dir}/${this.args.file}.html" class="inq-iframe" frameborder="0" allowfullscreen></iframe>`)

    // iframeの高さに合わせて要素の高さを指定
    this.iframe = this.tgt.find('iframe');
    this.iframe.on('load', (e) => {
      try {
        $(e.target).height(0);
        $(e.target).height(e.target.contentWindow.document.documentElement.scrollHeight)
      }
      catch(e) {
      }
    })
    .trigger('load');

    // コールバックがあれば実行
    if ( this.args.callback ) this.args.callback(this);
  }
}


export default includes;
