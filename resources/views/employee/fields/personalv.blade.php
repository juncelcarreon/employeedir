<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>First Name</label>
            <input  class="form-control" name="first_name" value="<?= @$employee->first_name ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Middle Name</label>
            <input class="form-control" name="middle_name" value="<?= @$employee->middle_name ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Last Name</label>
            <input class="form-control" name="last_name" value="<?= @$employee->last_name ?>" readonly />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Employee ID</label>
            <input class="form-control" name="eid" value="<?= @$employee->eid ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Phone Name</label>
            <input class="form-control" name="alias" value="<?= @$employee->alias ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Birthdate</label>
            <input class="form-control" name="birth_date" value="<?= @$employee->birthdate() ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Contact Number</label>
            <input type="text" class="form-control" name="contact_number" value="<?= @$employee->contact_number ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php
            $gender = 'Male';
            if(@$employee->gender == 2) { $gender = 'Female'; }
            ?>
            <label>Gender</label>
            <input type="text" class="form-control" placeholder="Gender" name="gender_id" value="<?= @$gender ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php
            $civil_status = 'Divorced';
            switch(@$employee->civil_status) {
                case 1: $civil_status = 'Single'; break;
                case 2: $civil_status = 'Married'; break;
                case 3: $civil_status = 'Separated'; break;
                case 4: $civil_status = 'Annulled'; break;
            }
            ?>
            <label>Civil Status</label>
            <input type="text" class="form-control" placeholder="Civil Status" name="civil_status" value="<?= @$civil_status ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Avega Number</label>
            <input type="text" class="form-control" name="avega_num" value="<?= isset($details->avega_num) ? $details->avega_num : "" ?>" readonly />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>City Address</label>
            <textarea name="address" class="form-control" rows="4" readonly><?= @$employee->address ?></textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Home Town Address</label>
            <textarea name="town_address" class="form-control" rows="4" readonly><?= @$details->town_address ?></textarea>
        </div>
    </div>
</div>