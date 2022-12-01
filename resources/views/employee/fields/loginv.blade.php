<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Company Email</label>
            <input type="email" class="form-control" name="email" value="<?= $employee->email ?>" readonly />
        </div>
    </div>
    <?php
    if($employee->email2 != "") {
    ?>
    <div class="col-md-4">
        <div class="form-group">
            <label>Personal Email</label>
            <input type="email" class="form-control" name="email2" value="<?= $employee->email2 ?>" readonly />
        </div>
    </div>
    <?php
    }
    if($employee->email2 != "") {
    ?>
    <div class="col-md-4">
        <div class="form-group">
            <label>Secondary Email</label>
            <input type="email" class="form-control" name="email3" value="<?= $employee->email3 ?>" readonly />
        </div>
    </div>
    <?php
    }
    ?>
</div>