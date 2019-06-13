class ReservationFormMapper {
    constructor() {
        this.form = $('#reservationForm');
        this.email = $('#inputEmail', this.form);
        this.comment = $('#inputComment', this.form);
        this.date = $('#inputDate', this.form);
        this.button = $('#reservationButton', this.form);
    }
}

export default ReservationFormMapper;