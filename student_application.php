<!-- Config -->
<?php include_once('config/config.php'); ?>

<!-- Header -->
<?php include_once(ROOT_PATH . 'components/header.php'); ?>

<!-- Top Navigation -->
<?php include_once(ROOT_PATH . 'components/topnav.php'); ?>

<?php
if (!isset($_SESSION['user_id'])){
    header('Location: index.php');
    exit();
} ?>

<div class="container py-4">
    <div class="row g-0 align-items-center justify-content-center card p-4 shadow">
        <div class="col-lg-6 mb-5 mb-lg-0">
            <p class="text-secondary"></p>
            <?php
            if(isset($_SESSION['errors'])){
                echo '<div class="alert alert-danger" role="alert">Please correct the errors below</div>';
            }
            ?>
            <form action="db/register_student.php" method="POST">
                <h1 class="text-center">Student bus application 2024</h1>
                <h2 class="text-secondary text-center">Student personal details:</h2>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="form-outline">
                            <input required type="text" name="name" id="name" class="form-control" placeholder="John"
                                   value="<?php echo $_SESSION['old']['name'] ?? ''; ?>"/>
                            <label class="form-label" for="name">
                                <i class="fa-solid fa-id-card"></i>
                                First name</label>
                            <?php
                            if (isset($_SESSION['errors']['name'])) {
                                echo '<p class="text-danger mb-0">' . $_SESSION['errors']['name'] . '</p>';
                                unset($_SESSION['errors']['name']);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="form-outline">
                            <input required type="text" name="surname" id="surname" class="form-control"
                                   placeholder="Smith" value="<?php echo $_SESSION['old']['surname'] ?? ''; ?>"/>
                            <label class="form-label" for="surname">
                                <i class="fa-solid fa-id-card"></i>
                                Last name</label>
                            <?php
                            if (isset($_SESSION['errors']['surname'])) {
                                echo '<p class="text-danger mb-0">' . $_SESSION['errors']['surname'] . '</p>';
                                unset($_SESSION['errors']['surname']);
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- Contact number input -->
                <div class="form-outline mb-4">
                    <div class="form-outline">
                        <input required type="text" name="phone" id="phone" class="form-control"
                               placeholder="0833780166" value="<?php echo $_SESSION['old']['phone'] ?? ''; ?>"/>
                        <label class="form-label" for="phone"><i class="fa-solid fa-phone"></i> Contact Number</label>
                        <?php
                        if (isset($_SESSION['errors']['phone'])) {
                            echo '<p class="text-danger mb-0">' . $_SESSION['errors']['phone'] . '</p>';
                            unset($_SESSION['errors']['phone']);
                        }
                        ?>
                    </div>
                </div>

                <!-- Grade in 2024 -->
                <div class="form-outline mb-4">
                    <div class="form-outline">
                        <!-- options from grade 8 - 12 -->
                        <select class="form-select"  name="grade" id="grade" required>
                            <option value="" disabled selected>Choose grade in 2024</option>
                            <option value="8">Grade 8</option>
                            <option value="9">Grade 9</option>
                            <option value="10">Grade 10</option>
                            <option value="11">Grade 11</option>
                            <option value="12">Grade 12</option>
                        </select>
                        <label class="form-label" for="grade"><i class="fa-solid fa-graduation-cap"></i> Grade in
                            2024</label>
                        <?php
                        if (isset($_SESSION['errors']['grade'])) {
                            echo '<p class="text-danger mb-0">' . $_SESSION['errors']['grade'] . '</p>';
                            unset($_SESSION['errors']['grade']);
                        }
                        ?>
                    </div>
                </div>

                <!-- Bus Route Morning -->
                <h2 class="text-secondary text-center">Choose bus routes:</h2>
                <?php
                include_once (ROOT_PATH . 'db/db_functions.php');
                include_once (ROOT_PATH . 'db/dbconn.php');
                $busMorningInfo = getMorningBusRoutes();
                $busAfternoonInfo = getAfternoonBusRoutes();
                ?>
                <div class="form-outline mb-4">
                    <div class="form-outline">
                        <!-- select input with foreach bus route -->
                        <select required class="form-select" name="bus_route_morning" id="bus_route_morning">
                            <option value="" disabled selected>Choose your bus route in the morning</option>
                            <option value="none" style="color: #dc3545; !important;">None (Student does not need to be picked up)</option>
                            <?php
                            foreach ($busMorningInfo as $busMorning) {
                                echo '<option value="' . $busMorning['BusStopID'] . '">' . $busMorning['BusStopID']. ' '. $busMorning['LocationName'] . ' - Time: '. $busMorning['Time'] .'</option>';
                            }
                            ?>
                        </select>
                        <label class="form-label" for="grade">
                            <i class="fa-solid fa-bus-simple"></i>
                            Bus Route Morning</label>
                        </label>
                    </div>
                </div>

                <!-- Bus Route Afternoon -->
                <div class="form-outline mb-4">
                    <div class="form-outline">
                        <!-- select input with foreach bus route -->
                        <select required class="form-select" name="bus_route_afternoon" id="bus_route_afternoon">
                            <option value="" disabled selected>Choose your bus route in the afternoon</option>
                            <option value="none" style="color: #dc3545; !important;">None (Student does not need to be dropped-off)</option>
                            <?php
                            foreach ($busAfternoonInfo as $busAfternoon) {
                                echo '<option value="' . $busAfternoon['BusStopID'] . '">' . $busAfternoon['BusStopID']. ' '. $busAfternoon['LocationName'] . ' - Time: '. $busAfternoon['Time'] .'</option>';
                            }
                            ?>
                        </select>
                        <label class="form-label" for="grade">
                            <i class="fa-solid fa-bus-simple"></i>
                            Bus Route afternoon</label>
                        </label>
                    </div>
                </div>


                <!-- Submit button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block mb-4 ">
                        Submit Application
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<?php include_once(ROOT_PATH . 'components/footer.php');
unset($_SESSION['old']);
?>