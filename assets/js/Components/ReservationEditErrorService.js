class ReservationEditErrorService {
    /**
     * @param {ReservationEditMapper} mapper
     */
    constructor(mapper) {
        this.mapper = mapper;
    }

    renderErrors(errors) {
        for (let field in errors) {
            let input = $(`[name="${field}"]`);
            let errorEl = input.next('.invalid-feedback');

            errorEl.text(errors[field]);
            errorEl.show();
        }
    }

    resetErrors() {
        let inputs = $('input, textarea', this.mapper.form);

        for(let i = 0; i < inputs.length; i++) {
            let errorEl = $(inputs[i]).next('.invalid-feedback');
            errorEl.hide();
        }
    }
}

export default ReservationEditErrorService;