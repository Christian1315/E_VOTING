<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>E-VOTING</title>
    <link rel="shortcut icon" href="favicon.jpeg" type="image/x-icon">
    <link rel="stylesheet" href="bootstrap.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="style.css">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

</head>

<body class="antialiased">
    <div class="container-fluid shadow-lg bg-light header">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <a class="navbar-brand text-white bg-success btn roundered px-3" href="/"> <strong>E-VOTING</strong></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a href="#" class="nav-link active" aria-current="page" href="#">Site Officiel</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="/documentation">Api Documentation</a>
                                </li> -->
                            </ul>
                            <form class="d-flex" role="search">
                                <img src="e-voting.jpeg" width="100px" class="shadow-lg p-3 bg-body rounded" alt="" srcset="">
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <div class="container content">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="title">Soyez les bienvenu sur l'API de E-VOTING</h1>
                <p class="text-dark">Pour commencer,veuillez jetter un oeil sur la documentation pour avoir une vision plus claire de l'implementation des différentes routes!</p>
                <img src="e-voting.jpeg" class="img-fluid rounded shadow-lg" width="500" alt="" srcset=""><br><br>
                <a href="#" class="btn documentation bg-success">Voir la documentation</a>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-light shadow-lg py-3 footer fixed-bottom">
        <div class="row">
            <div class="col-md-12">
                <p class="text-dark text-center">© Copyright 2023 - Développé par HSMC</p>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</html>