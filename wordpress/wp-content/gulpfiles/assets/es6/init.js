import UA from './_general/getUserAgent';

// タブレット時のviewportを固定
if (UA.TAB) document.querySelectorAll('meta[name=viewport]')[0].content = 'width=1024';

// 現在のデバイスから有効無効を判別
const live = UA.SP ? 'sp' : 'pc';
const kill = UA.SP ? 'pc' : 'sp';

const liveTgt = document.querySelectorAll(`#style-${live}`)[0];
const killTgt = document.querySelectorAll(`#style-${kill}`)[0];

// 有効スタイルのmediaをall
liveTgt.media = 'all';

killTgt.parentNode.removeChild(killTgt);
