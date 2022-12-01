<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="asterisk-required">Company Email</label>
            <input type="email" class="form-control" name="email" value="<?= $employee->email ?>" placeholder="email@elink.com.ph" required />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Personal Email</label>
            <input type="email" class="form-control" name="email2" value="<?= $employee->email2 ?>" placeholder="personal@email.com" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Secondary Email</label>
            <input type="email" class="form-control" name="email3" value="<?= $employee->email3 ?>" placeholder="secondary@email.com" />
        </div>
    </div>
</div>