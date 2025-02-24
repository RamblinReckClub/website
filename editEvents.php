<?php
	require "logged_in_check.php";
    require "set_session_vars_full.php";
    if ($_SESSION['isAdmin']==0 && $_SESSION['isEventAdmin']==0) {
		echo "<meta http-equiv=\"REFRESH\" content=\"0;url=points.php\">";
		die;
	} else {}
	require "database_connect.php";
    $pageTitle = "Edit Events";
?>


<?php
	$today = getdate();
	$currentday = $today['mday'];
	$currentmonth = $today['mon'];
	$currentyear = $today['year'];
	
	@$dateMonth=$_GET['dateMonth'];
	@$dateDay=$_GET['dateDay'];
	@$eventID=$_GET['eventID'];
	@$familyEvent=$_GET['familyEvent'];    
	@$isFamilyEvent=$_GET['isFamilyEvent'];                  
	
	if(isset($dateMonth)) {
	     $selectedMonth = $dateMonth;
	} else {
	     $selectedMonth = $currentmonth;
	}
	if(isset($dateDay)) {
	     $selectedDay = $dateDay;
	} else {
	     $selectedDay = $currentday;
	}
	if(isset($eventID) && $eventID!=="none" && $selectedDay!=0) {
		$query = $db->prepare("SELECT dateDay, dateMonth FROM Event WHERE eventID=:eventID");
		$query->execute(array('eventID'=>$eventID));
			$query->setFetchMode(PDO::FETCH_ASSOC);
		 while($row = $query->fetch()) {
		 		if($row['dateDay']==$selectedDay && $row['dateMonth']==$selectedMonth){
		 				$selectedEvent = $eventID;
		 		} else {
		 				$selectedEvent = "none";
		 		}
		 }
	} elseif(isset($eventID) && $eventID!=="none" && $selectedDay==0) {
		$query = $db->prepare("SELECT dateMonth FROM Event WHERE eventID=:eventID");
		$query->execute(array('eventID'=>$eventID));
			$query->setFetchMode(PDO::FETCH_ASSOC);
		 while($row = $query->fetch()) {
		 		if($row['dateMonth']==$selectedMonth){
		 				$selectedEvent = $eventID;
		 		} else {
		 				$selectedEvent = "none";
		 		}
		 }                
	} else {
	     $selectedEvent = "none";
	}
	if(isset($familyEvent)) {
	} else {
	     $familyEvent = "false";
	}   
	if(isset($isFamilyEvent)) {
	} else {
	     $isFamilyEvent = "none";
	}                                                          
?>

<!DOCTYPE html>
<html>
<?php require "partials/head.php" ?>

<body>
<?php require "partials/header.php";
//<?PHP if($currentType=="mandatory") echo "selected";
//<?PHP if($currentType=="sports") echo "selected";
//<?PHP if($currentType == NULL || $currentType=="social") echo "selected";
//<?PHP if($currentType=="work") echo "selected";
?>

