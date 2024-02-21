<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-bus"></i> Online Bus Registration</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL ?>"><i class="fa-solid fa-house"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?php echo BASE_URL ?>#why"><i class="fa-solid fa-circle-info"></i> Why Register?</a>
                </li>
            </ul>
            <ul class="navbar-nav">
            <?php
            if($_SESSION['user_type'] === 'guest'){
                include_once (ROOT_PATH.'components/guest_actions.php');
            }
            if($_SESSION['user_type'] === 'parent'){
                include_once (ROOT_PATH.'components/parent_actions.php');
            }
            if($_SESSION['user_type'] === 'admin'){
                include_once (ROOT_PATH.'components/admin_actions.php');
            }
            ?>
            </ul>
        </div>
    </div>
</nav>