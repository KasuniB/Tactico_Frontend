<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verification</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="number"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        input[type="submit"],
        #resendOtpVerification {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover,
        #resendOtpVerification:hover {
            background-color: #45a049;
        }

        #message_error,
        #message_success {
            margin-bottom: 10px;
        }

        .time {
            font-size: 18px;
            margin-bottom: 10px;
        }

        /* Popup styles */
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .popup-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 4px;
            text-align: center;
        }

        .popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 18px;
            color: #888;
            cursor: pointer;
        }

        .popup-message {
            margin-bottom: 20px;
        }
        .popup-confirm {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }

    .popup-confirm:hover {
        background-color: #45a049;
    }
    </style>
</head>
<body>
    <p id="message_error" style="color:red;"></p>
    <p id="message_success" style="color:green;"></p>
    <form method="post" id="verificationForm">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="number" name="otp" placeholder="Enter OTP" required>
        <br><br>
        <input type="submit" value="Verify">
    </form>

    <p class="time"></p>

    <button id="resendOtpVerification">Resend Verification OTP</button>

    <div id="confirmationPopup" class="popup" style="display: none;">
        <div class="popup-content">
            <span id="popupClose" class="popup-close">&times;</span>
            <div class="popup-message" id="popupMessage"></div>
            <button id="popupConfirm" class="popup-confirm">OK</button>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#verificationForm').submit(function(e){
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{ route('verifiedOtp') }}",
                    type:"POST",
                    data: formData,
                    success:function(res){
                        if(res.success){
                            showPopup(res.msg);
                            setTimeout(function() {
                                window.open("/","_self");
                            }, 5000);
                        }
                        else{
                            $('#message_error').text(res.msg);
                            setTimeout(() => {
                                $('#message_error').text('');
                            }, 3000);
                        }
                    }
                });
            });

            $('#resendOtpVerification').click(function(){
                $(this).text('Wait...');
                var userMail = @json($email);

                $.ajax({
                    url:"{{ route('resendOtp') }}",
                    type:"GET",
                    data: {email:userMail },
                    success:function(res){
                        $('#resendOtpVerification').text('Resend Verification OTP');
                        if(res.success){
                            timer();
                            $('#message_success').text(res.msg);
                            setTimeout(() => {
                                $('#message_success').text('');
                            }, 3000);
                        }
                        else{
                            $('#message_error').text(res.msg);
                            setTimeout(() => {
                                $('#message_error').text('');
                            }, 3000);
                        }
                    }
                });
            });

            // Close the popup when clicking the close button
            $(document).on('click', '.popup-close', function() {
                hidePopup();
            });

            // Submit the form when clicking "OK" in the popup
            $(document).on('click', '#popupConfirm', function() {
                submitForm();
            });
        });

        function showPopup(message) {
            $('#popupMessage').text(message);
            $('#confirmationPopup').fadeIn();
        }

        function hidePopup() {
            $('#confirmationPopup').fadeOut();
        }

        function submitForm() {
            var formData = $('#verificationForm').serialize();

            $.ajax({
                url: "{{ route('verifiedOtp') }}",
                type: "POST",
                data: formData,
                success: function(res) {
                    if(res.success){
                        $('#message_success').text(res.msg);
                        setTimeout(() => {
                            $('#message_success').text('');
                        }, 5000);
                        window.open("/", "_self");
                    }
                    else{
                        $('#message_error').text(res.msg);
                        setTimeout(() => {
                            $('#message_error').text('');
                        }, 3000);
                    }
                }
            });

            hidePopup();
        }

        function timer() {
            var seconds = 30;
            var minutes = 1;

            var timer = setInterval(() => {
                if(minutes < 0){
                    $('.time').text('');
                    clearInterval(timer);
                }
                else{
                    let tempMinutes = minutes.toString().length > 1 ? minutes : '0' + minutes;
                    let tempSeconds = seconds.toString().length > 1 ? seconds : '0' + seconds;

                    $('.time').text(tempMinutes + ':' + tempSeconds);
                }

                if(seconds <= 0){
                    minutes--;
                    seconds = 59;
                }

                seconds--;

            }, 1000);
        }

        timer();
    </script>
</body>
</html>
