"use strict";
//let url = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1];
let url = window.location.protocol + "//" + window.location.host + "/";

if (window.addEventListener) {
    window.addEventListener("load", setup, false);
} else if (window.attachEvent) {
    window.attachEvent("onload", setup);
}
async function setup() {
    try {
        let learners = await fetchLearners();
        dataTable(learners); // This will now wait for fetchLearners to complete
    } catch (error) {
        console.error('Setup Error:', error);
        // Handle setup errors, possibly update UI to inform the user
    }
}

function pad(number) {
    return number < 10 ? '0' + number : number;
}

async function refreshTable() {
    let learners = await fetchLearners();
    $('#learner-report').DataTable().clear().rows.add(learners).draw();
    let date = document.getElementById('date');
    let now = new Date();
    date.textContent = 'Learners currently on each bus for ' +
        pad(now.getDate()) + '/' +
        pad(now.getMonth() + 1) + '/' +
        now.getFullYear() + ' ' +
        pad(now.getHours()) + ':' +
        pad(now.getMinutes());
}

function dataTable(learners) {
    let table = $('#learner-report').DataTable({
        responsive: true,
        data: learners,
        dom: 'lrtip',
        ordering: true,
        order: [0, 'asc'],
        columnDefs: [
            //add class
            {className: 'text-center', targets: [ 2, 3, 4, 5, 6]},
            ],
        columns: [
            {
                data: 'Name',
                render: function (data, type, row) {
                    return row.Name + ' ' + row.Surname;
                }
            },
            {data: 'PhoneNumber'},
            {data: 'Grade'},
            {data: 'PickupID'},
            {
                defaultContent: 'Static content',
                render: function (data, type, row) {
                    if (row.PickupID !== null) {
                        return '<button class="btn btn-danger btn-sm del-bus-morning"><i class="fa-solid fa-trash"></i></button>';
                    }
                    return '';
                }
            },
            {data: 'DropOffID'},
            {
                defaultContent: 'Static content',
                render: function (data, type, row) {
                    if (row.DropOffID !== null) {
                        return '<button class="btn btn-danger btn-sm del-bus-afternoon"><i class="fa-solid fa-trash"></i></button>';
                    }
                    return '';
                }
            },

        ],
    });

    // Delete learner from morning bus route
    $('#learner-report tbody').on('click', '.del-bus-morning', function (event) {
        let rowData = table.row($(this).closest('tr')).data();
        let confirmMove = confirm('Are you sure you want to remove the learner  \n' + rowData.Name + ' ' + rowData.Surname  + ' from the morning bus '+ rowData.PickupID);
        if (confirmMove) {
            removeLearnerRoute(rowData.LearnerID, 'PickupID', rowData.PickupID);
        }
    });

    // Delete learner from afternoon bus route
    $('#learner-report tbody').on('click', '.del-bus-afternoon', function () {
        let rowData = table.row($(this).closest('tr')).data();
        let confirmMove = confirm('Are you sure you want to remove the learner  \n' + rowData.Name + ' ' + rowData.Surname  + ' from the afternoon bus '+ rowData.DropOffID);
        if (confirmMove) {
            removeLearnerRoute(rowData.LearnerID, 'DropOffID', rowData.DropOffID);
        }
    });

    // Apply search on input keyup
    $('#learner-report thead tr.select-filter input').on('keyup', function() {
        let colIdx = $(this).parent().index();
        table
            .column(colIdx)
            .search(this.value)
            .draw();
    });

    // Apply search on select change
    $('#learner-report thead tr.select-filter select').on('change', function() {
        let colIdx = $(this).parent().index();
        table
            .column(colIdx)
            .search($(this).val())
            .draw();
    });
}
async function fetchLearners() {
    return $.ajax({
        url: url + 'db/mis/bus_learners.php',
        cache: false,
        type: 'GET',
        dataType: 'json', // Specifies expected response datatype
        headers: {
            "Accept": "application/json", // Explicitly define Accept header
        }
    }).then(data => {
        return data['data']; // Resolve the promise with the data for learners
    }).fail((jqXHR, textStatus, errorThrown) => {
        console.log("AJAX Error:", textStatus, errorThrown);
        throw new Error('Failed to fetch learners'); // Reject the promise if there's an error
    });
}


function removeLearnerRoute(learnerId, column, busStopId) {
    $.ajax({
        url: url +'/db/mis/remove_learner.php',
        type: 'POST',
        data: JSON.stringify({
            'LearnerID':learnerId,
            //PickupID or DropOffID for learners table
            //convert to SeatsForPickup or SeatsForDropOff for availableseats table
            'column': column,
            'BusStopID': busStopId,
        }),
        dataType: 'json',
        headers: {
            "Accept": "application/json", // Explicitly define Accept header
        },
        async: false,
        success: function (data) {
            alert(data['message']);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

