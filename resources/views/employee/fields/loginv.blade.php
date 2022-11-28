<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Company Email</label>
            <input class="form-control" readonly="1" placeholder="Company Email" name="email" value="<?= $employee->email ?>">
        </div>
    </div>
    <?php
    if($employee->email2 != "") {
    ?>
    <div class="col-md-4">
        <div class="form-group">
            <label>Personal Email</label>
            <input class="form-control" readonly="1" placeholder="Personal Email" name="email2" type="email" value="<?= $employee->email2 ?>">
        </div>
    </div>
    <?php
    }
    if($employee->email2 != "") {
    ?>
    <div class="col-md-4">
        <div class="form-group">
            <label>Secondary Email</label>
            <input class="form-control" readonly="1" placeholder="Secondary Email" name="email3" type="email" value="<?= $employee->email3 ?>">
        </div>
    </div>
    <?php
    }
    ?>
</div>