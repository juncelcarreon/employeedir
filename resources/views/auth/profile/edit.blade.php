@extends('layouts.main')
@section('title')
My Profile > Update Selected Information
@endsection
@section('breadcrumb')
My Profile <span>></span> Update Selected Information
@endsection
@section('content')
<style type="text/css">
ol.breadcrumb li span{
    display: inline-block;
    color: #ccc;
    padding: 0 5px;
}
.form-group label{
    color: #878;
}
</style>
<?php
if(Auth::user()->id == $employee->id) {
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        Update Selected Personal Information

        <a href="<?= url('myprofile') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="<?= url('save-profile') ?>" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="employee_id" value="<?= $employee->id ?>" />
            <input type="hidden" name="o_current_address" value="<?= $employee->address ?>" />
            <input type="hidden" name="o_contact_num" value="<?= $employee->contact_number ?>" />
            <input type="hidden" name="o_emergency" value="<?= $details->em_con_name ?>" />
            <input type="hidden" name="o_emergency_num" value="<?= $details->em_con_num ?>" />
            <input type="hidden" name="o_rel" value="<?= $details->em_con_rel ?>" />
            <input type="hidden" name="o_marital_stat" value="<?= $employee->civil_status ?>" />
            <div class="form-group">
                <label class="control-label col-sm-2">Current Address</label>
                <div class="col-sm-10">
                    <input type="text" name="n_current_address" class="form-control" value="<?= $employee->address ?>" placeholder="Current Address" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Contact Number</label>
                <div class="col-sm-10">
                    <input type="text" name="n_contact_num" class="form-control" placeholder="Contact Number" value="<?= $employee->contact_number ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">In Case of Emergency, Please Contact</label>
                <div class="col-sm-10">
                    <input type="text" name="n_emergency" class="form-control" value="<?= $details->em_con_name ?>" placeholder="Emergency Contact Person" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Contact Person Number</label>
                <div class="col-sm-10">
                    <input type="text" name="n_emergency_num" class="form-control" value="<?= $details->em_con_num ?>" placeholder="Emergency Contact Number" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Relationship</label>
                <div class="col-sm-10">
                    <input type="text" name="n_rel" class="form-control" value="<?= $details->em_con_rel ?>" placeholder="Relationship" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Marital Status</label>
                <div class="col-sm-10">
                    <select name="n_marital_stat" class="select2 form-control">
                        <option value="1"<?= $employee->civil_status == 1 ? " selected" : "" ?>>Single</option>
                        <option value="2"<?= $employee->civil_status == 2 ? " selected" : "" ?>>Married</option>
                        <option value="3"<?= $employee->civil_status == 3 ? " selected" : "" ?>>Separated</option>
                        <option value="4"<?= $employee->civil_status == 4 ? " selected" : "" ?>>Annulled</option>
                        <option value="5"<?= $employee->civil_status == 5 ? " selected" : "" ?>>Divorced</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form> 
    </div>
</div>
<?php
}
?>
@endsection