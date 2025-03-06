<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
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
                            <input type="text" class="username form-control" id="username">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        var $j = jQuery.noConflict();
        var response;
        var username = document.querySelectorAll(".username");
        for (let index = 0; index < username.length; index++) {
            const element = username[index].value;
            console.log("value : " + username[index].value);

        }
        // Handle form submission
        document.getElementById('loginForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the form from submitting normally
            // Show loading indicator
            document.getElementById('loadingIndicator').style.display = 'block';
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            let res;
            $j.ajax({
                type: "POST",
                url: "api/login.php",
                data: { username: username, password: password },
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
                var warning_text = document.getElementById('warning-text');
                console.log(res);
                if (res === 'success') {
                    // Successful login, close the modal and reset the form
                    //$('#loginModal').modal('hide');
                    //document.getElementById('loginForm').reset();
                    location.reload();
                } else {
                    // Display error message in the modal
                    warning_text.style.display = 'block'
                    warning_text.innerHTML = res;
                }

                // Hide loading indicator
                document.getElementById('loadingIndicator').style.display = 'none';
            }, 3000);

        });
        var loginBtn = document.getElementById("registerBtn");
        loginBtn.addEventListener("click", function () {
            $('#loginModal').modal('hide');
            $('#registerModal').modal('show');
        });

    </script>
</body>

</html>