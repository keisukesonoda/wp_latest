import ROOTPATH from '../_general/getRootPath';

class ajaxReadMore {
  constructor(args) {
    this.args = args;
  }

  init() {
    this.data = {
      start: this.args.start,
      max: '',
      flg: true,
    };

    this.action();
  }

  action() {
    $(this.args.trigger).on('click', (e) => {
      e.preventDefault();

      if (this.data.flg) {
        this.args.loader.addClass('isView');

        setTimeout(() => {
          this.ajaxCommunicate();
        }, 500);
      }
    });
  }

  ajaxCommunicate() {
    $.ajax({
      url: `${ROOTPATH}${this.args.dirName}/${this.args.fileName}.json`,
      dataType: 'json',
    })
    .done((res) => {
      // max値の設定
      if (!this.data.max) this.data.max = res.length;
      // htmlへの埋め込み
      for (let i = 0; i < this.args.unit; i += 1) {
        const news = res[this.data.start + i];

        if (news) {
          const date = news.date ? news.date : '';
          const title = news.title ? news.title : '';
          const link = news.link ? `href="${news.link}"` : '';
          $(this.args.target).append(`
            <li>
              <a ${link} target="${news.target}">
                <dl>
                  <dt class="date">${date}</dt>
                  <dd class="title">${title}</dd>
                </dl>
              </a>
            </li>
          `);
        }
      }

      // 次回の開始位置を指定
      this.data.start = this.data.start + this.args.unit;
      // loader非表示
      this.args.loader.removeClass('isView');
      // 最終まで達した際の処理
      if (this.data.start >= this.data.max) {
        this.data.flg = false;
        this.args.wrap.fadeTo('fast', 0).find('a').css('cursor', 'default');
      }
    })
    .fail((jqXHR, textStatus, errorThrown) => {
      console.log('ファイルの読み込みに失敗しました', errorThrown);
    });
  }
}

export default ajaxReadMore;
