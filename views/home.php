<?php include("../config/db_connect.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/home.css">
</head>

<body>
<?php include '../include/header.php' ?>
    <main class="container py-4 mt-5">
        <h1 class="text-center display-4">Welcome to SPLM Membership Portal</h1>

        <div class="row justify-content-center">
            <div class="col-md-4 mb-3">
                <a href="register.php" class="btn btn-danger w-100">Register Now</a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="login.php" class="btn btn-danger w-100">Login</a>
            </div>
        </div>
    </main>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
 <?php include '../include/footer.php' ?>
</body>

</html>
