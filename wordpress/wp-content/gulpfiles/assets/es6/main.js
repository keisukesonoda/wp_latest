import UA from './_general/getUserAgent';
import Includes from './_classes/includeClass';

/**
 * tablet viewport
 */
const changeViewport = () => {
  if (!UA.TAB) return;
  document.querySelectorAll('meta[name=viewport]')[0].content = 'width=900';
};


/**
 * ajaxIncludes
 */
const ajaxIncludes = () => {
  const includeFiles = ['header', 'footer'];
  let i = 0;
  const len = includeFiles.length;

  for (i; i < len; i += 1) {
    const file = includeFiles[i];
    const args = {
      dir: 'inq',
      fileName: file,
      selecter: `#${file}`,
      callback: (_this) => {
        if (file === 'header') {
          // header読み込み後のコールバック
        } else if (file === 'footer') {
          // footer読み込み後のコールバック
        }
      },
    };

    const inq = new Includes(args);
    inq.ajax();
  }
};


$(document).on('ready', () => {
  changeViewport();
  // ajaxIncludes();
});
