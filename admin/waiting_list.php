<!-- Config -->
<?php include_once('../config/config.php');?>

<!-- Header -->
<?php include_once(ROOT_PATH . 'components/header.php'); ?>

<!-- Security -->
<?php
if (!isset($_SESSION['user_id'], $_SESSION['user_type'])) {
    header('Location:' . BASE_URL);
    exit();
}
if ($_SESSION['user_type'] !== 'admin'){
    header('Location:' . BASE_URL);
    exit();
}
?>

<link href="<?php echo BASE_URL; ?>assets/datatables/datatables.min.css" rel="stylesheet">
<script src="<?php echo BASE_URL; ?>assets/datatables/datatables.min.js"></script>

<!-- Top Navigation -->
<?php include_once(ROOT_PATH . 'components/topnav.php'); ?>
<div class="row align-items-center justify-content-center mb-4">
    <div class="col-lg-6 mb-5 mb-lg-0 text-center">
        <h1>MIS Report</h1>
        <p class="fs-4 text-secondary">All learners currently on waiting list.</p>
    </div>
</div>

<!-- Waiting list -->
<div class="row justify-content-center mt-3 mb-4 pt-3">
    <div class="col-md-12 col-lg-8 px-4 col-sm-12">
        <button type="button" class="btn btn-primary mb-2" onclick="refreshTable();"><i class="fa-solid fa-arrows-rotate"></i> Refresh Waiting List</button>
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="card-title">Learners on Waiting List</h4>
            </div>
            <div class="card-body">
                <table id="learner-waiting-report" class="table table-responsive table-striped w-100">
                    <thead>
                    <tr class="select-filter">
                        <td>
                            <input type="text" class="form-control" placeholder="Search Name">
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Search PhoneNumber">
                        </td>
                        <td>
                            <select class="form-control form-select">
                                <option value="">Grade</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Search Date">
                        </td>
                        <td>
                            <select class="form-control form-select">
                                <option value="">Route</option>
                                <option value="1A">1A</option>
                                <option value="1B">1B</option>
                                <option value="2A">2A</option>
                                <option value="2B">2B</option>
                                <option value="3A">3A</option>
                                <option value="3B">3B</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="align-middle">Full Name</th>
                        <th class="align-middle">PhoneNumber</th>
                        <th class="text-center align-middle">Grade</th>
                        <th class="align-middle">Date Registered</th>
                        <th class="text-center align-middle">Bus and type</th>
                        <th class="text-center align-middle">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="text-center mt-2">
    <a class="btn btn-outline-primary" href="dashboard.php">Back to dashboard</a>
    </div>
</div>


<script src="<?php echo BASE_URL; ?>assets/custom/waiting_list.js"></script>
<?php include_once(ROOT_PATH . 'components/footer.php'); ?>
