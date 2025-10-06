<?php session_start(); ?>
<?php include('../server/connection.php'); ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Admin Dashboard · University Stationary Hub</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />

    <style>
        /* Adjust navbar */
        .navbar {
            background-color: white;
            border-bottom: 1px solid #ddd;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .navbar-brand {
            color: #333;
            font-size: 1.4rem;
            font-weight: bold;
        }

        .navbar .logo {
            height: 30px;
            margin-right: 10px;
        }

        .navbar-nav {
            flex-direction: row;
        }

        .navbar-nav .nav-item {
            margin-left: 15px;
        }

        .navbar-nav .nav-link {
            color: #333;
            font-weight: 500;
        }

        .btn-signout {
            background-color: #FF9F7F;
            color: black;
            border-radius: 5px;
            padding: 5px 15px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .btn-signout:hover {
            background-color: #FF7F50;
        }

        body {
            margin-top: 70px;
        }

        #sidebarMenu {
            margin-top: 70px;
        }

        /* Button to Add New Product, styled like the Sign-Out Button */
        .btn-signout {
            background-color: #FF9F7F;
            /* Pale Orange */
            color: black;
            border-radius: 5px;
            padding: 5px 15px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            position: absolute;
            top: 20px;
            right: 20px;
            /* Remove underline */
        }

        .btn-signout:hover {
            background-color: #FF7F50;
            /* Slightly darker orange on hover */
        }

        @media (max-width: 992px) {
            .navbar-toggler {
                border-color: transparent;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img class="logo" src="../assets/imgs/1.png" alt="University Stationery Hub Logo" />
                University Stationery Hub
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
                        <li class="nav-item">
                            <a class="btn btn-signout" href="logout.php?logout=1">Sign Out</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</body>

</html>