<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>booking room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/book-page.css">
    <link rel="stylesheet" href="styles/index.css">
    <style>
        .comment {
            background-color: #F9F9F9;
            padding: 15px 5px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .loader {
            border: 4px solid white;
            /* Light grey */
            border-top: 4px solid #007bff;
            /* Blue */
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .comment_form .comment_text {
            width: 100px;
            padding: 20px;
            background-color: #F9F9F9;
            border: none;
            border-radius: 10px;
        }

        .comment_form .comment_text:focus {
            outline: none;
        }

        .star-rating {
            position: relative;
            margin-left: 380px;
            display: inline-block;
            unicode-bidi: bidi-override;
            direction: rtl;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 30px;
            color: #ddd;
            padding: 0 2px;
            cursor: pointer;
        }

        .star-rating label:before {
            content: '\2605';
        }

        .star-rating input:checked~label {
            color: #ffcc00;
        }
    </style>
</head>

<body>
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="width: 350px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-sm-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                            </svg></div>
                        <div class="col">
                            <h5 style="font-weight: bold;">Login</h5>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning mt-1" id="warning-text" style="display:none;">he</div>
                    <form method="GET" id="loginForm" action="">
                        <div class="form-group">
                            <label for="username">Username/email</label>
                            <input type="text" class="form-control" id="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password">
                        </div>
                        <button id="submitLogin" type="submit" style="width: 100%;"
                            class="btn btn-primary">Login</button>
                        <div id="loadingIndicator" class="text-center mt-3" style="display: none;">
                            <center>
                                <div class="loader"></div>
                            </center>
                        </div>
                        <hr>
                        <center>Not have account? <a style="cursor:pointer;" id="registerBtn">Register</a></center>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    include ("database/connection.php");
    include ("login.php");
    include ("logout.php");
    include ("register.php");
    $room_id = $_GET['room_id'];
    ?>
    <div class="container-fluid custom-container">
        <!--   nav bar    -->
        <nav class="navbar navbar-expand-sm shadow-sm mb-1">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">BookingRoom.com</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mynavbar">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#rooms">Rooms</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#footer">About</a>
                        </li>
                        <?php
                        if (isset($_COOKIE['username'])) {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="book_room_detail.php">Booking History</a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <?php
                    if (isset($_COOKIE['username'])) {
                        ?>
                        <img class="mr-2" width="25px" src="images/profile/profile.png" alt="">
                        <h3 class="mr-3 text-muted"><?php echo $_COOKIE['username']; ?></h3>
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#logoutModal"
                            type="button">Logout</button>
                        <?php
                    } else {
                        ?>
                        <button class="btn btn-sm btn-outline-primary me-2" data-toggle="modal" data-target="#loginModal"
                            type="button">Login</button>
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#registerModal"
                            type="button">Register</button>
                        <?php

                    } ?>

                </div>
            </div>
        </nav>
        <?php
        $sql_get_room = "SELECT * FROM rooms WHERE room_id = '" . $room_id . "'";
        $result_get_room = $conn->query($sql_get_room);
        $row_room = $result_get_room->fetch_assoc();
        ?>
        <h1 class="mt-3 mb-2"><?php echo $row_room['room_name']; ?></h1>
        <p style="color: grey;"> <a style="text-decoration: none;link-style: none; color:grey;"
                href="index.php">Home</a> > Book rooms</p>

        <div class="row">
            <div class="col">
                <img src="<?php echo $row_room['room_image']; ?>" class="rounded" width="100%" alt="">
                <h4 class="mt-3">Feature</h4>
                <ul>
                    <?php
                    $sql_get_feature = "SELECT * FROM room_feature";
                    $result_get_room_feature = $conn->query($sql_get_feature);
                    while ($row_feature = $result_get_room_feature->fetch_assoc()) {
                        ?>
                        <li><?php echo $row_feature['feature_name'] ?></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="col">
                <div class="card" style="width:100%">
                    <div class="card-body">
                        <h4 class="card-title">Booking details</h4>
                        <h5> price: <?php echo $row_room['price']; ?>$/day</h5>
                        <p class="card-text text-muted">Please enter your infomation to booking room.</p>
                        <form method="POST" action="api/book_room.php" id="form_booking_room">
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mb-2" for="username ">Name</label>
                                        <input type="text" class="form-control" id="name" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mb-2" for="email_book">Email</label>
                                        <input type="email" class="form-control" id="email_book" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mb-2" for="check_in">Check-in</label>
                                        <input type="date" class="form-control" id="check_in" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mb-2" for="check_out">Check-out</label>
                                        <input type="date" class="form-control" id="check_out" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="mb-2" for="password">Card-numbers</label>
                                <input type="text" class="form-control" id="card_number" required>
                            </div>
                            <input type="hidden" name="room_id" id="room_id" value="<?php echo $room_id; ?>">
                            <input type="hidden" name="total_day" id="total_day">
                            <input type="hidden" id="total_price_hide" name="total_price_hide"
                                value="<?php echo $row_room['price'] ?>">
                            <div class="show_price mb-2" id="show_price" style="display:none">
                                <h6>Total day: <span id="day"></span><br>Total price: <span id="total_price"></span>
                                </h6>

                            </div>

                            <?php
                            if (isset($_COOKIE['username'])) {
                                ?>
                                <button style="width: 100%;" class="btn btn-primary" type="submit">Book now</button>
                                <?php
                            } else {
                                ?>
                                <div data-toggle="modal" data-target="#loginModal" type="button" style="width: 100%;"
                                    class="btn btn-primary">Book now</div>
                                <?php
                            }
                            ?>
                            <div id="alert" style="display:none;">
                                <div class="alert alert-success mt-2">Book room success
                                </div>
                                <p class="mt-2"><a href="book_room_detail.php">Click here</a> to see details</p>
                            </div>

                            <div id="loadingBook" class="loadingBook mt-2" style="display:none">
                                <center>
                                    <div class="loader"></div>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <h4 class="mt-3">Reviews room</h4>
        <?php
        $sql_get_rateing_room = "SELECT * FROM ROOM_RATING WHERE ROOM_ID = '" . $room_id . "' ORDER BY comment_time desc";
        $result = $conn->query($sql_get_rateing_room);
        $haveComment = false;
        while ($row = $result->fetch_assoc()) {
            $haveComment = true;
            ?>
            <div class="row comment">
                <div class="col-1">
                    <div class="images-profile"><img src="images/profile/profile.png" width="50px" alt="" srcset="">
                    </div>
                </div>
                <div class="col-11">
                    <h4><?php echo $row['username']; ?></h4>
                    <p style="margin-bottom :0;font-size: 15px;" class="text-muted"><?php echo $row['comment_time']; ?></p>
                    <div class="review" style="margin-bottom: 5px;">
                        <?php for ($i = 0; $i < intval($row['rating']); $i++) {
                            ?>
                            <svg xmlns="http://www.w3.org/2000/svg" color="#FCAC00" width="16" height="16" fill="currentColor"
                                class="bi bi-star-fill" viewBox="0 0 16 16">
                                <path
                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>
                            <?php
                        }
                        for ($i = intval($row['rating']) + 1; $i < 6; $i++) {
                            ?>
                            <svg xmlns="http://www.w3.org/2000/svg" color="grey" width="16" height="16" fill="currentColor"
                                class="bi bi-star" viewBox="0 0 16 16">
                                <path
                                    d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z" />
                            </svg>
                            <?php
                        }
                        ?>
                    </div>
                    <p style="margin-bottom:0;"><?php echo $row['comment']; ?></p>
                </div>
            </div>
            <?php
        }
        if (!$haveComment) {
            ?>
            <center>
                <h5>Not have any rating from user</h5>
            </center>
            <?php
        }
        ?>

        <form class="comment_form" action="add_comment.php" method="post">
            <input type="text" name="comment_text" class="comment_text" style="width: 100%; border: none;"
                placeholder="Write your reviews room" required>
            <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
            <div class="star-rating">
                <input type="radio" id="star5" name="rating" value="5">
                <label for="star5"></label>
                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4"></label>
                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3"></label>
                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2"></label>
                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1"></label>
            </div>
            <br>
            <?php
            if (isset($_COOKIE['username'])) {
                ?>
                <center> <button class="btn btn-sm btn-primary" type="submit">Add comment</button></center>
                <?php
            } else {
                ?>
                <center> <button class="btn btn-sm btn-primary" type="button" data-toggle="modal"
                        data-target="#loginModal">Add comment</button></center>
                <?php
            }
            ?>

        </form>
        <h4 class="mt-3">Similiar rooms</h4>
        <?php
        $sql_get_all_room = "SELECT * FROM rooms WHERE room_id <> '" . $room_id . "'";
        $result = $conn->query($sql_get_all_room);
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="room" id="rooms">
                <div class="row">
                    <div class="col"><img class="room-img" src="<?php echo $row['room_image']; ?>" width="300px" alt="">
                    </div>
                    <div class="col" style="padding: 10px 0px;">
                        <h4 style="font-weight: bold;"><?php echo $row['room_name']; ?></h4>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            width="20" height="20">
                                            <path
                                                d="M20.5 11.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-17a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5H6V9a1 1 0 0 1 1-1h1.5a1 1 0 0 1 1 1v2h3V9a1 1 0 0 1 1-1h1.5a1 1 0 0 1 1 1v2h2.5zM18 19h-13v-6h13v6zm0-7h-2v-2.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5V12H6V8h12v4h-1V9.5a.5.5 0 0" />
                                        </svg>

                                    </div>
                                    <div class="col"><?php echo $row['bed']; ?> Bed</div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">

                                    <div class="col-sm-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                                        </svg></div>
                                    <div class="col"><?php echo $row['people']; ?> Person</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                </svg></div>
                            <div class="col"><?php echo $row['location']; ?></div>
                        </div>
                        <div class="avai-room">
                            <?php echo $row['total_room']; ?>
                        </div>
                    </div>
                    <div class="col" style="padding: 10px 10px;">
                        <h4 style="font-weight: bold;"><?php echo $row['price']; ?>$/day </h4>
                        <?php
                        $room_id = $row['room_id'];
                        $sql_get_rating_room = "select rooms.room_id, count(*) as num_rate, sum(room_rating.rating) as rating from rooms, room_rating where rooms.room_id = '{$room_id}' and rooms.room_id = room_rating.room_id";
                        $result1 = $conn->query($sql_get_rating_room);
                        $haveRating = false;
                        $numRating = 0;
                        $rating = 0;
                        while ($row1 = $result1->fetch_assoc()) {
                            $haveRating = true;
                            $numRating = intval($row1['num_rate']);
                            if ($numRating > 0) {
                                $rating = intval($row1['rating']) / $numRating;
                            }
                        }
                        if ($haveRating) {
                            ?>
                            <div class="review" style="margin-top: 10px;">
                                <?php
                                for ($i = 0; $i < intval($rating); $i++) {
                                    ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" color="#FCAC00" width="16" height="16"
                                        fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                    </svg>
                                    <?php
                                }
                                for ($i = intval($rating) + 1; $i < 6; $i++) {
                                    ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" color="grey" width="16" height="16" fill="currentColor"
                                        class="bi bi-star" viewBox="0 0 16 16">
                                        <path
                                            d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z" />
                                    </svg>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php

                        } else {

                        }
                        ?>

                        <div class="review-nums"><?php echo $numRating; ?> review</div>
                        <a href="book-page.php?room_id=<?php echo $row['room_id']; ?>" class="btn btn-primary"
                            style="margin-top: 10px;">Book now</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <footer class="footer bg-dark" style="color: white; padding: 20px 20px;">
        <div class="container custom-container">
            <div class="row">
                <div class="col-lg-6 text-lg-left text-center mb-3 mb-lg-0">
                    <p>&copy; 2024 Booking Room. All rights reserved.</p>
                </div>
                <div class="col-lg-6 text-lg-right text-center">
                    <ul class="list-inline">
                        <li class="list-inline-item "><a href="#" class="text-light">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="#" class="text-light">Terms of Service</a></li>
                        <li class="list-inline-item"><a href="#" class="text-light">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        var $j = jQuery.noConflict();
        document.getElementById('check_in').addEventListener('change', calculateDays);
        document.getElementById('check_out').addEventListener('change', calculateDays);

        function calculateDays() {
            var check_in = new Date(document.getElementById('check_in').value);
            var check_out = new Date(document.getElementById('check_out').value);
            if (check_in && check_out) {
                var timeDifference = Math.abs(check_out.getTime() - check_in.getTime());
                var differenceInDays = Math.ceil(timeDifference / (1000 * 3600 * 24));
                if (differenceInDays > 0) {
                    var show_price = document.getElementById('show_price').style.display = 'block';
                    var day = document.getElementById('day').innerHTML = differenceInDays;
                    var total_price_hide = document.getElementById('total_price_hide');
                    var total_price = document.getElementById('total_price');
                    var price = total_price_hide.value * differenceInDays;
                    total_price.innerHTML = price + "$";
                    total_price_hide.value = price;
                    var total_day = document.getElementById('total_day').value = differenceInDays;
                }

            }
        }

        document.getElementById('form_booking_room').addEventListener('submit', function (event) {
            event.preventDefault();
            document.getElementById('loadingBook').style.display = 'block';
            var name = document.getElementById('name').value;
            var email = document.getElementById('email_book').value;
            var check_in = document.getElementById('check_in').value;
            var check_out = document.getElementById('check_out').value;
            var card_number = document.getElementById('card_number').value;
            var total_price_hide = document.getElementById('total_price_hide').value;
            var total_day = document.getElementById('total_day').value;
            var room_id = document.getElementById('room_id').value;
            console.log("name : " + name + ", phone : " + phone + ", check_in : " + check_in + ", check_out : " + check_out + ", total_price : " + total_price_hide + ", total_day : " + total_day);
            $j.ajax({
                type: 'POST',
                url: 'api/book_room_service.php',
                data: { name: name, email: email, check_in, check_out, card_number, total_day: total_day, total_price: total_price_hide, room_id: room_id },
                success: function (response) {
                    console.log("response success : " + response);
                },
                error: function (error) {
                    console.log("error : " + error);
                }
            });
            setTimeout(function () {
                document.getElementById('loadingBook').style.display = 'none';
                document.getElementById('alert').style.display = 'block';
            }, 3000);
        });
    </script>
</body>

</html>