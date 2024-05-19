<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">


    <title>Movie Theater Booking</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            /*background-image: url('./images/indexpage_bg.svg');*/
            background-color: black;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;

        }

        .topBar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: black;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0px 40px;
            z-index: 1000;
            height: 90px;
        }



        #logo {
            padding-bottom: 20px;
            width: 100px;
            height: 75px;
        }

        #logo img {
            width: 100%;
            /* Make sure the image fills the container */
            height: auto;
            /* Maintain aspect ratio */
        }

        .sign-log {
            padding-bottom: 25px;
            display: inline-flex;
        }

        #admin-login {
            text-decoration: none;
            color: #0CE7EB;
            border-color: #0CE7EB;
            font-weight: bold;
            display: inline-block;
            padding: 5px 20px;
            margin-top: 40px;
            text-align: center;
        }

        #admin-signup {
            margin-right: 10px;
            background-color: #0CE7EB;
            color: #FC3066;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            padding: 5px 20px;
            margin-top: 40px;
            text-align: center;
            
        }

        #admin-signup :hover {
            color: #0CE7EB;
        }

        #admin-login:hover {
            color: #FC3066;
            background-color: #0CE7EB;
            border-color: #FC3066;
        }

        .btn {
            padding-top: 20px;
            align-items: center;
            display: flex;
        }

        .currentMovies-container {
            margin: 0 auto;
            padding-top: 80px;
            color: white;
            text-align: left;
        }

        .slideshow-container {
            max-width: 100%;
            position: relative;
            margin: auto;
            text-align: center;
        }


        .mySlides {
            display: none;
            text-align: left;

        }

        /* Style for the image */
        img {
            width: 600px;
            height: 338px;

        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            color: #eb2da4;
            /* Set color */
            font-size: 2.5em;
            /* Increase size slightly */
        }

        .intro-page {
            padding-top: 40px;
        }

        .intro-text {

            padding: 10px;
            border-radius: 8px;
            color: white;
            max-width: 40%;
            opacity: 0.7;
            text-align: left;

        }

        .text-container {
            padding-top: 40px;
        }

        .carousel-caption {
            text-align: left;
        }



        .intro-text {
            text-transform: uppercase;
        }

        .intro-img {
            margin-top: -380px;
            padding-left: 600px;
            width: 100%;

        }

        .animated {
            animation-duration: 2s;
        }

        @keyframes bounceInRight {

            from,
            60%,
            75%,
            90%,
            to {
                animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
            }

            0% {
                opacity: 0;
                transform: translate3d(3000px, 0, 0);
            }

            60% {
                opacity: 1;
                transform: translate3d(-25px, 0, 0);
            }

            75% {
                transform: translate3d(10px, 0, 0);
            }

            90% {
                transform: translate3d(-5px, 0, 0);
            }

            to {
                transform: none;
            }
        }

        .bounceInRight {
            animation-name: bounceInRight;
        }

        .slide-container {
            max-width: 80%;
            margin: 0 auto;
            padding-top: 50px;
            color: white;
            text-align: center;
        }

        .form-container {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }

        .form-container input[type="text"],
        .form-container select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            border: none;
            border-radius: 5px;
            background-color: #f2f2f2;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .whatsapp-widget {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            padding-bottom: 50px;
        }

        .whatsapp-widget:hover {
            background-color: transparent;
            animation: increaseSize 0.3s ease forwards;
        }

        @keyframes increaseSize {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.1);
            }
        }
    </style>
</head>

<header>
    <div class="topBar">
        <a href="#" id="logo"><img src="./images/logo.png" /> </a>
        <div class="sign-log">
            <a href="signUp.php" id="admin-signup" class="btn btn-outline">Sign Up</a>
            <a href="admin-login.php" id="admin-login" class="btn btn-outline" target="_blank">Login</a>
        </div>
    </div>

</header>

<body>
    <div class="slide-container">

        <div class="currentMovies-container">

            <div class="currentMovies">
                <div class="slideshow-container">
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "movie_theater";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM movieImages";
                    $result = $conn->query($sql);
                    ?>

                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php
                            if ($result->num_rows > 0) {
                                $active = "active";
                                $counter = 0;
                                while ($row = $result->fetch_assoc()) {
                                    echo '<li data-target="#myCarousel" data-slide-to="' . $counter . '" class="' . $active . '"></li>';
                                    $active = "";
                                    $counter++;
                                }
                            }
                            ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php
                            if ($result->num_rows > 0) {
                                $active = "active";
                                $result->data_seek(0);
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="carousel-item ' . $active . '">';
                                    echo '<img class="d-block w-100" src="data:image/jpeg;base64,' . base64_encode($row['poster']) . '" alt="' . $row['name'] . '">';

                                    echo '<h1 style="text-transform: uppercase; text-align: right;">' . $row['name'] . '</h1>';
                                    echo '</div>';
                                    $active = "";
                                }
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>


                    </div>





                    <div class="intro-page">
                        <h2 class="intro-text animated bounceInTop" style="animation-delay: 2s; text-align: left;">WELCOME TO UP CINEMA!</h2>
                        <div class="intro-text animated bounceInRight" style="animation-delay: 3s;">
                            <p>Welcome to our Movie Seat Booking!</p>
                            <p>Enjoy the ease of selecting your seats in our intuitive booking system.</p>
                            <p>Simply click on the seats to book them. Once selected, they will turn pink. Seats that are already booked are grayed out and cannot be selected.</p>
                            <p>Enjoy the show!</p>
                        </div>
                        <div class="button-container text-left" style="padding-bottom: 15px;">
                            <a class="btn btn-lg btn-primary d-inline-block" href="slideshow.php" role="button" style="background-color: #0ce7eb; width: 40%; opacity: 0.8;">Book Here..</a>
                        </div>

                        <div class="intro-img animated bounceInRight" style="animation-delay: 2s; max-width:50%;">
                            <img src="./images/side_img.svg" />
                        </div>
                    </div>


                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $(".intro-text").addClass("animated bounceInRight").css("animation-delay", "1s");
                        });
                    </script>




                    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

                    <script>
                        $('.carousel').carousel({
                            interval: 3000 // Change slide every 3 seconds
                        });
                    </script>


                    <?php
                    $conn->close();
                    ?>

                </div>







                <div class="whatsapp-widget">

                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16" onclick="openWhatsApp()">
                        <circle cx="8" cy="8" r="8" fill="#25D366" />
                        <path fill="#FFF" d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
                    </svg>


                </div>

                <script>
                    function openWhatsApp() {
                        var phoneNumber = '+94123456789';
                        var message = 'Hello, how can we assist you?';
                        var whatsappWebUrl = 'https://web.whatsapp.com/send?phone=' + phoneNumber + '&text=' + encodeURIComponent(message);

                        window.open(whatsappWebUrl, '_blank');
                    }
                </script>


                <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>