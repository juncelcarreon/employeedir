<div class="row">
    <div class="col-md-12">
        <input type="radio" disabled="1" <?= $employee->usertype == 1 ? 'checked' : '' ?> id="employee" name="employee_type" value="1" placeholder="test">
        <label class="radio-label" for="employee">Employee</label>
            &nbsp;
            &nbsp;
        <input type="radio" disabled="1" <?= $employee->usertype == 2 ? 'checked' : '' ?> id="supervisor" name="employee_type" value="2" placeholder="test">
        <label class="radio-label" for="supervisor">Supervisor</label>
            &nbsp;
            &nbsp;
        <input type="radio" disabled="1" <?= $employee->usertype == 3 ? 'checked' : '' ?> id="manager" name="employee_type" value="3" placeholder="test">
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
        <input type="checkbox" disabled="1" <?= $employee->is_admin == 1 ? 'checked' : '' ?> id="admin" name="is_admin">
        <label class="radio-label" for="admin">WebsiteAdmin</label>
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
        <input type="checkbox" disabled="1" <?= $employee->is_hr == 1 ? 'checked' : '' ?> id="hr" name="is_hr">
        <label class="radio-label" for="hr">HR</label>
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
        <input type="checkbox" disabled="1" <?= $employee->is_erp == 1 ? 'checked' : '' ?> id="erp" name="is_erp">
        <label class="radio-label" for="erp">ERP</label>
            &nbsp;
            &nbsp;
    </div>
</div>
<link rel="stylesheet" href="{{asset('./css/custom-bootstrap.css')}}">

