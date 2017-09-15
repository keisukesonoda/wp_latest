class hoverZoom {
  constructor(args) {
    this.args = args;
  }

  init() {
    if ( this.args.tgt.length === 0 ) return;

    this.params = {
      tgtClass: this.args.tgt.attr('class').split(' ')[0],
    };

    this.action();
  }

  action() {
    this.args.tgt.on({
      mouseenter: (e) => {
        this.getCorrectTarget(this.args.tgt, e.target);
        this.crctTgt.addClass('js-zoom');
      },
      mouseleave: (e) => {
        this.crctTgt.removeClass('js-zoom');
      },
    });
  }

  getCorrectTarget(tgt, eventTarget) {
    let tgtClass = tgt.attr('class').split(' ')[0];
    this.crctTgt = $(eventTarget).hasClass(tgtClass) ?
                   $(eventTarget) :
                   $(eventTarget).parents(`.${this.params.tgtClass}`);
  }
}

export default hoverZoom;
