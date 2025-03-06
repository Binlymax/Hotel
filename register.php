<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Register</title>

    <style>
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
    </style>
</head>

<body>

    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-sm-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                <path
                                    d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
                            </svg></div>
                        <div class="col-sm-8">
                            <h5 style="font-weight: bold;">Registration</h5>
                        </div>

                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" id="warning_text" style="display:none;"></div>
                    <form method="POST" id="registerForm" action="api/register.php">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username_reg" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="phone">Phone number</label>
                                    <input type="text" class="form-control" id="phone" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="date">Date of birth</label>
                                    <input type="date" class="form-control" id="date" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Address</label>
                            <input type="text" class="form-control" id="address" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password_reg" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="com-password">Comfirm Password</label>
                                    <input type="password" class="form-control" id="com_password" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
                        <div id="loadingRegister" class="text-center mt-3" style="display: none;">
                            <center>
                                <div class="loader"></div>
                            </center>
                        </div>
                        <hr>
                        <center>Already have account? <a style="cursor: pointer;" id="loginBtn">Login</a></center>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            var $j = jQuery.noConflict();
            var response;
            // Handle form submission
            document.getElementById('registerForm').addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the form from submitting normally
                // Show loading indicator
                document.getElementById('loadingRegister').style.display = 'block';
                var username = document.getElementById('username_reg').value;
                var password = document.getElementById('password_reg').value;
                var email = document.getElementById('email').value;
                var com_password = document.getElementById('com_password').value;
                var address = document.getElementById('address').value;
                var date = document.getElementById('date').value;
                var phone = document.getElementById('phone').value;
                let res;
                $j.ajax({
                    type: "POST",
                    url: "api/register.php",
                    data: { username: username, email: email, phone: phone, date: date, address: address, password: password, com_password: com_password },
                    success: function (response) {
                        res = response;
                        console.log(response);
                    },
                    error: function (error) {
                        res = error;
                        console.log(error);
                    }
                });
                // Simulate login process with a delay
                setTimeout(function () {
                    var warning_text = document.getElementById('warning_text');
                    console.log(res);
                    if (res === 'success') {
                        location.reload();
                    } else {
                        // Display error message in the modal
                        warning_text.style.display = 'block'
                        warning_text.innerHTML = res;
                    }

                    // Hide loading indicator
                    document.getElementById('loadingRegister').style.display = 'none';
                }, 3000);

            });
            var loginBtn = document.getElementById("loginBtn");
            loginBtn.addEventListener("click", function () {
                $('#registerModal').modal('hide');
                $('#loginModal').modal('show');
            });
        </script>
    </div>
</body>

</html>