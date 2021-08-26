document.addEventListener("DOMContentLoaded", function(event) {

    /* Date & Time Pickers */
    flatpickr(".datetime-picker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true
    });

    flatpickr(".date-picker", {
        dateFormat: "Y-m-d"
    });

    flatpickr(".time-picker", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    /*  Sidebar Toggle */
    let button = document.getElementById(`menu-toggle`);
    button.onclick = function (event) {
        let menu = document.getElementById(`wrapper`);
        menu.classList.toggle(`toggled`);
    }

    /* Bootstrap JS */
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    var alertList = document.querySelectorAll('.alert')
    alertList.forEach(function (alert) {
        new bootstrap.Alert(alert)
    });

});
