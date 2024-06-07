<?php
// session_start();
$user_type = $_SESSION['user_type'] ?? 'guest'; // 'admin', 'applicant', or 'guest'

// Get the current page's filename
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPLM MIMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/header.css">
</head>

<body>
    <header class="container-fluid navbar-custom">
        <div class="row">
            <div class="col-12 d-flex flex-column align-items-center">
                <a href="home.php" class="navbar-brand">
                    <img src="../assets/images/logo.jpg" alt="SPLM Logo" width="200px">
                </a>
                <nav class="navbar navbar-expand">
                    <div class="navbar-collapse">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="home.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#constitution">Constitution</a>
                            </li>
                            <?php if ($user_type == 'guest'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#news">News</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#contact">Contact</a>
                            </li>
                            <?php endif; ?>
                            <?php if ($current_page != 'register.php' && $current_page != 'login.php' && $current_page != 'home.php'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../core/logout.php">Logout</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
