"use strict";
let url = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1];
if (window.addEventListener) {
    window.addEventListener("load", setup, false);
} else if (window.attachEvent) {
    window.attachEvent("onload", setup);
}
function setup(){
    let seatInfo = fetchAvailableSeats();
    dataTable(seatInfo);
}

function refreshTable() {
    let seatInfo = fetchAvailableSeats();
    $('#bus-report').DataTable().clear().rows.add(seatInfo).draw();
}

function dataTable(seatInfo) {
    let table = $('#bus-report').DataTable({
        responsive: true,
        ordering: true,
        dom: 'lrtip',
        columnDefs: [
            //add class
            {className: 'text-center', targets: [0, 1, 2, 3, 4, 5]},
        ],
        data: seatInfo,
        columns: [
            {data: 'BusRouteID'},
            {data: 'SeatLimit'},
            {data: 'SeatsForPickup'},
            {data: 'SeatsForDropOff'},
            {
                data: 'PickupUtilization',
                render: function (data, type, row) {
                    return data + ' %';
                }
            },
            {
                data: 'DropOffUtilization',
                render: function (data, type, row) {
                    return data + ' %';
                }
            },
        ],
    });


    $('#bus-report thead tr.select-filter select').on('change', function () {
        let colIdx = $(this).parent().index();
        table
            .column(colIdx)
            .search($(this).val())
            .draw();
    });
}

function fetchAvailableSeats(){
    let seatInfo;
    $.ajax({
        url: url +'/db/mis/bus_utilization.php',
        type: 'GET',
        dataType: 'json',
        async: false,
        success: function (data) {
            seatInfo = data['data'];
        },
        error: function (error) {
            console.log(error);
        }
    });
    return seatInfo;
}
