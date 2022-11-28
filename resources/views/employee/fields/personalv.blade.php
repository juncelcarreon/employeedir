<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>First Name</label>
            <input  class="form-control" placeholder="First Name" name="first_name" value="<?= @$employee->first_name ?>" readonly="1"> 
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Middle Name</label>
            <input class="form-control" placeholder="Middle Name" name="middle_name" value="<?= @$employee->middle_name ?>" readonly="1">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Last Name</label>
            <input class="form-control" placeholder="Last Name" name="last_name" value="<?= @$employee->last_name ?>" readonly="1">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Employee ID</label>
            <input class="form-control" placeholder="Employee ID" name="eid" value="<?= @$employee->eid ?>" maxLength="20" readonly="1">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Phone Name</label>
            <input class="form-control" placeholder="Phone Name" name="alias" value="<?= @$employee->alias ?>" readonly="1">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Birthdate</label>
            <input class="form-control" placeholder="Birthdate" name="birth_date" value="<?= @$employee->birthdate() ?>" readonly="1">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Contact Number</label>
            <input type="text" class="form-control" name="contact_number" maxLength="20" value="<?= @$employee->contact_number ?>" readonly="1">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php
            $gender = 'Male';
            if(@$employee->gender == 2) { $gender = 'Female'; }
            ?>
            <label>Gender</label>
            <input type="text" class="form-control" placeholder="Gender" name="gender_id" value="<?= @$gender ?>" readonly="1">
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
            <input type="text" class="form-control" placeholder="Civil Status" name="civil_status" value="<?= @$civil_status ?>" readonly="1">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Avega Number</label>
            <input type="text" class="form-control" name="avega_num" value="<?= isset($details->avega_num) ? $details->avega_num : "" ?>" readonly="1">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>City Address</label>
            <textarea name="address" class="form-control" readonly="1" maxLength="200" rows="4"><?= @$employee->address ?></textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Home Town Address</label>
            <textarea name="town_address" class="form-control" readonly="1" rows="4"><?= @$details->town_address ?></textarea>
        </div>
    </div>
</div>