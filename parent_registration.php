<!-- Config -->
<?php include_once('config/config.php'); ?>

<!-- Header -->
<?php include_once(ROOT_PATH . 'components/header.php'); ?>

<!-- Top Navigation -->
<?php include_once(ROOT_PATH . 'components/topnav.php'); ?>

<!-- Section: Design Block -->
<section class="text-center text-lg-start">
    <style>
        .cascading-right {
            margin-right: -50px;
        }

        @media (max-width: 991.98px) {
            .cascading-right {
                margin-right: 0;
            }
        }
    </style>

    <!-- Jumbotron -->
    <div class="container py-4">
        <div class="row g-0 align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="card cascading-right" style="
            background: hsla(0, 0%, 100%, 0.55);
            backdrop-filter: blur(30px);
            ">
                    <div class="card-body p-5 shadow-5 text-center">
                        <?php
                        if(isset($_SESSION['errors'])){
                            echo '<div class="alert alert-danger" role="alert">Please correct the errors below</div>';
                        }
                        ?>
                        <h2 class="fw-bold">Register your account</h2>
                        <p class="text-secondary">After registering you will be taken to the bus application form.</p>
                        <form action="db/register_parent.php" method="POST">
                            <!-- 2 column grid layout with text inputs for the first and last names -->

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <input required type="text" name="name" id="name" class="form-control" placeholder="John" value="<?php echo $_SESSION['old']['name'] ?? '';?>"/>
                                        <label class="form-label" for="name">First name</label>
                                        <?php
                                        if(isset($_SESSION['errors']['name'])){
                                            echo '<p class="text-danger mb-0">'.$_SESSION['errors']['name'].'</p>';
                                            unset($_SESSION['errors']['name']);
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <input required type="text" name="surname" id="surname" class="form-control" placeholder="Smith" value="<?php echo $_SESSION['old']['surname'] ?? '';?>"/>
                                        <label class="form-label" for="surname">Last name</label>
                                        <?php
                                        if(isset($_SESSION['errors']['surname'])){
                                            echo '<p class="text-danger mb-0">'.$_SESSION['errors']['surname'].'</p>';
                                            unset($_SESSION['errors']['surname']);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Contact number input -->
                            <div class="form-outline mb-4">
                                <div class="form-outline">
                                    <input required type="text" name="phone" id="phone" class="form-control" placeholder="0833780166" value="<?php echo $_SESSION['old']['phone'] ?? '';?>"/>
                                    <label class="form-label" for="phone"><i class="fa-solid fa-phone"></i> Contact Number</label>
                                    <?php
                                    if(isset($_SESSION['errors']['phone'])){
                                        echo '<p class="text-danger mb-0">'.$_SESSION['errors']['phone'].'</p>';
                                        unset($_SESSION['errors']['phone']);
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input required type="email" name="email" id="email" class="form-control" placeholder="john.smith@gmail.com" value="<?php echo $_SESSION['old']['email'] ?? '';?>"/>
                                <label class="form-label" for="email"><i class="fa-solid fa-envelope"></i> Email address</label>
                                <?php
                                if(isset($_SESSION['errors']['email'])){
                                    echo '<p class="text-danger mb-0">'.$_SESSION['errors']['email'].'</p>';
                                    unset($_SESSION['errors']['email']);
                                }
                                ?>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input required type="password" name="password" id="password" class="form-control" placeholder="*********"/>
                                <label class="form-label" for="password"><i class="fa-solid fa-lock"></i> Password</label>
                                <?php
                                if(isset($_SESSION['errors']['password'])){
                                    echo '<p class="text-danger mb-0">'.$_SESSION['errors']['password'].'</p>';
                                    unset($_SESSION['errors']['password']);
                                }
                                ?>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4">
                                Register
                            </button>

                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-5 mb-lg-0">
                <img src="<?php echo BASE_URL; ?>assets/images/bus_animation_01.png" class="w-100 rounded-4 shadow-4"
                     alt="" />
            </div>
        </div>
    </div>
    <!-- Jumbotron -->
</section>
<?php include_once(ROOT_PATH . 'components/footer.php');
unset($_SESSION['errors']);
?>

