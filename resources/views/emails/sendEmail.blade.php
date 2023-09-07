<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>E-VOTING</title>

    <style>
        .object {
            border-bottom: 3px solid #008651;
            text-align: center !important;
            text-transform: uppercase !important;
            font-size: 25px !important;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            padding-block: 10px;
        }

        img {
            width: 300px;
            height: auto;
        }

        .text-center {
            text-align: center !important;
        }

        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important
        }

        .container {
            background-color: #E8E8E8 !important;
            padding-top: 30px !important;
        }

        .text-dark {
            color: #000;
        }

        .message {
            font-size: 20px !important;
            text-align: center !important;
            padding: 50px !important;
        }

        .bottom {
            border-top: 3px solid #fff;
            padding-block: 10px;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row shadow-lg mb-5">
            <div class="col-md-12 text-center" style="margin-bottom: 50px!important">
                <h1 class="object">{{$details["subject"]}}</h1>
                <img class="img-fluid mt-5 shadow-lg rounded" src="https://res.cloudinary.com/duk6hzmju/image/upload/v1693225963/e-voting_llixiz.jpg" alt="" srcset="">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p class="text-dark message">{{$details["message"]}}</p>
            </div>
        </div>

        <div class="row shadow-lg py-3 text-center bottom" style="margin-top: 50px!important">
            <div class="col-md-12">
                <h3 class="text-dark">© Copyright 2023 - Développé par HSMC</h3>
            </div>
        </div>
    </div>
</body>

</html>