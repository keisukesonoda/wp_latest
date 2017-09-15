const obj = {};
const style = document.querySelectorAll('link');

let curPath = location.href.replace(/[?|#].*$/, '');
if (!/\/$/.test(curPath)) {
  curPath = curPath.slice(0, curPath.lastIndexOf('/') + 1);
}

let i = style.length;
while (i) {
  i -= 1;
  const matchs = [
    style[i].href.match(/(^|.*\/)style\.css$/),
    style[i].href.match(/(^|.*\/)style\.min\.css$/),
    style[i].href.match(/(^|.*\/)style\.sp\.css$/),
    style[i].href.match(/(^|.*\/)style\.sp\.min\.css$/),
  ];

  matchs.some((match) => {
    let rootPath;

    if (match !== null) {
      rootPath = match[1];

      if (rootPath.substr(0, 1) === '/') {
        rootPath = `${location.protocol}//${location.host}${rootPath}`;
      } else if (rootPath.substr(0, 4) !== 'http') {
        rootPath = `${curPath}${rootPath}`;
      // } else if (rootPath.substr(0, 4) === 'file') {
      //   rootPath = rootPath;
      }
      obj.path = rootPath.replace('css/', '');
      // .some関数はtrueを返すとループを抜ける
      return true;
    }
    return false;
  });
}

export default obj.path;