<div class="container mt-4">
    <h2 class="mb-4">Create Event</h2>
    <?php require "createEventForm.php"?>


    <div class="row my-5">
        <div class="col-5">
            <hr class="mb-4">
        </div>
        <div class="col-2 justify-content-center align-items-center text-center">
            <h5><strong>or</strong></h5>
        </div>
        <div class="col-5">
            <hr class="mb-4">
        </div>
    </div>

    <h2 class="mb-4">Edit Event</h2>

    <?php if (false): ?>
        <div class="row">
        <form class="col-12 needs-validation" id="myform" name="myform" action="createEvent.php" method="POST">
            <h4 class="mb-3">Create Event</h4>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="event-name">Event name</label>
                        <input type="text" class="form-control" name="eventName" placeholder="" value="" required="" size="32" maxlength="32">
                        <div class="invalid-feedback">
                            Valid event name is required.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="event-type">Type</label>
                        <select class="custom-select d-block w-100" name="type" id="event-type" required="">
                            <option value="mandatory">Mandatory</option>
                            <option value="sports">Sports</option>
                            <option value="social">Social</option>
                            <option value="work">Work</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid type.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="event-points">Points</label>
                        <?php
                        if($familyEvent == "false") {
                            echo "<select class=\"custom-select d-block w-100\" name=\"pointValue\" id=\"pointValue\">";
                            echo "<option value=\"0\">0</option>";
                            echo "<option value=\"5\">5</option>";
                            echo "<option value=\"10\" selected>10</option>";
                            echo "<option value=\"15\">15</option>";
                            echo "<option value=\"20\">20</option>";
                            echo "</select>";
                        } else {
                            echo "<input type=\"text\" class=\"form-control\" name=\"pointValue\" size=5 maxlength=5>";
                        }
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="dateMonth">Month</label>
                        <select class="custom-select d-block w-100" id="dateMonth" name="dateMonth" required="">
                            <option value="01"  <?PHP if($currentmonth==1)echo "selected";?>>January</option>
                            <option value="02"  <?PHP if($currentmonth==2)echo "selected";?>>February</option>
                            <option value="03"  <?PHP if($currentmonth==3)echo "selected";?>>March</option>
                            <option value="04"  <?PHP if($currentmonth==4)echo "selected";?>>April</option>
                            <option value="05"  <?PHP if($currentmonth==5)echo "selected";?>>May</option>
                            <option value="06"  <?PHP if($currentmonth==6)echo "selected";?>>June</option>
                            <option value="07"  <?PHP if($currentmonth==7)echo "selected";?>>July</option>
                            <option value="08"  <?PHP if($currentmonth==8)echo "selected";?>>August</option>
                            <option value="09"  <?PHP if($currentmonth==9)echo "selected";?>>September</option>
                            <option value="10"  <?PHP if($currentmonth==10)echo "selected";?>>October</option>
                            <option value="11"  <?PHP if($currentmonth==11)echo "selected";?>>November</option>
                            <option value="12"  <?PHP if($currentmonth==12)echo "selected";?>>December</option>
                        </select>
                        <div class="invalid-feedback">
                            Please provide a valid month.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="event-day">Day</label>
                        <select class="custom-select d-block w-100" name="dateDay" required="">
                            <option value="00"  <?PHP if($currentday==0) echo "selected";?>>--</option>
                            <option value="01"  <?PHP if($currentday==1) echo "selected";?>>01</option>
                            <option value="02"  <?PHP if($currentday==2) echo "selected";?>>02</option>
                            <option value="03"  <?PHP if($currentday==3) echo "selected";?>>03</option>
                            <option value="04"  <?PHP if($currentday==4) echo "selected";?>>04</option>
                            <option value="05"  <?PHP if($currentday==5) echo "selected";?>>05</option>
                            <option value="06"  <?PHP if($currentday==6) echo "selected";?>>06</option>
                            <option value="07"  <?PHP if($currentday==7) echo "selected";?>>07</option>
                            <option value="08"  <?PHP if($currentday==8) echo "selected";?>>08</option>
                            <option value="09"  <?PHP if($currentday==9) echo "selected";?>>09</option>
                            <option value="10"  <?PHP if($currentday==10) echo "selected";?>>10</option>
                            <option value="11"  <?PHP if($currentday==11) echo "selected";?>>11</option>
                            <option value="12"  <?PHP if($currentday==12) echo "selected";?>>12</option>
                            <option value="13"  <?PHP if($currentday==13) echo "selected";?>>13</option>
                            <option value="14"  <?PHP if($currentday==14) echo "selected";?>>14</option>
                            <option value="15"  <?PHP if($currentday==15) echo "selected";?>>15</option>
                            <option value="16"  <?PHP if($currentday==16) echo "selected";?>>16</option>
                            <option value="17"  <?PHP if($currentday==17) echo "selected";?>>17</option>
                            <option value="18"  <?PHP if($currentday==18) echo "selected";?>>18</option>
                            <option value="19"  <?PHP if($currentday==19) echo "selected";?>>19</option>
                            <option value="20"  <?PHP if($currentday==20) echo "selected";?>>20</option>
                            <option value="21"  <?PHP if($currentday==21) echo "selected";?>>21</option>
                            <option value="22"  <?PHP if($currentday==22) echo "selected";?>>22</option>
                            <option value="23"  <?PHP if($currentday==23) echo "selected";?>>23</option>
                            <option value="24"  <?PHP if($currentday==24) echo "selected";?>>24</option>
                            <option value="25"  <?PHP if($currentday==25) echo "selected";?>>25</option>
                            <option value="26"  <?PHP if($currentday==26) echo "selected";?>>26</option>
                            <option value="27"  <?PHP if($currentday==27) echo "selected";?>>27</option>
                            <option value="28"  <?PHP if($currentday==28) echo "selected";?>>28</option>
                            <option value="29"  <?PHP if($currentday==29) echo "selected";?>>29</option>
                            <option value="30"  <?PHP if($currentday==30) echo "selected";?>>30</option>
                            <option value="31"  <?PHP if($currentday==31) echo "selected";?>>31</option>
                        </select>
                        <div class="invalid-feedback">
                            Event day required.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="event-year">Year</label>
                        <select class="custom-select d-block w-100" name="dateYear" required="">
                            <option value="<?php echo $currentyear; ?>" SELECTED><?php echo $currentyear; ?></option>
                        </select>
                        <div class="invalid-feedback">
                            Event year required.
                        </div>
                    </div>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" name="isBonus" id="bonus-event">
                    <label class="custom-control-label" for="bonus-event">Bonus event?</label>
                </div>
                <button class="btn btn-primary btn-lg btn-block" type="submit">Create event</button>
        </form>
    </div>
        <hr class="mb-4">
    <?php endif ?>

    <?php if (false): ?>
        <div class="row">
            <form class="col-12" name="deleteForm" action="deleteEvent.php" method="POST">
                <h4 class="mb-3">Delete Event</h4>
                <div class="row">
                    <div class="offset-lg-1 col-6 mb-3">
                        <label for="dateMonth">Month</label>
                        <select class="custom-select d-block w-100" id="dateMonth" name="dateMonth" onChange="reload(this.form)" required="">
                            <option value="01"  <?PHP if($selectedMonth==1)echo "selected";?>>January</option>
                            <option value="02"  <?PHP if($selectedMonth==2)echo "selected";?>>February</option>
                            <option value="03"  <?PHP if($selectedMonth==3)echo "selected";?>>March</option>
                            <option value="04"  <?PHP if($selectedMonth==4)echo "selected";?>>April</option>
                            <option value="05"  <?PHP if($selectedMonth==5)echo "selected";?>>May</option>
                            <option value="06"  <?PHP if($selectedMonth==6)echo "selected";?>>June</option>
                            <option value="07"  <?PHP if($selectedMonth==7)echo "selected";?>>July</option>
                            <option value="08"  <?PHP if($selectedMonth==8)echo "selected";?>>August</option>
                            <option value="09"  <?PHP if($selectedMonth==9)echo "selected";?>>September</option>
                            <option value="10"  <?PHP if($selectedMonth==10)echo "selected";?>>October</option>
                            <option value="11"  <?PHP if($selectedMonth==11)echo "selected";?>>November</option>
                            <option value="12"  <?PHP if($selectedMonth==12)echo "selected";?>>December</option>
                        </select>
                        <div class="invalid-feedback">
                            Please provide a valid month.
                        </div>
                    </div>
                    <div class="col-lg-2 col-3 mb-3">
                        <label for="event-day">Day</label>
                        <select class="custom-select d-block w-100" name="dateDay" onChange="reload(this.form)" required="">
                            <option value="00"  <?PHP if($selectedDay==0) echo "selected";?>>--</option>
                            <option value="01"  <?PHP if($selectedDay==1) echo "selected";?>>01</option>
                            <option value="02"  <?PHP if($selectedDay==2) echo "selected";?>>02</option>
                            <option value="03"  <?PHP if($selectedDay==3) echo "selected";?>>03</option>
                            <option value="04"  <?PHP if($selectedDay==4) echo "selected";?>>04</option>
                            <option value="05"  <?PHP if($selectedDay==5) echo "selected";?>>05</option>
                            <option value="06"  <?PHP if($selectedDay==6) echo "selected";?>>06</option>
                            <option value="07"  <?PHP if($selectedDay==7) echo "selected";?>>07</option>
                            <option value="08"  <?PHP if($selectedDay==8) echo "selected";?>>08</option>
                            <option value="09"  <?PHP if($selectedDay==9) echo "selected";?>>09</option>
                            <option value="10"  <?PHP if($selectedDay==10) echo "selected";?>>10</option>
                            <option value="11"  <?PHP if($selectedDay==11) echo "selected";?>>11</option>
                            <option value="12"  <?PHP if($selectedDay==12) echo "selected";?>>12</option>
                            <option value="13"  <?PHP if($selectedDay==13) echo "selected";?>>13</option>
                            <option value="14"  <?PHP if($selectedDay==14) echo "selected";?>>14</option>
                            <option value="15"  <?PHP if($selectedDay==15) echo "selected";?>>15</option>
                            <option value="16"  <?PHP if($selectedDay==16) echo "selected";?>>16</option>
                            <option value="17"  <?PHP if($selectedDay==17) echo "selected";?>>17</option>
                            <option value="18"  <?PHP if($selectedDay==18) echo "selected";?>>18</option>
                            <option value="19"  <?PHP if($selectedDay==19) echo "selected";?>>19</option>
                            <option value="20"  <?PHP if($selectedDay==20) echo "selected";?>>20</option>
                            <option value="21"  <?PHP if($selectedDay==21) echo "selected";?>>21</option>
                            <option value="22"  <?PHP if($selectedDay==22) echo "selected";?>>22</option>
                            <option value="23"  <?PHP if($selectedDay==23) echo "selected";?>>23</option>
                            <option value="24"  <?PHP if($selectedDay==24) echo "selected";?>>24</option>
                            <option value="25"  <?PHP if($selectedDay==25) echo "selected";?>>25</option>
                            <option value="26"  <?PHP if($selectedDay==26) echo "selected";?>>26</option>
                            <option value="27"  <?PHP if($selectedDay==27) echo "selected";?>>27</option>
                            <option value="28"  <?PHP if($selectedDay==28) echo "selected";?>>28</option>
                            <option value="29"  <?PHP if($selectedDay==29) echo "selected";?>>29</option>
                            <option value="30"  <?PHP if($selectedDay==30) echo "selected";?>>30</option>
                            <option value="31"  <?PHP if($selectedDay==31) echo "selected";?>>31</option>
                        </select>
                        <div class="invalid-feedback">
                            Event day required.
                        </div>
                    </div>
                    <div class="col-lg-2 col-3 mb-3">
                        <label for="event-year">Year</label>
                        <select class="custom-select d-block w-100" name="dateYear" onChange="reload(this.form)" required="">
                            <option value="<?php echo $currentyear; ?>" SELECTED><?php echo $currentyear; ?></option>
                        </select>
                        <div class="invalid-feedback">
                            Event year required.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-md-3 col-md-6 col-xs-12 mb-3">
                        <label for="eventID">Event Name: </label></td><td>
                            <select class="custom-select d-block w-100" name="eventID" id="eventID">
                                <option value="">---</option>
                                <?php
                                if($selectedDay != 0) {
                                    $query = $db->prepare("SELECT * FROM Event WHERE dateMonth=:selectedMonth AND dateDay=:selectedDay ORDER BY dateDay");
                                    $query->execute(array('selectedMonth'=>$selectedMonth, 'selectedDay'=>$selectedDay));
                                    $query->setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()) {
                                        echo "<option value=\"";
                                        echo $row['eventID'];
                                        echo "\"";
                                        echo ">".$row['eventName']."</option>";
                                    }
                                } elseif($selectedDay == 0) {
                                    $query = $db->prepare("SELECT * FROM Event WHERE dateMonth=:selectedMonth ORDER BY dateDay");
                                    $query->execute(array('selectedMonth'=>$selectedMonth));
                                    $query->setFetchMode(PDO::FETCH_ASSOC);
                                    while($row = $query->fetch()) {
                                        echo "<option value=\"";
                                        echo $row['eventID'];
                                        echo "\"";
                                        echo ">".$row['eventName']." (".$row['dateMonth']."-".$row['dateDay'].")</option>";
                                    }
                                }
                                ?>
                            </select>
                    </div>
                </div>
                <button class="btn btn-danger btn-lg btn-block" type="submit" onClick="return confirmSubmit()">Delete event</button>
            </form>
        </div>
        <hr class="mb-4">
    <?php endif ?>



    <div class="row">
        <form class="col-12" id="changeForm" name="changeForm" onsubmit="return newvalidate();" action="changeEvent.php" method="POST">
            <div class="mb-4">
                <h4 class="mb-3">Select Event</h4>
                <div class="row">
                    <div class="offset-lg-1 col-6 mb-3">
                        <label for="dateMonth">Month</label>
                        <select class="custom-select d-block w-100" id="dateMonth" name="dateMonth" onChange="reload(this.form)" required="">
                            <option value="01"  <?PHP if($selectedMonth==1)echo "selected";?>>January</option>
                            <option value="02"  <?PHP if($selectedMonth==2)echo "selected";?>>February</option>
                            <option value="03"  <?PHP if($selectedMonth==3)echo "selected";?>>March</option>
                            <option value="04"  <?PHP if($selectedMonth==4)echo "selected";?>>April</option>
                            <option value="05"  <?PHP if($selectedMonth==5)echo "selected";?>>May</option>
                            <option value="06"  <?PHP if($selectedMonth==6)echo "selected";?>>June</option>
                            <option value="07"  <?PHP if($selectedMonth==7)echo "selected";?>>July</option>
                            <option value="08"  <?PHP if($selectedMonth==8)echo "selected";?>>August</option>
                            <option value="09"  <?PHP if($selectedMonth==9)echo "selected";?>>September</option>
                            <option value="10"  <?PHP if($selectedMonth==10)echo "selected";?>>October</option>
                            <option value="11"  <?PHP if($selectedMonth==11)echo "selected";?>>November</option>
                            <option value="12"  <?PHP if($selectedMonth==12)echo "selected";?>>December</option>
                        </select>
                        <div class="invalid-feedback">
                            Please provide a valid month.
                        </div>
                    </div>
                    <div class="col-lg-2 col-3 mb-3">
                        <label for="event-day">Day</label>
                        <select class="custom-select d-block w-100" name="dateDay" onChange="reload(this.form)" required="">
                            <option value="00"  <?PHP if($selectedDay==0) echo "selected";?>>--</option>
                            <option value="01"  <?PHP if($selectedDay==1) echo "selected";?>>01</option>
                            <option value="02"  <?PHP if($selectedDay==2) echo "selected";?>>02</option>
                            <option value="03"  <?PHP if($selectedDay==3) echo "selected";?>>03</option>
                            <option value="04"  <?PHP if($selectedDay==4) echo "selected";?>>04</option>
                            <option value="05"  <?PHP if($selectedDay==5) echo "selected";?>>05</option>
                            <option value="06"  <?PHP if($selectedDay==6) echo "selected";?>>06</option>
                            <option value="07"  <?PHP if($selectedDay==7) echo "selected";?>>07</option>
                            <option value="08"  <?PHP if($selectedDay==8) echo "selected";?>>08</option>
                            <option value="09"  <?PHP if($selectedDay==9) echo "selected";?>>09</option>
                            <option value="10"  <?PHP if($selectedDay==10) echo "selected";?>>10</option>
                            <option value="11"  <?PHP if($selectedDay==11) echo "selected";?>>11</option>
                            <option value="12"  <?PHP if($selectedDay==12) echo "selected";?>>12</option>
                            <option value="13"  <?PHP if($selectedDay==13) echo "selected";?>>13</option>
                            <option value="14"  <?PHP if($selectedDay==14) echo "selected";?>>14</option>
                            <option value="15"  <?PHP if($selectedDay==15) echo "selected";?>>15</option>
                            <option value="16"  <?PHP if($selectedDay==16) echo "selected";?>>16</option>
                            <option value="17"  <?PHP if($selectedDay==17) echo "selected";?>>17</option>
                            <option value="18"  <?PHP if($selectedDay==18) echo "selected";?>>18</option>
                            <option value="19"  <?PHP if($selectedDay==19) echo "selected";?>>19</option>
                            <option value="20"  <?PHP if($selectedDay==20) echo "selected";?>>20</option>
                            <option value="21"  <?PHP if($selectedDay==21) echo "selected";?>>21</option>
                            <option value="22"  <?PHP if($selectedDay==22) echo "selected";?>>22</option>
                            <option value="23"  <?PHP if($selectedDay==23) echo "selected";?>>23</option>
                            <option value="24"  <?PHP if($selectedDay==24) echo "selected";?>>24</option>
                            <option value="25"  <?PHP if($selectedDay==25) echo "selected";?>>25</option>
                            <option value="26"  <?PHP if($selectedDay==26) echo "selected";?>>26</option>
                            <option value="27"  <?PHP if($selectedDay==27) echo "selected";?>>27</option>
                            <option value="28"  <?PHP if($selectedDay==28) echo "selected";?>>28</option>
                            <option value="29"  <?PHP if($selectedDay==29) echo "selected";?>>29</option>
                            <option value="30"  <?PHP if($selectedDay==30) echo "selected";?>>30</option>
                            <option value="31"  <?PHP if($selectedDay==31) echo "selected";?>>31</option>
                        </select>
                        <div class="invalid-feedback">
                            Event day required.
                        </div>
                    </div>
                    <div class="col-lg-2 col-3 mb-3">
                        <label for="event-year">Year</label>
                        <select class="custom-select d-block w-100" name="dateYear" onChange="reload(this.form)" required="">
                            <option value="<?php echo $currentyear; ?>" SELECTED><?php echo $currentyear; ?></option>
                        </select>
                        <div class="invalid-feedback">
                            Event year required.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-md-3 col-md-6 col-xs-12 mb-3">
                        <label for="eventID">Event to update: </label>
                        <select class="custom-select d-block w-100" name="eventID" id="eventID" onchange="reload2(this.form)">
                            <option value="">---</option>
                            <?php
                            if($selectedDay != 0) {
                                $query = $db->prepare("SELECT * FROM Event WHERE dateMonth=:selectedMonth AND dateDay=:selectedDay ORDER BY dateDay");
                                $query->execute(array('selectedMonth'=>$selectedMonth, 'selectedDay'=>$selectedDay));
                                $query->setFetchMode(PDO::FETCH_ASSOC);
                                while($row = $query->fetch()) {
                                    echo "<option value=\"";
                                    echo $row['eventID'];
                                    echo "\"";
                                    echo ">".$row['eventName']."</option>";
                                }
                            } elseif($selectedDay == 0) {
                                $query = $db->prepare("SELECT * FROM Event WHERE dateMonth=:selectedMonth ORDER BY dateDay");
                                $query->execute(array('selectedMonth'=>$selectedMonth));
                                $query->setFetchMode(PDO::FETCH_ASSOC);
                                while($row = $query->fetch()) {
                                    echo "<option value=\"";
                                    echo $row['eventID'];
                                    echo "\"";
                                    echo ">".$row['eventName']." (".$row['dateMonth']."-".$row['dateDay'].")</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <?php
                if($selectedEvent!="none") {
                    $query = $db->prepare("SELECT * FROM Event WHERE eventID = :selectedEvent");
                    $query->execute(array('selectedEvent'=>$selectedEvent));
                    $query->setFetchMode(PDO::FETCH_ASSOC);
                    $retrievedEvent = $query->fetch();
                }
                ?>
            </div>
            <?php if ($selectedEvent!="none" && $retrievedEvent != null): ?>
                <h4>Update Event Information</h4>
                <div class="row mb-3">

                    <div class="offset-md-2 col-md-8 col-xs-12">
<!--                        <h4 class="mt-3 mb-3">Event information</h4>-->
                        <input type="hidden" name="selectedEventID" value="<?php echo $selectedEvent; ?>">
                        <div class="mt-3 row">
                            <div class="col-12 mb-3">
                                <label for="event-name">Event name</label>
                                <input type="text" class="form-control" name="newEventName" placeholder="" value="<?php echo $retrievedEvent['eventName'] ?>" required="" size="32" maxlength="32">
                                <div class="invalid-feedback">
                                    Valid event name is required.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="event-type">Type</label>
                                <select class="custom-select d-block w-100" name="newType" id="newType" required="">
                                    <option value="mandatory"  <?PHP if($retrievedEvent['type']=="mandatory") echo "selected";?>>Mandatory</option>
                                    <option value="sports"  <?PHP if($retrievedEvent['type']=="sports") echo "selected";?>>Sports</option>
                                    <option value="social"  <?PHP if($retrievedEvent['type'] == NULL || !isset($retrievedEvent['type']) || $retrievedEvent['type']=="social") echo "selected";?>>Social</option>
                                    <option value="work"  <?PHP if($retrievedEvent['type']=="work") echo "selected";?>>Work</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid type.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="newPointValue">Points</label>
                                <?php
                                if($isFamilyEvent == "false" || $isFamilyEvent == "none") {
                                    echo "<select class=\"custom-select d-block w-100\" name=\"newPointValue\" id=\"newPointValue\">";
                                    echo "<option value=\"0\"" . (($retrievedEvent['pointValue']==0) ? 'selected' : '') . ">0</option>";
                                    echo "<option value=\"5\"" . (($retrievedEvent['pointValue']==5) ? 'selected' : '') . ">5</option>";
                                    echo "<option value=\"10\"" . (($retrievedEvent['pointValue']==10) ? 'selected' : '') . ">10</option>";
                                    echo "<option value=\"15\"" . (($retrievedEvent['pointValue']==15) ? 'selected' : '') . ">15</option>";
                                    echo "<option value=\"20\"" . (($retrievedEvent['pointValue']==20) ? 'selected' : '') . ">20</option>";
                                    echo "</select>";
                                } else {
                                    echo "<input type=\"text\" class=\"form-control\" name=\"newPointValue\" value=\"".$retrievedEvent['pointValue']."\" size=5 maxlength=5>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dateMonth">Month</label>
                                <select class="custom-select d-block w-100" name="newDateMonth" id="newDateMonth" required="">
                                    <option value="01"  <?PHP if($retrievedEvent['dateMonth']==1)echo "selected";?>>January</option>
                                    <option value="02"  <?PHP if($retrievedEvent['dateMonth']==2)echo "selected";?>>February</option>
                                    <option value="03"  <?PHP if($retrievedEvent['dateMonth']==3)echo "selected";?>>March</option>
                                    <option value="04"  <?PHP if($retrievedEvent['dateMonth']==4)echo "selected";?>>April</option>
                                    <option value="05"  <?PHP if($retrievedEvent['dateMonth']==5)echo "selected";?>>May</option>
                                    <option value="06"  <?PHP if($retrievedEvent['dateMonth']==6)echo "selected";?>>June</option>
                                    <option value="07"  <?PHP if($retrievedEvent['dateMonth']==7)echo "selected";?>>July</option>
                                    <option value="08"  <?PHP if($retrievedEvent['dateMonth']==8)echo "selected";?>>August</option>
                                    <option value="09"  <?PHP if($retrievedEvent['dateMonth']==9)echo "selected";?>>September</option>
                                    <option value="10"  <?PHP if($retrievedEvent['dateMonth']==10)echo "selected";?>>October</option>
                                    <option value="11"  <?PHP if($retrievedEvent['dateMonth']==11)echo "selected";?>>November</option>
                                    <option value="12"  <?PHP if($retrievedEvent['dateMonth']==12)echo "selected";?>>December</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please provide a valid month.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="event-day">Day</label>
                                <select class="custom-select d-block w-100" name="newDateDay" id="newDateDay" required="">
                                    <option value="00"  <?PHP if($retrievedEvent['dateDay']==0) echo "selected";?>>--</option>
                                    <option value="01"  <?PHP if($retrievedEvent['dateDay']==1) echo "selected";?>>01</option>
                                    <option value="02"  <?PHP if($retrievedEvent['dateDay']==2) echo "selected";?>>02</option>
                                    <option value="03"  <?PHP if($retrievedEvent['dateDay']==3) echo "selected";?>>03</option>
                                    <option value="04"  <?PHP if($retrievedEvent['dateDay']==4) echo "selected";?>>04</option>
                                    <option value="05"  <?PHP if($retrievedEvent['dateDay']==5) echo "selected";?>>05</option>
                                    <option value="06"  <?PHP if($retrievedEvent['dateDay']==6) echo "selected";?>>06</option>
                                    <option value="07"  <?PHP if($retrievedEvent['dateDay']==7) echo "selected";?>>07</option>
                                    <option value="08"  <?PHP if($retrievedEvent['dateDay']==8) echo "selected";?>>08</option>
                                    <option value="09"  <?PHP if($retrievedEvent['dateDay']==9) echo "selected";?>>09</option>
                                    <option value="10"  <?PHP if($retrievedEvent['dateDay']==10) echo "selected";?>>10</option>
                                    <option value="11"  <?PHP if($retrievedEvent['dateDay']==11) echo "selected";?>>11</option>
                                    <option value="12"  <?PHP if($retrievedEvent['dateDay']==12) echo "selected";?>>12</option>
                                    <option value="13"  <?PHP if($retrievedEvent['dateDay']==13) echo "selected";?>>13</option>
                                    <option value="14"  <?PHP if($retrievedEvent['dateDay']==14) echo "selected";?>>14</option>
                                    <option value="15"  <?PHP if($retrievedEvent['dateDay']==15) echo "selected";?>>15</option>
                                    <option value="16"  <?PHP if($retrievedEvent['dateDay']==16) echo "selected";?>>16</option>
                                    <option value="17"  <?PHP if($retrievedEvent['dateDay']==17) echo "selected";?>>17</option>
                                    <option value="18"  <?PHP if($retrievedEvent['dateDay']==18) echo "selected";?>>18</option>
                                    <option value="19"  <?PHP if($retrievedEvent['dateDay']==19) echo "selected";?>>19</option>
                                    <option value="20"  <?PHP if($retrievedEvent['dateDay']==20) echo "selected";?>>20</option>
                                    <option value="21"  <?PHP if($retrievedEvent['dateDay']==21) echo "selected";?>>21</option>
                                    <option value="22"  <?PHP if($retrievedEvent['dateDay']==22) echo "selected";?>>22</option>
                                    <option value="23"  <?PHP if($retrievedEvent['dateDay']==23) echo "selected";?>>23</option>
                                    <option value="24"  <?PHP if($retrievedEvent['dateDay']==24) echo "selected";?>>24</option>
                                    <option value="25"  <?PHP if($retrievedEvent['dateDay']==25) echo "selected";?>>25</option>
                                    <option value="26"  <?PHP if($retrievedEvent['dateDay']==26) echo "selected";?>>26</option>
                                    <option value="27"  <?PHP if($retrievedEvent['dateDay']==27) echo "selected";?>>27</option>
                                    <option value="28"  <?PHP if($retrievedEvent['dateDay']==28) echo "selected";?>>28</option>
                                    <option value="29"  <?PHP if($retrievedEvent['dateDay']==29) echo "selected";?>>29</option>
                                    <option value="30"  <?PHP if($retrievedEvent['dateDay']==30) echo "selected";?>>30</option>
                                    <option value="31"  <?PHP if($retrievedEvent['dateDay']==31) echo "selected";?>>31</option>
                                </select>
                                <div class="invalid-feedback">
                                    Event day required.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="event-year">Year</label>
                                <select class="custom-select d-block w-100" name="newDateYear" id="newDateYear" required="">
                                    <option value="<?php echo $retrievedEvent['dateYear']; ?>" SELECTED><?php echo $retrievedEvent['dateYear']; ?></option>
                                </select>
                                <div class="invalid-feedback">
                                    Event year required.
                                </div>
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" name="newIsBonus" id="newIsBonus"
                                <?php
                                if($retrievedEvent['isBonus'] == 1) {
                                    echo "checked=\"yes\"";
                                }
                                ?>
                            >
                            <label class="custom-control-label" for="newIsBonus">Bonus event?</label>
                        </div>
                        <div class="row d-flex justify-content-between mt-3">
                            <button type="submit" class="btn btn-primary col-lg-8 mb-2">Update Event</button>
                            <button type="button" class="btn btn-danger col-lg-3 mb-2" onclick="confirmSubmit()">Delete Event</button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php require "partials/footer.php" ?>
<?php require "partials/scripts.php" ?>
<script type="text/javascript">
    function confirmSubmit()
    {
        if (confirm("Are you sure you want to delete this event? This action cannot be undone.")) {
            document.getElementById('changeForm').action = 'deleteEvent.php';
            document.getElementById('changeForm').submit();
        }
    }
    var whitespace = " \t\n\r";
    function isEmpty(s) {
        var i;
        if((s == null) || (s.length == 0))
            return true;
        // Search string looking for characters that are not whitespace
        for (i = 0; i < s.length; i++) {
            var c = s.charAt(i);
            if (whitespace.indexOf(c) == -1)
                return false;
        }
        // At this point all characters are whitespace.
        return true;
    }
    var intRegex = /^\d+$/;
    function validate() {
        if (isEmpty(document.myform.eventName.value)) {
            alert("Error: Event name is required.");
            document.myform.eventName.focus();
            return false;
        }
        if (isEmpty(document.myform.pointValue.value)) {
            alert("Error: Point value is required.");
            document.myform.pointValue.focus();
            return false;
        }
        if (!intRegex.test(document.myform.pointValue.value) && !isEmpty(document.myform.pointValue.value)) {
            alert("Error: Point value must be an integer.");
            document.myform.pointValue.focus();
            return false;
        }
        return true;
    }
    function newvalidate() {
        if (isEmpty(document.changeForm.newEventName.value)) {
            alert("Error: Event name is required.");
            document.changeForm.newEventName.focus();
            return false;
        }
        if (isEmpty(document.changeForm.newPointValue.value)) {
            alert("Error: Point value is required.");
            document.changeForm.newPointValue.focus();
            return false;
        }
        if (!intRegex.test(document.changeForm.newPointValue.value) && !isEmpty(document.changeForm.newPointValue.value)) {
            alert("Error: Point value must be an integer.");
            document.changeForm.newPointValue.focus();
            return false;
        }
        return true;
    }
    function reload(form){
        var day=form.dateDay.options[form.dateDay.options.selectedIndex].value;
        var month=form.dateMonth.options[form.dateMonth.options.selectedIndex].value;
        self.location='editEvents.php?dateMonth=' + month + '&dateDay=' + day;
    }
    function reload2(form){
        var day=form.dateDay.options[form.dateDay.options.selectedIndex].value;
        var month=form.dateMonth.options[form.dateMonth.options.selectedIndex].value;
        var eventID=form.eventID.options[form.eventID.options.selectedIndex].value;
        self.location='editEvents.php?dateMonth=' + month + '&dateDay=' + day + '&eventID=' + eventID;
    }
    function reload3(form){
        var day=form.dateDay.options[form.dateDay.options.selectedIndex].value;
        var month=form.dateMonth.options[form.dateMonth.options.selectedIndex].value;
        var eventID=form.selectedEventID.value;
        if(form.newIsFamilyEvent.checked) {
            var isFamilyEvent="true";
            self.location='editEvents.php?dateMonth=' + month + '&dateDay=' + day + '&eventID=' + eventID + '&isFamilyEvent=' + isFamilyEvent;
        } else {
            var isFamilyEvent="false";
            self.location='editEvents.php?dateMonth=' + month + '&dateDay=' + day + '&eventID=' + eventID + '&isFamilyEvent=' + isFamilyEvent;
        }
    }
    function rereload(form){
        if(form.isFamilyEvent.checked) {
            var familyEvent="true";
            self.location='editEvents.php?familyEvent=' + familyEvent;
        } else {
            self.location='editEvents.php';
        }
    }
</script>
</body>

</html>
