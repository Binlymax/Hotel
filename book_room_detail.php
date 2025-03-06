<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book roomd detail</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>
    <?php
    include ("logout.php");
    include ("database/connection.php");
    ?>
    <div class="container-fluid custom-container"> <!--   nav bar    -->
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
                    </ul>
                    <?php
                    if (isset($_COOKIE['username'])) {
                        ?>
                        <img class="mr-2" width="25px" src="images/profile/profile.png" alt="">
                        <h3 class="mr-3 text-muted"><?php echo $_COOKIE['username']; ?></h3>
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#logoutModal"
                            type="button">Logout</button>
                        <?php
                    } ?>

                </div>
            </div>
        </nav>
        <p class="mt-1" style="color: grey;"> <a style="text-decoration: none;link-style: none; color:grey;"
                href="index.php">Home</a> > Booking history</p>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Room</th>
                    <th>Name</th>
                    <th>Check In</th>
                    <th>Check out</th>
                    <th>time_book</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $username = $_COOKIE['username'];
                $sql_get_booking_room_history = "SELECT * FROM book_room,rooms where book_room.username = '" . $username . "' and book_room.room_id = rooms.room_id order by book_room.time_book desc";
                $result_get_room_history = $conn->query($sql_get_booking_room_history);
                $i = 0;
                while ($row = $result_get_room_history->fetch_assoc()) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><img class="rounded" width="100px" src="<?php echo $row['room_image']; ?>" alt="" srcset="">
                        </td>
                        <td><?php echo $row['room_name']; ?></td>
                        <td><?php echo $row['check_in']; ?></td>
                        <td><?php echo $row['check_out']; ?></td>
                        <td><?php echo $row['time_book']; ?></td>
                        <td>Total days: <?php echo $row['total_day']; ?> <br>Total price:
                            <?php echo $row['total_price'] . '$'; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>

            </tbody>
        </table>

    </div>

</body>

</html>