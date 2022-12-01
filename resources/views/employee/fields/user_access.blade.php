<div class="row">
    <div class="col-md-12">
        <input type="radio" id="employee" name="employee_type" value="1"<?= $employee->usertype == 1 ? ' checked' : '' ?> />
        <label class="radio-label" for="employee">Employee</label>
            &nbsp;
            &nbsp;
        <input type="radio" id="supervisor" name="employee_type" value="2"<?= $employee->usertype == 2 ? ' checked' : '' ?> />
        <label class="radio-label" for="supervisor">Supervisor</label>
            &nbsp;
            &nbsp;
        <input type="radio" id="manager" name="employee_type" value="3"<?= $employee->usertype == 3 ? ' checked' : '' ?> />
        <label class="radio-label" for="manager">Manager</label>
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            |
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
        <input type="checkbox" id="admin" name="is_admin"<?= $employee->is_admin == 1 ? ' checked' : '' ?> />
        <label class="radio-label" for="admin">WebsiteAdmin</label>
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
        <input type="checkbox" id="hr" name="is_hr"<?= $employee->is_hr == 1 ? ' checked' : '' ?> />
        <label class="radio-label" for="hr">HR</label>
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
        <input type="checkbox" id="erp" name="is_erp"<?= $employee->is_erp == 1 ? ' checked' : '' ?> />
        <label class="radio-label" for="erp">ERP</label>
    </div>
</div>