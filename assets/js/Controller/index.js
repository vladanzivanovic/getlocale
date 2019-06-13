import ReservationEdit from "./ReservationEditController";

let routes = [
    {
        name: 'reservation_edit',
        path: '/dashboard/reservation/new',
        controller: ReservationEdit,
    },
];

$(document).ready(() => {
    let route = matchRoute();
    // let core = new CoreController();

    // core.showFlashMsg();
    if (route) {
        new route.controller();
    }
});

let matchRoute = () => {
    for(let i in routes) {
        let currentUrl = location.pathname.split('/');
        let route = routes[i];
        let path = route.path.split('/');

        for (let p in path) {
            let item = path[p];

            if (item.charAt(0) == ':') {
                currentUrl.splice(p, 1, item);
            }
        }

        if (currentUrl.join('/') == path.join('/')) {
            return route;
        }
    }
}