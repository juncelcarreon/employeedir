<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="asterisk-required">First Name</label>
            <input type="text" class="form-control" name="first_name" value="<?= @$employee->first_name ?>" placeholder="First Name" required />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Middle Name</label>
            <input type="text" class="form-control" name="middle_name" value="<?= @$employee->middle_name ?>" placeholder="Middle Name" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="asterisk-required">Last Name</label>
            <input type="text" class="form-control" name="last_name" value="<?= @$employee->last_name ?>" placeholder="Last Name" required />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="asterisk-required">Employee ID</label>
            <input type="text" class="form-control" name="eid" value="<?= @$employee->eid ?>" placeholder="ESCC-xxxxxxx" required />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Phone Name</label>
            <input type="text" class="form-control" name="alias" value="<?= @$employee->alias ?>" placeholder="Phone Name" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="asterisk-required">Birthdate</label>
            <input type="text" class="form-control datetimepicker" name="birth_date" value="<?= @$employee->birthdate() ?>" placeholder="MM/DD/YYYY" required />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Contact Number</label>
            <input type="text" class="form-control" name="contact_number" value="<?= @$employee->contact_number ?>" placeholder="xxxx-xxx-xxxx" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Gender</label><br>
            <input type="radio" id="male" name="gender_id" value="1" placeholder="test"<?= @$employee->gender == 1 ? " checked" : "" ; ?> />
            <label class="radio-label" for="male">Male</label>
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            <input type="radio" id="female" name="gender_id" value="2" placeholder="test"<?= @$employee->gender == 2 ? " checked" : "" ; ?> />
            <label class="radio-label" for="female">Female</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Civil Status</label>
            <select name="civil_status" class="form-control select2">
                <option value="1"<?= @$employee->civil_status == 1 ? ' selected' : '' ?>>Single</option>
                <option value="2"<?= @$employee->civil_status == 2 ? ' selected' : '' ?>>Married</option>
                <option value="3"<?= @$employee->civil_status == 3 ? ' selected' : '' ?>>Separated</option>
                <option value="4"<?= @$employee->civil_status == 4 ? ' selected' : '' ?>>Anulled</option>
                <option value="5"<?= @$employee->civil_status == 5 ? ' selected' : '' ?>>Divorced</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Avega Number</label>
            <input type="text" class="form-control" name="avega_num" value="<?= empty($details->avega_num) ? '' : $details->avega_num ?>" placeholder="xx-xx-xxxxx-xxxxx-xx" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>City Address</label>
            <textarea name="address" class="form-control" rows="4"><?= @$employee->address ?></textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Home Town Address</label>
            <textarea name="town_address" class="form-control" rows="4"><?= empty($details->town_address) ? '' : $details->town_address ?></textarea>
        </div>
    </div>
</div>