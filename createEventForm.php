<?php require "set_session_vars_full.php"; ?>
<?php if ($isEventAdmin || $isAdmin): ?>

    <form action="createEvent.php" method="POST" class="mt-3">

        <div class="row g-0 align-items-center">

            <!-- Event Name -->
            <div class="col-lg-3 mb-1">
                <input type="text" name="eventName" class="form-control" placeholder="Event Name" required>
            </div>

            <!-- Date Group: Month, Day, Year (Inline) -->
            <div class="col-lg-4 d-flex align-items-center mb-1">

                <!-- Month -->
                <select name="dateMonth" class="form-control me-1" required>
                    <option value="">Month</option>
                    <?php foreach (range(1, 12) as $month): ?>
                        <option value="<?= $month ?>"><?= date('F', mktime(0, 0, 0, $month, 1)) ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Day -->
                <select name="dateDay" class="form-control me-1" required>
                    <option value="">Day</option>
                    <?php foreach (range(1, 31) as $day): ?>
                        <option value="<?= $day ?>"><?= $day ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Year (Current Year Only) -->
                <select name="dateYear" class="form-control" required>
                    <option value="<?= date('Y') ?>"><?= date('Y') ?></option>
                </select>
            </div>

            <!-- Event Type -->
            <div class="col-lg-3 d-flex align-items-center mb-1">
                <select name="type" class="form-control me-1" required>
                    <option value="">Type</option>
                    <option value="mandatory">Mandatory</option>
                    <option value="sports">Sports</option>
                    <option value="social">Social</option>
                    <option value="work">Work</option>
                </select>
                <select name="pointValue" class="form-control me-1" required>
                    <option value="">Points</option>
                    <?php foreach ([0, 5, 10, 15, 20] as $points): ?>
                        <option value="<?= $points ?>"><?= $points ?> Points</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-lg-2 d-flex align-items-center justify-content-end">
                <div class="form-check" style="margin-right: 10px;">
                    <input type="checkbox" name="isBonus" id="isBonus" class="form-check-input">
                    <label for="isBonus" class="form-check-label">Bonus</label>
                </div>
                <input type="submit" class="btn btn-primary" value="Add">
            </div>


        </div>
    </form>


<!--    <div class="row mt-3">-->
<!--        <div class="col-12">-->
<!--            <h4>Additional Event Management</h4>-->
<!--            <a href="/editEvents.php" class="btn btn-outline-secondary mr-2">Edit and Remove Events</a>-->
<!--        </div>-->
<!--    </div>-->
<?php endif ?>