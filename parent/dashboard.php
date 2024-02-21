<!-- Config -->
<?php include_once('../config/config.php'); ?>

<!-- Header -->
<?php include_once(ROOT_PATH . 'components/header.php'); ?>

<!-- Top Navigation -->
<?php include_once(ROOT_PATH . 'components/topnav.php'); ?>

<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: '. BASE_URL);
    exit();
}
if ($_SESSION['user_type'] !== 'parent') {
    header('Location: '. BASE_URL);
    exit();
}

include_once(ROOT_PATH . 'db/db_parent_dashboard.php');
?>
<div class="container py-4">
    <div class="row align-items-center justify-content-center mb-4">
        <div class="col-lg-6 mb-5 mb-lg-0 text-center">
            <h1>Parent Dashboard</h1>
            <p class="fs-3">Welcome, <?php echo $_SESSION['user_name'] . ' ' . $_SESSION['user_surname']; ?>.</p>
            <!-- success message -->
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

        </div>
    </div>
    <h1 class="text-center">Student(s) Application Status</h1>
    <?php
    $learnerArr = getStudentData($_SESSION['user_id']);
    $count = 1;
    if (count($learnerArr) == 0) {
        ?>
        <div class="text-center">
            <p class="fs-4">Did you apply for bus transport?</p>
            <a href="<?php echo(BASE_URL . 'student_application.php') ?>" class="btn btn-outline-primary">Apply Here <i
                        class="fa-solid fa-arrow-pointer"></i></a>
        </div>
        <?php
    }
    ?>
    <div class="d-flex flex-wrap justify-content-center align-content-center">
        <?php
        foreach ($learnerArr as $learner) {
            ?>

            <div class="card p-2 m-2" style="flex-basis: 420px;">
                <div class="card-body">

                    <p class="text-secondary text-center fs-4">Student <?php echo $count;
                        $count++; ?></p>
                    <div class="d-flex justify-content-evenly">

                        <div class="pe-2">
                            <p><i class="fa-solid fa-user"></i> Full Names</p>
                            <p><i class="fa-solid fa-graduation-cap"></i> Grade</p>
                            <p><i class="fa-solid fa-phone"></i> Contact</p>
                            <p><i class="fa-solid fa-bus"></i> Bus route morning</p>
                            <p><i class="fa-solid fa-bus"></i> Bus route afternoon</p>
                        </div>
                        <?php
                        echo '<div>';
                        echo '<p>' . $learner['Name'] . ' ' . $learner['Surname'] . '</p>';
                        echo '<p>' . $learner['Grade'] . '</p>';
                        echo '<p>' . $learner['PhoneNumber'] . '</p>';
                        if (isset($learner['PickupID']) || isset($learner['PickupWaitingList'])) {
                            echo '<p>' . ($learner['PickupID'] ?? ('On Waiting list for route: ' . $learner['PickupWaitingList'])) . '</p>';
                        }else {
                            echo '<p>None</p>';
                        }

                        if (isset($learner['DropOffID']) || isset($learner['DropOffWaitingList'])) {
                            echo '<p>' . ($learner['DropOffID'] ?? ('On Waiting list for route: ' . $learner['DropOffWaitingList'])) . '</p>';
                        }
                        else {
                            echo '<p>None</p>';
                        }
                        echo '</div>';
                        ?>

                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<?php include_once(ROOT_PATH . 'components/footer.php');