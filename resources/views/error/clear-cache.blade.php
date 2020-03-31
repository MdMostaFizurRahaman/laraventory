<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Success! | {{ config('app.name', 'AMP') }}</title>
    <!-- partial CSS specific page-->
    <!-- FAVICONS ICON -->
    <link href="{{ URL::to('/') }}/favicon.png" type="image/x-icon" rel="icon"/>
    <link href="{{ URL::to('/') }}/favicon.png" type="image/x-icon" rel="shortcut icon"/>

    <!--[if lt IE 9]>
    <script src="http://autocare.dexignlab.com/xhtml/js/html5shiv.min.js"></script>
    <script src="http://autocare.dexignlab.com/xhtml/js/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        #bg-color {
            background: #ececf3;
            margin: 0px;
            padding: 0px;
            text-align: center;
        }

        .section-content {
            width: 100%;
            height: 100%;
        }

        .page-notfound {
            position: relative;
            height: 100vh;
        }

        .content {
            margin: 0;
            position: absolute;
            top: 35%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .content strong {
            font-size: 125px;
            font-weight: 800;
            color: #ee3322;
            letter-spacing: 5px;
        }

        .content h5 {
            font-size: 30px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .content p {
            font-size: 20px;
            text-transform: capitalize;
            color: #ee3322;
        }

        @media (max-width: 767.98px) {
            .content strong {
                font-size: 70px;
                font-weight: 700;
                color: #ee3322;
                letter-spacing: 0px;
            }

            .content h5 {
                font-size: 20px;
                font-weight: 700;
                text-transform: uppercase;
            }

            .content p {
                font-size: 16px;
            }

        }
    </style>
</head>

<body id="bg-color">
<!-- contact area -->
<div class="container-fluid">
    <!-- 500 Page -->
    <div class="section-content">
        <div class="row">
            <div class="col-md-12">
                <div class="page-notfound text-center">
                    <div class="content">
                        <strong>Success!</strong>
                        <h5>Your Cache Cleaned Successfully.</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 500 Page END -->
</div>
<!-- contact area  END -->

</div>
</body>

</html>
