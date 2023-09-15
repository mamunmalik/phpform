<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Form Submission</h1>
    <form id="submissionForm" onsubmit="handleForm(); return false;">
        <div>
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount">
            <span id="amountError" class="error"></span>
        </div>
        <div>
            <label for="buyer">Buyer:</label>
            <input type="text" id="buyer" name="buyer">
            <span id="buyerError" class="error"></span>
        </div>
        <div>
            <label for="receipt_id">Receipt Id:</label>
            <input type="text" id="receipt_id" name="receipt_id">
            <span id="receiptIdError" class="error"></span>
        </div>
        <div>
            <label for="receipt_id">Items:</label>
            <input type="text" id="items" name="items">
            <span id="itemsError" class="error"></span>
        </div>
        <div>
            <label for="receipt_id">Buyer Email:</label>
            <input type="email" id="buyer_email" name="buyer_email">
            <span id="buyerEmailError" class="error"></span>
        </div>
        <div>
            <label for="note">Note:</label>
            <textarea id="note" name="note"></textarea>
            <span id="noteError" class="error"></span>
        </div>
        <div>
            <label for="city">City:</label>
            <input type="text" id="city" name="city">
            <span id="cityError" class="error"></span>
        </div>
        <div>
            <label for="phone">Phone:</label>
            <input type="number" id="phone" name="phone">
            <span id="phoneError" class="error"></span>
        </div>
        <div>
            <label for="entry_by">entry_by:</label>
            <input type="number" id="entry_by" name="entry_by">
            <span id="entryByError" class="error"></span>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            // Form submission using AJAX

            function handleSubmitForm() {
                if (!hasSubmittedRecently()) {

                    // Validate form fields
                    if (!validateForm()) {
                        return;
                    }

                    // Prepare data for submission
                    var formData = $(this).serialize();

                    // AJAX POST request
                    $.ajax({
                        type: "POST",
                        url: "Payment/store",
                        data: formData,
                        success: function(response) {
                            // Check if the response contains errors
                            if (response.errors) {
                                Object.keys(response.errors).forEach(function(key) {
                                    $("#" + key + "Error").text(response.errors[key]);
                                });
                            } else {
                                // Success: Display a success message
                                alert(response.message);
                                // Optionally, redirect or perform other actions on success
                            }
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            // Handle error response
                            console.error(errorThrown);
                        }
                    });

                    // Set a cookie to record the timestamp of the submission
                    var currentTimestamp = new Date().getTime();
                    setCookie("today_submission", currentTimestamp.toString(), 24); // 24 hours expiration
                } else {
                    alert("You have already submitted within the last 24 hours.");
                }
            }

            // Validation function
            function validateForm() {
                var isValid = true;

                // Validate Amount (only numbers)
                var amount = $("#amount").val();
                if (!/^\d+$/.test(amount)) {
                    isValid = false;
                    $("#amountError").text("Amount must contain only numbers.");
                } else {
                    $("#amountError").text("");
                }

                // Validate Buyer (only text, spaces, and numbers, not more than 20 characters)
                var buyer = $("#buyer").val();
                if (!/^[A-Za-z0-9\s]{1,20}$/.test(buyer)) {
                    isValid = false;
                    $("#buyerError").text("Buyer should contain only text, spaces, and numbers (up to 20 characters).");
                } else {
                    $("#buyerError").text("");
                }

                // Validate Receipt Id (only text)
                var receiptId = $("#receipt_id").val();
                if (!/^[A-Za-z]+$/.test(receiptId)) {
                    isValid = false;
                    $("#receiptIdError").text("Receipt Id should contain only text.");
                } else {
                    $("#receiptIdError").text("");
                }

                // Validate buyer email (only email)
                var buyerEmail = $("#buyer_email").val();
                if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(buyerEmail)) {
                    isValid = false;
                    $("#buyerEmailError").text('Please enter a valid email address.');
                } else {
                    $("#buyerEmailError").text("");
                }

                // Validate note (only text)
                var note = $("#note").val();
                if (!/^[A-Za-z]+$/.test(note)) {
                    isValid = false;
                    $("#noteError").text("Note can't exceed 30 words.");
                } else {
                    $("#noteError").text("");
                }

                // Validate Receipt Id (only text and spaces)
                var city = $("#city").val();
                if (!/^[A-Za-z\s]+$/.test(city)) {
                    isValid = false;
                    $("#cityError").text("City should contain only text and spaces.");
                } else {
                    $("#cityError").text("");
                }

                // Validate phone (only number)
                var phone = $("#phone").val();
                if (!/^\d+$/.test(phone)) {
                    isValid = false;
                    $("#phoneError").text("Phone should contain only numbers.");
                } else {
                    $("#phoneError").text("");
                }

                // Validate entry by (only number)
                var entryBy = $("#entry_by").val();
                if (!/^\d+$/.test(entryBy)) {
                    isValid = false;
                    $("#entryByError").text("Entry By should contain only numbers.");
                } else {
                    $("#entryByError").text("");
                }

                return isValid;
            }

            function getCookie(cookieName) {
                var name = cookieName + "=";
                var decodedCookie = decodeURIComponent(document.cookie);
                var cookieArray = decodedCookie.split(';');
                for (var i = 0; i < cookieArray.length; i++) {
                    var cookie = cookieArray[i];
                    while (cookie.charAt(0) == ' ') {
                        cookie = cookie.substring(1);
                    }
                    if (cookie.indexOf(name) == 0) {
                        return cookie.substring(name.length, cookie.length);
                    }
                }
                return null;
            }

            function setCookie(cookieName, cookieValue, expirationHours) {
                var d = new Date();
                d.setTime(d.getTime() + (expirationHours * 60 * 60 * 1000));
                var expires = "expires=" + d.toUTCString();
                document.cookie = cookieName + "=" + cookieValue + "; " + expires + "; path=/";
            }

            function hasSubmittedToday() {
                var lastSubmissionTimestamp = getCookie("today_submission");
                if (lastSubmissionTimestamp) {
                    var currentTime = new Date().getTime();
                    var lastSubmissionTime = parseInt(lastSubmissionTimestamp);

                    // Calculate the time difference in milliseconds
                    var timeDifference = currentTime - lastSubmissionTime;

                    // Define the time limit for preventing multiple submissions (24 hours)
                    var timeLimit = 24 * 60 * 60 * 1000; // 24 hours in milliseconds

                    return timeDifference < timeLimit;
                }
                return false;
            }

        });
    </script>
</body>

</html>