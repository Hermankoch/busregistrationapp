"use strict";
let url = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1];
if (window.addEventListener) {
    window.addEventListener("load", setup, false);
} else if (window.attachEvent) {
    window.attachEvent("onload", setup);
}
function setup(){
    let waitingList = fetchWaitingList();
    dataTable(waitingList);
}

function refreshTable() {
    let waitingList = fetchWaitingList();
    $('#learner-waiting-report').DataTable().clear().rows.add(waitingList).draw();
}

function fetchWaitingList() {
    let waitingList;
    $.ajax({
        url: url + '/db/mis/waiting_list.php',
        type: 'GET',
        dataType: 'json',
        async: false,
        success: function (data) {
            waitingList = data['data'];
        },
        error: function (error) {
           console.log(error);
        }
    });
    return waitingList;
}


function dataTable(waitingList) {
    let table = $('#learner-waiting-report').DataTable({
        responsive: true,
        ordering: true,
        dom: 'lrtip',
        columnDefs: [
            //add class
            {className: 'text-center', targets: [ 2, 4, 5]},
        ],
        order: [
            3, 'asc'
        ],
        data: waitingList,
        columns: [
            {
                data: 'Name',
                render: function (data, type, row) {
                    return row.Name + ' ' + row.Surname;
                }
            },
            {data: 'PhoneNumber'},
            {data: 'Grade'},
            {data: 'ListDate'},
            {
                data: 'BusStopID',
                render: function (data, type, row) {
                    return row.BusStopID + ' ' + row.PickupOrDropOff;
                }
            },
            {
                defaultContent: 'Static content',
                render: function (data, type, row) {
                    return '<button class="btn btn-warning btn-sm move"><i class="fa-solid fa-user-minus"></i></button>';
                }
            },
        ],
    });

    $('#learner-waiting-report tbody').on('click', '.move', function () {
        let rowData = table.row($(this).closest('tr')).data();
        let confirmMove = confirm('Are you sure you want to move \n' + rowData.Name + ' ' + rowData.Surname + ' to the bus route ' + rowData.BusStopID + ' for ' + rowData.PickupOrDropOff);
        if (confirmMove) {
            moveLearner(rowData);
        }
    });

    // Apply search on input keyup
    $('#learner-waiting-report thead tr.select-filter input').on('keyup', function() {
        let colIdx = $(this).parent().index();
        table
            .column(colIdx)
            .search(this.value)
            .draw();
    });

    // Apply search on select change
    $('#learner-waiting-report thead tr.select-filter select').on('change', function() {
        let colIdx = $(this).parent().index();
        table
            .column(colIdx)
            .search($(this).val())
            .draw();
    });
}

function moveLearner(rowData){
    $.ajax({
        url: 'http://localhost/onlinebusregistration/db/mis/move_learner.php',
        type: 'POST',
        dataType: 'json',
        data: JSON.stringify(rowData),
        success: function (data) {
            alert(data['message']);
        },
        error: function(error) {
            console.log(error['responseText']);
        }
    });
}