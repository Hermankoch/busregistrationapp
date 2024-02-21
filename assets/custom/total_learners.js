"use strict";
let url = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1];
if (window.addEventListener) {
    window.addEventListener("load", setup, false);
} else if (window.attachEvent) {
    window.attachEvent("onload", setup);
}
function setup(){
    let waitingList = fetchTotalLearners();
    dataTable(waitingList);
    updateTitle();
    updateDate();
}

function updateTitle() {
    let title = $('h4 .title');
    title.innerHTML = 'Total Learners';
}

function refreshTable() {
    let waitingList = fetchTotalLearners();
    $('#learner-waiting-report').DataTable().clear().rows.add(waitingList).draw();
    updateDate();
}
function updateDate() {
    let date = document.getElementById('date');
    let now = new Date();
    // Get date for the current week monday - friday
    let monday = new Date();
    monday.setDate(monday.getDate() - monday.getDay() + 1);
    let friday = new Date();
    friday.setDate(friday.getDate() - friday.getDay() + 5);
    date.textContent = 'Total learners on each bus for Mon ' + monday.getDate() + '/' + (monday.getMonth() + 1) + '/' + monday.getFullYear() + ' - ' + 'Fri ' + friday.getDate() + '/' + (friday.getMonth() + 1) + '/' + friday.getFullYear();
}


function fetchTotalLearners() {
    let totalLearners;
    $.ajax({
        url: url + '/db/mis/total_learners.php',
        type: 'GET',
        dataType: 'json',
        async: false,
        success: function (data) {
            totalLearners = data['data'];
        },
        error: function (error) {
           console.log(error);
        }
    });
    return totalLearners;
}

function dataTable(totalLearners){
    let table = $('#weekly-report').DataTable({
        responsive: true,
        ordering: true,
        dom: 'lrtip',
        columnDefs: [
            {className: 'text-center', targets: [ 1, 2]},
        ],
        data: totalLearners,
        columns: [
            {data: 'BusRouteID'},
            {data: 'MorningTotalLearners'},
            {data: 'AfternoonTotalLearners'},
        ],
    });
    // Apply search on select change
    $('#weekly-report thead tr.select-filter select').on('change', function() {
        let colIdx = $(this).parent().index();
        table
            .column(colIdx)
            .search($(this).val())
            .draw();
    });
}
