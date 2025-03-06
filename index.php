<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>booking-room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>
    <!-- Login / register -->
    <?php
    include ("database/connection.php");
    include ("login.php");
    include ("register.php");
    include ("logout.php");
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
        <!--   search saction   -->
        <div class="banner">
            <img src="images/banner.jpg" width="100%" alt="" srcset="">
            <form action="index.php" method="post">
                <div class="find-room shadow-lg">
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col">
                            <h4>Check Room Available</h4>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col">
                            <label for="location">Select Location</label>
                        </div>
                        <div class="col">
                            <label for="checkin">Check In Date</label>
                        </div>
                        <div class="col">
                            <label for="checkout">Check Out Date</label>
                        </div>
                        <div class="col">
                            <label for="guest">Guest</label>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <select name="locationSearch" id="location">
                                <option value="Quang Binh">Quang Binh</option>
                                <option value="Dong Hoi">Dong Hoi</option>
                                <option value="Bac Ly">Bac Ly</option>
                                <option value="Bao Ninh">Bao Ninh</option>
                            </select>
                        </div>
                        <div class="col">
                            <input type="date" name="check-in" id="checkin">
                        </div>
                        <div class="col">
                            <input type="date" name="check-out" id="checkout">
                        </div>
                        <div class="col">
                            <select name="guest" id="guest">
                                <option value="1">1 person</option>
                                <option value="2">2 person</option>
                                <option value="3">3 person</option>
                                <option value="4">4 person</option>
                            </select>
                        </div>
                        <div class="col-sm-1 mt-1 mr-4">
                            <button type="submit" name="submitSearch" class="btn btn-sm btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php
        $sql_get_all_room = "SELECT * FROM rooms";
        if (isset($_POST['submitSearch'])) {
            $people = $_POST['guest'];
            $locationSearch = $_POST['locationSearch'];
            $sql_get_all_room = "SELECT * FROM rooms WHERE location = '" . $locationSearch . "' AND people = '" . $people . "'";
            ?>
            <h4 class="mt-2 mb-2">Resutl search:</h4>
            <?php
        }
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


    <footer id="footer" class="footer bg-dark" style="color: white; padding: 20px 20px;">
        <div class="container custom-container">
            <div class="row">
                <div class="col-lg-6 text-lg-left text-center mb-3 mb-lg-0">
                    <p>&copy; 2024 Booking Room. All rights reserved.</p>
                </div>
                <div class="col-lg-6 text-lg-right text-center">
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="#">Terms of Service</a></li>
                        <li class="list-inline-item"><a href="#">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Get the current date
        const currentDate = new Date();

        // Format the date as YYYY-MM-DD (required format for date input)
        const year = currentDate.getFullYear();
        let month = currentDate.getMonth() + 1;
        if (month < 10) {
            month = '0' + month; // Add leading zero if month is single digit
        }
        let day = currentDate.getDate();
        if (day < 10) {
            day = '0' + day; // Add leading zero if day is single digit
        }
        const dateCheckIn = `${year}-${month}-${day}`;
        const dateCheckOut = `${year}-${month}-${day + 2}`;

        // Set the value of the date input field
        document.getElementById('checkin').value = dateCheckIn;
        document.getElementById('checkout').value = dateCheckOut;

    </script>
</body>

</html>