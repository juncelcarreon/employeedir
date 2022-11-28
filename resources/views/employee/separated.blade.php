@extends('layouts.main')
@section('title')
Employees > Separated Employees
@endsection
@section('content')
<style type="text/css">
    .emp-profile{
        background-color: white;
    }
    .col-md-12{
        margin-bottom: 1px !important;
    }
    .emp-profile{
        margin: auto;
    }
    .header-container{
        margin-top: 20px;
    }
    #search_employee{
        padding-left: 5px;
    }
    .alphabet-search{
        display: inline-flex;
        list-style: none;
    }
    .alphabet-search li{
        margin-left: 10px;
    }
    .header-list{

    }
    .employee-description{
        color: #777;
        font-size: 12px;
    }
    h1, h2, h3, h4, h5, h6 {
        color: #777;
    }
    li a.selected{
        font-weight: 900!important;
    }
    .pagination>li:first-child>a, .pagination>li:first-child>span{
        border-top-left-radius: 0px !important;
        border-bottom-left-radius: 0px !important;
    }
    .pagination>li:last-child>a, .pagination>li:last-child>span {
        border-top-right-radius: 0px !important;
        border-bottom-right-radius: 0px !important;
    }
    .emp-profile .fa{
        color: #555;
    }
    select{
        cursor: pointer !important;
    }
</style>
<div class="col-md-12">
    <ul class="alphabet-search" style="padding-left: 0px">
        <li style="margin-left: 0px">
            <form style="display: unset;">
                <input type="hidden" name="alphabet" value="<?= $request->alphabet ?>">
                <input type="hidden" name="department" value="<?= $request->department ?>">
                <input type="text" placeholder="Search by name" id="search_employee" name="keyword" value="<?= $request->keyword ?>">
                <button class="btn btn-primary" style="height:  35px; margin-top: 1px;">
                    <span class="fa fa-search"></span>
                </button>
            </form>
            <a href="/download-inactive?<?= (empty($_SERVER['QUERY_STRING']) ? '' : $_SERVER['QUERY_STRING']) ?>" class="btn btn-success"><span class="fa fa-download">&nbsp;</span> DOWNLOAD SEPARATED EMPLOYEES</a>
        </li>
    </ul>
<?php
if(count($employees) == 0) {
?>
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
<?php
}
foreach($employees as $employee) {
?>
    <div class="col-md-12" style="padding-left: 0px; padding-right: 0px; ">
        <div class="emp-profile" style="padding: 10px; margin-bottom: 0px;">
            <div class="row">
                <div class="col-md-1" style="float: left;">
                    <div style="background-image: url(<?= $employee->profile_img ?>); width: 60px; height: 60px;margin: 15px; background-size: cover; background-repeat: no-repeat; background-position: 50% 50%; border-radius: 50%;"></div>
                </div>
                <div class="col-md-3">
                    <h4 class="timeline-title name-format" style="color: #444;font-weight: 500; font-size: 17px; margin-top: 10px; text-transform: uppercase;">
                        <a href="<?= url("profile/{$employee->id}") ?>"><?= $employee->fullname() ?></a>
                    </h4>
                    <h5 style="color: #455;"><?= $employee->position_name ?></h5>
                    <h6><?= $employee->team_name.(isset($employee->account) ? "- ". $employee->account->account_name : ""); ?></h6>
                </div>
                <div class="col-md-3">
                    <h5>
                        <span class="fa fa-id-card" title="Employee ID"></span>
                        <span class="employee-description">&nbsp;&nbsp;<?= $employee->eid ?></span>
                    </h5>
                    <h5>
                        <span class="fa fa-envelope" title="Email Address"></span>
                        <span class="employee-description" style="color: #0c59a2;;">&nbsp;&nbsp;<?= $employee->email ?></span>
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
                    <h5 style="font-size: 12px;">
                        <span class="fa fa-user" title="Immediate Superior"></span>
                        <span class="name-format" style="color: gray;">Immediate Superior:</span>
                        <?= $employee->supervisor_name ?>
                    </h5>
                <?php
                }
                if(isset($employee->manager_name)) {
                ?>
                    <h5 style="font-size: 12px;">
                        <span class="fa fa-user" title="Manager"></span>
                        <span style="color: gray;">Manager: </span>
                        <span class="name-format"><?= $employee->manager_name ?></span>
                    </h5>
                <?php
                }
                ?>
                </div>
                <div class="col-md-2">
                    <a href="<?= url("profile/{$employee->id}") ?>" title="View">
                        <i class="fa fa-eye"  style="color: #3A75FB;"></i>
                    </a>&nbsp;&nbsp;
                <?php
                if($employee->isActive()) {
                ?>
                    <a href="<?= url("employee_info/{$employee->id}/edit") ?>" title="Edit">
                        <i class="fa fa-pencil" style="color: #3A75FB;"></i>
                    </a>&nbsp;&nbsp;
                    <a href="#" class="delete_btn" data-toggle="modal" data-target="#messageModal" title="Deactivate" data-id="<?= $employee->id ?>">
                        <i class="fa fa-user-times" style="color: red;"></i>
                    </a>
                <?php
                } else {
                ?>
                    <a href="<?= url("employees/{$employee->id}/reactivate") ?>" title="Reactivate Employee" data-id="<?= $employee->id ?>">
                        <i class="fa fa-user-plus" style="color: green;"></i>
                    </a>
                <?php
                }
                ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
</div>
    <div class="col-md-12 header-container" style="margin-top: 0px;">
        <div class="pull-right">
            <?= $employees->appends(Illuminate\Support\Facades\Input::except('page'))->links() ?>
        </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    activeMenu($('#menu-separated-employees'));
});
</script>
@endsection 