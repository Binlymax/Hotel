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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="width: 350px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-weight: bold;">Are you sure to logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-footer">

                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-sm btn-secondary"
                        data-bs-dismiss="modal">No</button>
                    <form action="api/logout.php" id="logoutBtn" method="post"> <button type="submit"
                            class="btn btn-sm btn-primary">Yes</button></form>
                </div>
                <div id="loadingLogout" class="text-center mt-3 mb-3" style="display: none;">
                    <center>
                        <div class="loader"></div>
                    </center>
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
        // Handle form submission
        document.getElementById('logoutBtn').addEventListener('submit', function (event) {
            event.preventDefault();
            var loading = document.getElementById('loadingLogout').style.display = 'block';
            let res;
            $j.ajax({
                type: "POST",
                url: "api/logout.php",

            });
            setTimeout(function () {
                var loading = document.getElementById('loadingLogout').style.display = 'none';
              //  location.reload();
                window.location = 'index.php';
            }, 2000);

        });
    </script>
</body>

</html>