<?php $pageTitle = "Request Big Buzz"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<body>
<?php
$tz = 'America/New_York';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz));
?>
<div class="container mb-3">
    <div class="py-3 text-center">
        <a href="../index.php"><img class="d-block mx-auto mb-4 mt-4" src="/img/brand/official-logo.png" alt="" width="150" height="150"></a>
        <h2>Request Big Buzz</h2>
        <p class="lead">Big Buzz appearances are fulfilled at the discretion of the Ramblin' Reck Club. Please email rrcbigbuzz@gmail.com with any questions or concerns. </p>
        <p><b>NOTE: This is NOT a request for Buzz the mascot, but rather it is to request a giant inflatable Buzz as seen in the picture below.</b></p>
        <p>You can request Buzz the mascot here: <a href="http://www.ramblinwreck.com/requests.html">http://www.ramblinwreck.com/requests.html</a></p>
        <img src="/img/promo/big-buzz.jpg" class="img img-responsive rounded" width="500px">
    </div>
    <div class="row">
        <div class="message-space col-6 offset-3">

        </div>
    </div>
    <div class="row">
        <div id="request-form" class="offset-xl-1 col-xl-10 offset-lg-2 col-lg-8 offset-md-3 col-md-6">
            <h4 class="mb-3">Request Details</h4>
            <form class="needs-validation" novalidate="">
                <div class="row">
                    <div class="col-4 mb-3">
                        <label for="event-name">Name</label>
                        <input type="text" class="form-control" id="renter-name" placeholder="George P. Burdell" value="" required="">
                        <div class="invalid-feedback">
                            Valid name is required.
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="event-name">Email</label>
                        <input type="email" class="form-control" id="renter-email" placeholder="gpb@gatech.edu" value="" required="">
                        <div class="invalid-feedback">
                            Valid email is required.
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="event-phone-number">Contact Phone Number</label>
                        <input type="text" class="form-control" id="renter-phone-number" placeholder="(xxx) xxx-xxxx" value="" required="">
                        <div class="invalid-feedback">
                            Valid phone number is required.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="org-dept-name">Organization/Department Name</label>
                        <input type="text" class="form-control" id="org-dept-name" placeholder="What organization or department is the event for?" value="" required="">
                        <div class="invalid-feedback">
                            Valid organization or department name is required.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="event-name">Event name</label>
                        <input type="text" class="form-control" id="event-name" placeholder="" value="" required="">
                        <div class="invalid-feedback">
                            Valid event name is required.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="event-name">Event location</label>
                        <input type="text" class="form-control" id="event-location" placeholder="" value="" required="">
                        <div class="invalid-feedback">
                            Valid event location is required.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="event-name">Event time and details</label>
                        <textarea class="form-control" id="event-details" placeholder="Please provide event start/end times, all important setup details, and other pertinent information here."></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="event-month">Event Month</label>
                        <select class="custom-select d-block w-100" id="event-month" required="">
                            <?php $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                            foreach ($months as $month) {
                                if ($month == $dt->format('F')) {
                                    echo "<option value=\"" . $month . "\" selected=\"selected\">" . $month . "</option>";
                                } else {
                                    echo "<option value=\"" . $month . "\">" . $month . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please provide a valid month.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="event-day">Event Day</label>
                        <select class="custom-select d-block w-100" id="event-day" required="">
                            <?php
                            for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, array_search($month, $months, TRUE) + 1, date("Y")); $day++) {
                                if ($day == date("d")) {
                                    echo "<option value=\"" . $day . "\" selected=\"selected\">" . $day . "</option>";
                                } else {
                                    echo "<option value=\"" . $day . "\">" . $day . "</option>";
                                }
                            }

                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Event day required.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="event-year">Event Year</label>
                        <input id="event-year" class="form-control" maxlength="4" type="text" placeholder="Year" value="<?php echo $dt->format('Y'); ?>" required>
                        <div class="invalid-feedback">
                            Event year required.
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button id="submit-request-button" class="btn btn-primary btn-lg btn-block" type="submit">Submit request</button>
            </form>
        </div>
    </div>
</div>
<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
<script>
    $('#event-month').on('select', function(e) {
        e.preventDefault();
        $(document).load(location.href+" #event-day>*","");
    });

    function isDateSetValid() {
        var curDate = moment();
        var eventDate = moment($('#event-year').val() + '-' + $('#event-month').val() + '-' + $('#event-day').val(),'YYYY-MMM-D');
        return eventDate.isSameOrAfter(curDate, 'day');
    }

    function createEvent() {
        $('#submit-request-button').attr('disabled','disabled')
        $('#submit-request-button').html('Submitting request...');
        $.ajax({
            url: '/big-buzz/request-handler.php',
            type: 'POST',
            data: {
                renterName: $('#renter-name').val(),
                renterEmail: $('#renter-email').val(),
                renterPhoneNumber: $('#renter-phone-number').val(),
                orgDeptName: $('#org-dept-name').val(),
                eventDetails: $('#event-details').val(),
                eventName: $('#event-name').val(),
                eventLocation: $('#event-location').val(),
                eventDate: $('#event-month').val() + ' ' + $('#event-day').val() + ', ' + $('#event-year').val()
            },
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            success: function(result) {
                console.log(result);
                // window.location.replace('/points');
                $('#request-form').html("<div class=\"alert alert-success\" role=\"alert\">Your request has been successfully submitted! Return to <a href=\"/\">the home page</a>.</div>");
            },
            error: function(error) {
                console.log(error);
                $('#request-form').remove();
                $('.message-space').html("    <div class=\"alert alert-danger alert-dismissible show fade\" role=\"alert\">\n" +
                    "        <strong>Error!</strong> <span id=\"error-message\">" + error.message + "</span>\n" +
                    "        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                    "            <span aria-hidden=\"true\">&times;</span>\n" +
                    "        </button>\n" +
                    "    </div>");
            }
        })
    }

    (function() {
        'use strict';

        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    if (form.checkValidity() === false) {
                        event.stopPropagation();
                        if (!isDateSetValid()) {
                            event.stopPropagation();
                            $('.message-space').html("    <div class=\"alert alert-danger alert-dismissible show fade\" role=\"alert\">\n" +
                                "        <strong>Error!</strong> <span id=\"error-message\">Please provide a valid date.</span>\n" +
                                "        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                                "            <span aria-hidden=\"true\">&times;</span>\n" +
                                "        </button>\n" +
                                "    </div>");
                            $('#event-day').css('border-color', '#D75452');
                            $('#event-month').css('border-color', '#D75452');
                            $('#event-year').css('border-color', '#D75452');
                        }
                    } else if (!isDateSetValid()) {
                        event.stopPropagation();
                        $('.message-space').html("    <div class=\"alert alert-danger alert-dismissible show fade\" role=\"alert\">\n" +
                            "        <strong>Error!</strong> <span id=\"error-message\">Please provide a valid date.</span>\n" +
                            "        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                            "            <span aria-hidden=\"true\">&times;</span>\n" +
                            "        </button>\n" +
                            "    </div>");
                        $('#event-day').css('border-color', '#D75452');
                        $('#event-month').css('border-color', '#D75452');
                        $('#event-year').css('border-color', '#D75452');
                    } else {
                        $('.message-space').html("");
                        $('#event-day').css('border-color', '#5FB760');
                        $('#event-month').css('border-color', '#5FB760');
                        $('#event-year').css('border-color', '#5FB760');
                        createEvent();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>


</body></html>