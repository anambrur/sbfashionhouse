<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .form-container:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .form-title {
            font-size: 24px;
            font-weight: 700;
            color: #495057;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }

        .btn-custom {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            font-weight: 600;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .text-muted {
            font-size: 14px;
            text-align: center;
            margin-top: 15px;
        }

        #otp-form {
            display: none;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <!-- Phone Number Form -->
        <div id="phone-form">
            <h2 class="form-title">Login</h2>
            <form action="{{ url('/signUpPhoneNumber') }}" method="post" id="phoneForm">
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="mobile"
                        placeholder="Enter your phone number" required>
                </div>
                <button type="button" class="btn btn-custom" id="loginBtn">Login</button>
            </form>
            <p class="text-muted">Don't have an account? <a href="/register" class="text-decoration-none">Sign up</a>
            </p>
        </div>

        <!-- OTP Form -->
        <div id="otp-form">
            <h2 class="form-title">Enter OTP</h2>
            <form action="{{ url('/verifyOtp') }}" method="post">
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="mb-3">
                    <input type="hidden" name="valid_mobile" id="valid_mobile">
                    <label for="otp" class="form-label">OTP</label>
                    <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP"
                        required>
                </div>
                <button type="submit" class="btn btn-custom">Submit</button>
            </form>
            <p class="text-muted">Didn’t receive an OTP? <a href="#" id="resendOtp"
                    class="text-decoration-none">Resend OTP</a></p>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginBtn').click(function() {
                $.ajax({
                    url: $('#phoneForm').attr('action'),
                    type: 'POST',
                    data: $('#phoneForm').serialize(),
                    success: function(response) {
                        if (response.redirect) {
                            window.location.replace(response.redirect);
                        } else if (response.otpRequired) {
                            $('#phone-form').hide();
                            $('#otp-form').show();
                            var valid_mobile = $('#phone').val();
                            $('#valid_mobile').val(valid_mobile);
                            startCountdown(180);
                        }
                    },
                    error: function(xhr) {
                        alert('There was an error. Please try again.');
                    }
                });
            });

            function startCountdown(duration) {
                let timer = duration,
                    minutes, seconds;
                const countdownDisplay = $('#otp-countdown');

                const interval = setInterval(function() {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    countdownDisplay.text("Time remaining: " + minutes + ":" + seconds);

                    if (--timer < 0) {
                        clearInterval(interval);
                        countdownDisplay.text("OTP expired. Please request a new one.");
                        $('#otp-input').hide(); // Optionally hide the OTP form after expiration
                    }
                }, 1000);
            }
        });
    </script>
</body>

</html>
