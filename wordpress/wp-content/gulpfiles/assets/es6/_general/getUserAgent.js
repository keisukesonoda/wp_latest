const ua = window.navigator.userAgent.toLowerCase();

const UA = {
  TAB: ua.indexOf('windows') !== -1 && ua.indexOf('touch') !== -1 ||
       ua.indexOf('android') !== -1 && ua.indexOf('mobile') === -1 ||
       ua.indexOf('firefox') !== -1 && ua.indexOf('tablet') !== -1 ||
       ua.indexOf('ipad') !== -1 ||
       ua.indexOf('kindle') !== -1 ||
       ua.indexOf('silk') !== -1 ||
       ua.indexOf('playbook') !== -1,
  SP: ua.indexOf('windows') !== -1 && ua.indexOf('phone') !== -1 ||
      ua.indexOf('android') !== -1 && ua.indexOf('mobile') !== -1 ||
      ua.indexOf('firefox') !== -1 && ua.indexOf('mobile') !== -1 ||
      ua.indexOf('iphone') !== -1 ||
      ua.indexOf('ipod') !== -1 ||
      ua.indexOf('blackberry') !== -1 ||
      ua.indexOf('bb') !== -1,
  AD: ua.indexOf('android') !== -1,
  ANDROIDBROWSER: ua.indexOf('android') !== -1 && ua.indexOf('linux; u;') !== -1 && ua.indexOf('chrome') === -1,
  WINDOWS: ua.indexOf('windows') !== -1,
  MAC: ua.indexOf('mac os') !== -1,
  CHROME: ua.indexOf('chrome') !== -1 && ua.indexOf('edge') === -1,
  IE: ua.indexOf('MSIE') !== -1 ||
      ua.indexOf('Trident/') !== -1 ||
      ua.indexOf('Edge') !== -1,
};

export default UA;
