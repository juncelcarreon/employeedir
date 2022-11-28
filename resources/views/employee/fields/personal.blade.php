<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="asterisk-required">First Name</label>
            <input  class="form-control" placeholder="First Name" name="first_name" value="<?= @$employee->first_name ?>" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Middle Name</label>
            <input class="form-control" placeholder="Middle Name" name="middle_name" value="<?= @$employee->middle_name ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="asterisk-required">Last Name</label>
            <input class="form-control" placeholder="Last Name" name="last_name" value="<?= @$employee->last_name ?>" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="asterisk-required">Employee ID</label>
            <input class="form-control" placeholder="Employee ID" name="eid" value="<?= @$employee->eid ?>" maxLength="20" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Phone Name</label>
            <input class="form-control" placeholder="Phone Name" name="alias" value="<?= @$employee->alias ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Birthdate</label>
            <input class="form-control datepicker" placeholder="Birthdate" name="birth_date" value="<?= @$employee->birthdate() ?>" >
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Contact Number</label>            
            <input type="text" class="form-control" name="contact_number" maxLength="20" value="<?= @$employee->contact_number ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Gender</label><br>
            <input type="radio" id="male" name="gender_id" value="1" placeholder="test" <?= @$employee->gender == 1 ? "checked" : "" ; ?>>
            <label class="radio-label" for="male">Male</label>
            &nbsp;
            &nbsp;
            <input type="radio" id="female" name="gender_id" value="2" placeholder="test" <?= @$employee->gender == 2 ? "checked" : "" ; ?>>
            <label class="radio-label" for="female" >Female</label>
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
            <input type="text" class="form-control" name="avega_num" value="<?= $details->avega_num ?>">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>City Address</label>
            <textarea name="address" class="form-control" rows="4">{{ @$employee->address }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Home Town Address</label>
            <textarea name="town_address" class="form-control" rows="4">{{ @$details->town_address }}</textarea>
        </div>
    </div>
</div>