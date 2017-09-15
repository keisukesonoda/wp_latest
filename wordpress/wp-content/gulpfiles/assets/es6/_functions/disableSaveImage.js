class disableSaveImage {
  constructor(args) {
    this.args = args;
  }

  action() {
    this.args.tgt.on({
      mousedown: (e) => {
        e.preventDefault();
        return false;
      },
      contextmenu: (e) => {
        e.preventDefault();
        return false;
      },
      selectstart: (e) => {
        e.preventDefault();
        return false;
      },
      copy: (e) => {
        e.preventDefault();
        return false;
      },
    });
  }
}


export default disableSaveImage;
