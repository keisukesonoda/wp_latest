import UA from '../_init/userAgent';

class youtubeAPI {
  constructor(args) {
    this.args = args;
  }

  init() {
    let elm = `
      <div class="${this.args.params.name}-area">
        <div class="yt-wrap">
          <div id="${this.args.params.name}" class="${this.args.params.name}"></div>
        </div>
      </div>
    `;
    $(this.args.params.to).prepend(elm);
  }


  insertScriptTag() {
    let tags = document.getElementsByTagName('script');
    let tag  = document.createElement('script');
    let len  = tags.length;
    let last = tags[len-1];
    tag.src = 'https://www.youtube.com/iframe_api';
    last.parentNode.insertBefore(tag, last);
  }


  checkLoadedAPI() {
    // YTオブジェクトが生成されていればplayerを生成
    let interval;
    let checkYT = () => {
      if ( YT ) {
        clearInterval(interval);
        this.getMovie();
      }
    }

    setTimeout( () => {
      interval = setInterval(checkYT, 300);
    }, 300);
  }


  getMovie() {
    this.player = new YT.Player(this.args.params.name, {
    width: this.args.params.width,
    height: this.args.params.height,
    videoId: this.args.params.id,
    events: {
      onReady: this.onPlayerReady,
      onStateChange: this.onPlayerStateChange,
      // onPlaybackQualityChange: this.onPlaybackQualityChange,
    },
    playerVars: this.args.vars,
    });
  }


  /**
   * 各動画毎の設定
   */
  mainvisual() {
    this.init();
    this.insertScriptTag();
    this.checkLoadedAPI();

    this.onPlayerReady = (event) => {
      // ループ再生を指定するとループ時の画質が落ちる
      this.player.setPlaybackQuality('highres')
                 // .setLoop({loopPlaylists: true})
                 .mute()
                 .playVideo();
    }

    this.onPlayerStateChange = (event) => {
      // ステートでループ再生をコントロール
      if ( event.data == 0 ) {
        this.player.setPlaybackQuality('highres')
                   .mute()
                   .playVideo()
      }
    }

    this.onPlaybackQualityChange = (event) => {
      this.player.setPlaybackQuality('highres');
    }

    this.stopVideo = () => {
      this.player.stopVideo();
    }
  }

}

export default youtubeAPI;

