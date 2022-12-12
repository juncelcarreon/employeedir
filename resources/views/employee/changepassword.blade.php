@extends('layouts.main')
@section('title')
Employee > Change Password
@endsection
@section('breadcrumb')
Employees <span>></span> Change Password
@endsection
@section('content')
<style type="text/css">
@include('employee.style');
</style>
<div class="panel panel-primary">
    <div class="panel-heading">
        Change Password

        <a href="<?= url()->previous() ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" method="POST" action="<?= url("employee/{$id}/savepassword") ?>">
            {{ csrf_field() }}
            <?php
            if($errors->any()) {
            ?>
            <div class="form-group text-center">
                <span class="message-{{session('errors')->first('status') }}">{{session('errors')->first('message') }}</span>
            </div>
            <?php
            }
            if(!Auth::user()->isAdmin()) {
            ?>
            <div class="form-group password">
                <label class="control-label col-sm-2">Old Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" placeholder="Password" name="old_password" />
                </div>
            </div>
            <?php
            }
            ?>
            <div class="form-group password">
                <label class="control-label col-sm-2">New Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" placeholder="Password" name="new_password" />
                </div>
            </div>
            <div class="form-group password">
                <label class="control-label col-sm-2">Confirm Password</label>
                <div class="col-sm-10">
                    <input type="password"  class="form-control" placeholder="Confirm Password" name="confirm_password" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Change</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection