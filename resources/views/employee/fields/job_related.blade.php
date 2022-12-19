<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="asterisk-required">Position</label>
            <input class="form-control" name="position_name" placeholder="Position" value="<?= @$employee->position_name ?>" required />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="asterisk-required">Account</label>
             <select class="select2 form-control" name="account_id" required>
                <option disabled>Select</option>
                <?php
                foreach($accounts as $account) {
                ?>
                <option value="<?= $account->id ?>"<?= @$employee->account_id == $account->id ? " selected" : "" ; ?>><?= $account->account_name ?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="asterisk-required">Team/Department</label>
            <select class="select2 form-control" id="_team_name" name="team_name" required>
                <option disabled>Select</option>
                <?php
                foreach($departments as $department) {
                ?>
                <option data-_dept_code="<?= $department->department_code ?>" value="<?= $department->department_name ?>"<?= $department->department_name == @$employee->team_name ? " selected" : "";?>><?= $department->department_name ?></option>
                <?php
                }
                ?>
            </select>
            <input type="hidden" id="_dept_code" name="dept_code" value="<?= $employee->dept_code ?>" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Manager</label>
            <select class="select2 form-control" name="manager_id">
                <option value="0" selected>Select</option>
                <?php
                foreach($supervisors as $supervisor) {
                ?>
                <option value="<?= $supervisor->id ?>"<?= $supervisor->id == @$employee->manager_id ? " selected" : "" ; ?>><?= $supervisor->fullname() ?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Immediate Superior / Supervisor</label>
            <select class="select2 form-control" name="supervisor_id">
                <option value="0" selected>Select</option>
                <?php
                foreach($supervisors as $supervisor) {
                ?>
                <option value="<?= $supervisor->id ?>"<?= $supervisor->id == @$employee->supervisor_id ? " selected" : "" ; ?>><?= $supervisor->fullname() ?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Employee Type</label>
            <select name="is_regular" class="select2 is_reg_event form-control">
                <option value="0"<?= $employee->is_regular == 0 ? ' selected' : '' ?>>Probationary</option>
                <option value="1"<?= $employee->is_regular == 1 ? ' selected' : '' ?>>Regular</option>
                <option value="2"<?= $employee->is_regular == 2 ? ' selected' : '' ?>>Project Based</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Employee Category</label>
            <select name="employee_category" class="select2 form-control">
                <option value="1"<?= $employee->employee_category == 1 ? ' selected' : '' ?>>Manager</option>
                <option value="2"<?= $employee->employee_category == 2 ? ' selected' : '' ?>>Supervisor</option>
                <option value="3"<?= $employee->employee_category == 3 ? ' selected' : '' ?>>Support</option>
                <option value="4"<?= $employee->employee_category == 4 ? ' selected' : '' ?>>Rank</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Hire Date</label>
            <input type="text" class="form-control datetimepicker" name="hired_date" value="<?= @$employee->datehired() ?>" placeholder="MM/DD/YYYY" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Production Date</label>
            <input type="text" class="form-control datetimepicker" name="prod_date" value="<?= @$employee->prodDate() ?>" placeholder="MM/DD/YYYY" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Regularization Date</label>
            <input type="text" name="regularization_date" class="form-control datetimepicker" value="<?= @$employee->regularization_date == '1970-01-01' ? '' : date('m/d/Y', strtotime(@$employee->regularization_date)) ?>" placeholder="MM/DD/YYYY" autocomplete="off" />
        </div>
    </div>
    <input type="hidden" name="status_id" value="{{@$employee->status || 1}}" />
    <div class="col-md-4">
        <div class="form-group">
            <label>EXT</label>
            <input type="text" class="form-control" placeholder="Ext" name="ext" value="<?= @$employee->ext ?>"  />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Wave</label>
            <input type="text" class="form-control" placeholder="Wave" name="wave" value="<?= @$employee->wave ?>" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Resignation Date </label>
            <input type="text" class="form-control datetimepicker" name="resignation_date" value="<?= @$details->resignation_date == '1970-01-01' ? '' : date('m/d/Y', strtotime(@$details->resignation_date)) ?>" placeholder="MM/DD/YYYY" autocomplete="off" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Rehirable</label>
            <select class="select2 form-control" name="rehirable">
                <option disabled>Select</option>
                <option<?= @$details->rehirable == 1 ? " selected" : "" ; ?> value="1">Yes</option>
                <option<?= @$details->rehirable == 0 ? " selected" : "" ; ?> value="0">No</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>&nbsp;</label>
            <a id="btnViewMovments" class="btn btn-warning form-control text-dark" href="#" data-toggle="modal" data-target="#modalMovements">Movements/Transfer</a>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Reason</label>
            <input type="text" name="rehire_reason" class="form-control" value="<?= @$details->rehire_reason ?>" placeholder="State your reason..." />
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <input type="checkbox" name="all_access"<?= @$employee->all_access == 1 ? " checked" : "" ; ?> /> &nbsp;
            <span for="all_access">can view information from other account ?</span>
        </div>
    </div>
</div>
