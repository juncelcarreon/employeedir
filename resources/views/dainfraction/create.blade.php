@extends('layouts.main')
@section('title')
DA Infractions > Create
@endsection
@section('head')
<style type="text/css">
@include('dainfraction.style');
</style>
@endsection
@section('breadcrumb')
DA Infractions <span>></span> File Infraction
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                DA INFRACTION FORM

                <a href="<?= url('dainfraction') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
            </div>
            <div class="panel-body timeline-container">
                <div class="flex-center position-ref full-height">
                    <form enctype="multipart/form-data" action="<?= url('dainfraction') ?>" method="post">
                    {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Recipient: </strong>
                                    <select name="employee_id" class="form-control select2" <?= Auth::user()->isAdmin() ? '' : 'readonly' ?>>
                                    <?php
                                    foreach($employees as $employee) {
                                        if(empty($employee->deleted_at) && $employee->status == 1) {
                                    ?>
                                        <option value="<?= $employee->id ?>" data-position="<?= $employee->position_name ?>" data-department="<?= $employee->team_name ?>" <?= Auth::user()->id == $employee->id ? ' selected' : '' ?>><?= $employee->fullName2() ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Position: </strong>
                                    <input type="text" name="position" class="form-control" placeholder="Position" value="<?= Auth::user()->position_name ?>" readonly>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Department: </strong>
                                    <input type="text" name="department" class="form-control" placeholder="Dept/Section" value="<?= Auth::user()->team_name ?>" readonly>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Date Filed: </strong>
                                    <input type="text" value="<?= date('m/d/Y') ?>" name="date_filed" class="form-control" placeholder="Date Filed" readonly autocomplete="off">
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong>Title: </strong>
                                    <input type="text" name="title" class="form-control" maxlength="200" placeholder="Title..." required>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Infraction Type: </strong>
                                    <select name="infraction_type" class="form-control" required>
                                        <option value="" selected hidden>Select Infraction Type</option>
                                        <option value="NOD">Notice of Decision</option>
                                        <option value="NTE">Notice to Explain</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Date </strong>
                                    <input type="text" name="date" class="form-control datepicker" placeholder="MM/DD/YYYY" placeholder="Date" autocomplete="off" required>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>File </strong>
                                    <input type="file" name="file" class="form-control" accept="application/pdf" required>
                                </div> 
                            </div>
                        </div>
                        <div class="division"></div>
                        <div class="form-group pull-right">
                            <input type="submit" id="register-button" class="btn btn-primary" value="Submit">
                            <input type="reset" class="btn btn-default" value="Reset">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('dainfraction.script')
@endsection
