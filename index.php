<!-- Config -->
<?php include_once('config/config.php'); ?>

<!-- Header -->
<?php include_once(ROOT_PATH . 'components/header.php'); ?>

<!-- Top Navigation -->
<?php include_once(ROOT_PATH . 'components/topnav.php'); ?>

<!-- Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-2">
            <h1 class="text-center">Impumelelo High School</h1>
            <h2 class="text-center text-secondary">Welcome to the New Online Bus Registration Portal of Our High School</h2>

            <div class="row justify-content-center align-content-center p-1">

                <div class="col-lg-4 d-flex align-self-center">
                    <i class="fa-solid fa-quote-left fs-6 text-primary me-2"></i>
                    <p class="fs-5 lh-lg">
                        We're thrilled to usher in an exciting era of digital transformation at our
                        school! Moving away from the old paper-based system, we're delighted to introduce our online portal. Designed to
                        provide a seamless and efficient platform for the transport needs of our
                        learners.
                        <i class="fa-solid fa-quote-right fs-6 text-primary"></i>
                    </p>
                </div>

                <div class="col-md-4 col-sm-4">
                    <img src="assets/images/orange_bus_01.png" alt="bus" class="img-fluid">
                </div>

            </div>

        </div>

        <div class="d-flex justify-content-center align-items-center bg-body-secondary pt-5">
            <div class="col-md-6">
                <h2 class="text-center pb-2" id="why">Why Register Online?</h2>
                <p class="fs-5">
                    With the new school year 2024 fast approaching, we encourage parents and guardians to take advantage of this
                    new online portal. Registration will ensure that your child has safe and reliable transport to-and-from
                    school each day. Please note, the deadline for bus registration for the 2024 school year is 1 November 2023.
                    We advise registering as soon as possible to guarantee your child's seat and avoid any last-minute
                    hassles.
                </p>
                <p class="fs-5">
                    To start the registration process, simply login or register a new account, then follow the prompts
                    to
                    register your child. Our new online system is very user-friendly.
                </p>
                <div class="text-center pt-3 pb-5">
                    <a href="<?php echo BASE_URL . 'parent_registration.php' ?>" class="btn btn-primary align-self-center fs-5">Register Now</a>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content End -->
<!-- Footer -->
<?php include_once(ROOT_PATH . 'components/footer.php'); ?>




