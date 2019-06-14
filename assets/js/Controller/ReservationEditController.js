import ReservationFormMapper from "../Mapper/ReservationFormMapper";
import ReservationEditErrorService from "../Components/ReservationEditErrorService";

class ReservationEditController {

    constructor() {
        this.mapper = new ReservationFormMapper();
        this.errorService = new ReservationEditErrorService(this.mapper);

        this.registerEvents();
    }

    sendReservation() {
        const form = this.mapper.form.serializeArray();
        const code = this.mapper.code.val();
        let url = '/api/reservation/add';

        this.errorService.resetErrors();

        if (code) {
            url = `/api/reservation/edit/${code}`;
        }

        $.post(url, form)
            .then(response => {
                console.log(response);
            })
            .fail(error => {
                let errors = error.responseJSON;

                this.errorService.renderErrors(errors);
            })
    }

    registerEvents() {
        this.mapper.button.on('click', e => {
            this.sendReservation();
        });
    }
}

export default ReservationEditController;