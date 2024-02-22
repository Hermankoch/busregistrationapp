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

<!-- links to all pages -->
<div class="container py-4">
<div class="row align-items-center justify-content-center mb-4">
    <div class="col-lg-6 mb-5 mb-lg-0 text-center">
        <h1>Admin Dashboard</h1>
        <p class="fs-3">Welcome, <?php echo $_SESSION['user_initials'] . ' ' . $_SESSION['user_surname']; ?>.</p>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <i class="fa-solid fa-check"></i>
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php }
        if (isset($_SESSION['info'])) {
            ?>
            <div class="alert alert-info" role="alert">
                <i class="fa-solid fa-info"></i>
                <?php
                foreach ($_SESSION['info'] as $info) {
                    echo $info . '<br>';
                }
                unset($_SESSION['info']);
                ?>
            </div>
            <?php
        }
        ?>
        <p class="fs-4 text-secondary">Visit the MIS Reports below <br>or the learner application form.</p>
    </div>

    <div class="d-sm-block d-md-flex justify-content-center align-content-center text-center">
        <a class="btn btn-primary m-2" href="waiting_list.php">Waiting List</a>
        <a class="btn btn-primary m-2" href="bus_learners.php">Learners on Bus</a>
        <a class="btn btn-primary m-2" href="total_learners.php">Total Learners per Bus</a>
        <a class="btn btn-primary m-2" href="bus_utilization.php">Bus Utilization</a>

    </div>

    <div class="d-flex justify-content-center align-content-center mt-4">

        <a class="btn btn-primary mx-2" href="<?php echo BASE_URL . 'student_application.php'?>">Learner Application</a>
    </div>
</div>
<?php include_once(ROOT_PATH . 'components/footer.php'); ?>



