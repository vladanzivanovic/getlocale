import ReservationFormMapper from "../Mapper/ReservationFormMapper";
import ReservationEditErrorService from "../Components/ReservationEditErrorService";

class ReservationEditController {

    constructor() {
        this.mapper = new ReservationFormMapper();
        this.errorService = new ReservationEditErrorService(this.mapper);

        this.registerEvents();
    }

    addReservation() {
        let form = this.mapper.form.serializeArray();
        this.errorService.resetErrors();

        $.post('/api/reservation/add', form)
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
            this.addReservation();
        });
    }
}

export default ReservationEditController;