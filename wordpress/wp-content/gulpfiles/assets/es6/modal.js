import ModalClass from './_classes/modalClass';

class GoodsModalClass extends ModalClass {
  constructor(args) {
    super(args);
  }

  init() {
    this.openAction();
  }

  openAction() {
    this.args.trg.on('click', (e) => {
      e.preventDefault();
      super.disableScroll();
      super.open(this.args.content);
      this.closeAction();
    });
  }

  closeAction() {
    const trgs = [this.elms.overlay, this.elms.close];
    $.each(trgs, (i, trg) => {
      $(trg).on('click', (e) => {
        e.preventDefault();
        super.close();
        super.enableScroll();
        $(trg).off('click');
      });
    });
  }
}

const goodsModal = () => {
  const $trgs = $('.cm-modal-trg');

  $trgs.each((i, trg) => {
    const args = {
      trg: $(trg),
      content: $(trg),
    };
    const Modal = new GoodsModalClass(args);
    Modal.init();
  });
};
