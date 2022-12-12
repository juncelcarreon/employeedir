@extends('layouts.main')
@section('title')
Departments > Add Department
@endsection
@section('content')
@section('breadcrumb')
Departments <span>></span> Add Department 
@endsection
<style type="text/css">
ol.breadcrumb li span{
    display: inline-block;
    color: #ccc;
    padding: 0 5px;
}
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        New Department

        <a href="<?= url('department') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel-body timeline-container">
        <div class="flex-center position-ref full-height">
            <form action="<?= route('department.store') ?>" method="POST">
            {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Department Name:</strong>
                            <input type="text" name="department_name" class="form-control" placeholder="Department Name..." required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Department Code:</strong>
                            <input type="text" name="department_code" class="form-control" placeholder="Department Code..." required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Division:</strong>
                            <select class="select2 form-control" name="division_id">
                                <option value="" selected disabled>Select Division</option>
                                <?php
                                foreach($divisions as $division) {
                                ?>
                                <option value="<?= $division->id ?>"><?= $division->division_name ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Account</strong>
                            <select class="select2 form-control" name="account_id" required>
                                <option value="" disabled selected>Select Account</option>
                                <?php
                                foreach($accounts as $account) {
                                ?>
                                <option value="<?= $account->id ?>"><?= $account->account_name ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 15px"></div>
                <div class="form-group pull-right">
                    <button id="btn_save" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$(function(e) {
    var departments = [<?php foreach($departments as $department) { echo '"'.$department->department_code.'"'.","; } ?>];

    activeMenu($('#menu-department'));

    $('#btn_save').click(function(e) {
        e.preventDefault();
        var result = true;

        result = checkRequired($(this).closest('form'));

        if(result && $.inArray($('input[name="department_code"]').val(), departments) !== -1) {
            alert('Department Code Already Exists');

            result = false;
        }

        if(result) {
            saveForm($(this));
        }
    });
});
</script>
@endsection