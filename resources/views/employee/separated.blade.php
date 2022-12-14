@extends('layouts.main')
@section('title')
Employees > Separated Employees
@endsection
@section('head')
<style type="text/css">
@include('employee.style');
</style>
@endsection
@section('breadcrumb')
Employees <span>></span> Separated Employees
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="alphabet-search d-flex">
            <form>
                <input type="hidden" name="alphabet" value="<?= $request->alphabet ?>">
                <input type="hidden" name="department" value="<?= $request->department ?>">
                <input type="text" placeholder="Search by name" id="search_employee" name="keyword" value="<?= $request->keyword ?>">
                <button class="btn btn-primary">
                    <span class="fa fa-search"></span>
                </button>
            </form>

            <a href="/download-inactive?<?= (empty($_SERVER['QUERY_STRING']) ? '' : $_SERVER['QUERY_STRING']) ?>" class="btn btn-success"><span class="fa fa-download">&nbsp;</span> DOWNLOAD SEPARATED EMPLOYEES</a>
        </div>
    </div>
</div>
<?php
if(count($employees) == 0) {
?>
<div class="row">
    <div class="col-md-12">
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="text-center">
            <h3>No results found.</h3>
        </div>
    </div>
</div>
<?php
}
foreach($employees as $employee) {
?>
<div class="row">
    <div class="col-md-12">
        <div class="emp-profile">
            <div class="row d-flex">
                <div class="col-md-1">
                    <div class="emp-image">
                        <img src="<?= $employee->profile_img ?>" alt="<?= $employee->fullname() ?>" />
                    </div>
                </div>
                <div class="col-md-3">
                    <h4 class="timeline-title name-format">
                        <a href="<?= url("profile/{$employee->id}") ?>"><?= $employee->fullname() ?></a>
                    </h4>
                    <h5><?= $employee->position_name ?></h5>
                    <h6 class="employee-account"><?= $employee->team_name.(isset($employee->account) ? "- ". $employee->account->account_name : ""); ?></h6>
                </div>
                <div class="col-md-3">
                    <h5>
                        <span class="fa fa-id-card" title="Employee ID">&nbsp;&nbsp;</span>
                        <span class="employee-description"><?= $employee->eid ?></span>
                    </h5>
                    <h5 class="employee-email-description">
                        <span class="fa fa-envelope" title="Email Address">&nbsp;&nbsp;</span>
                        <span class="employee-description employee-email" title="<?= $employee->email ?>"><?= $employee->email ?></span>
                    </h5>
                <?php
                if(isset($employee->ext) && $employee->ext != '--' && $employee->ext != '') {
                ?>
                    <h5>
                        <span class="fa fa-phone" title="Extension Number"></span>
                        <span class="employee-description">&nbsp;&nbsp;<?= $employee->ext ?></span>
                    </h5>
                <?php
                }
                if(isset($employee->alias) && $employee->alias != '--' && $employee->alias != '') {
                ?>
                    <h5>
                        <span class="fa fa-mobile" title="Phone Name"></span>
                        <span class="employee-description">&nbsp;&nbsp;<?= $employee->alias ?></span>
                    </h5>
                <?php
                }
                ?>
                </div>
                <div class="col-md-3">
                <?php
                if(isset($employee->supervisor_name)) {
                ?>
                    <h6>
                        <span class="fa fa-user" title="Immediate Superior"></span>
                        <span class="name-format">Immediate Superior:</span>
                        <?= $employee->supervisor_name ?>
                    </h6>
                <?php
                }
                if(isset($employee->manager_name)) {
                ?>
                    <h6>
                        <span class="fa fa-user" title="Manager"></span>
                        <span class="name-format">Manager: </span>
                        <?= $employee->manager_name ?>
                    </h6>
                <?php
                }
                ?>
                </div>
                <div class="col-md-2">
                    <div class="options">
                        <a href="<?= url("profile/{$employee->id}") ?>" title="View">
                            <i class="fa fa-eye"></i>
                        </a>&nbsp;&nbsp;
                    <?php
                    if($employee->isActive()) {
                    ?>
                        <a href="<?= url("employee_info/{$employee->id}/edit") ?>" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>&nbsp;&nbsp;
                        <a href="#" class="delete_btn" data-toggle="modal" data-target="#messageModal" title="Deactivate" data-id="<?= $employee->id ?>">
                            <i class="fa fa-user-times"></i>
                        </a>
                    <?php
                    } else {
                    ?>
                        <a href="<?= url("employees/{$employee->id}/reactivate") ?>" title="Reactivate Employee" data-id="<?= $employee->id ?>">
                            <i class="fa fa-user-plus"></i>
                        </a>
                    <?php
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<?php
    if($employees->appends(Illuminate\Support\Facades\Input::except('page'))->hasPages()) {
?>
<div class="row">
    <div class="col-md-12 header-container">
        <div class="pull-right mt-20">
            <?= $employees->appends(Illuminate\Support\Facades\Input::except('page'))->links() ?>
        </div>
    </div>
</div>
<?php
    }
?>
@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    activeMenu($('#menu-separated-employees'));
});
</script>
@endsection 