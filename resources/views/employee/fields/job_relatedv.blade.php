<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Position</label>
            <input class="form-control" readonly="1" placeholder="Position" name="position_name" value="<?= @$employee->position_name ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php
            $account_name = '';
            foreach($accounts as $account) {
                if(@$employee->account_id == $account->id) {
                    $account_name = $account->account_name;
                }
            }
            ?>
            <label>Account</label>
            <input class="form-control" readonly="1" placeholder="Account" name="account_id" value="<?= @$account_name ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Team/Department</label>
            <input class="form-control" readonly="1" placeholder="Team/Department" name="team_name" value="<?= @$employee->team_name ?>">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Manager</label>
            <input class="form-control" readonly="1" placeholder="Manager" name="manager_id" value="<?= @$employee->manager_name ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Immediate Superior</label>
            <input class="form-control" readonly="1" placeholder="Immediate Superior" name="supervisor_id" value="<?= @$employee->supervisor_name ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php
            $type = 'Probationary';
            switch($employee->is_regular) {
                case 1: $type = 'Regular'; break;
                case 2: $type = 'Project Based'; break;
            }
            ?>
            <label>Type</label>
            <input class="form-control" readonly="1" placeholder="Type" name="is_regular" value="<?= @$type ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php
            $category = 'Rank';
            switch($employee->employee_category) {
                case 1: $category = 'Manager'; break;
                case 2: $category = 'Supervisor'; break;
                case 3: $category = 'Support'; break;
            }
            ?>
            <label>Category</label>
            <input class="form-control" readonly="1" placeholder="Type" name="is_regular" value="<?= @$category ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Hire Date</label>
            <input class="form-control" readonly="1" placeholder="Hire Date" name="hired_date" value="<?= @$employee->datehired() ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Production Date</label>
            <input class="form-control" readonly="1" placeholder="Hire Date" name="prod_date" value="<?= @$employee->prodDate() ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Regularization Date</label>
            <input type="text" readonly="1" placeholder="Regularization Date" name="regularization_date" class="form-control" value="<?= @$employee->regularization_date == '1970-01-01' ? '' : @$employee->regularization_date ?>" autocomplete="off">
        </div>
    </div>
    <input type="hidden" class="form-control" placeholder="Ext" name="status_id" value="<?= @$employee->status || 1 ?>" >
    <div class="col-md-4">
        <div class="form-group">
            <label>EXT</label>
            <input readonly="1" class="form-control" placeholder="Ext" name="ext" value="<?= @$employee->ext ?>" >
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Wave</label>
            <input readonly="1" class="form-control" placeholder="Wave" name="wave" value="<?= @$employee->wave ?>" >
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Resignation Date </label>
            <input class="form-control" readonly="1" placeholder="Resignation Date" name="resignation_date" value="<?= @$details->resignation_date == '1970-01-01' ? '' : @$details->resignation_date ?>" >
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php
            $rehirable = 'No';
            if(@$details->rehirable) {
                $rehirable = 'Yes';
            }
            ?>
            <label>Rehirable</label>
            <input readonly="1" class="form-control" placeholder="Rehirable" name="rehirable" value="<?= @$rehirable ?>">
        </div>
    </div> 
    <div class="col-md-12">
        <div class="form-group">
            <label>Reason</label>
            <input type="text" name="rehire_reason" class="form-control" value="{{ @$details->rehire_reason }}" readonly="">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <input type="checkbox" disabled="1" name="all_access" <?php echo @$employee->all_access == 1 ? "checked" : "" ; ?>> &nbsp;
            <span for="all_access">can view information from other account ?</span>
        </div>
    </div>
</div>