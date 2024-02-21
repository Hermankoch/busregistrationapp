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
                        if (isset($_GET['error'])) {
                            echo '<div class="alert alert-danger" role="alert">' . $_GET['error'] . '</div>';
                        }

                        ?>
                        <h2 class="fw-bold mb-5">Impumelelo High School</h2>
                        <h2 class="fw-bold mb-5">Admin Login</h2>
                        <form  method="post" action="db/login_admin.php">
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" name="email" id="email" class="form-control" value="dnkosi.impumelelo.high.school@hermankoch.co.za"/>
                                <label class="form-label" for="email"><i class="fa-solid fa-envelope"></i> Email address</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline input-group">
                                <input name="password" type="password" id="password" class="form-control" value="DNkosi123@">
                                <span class="input-group-text">
                                    <i class="fa fa-eye" id="togglePassword" style="cursor: pointer"></i>
                                </span>
                            </div>
                            <div class="p-0 mb-4">
                                <label class="form-label" for="password"><i class="fa-solid fa-lock"></i>
                                    Password</label>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4">
                                Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-5 mb-lg-0">
                <img src="<?php echo BASE_URL; ?>assets/images/bus_animation_01.png" class="w-100 rounded-4 shadow-4"
                     alt=""/>
            </div>
        </div>
    </div>
    <!-- Jumbotron -->
</section>
<script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {

        // toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        // toggle the eye icon
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>

<?php include_once(ROOT_PATH . 'components/footer.php'); ?>