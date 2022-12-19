<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Position</label>
            <input type="text" class="form-control" name="position_name" value="<?= @$employee->position_name ?>" readonly />
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
            <input type="text" class="form-control" name="account_id" value="<?= @$account_name ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Team/Department</label>
            <input type="text" class="form-control" name="team_name" value="<?= @$employee->team_name ?>" readonly />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Manager</label>
            <?php
            $manager_name = '';
            foreach($supervisors as $supervisor) {
                if($supervisor->id == @$employee->manager_id) {
                    $manager_name = $supervisor->fullname();
                }
            }
            ?>
            <input type="text" class="form-control" name="manager_id" value="<?= @$manager_name ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Immediate Superior / Supervisor</label>
            <?php
            $supervisor_name = '';
            foreach($supervisors as $supervisor) {
                if($supervisor->id == @$employee->supervisor_id) {
                    $supervisor_name = $supervisor->fullname();
                }
            }
            ?>
            <input type="text" class="form-control" name="supervisor_id" value="<?= @$supervisor_name ?>" readonly />
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
            <label>Employee Type</label>
            <input type="text" class="form-control" name="is_regular" value="<?= @$type ?>" readonly />
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
            <label>Employee Category</label>
            <input type="text" class="form-control" name="is_regular" value="<?= @$category ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Hire Date</label>
            <input type="text" class="form-control" name="hired_date" value="<?= @$employee->datehired() ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Production Date</label>
            <input type="text" class="form-control" name="prod_date" value="<?= @$employee->prodDate() ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Regularization Date</label>
            <input type="text" name="regularization_date" class="form-control" value="<?= @$employee->regularization_date == '1970-01-01' ? '' : date('m/d/Y', strtotime(@$employee->regularization_date)) ?>" autocomplete="off" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>EXT</label>
            <input type="text" class="form-control" name="ext" value="<?= @$employee->ext ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Wave</label>
            <input type="text" class="form-control" name="wave" value="<?= @$employee->wave ?>" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Resignation Date </label>
            <input type="text" class="form-control" name="resignation_date" value="<?= @$details->resignation_date == '1970-01-01' ? '' : date('m/d/Y', strtotime(@$details->resignation_date)) ?>" readonly />
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
            <input type="text" class="form-control" name="rehirable" value="<?= @$rehirable ?>" readonly />
        </div>
    </div> 
    <div class="col-md-12">
        <div class="form-group">
            <label>Reason</label>
            <input type="text" name="rehire_reason" class="form-control" value="<?= @$details->rehire_reason ?>" readonly />
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <input type="checkbox" disabled="1" name="all_access"<?= @$employee->all_access == 1 ? " checked" : "" ; ?> /> &nbsp;
            <span for="all_access">can view information from other account ?</span>
        </div>
    </div>
</div>