<!-- Config -->
<?php include_once('../config/config.php'); ?>

<!-- Header -->
<?php include_once(ROOT_PATH . 'components/header.php'); ?>

<!-- Security -->
<?php
if (!isset($_SESSION['user_id'], $_SESSION['user_type'])) {
    header('Location:' . BASE_URL);
    exit();
}
if ($_SESSION['user_type'] !== 'admin') {
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
        <p class="fs-4 text-secondary">Total learners on each bus.</p>
    </div>
</div>
<!-- total learners -->
<div class="row justify-content-center mt-3 mb-4 pt-3">
    <div class="col-md-12 col-lg-8 px-4 col-sm-12">
        <button type="button" class="btn btn-primary mb-2" onclick="refreshTable();"><i class="fa-solid fa-arrows-rotate"></i> Refresh Total Learners</button>
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="card-title" id="date"></h4>
            </div>
            <div class="card-body">
                <table id="weekly-report" class="table table table-responsive w-100">
                    <thead>
                    <tr class="select-filter">
                        <td>
                            <select class="form-control form-select">
                                <option value="">Route</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Bus Number</th>
                        <th>Total Morning</th>
                        <th>Total Afternoon</th>
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
<script src="<?php echo BASE_URL; ?>assets/custom/total_learners.js"></script>
<?php include_once(ROOT_PATH . 'components/footer.php'); ?>