<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>SSS Number</label>
            <input type="text" class="form-control" name="sss" value="<?= @$employee->sss ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Pag-ibig/HDMF</label>
            <input type="text" class="form-control" name="pagibig" value="<?= @$employee->pagibig ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Philhealth Number</label>
            <input type="text" class="form-control" name="philhealth" value="<?= @$employee->philhealth ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>TIN ID</label>
            <input type="text" class="form-control" name="tin" value="<?= @$employee->tin ?>" readonly />
        </div>
    </div>
</div>