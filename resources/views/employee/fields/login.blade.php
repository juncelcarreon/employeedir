<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="asterisk-required">Company Email</label>
            <input class="form-control" placeholder="Company Email" name="email" value="<?= $employee->email ?>" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Personal Email</label>
            <input class="form-control" placeholder="Personal Email" name="email2" type="email" value="<?= $employee->email2 ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Secondary Email</label>
            <input class="form-control" placeholder="Secondary Email" name="email3" type="email" value="<?= $employee->email3 ?>">
        </div>
    </div>
</div>