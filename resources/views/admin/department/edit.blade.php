@extends('layouts.main')
@section('title')
Departments > Edit Department 
@endsection
@section('head')
<style type="text/css">
@include('admin.style')
</style>
@endsection
@section('breadcrumb')
Departments <span>></span> Edit Department
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                Edit Department

                <a href="<?= url('department') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
            </div>
            <div class="panel-body timeline-container">
                <div class="flex-center position-ref full-height">
                    <form action="<?= url("department/{$department->id}") ?>" method="POST" id="edit_department_form" autocomplete="off">
                        {{ Form::hidden('_method', 'PUT') }}
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong class="asterisk-required">Department Name:</strong>
                                    <input type="text" name="department_name" class="form-control" value="<?= $department->department_name ?>" placeholder="Department Name..." required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong class="asterisk-required">Department Code:</strong>
                                    <input type="text" name="department_code" class="form-control" value="<?= $department->department_code ?>" placeholder="Department Code..." required>
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
                                        <option value="<?= $division->id ?>"<?= ($department->division_id == $division->id) ? ' selected' : '' ?>><?= $division->division_name ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong class="asterisk-required">Account</strong>
                                    <select class="select2 form-control" name="account_id" required>
                                        <option value="" disabled selected>Select Account</option>
                                        <?php
                                        foreach($accounts as $account) {
                                        ?>
                                        <option value="<?= $account->id ?>"<?= $department->account_id == $account->id ? ' selected' : '' ?>><?= $account->account_name ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="division"></div>
                        <div class="form-group pull-right">
                            <button id="btn_save" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('admin.js-script')
@endsection