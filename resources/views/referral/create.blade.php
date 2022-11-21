@extends('layouts.main')
@section('title')
    Job Referrals > Create
@endsection
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        Job Referral
    </div>
    <div class="panel-body timeline-container">
        <div class="flex-center position-ref full-height">
            <form action="<?= url('referral') ?>" method="POST">
            {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Referrer <span class="text-muted" style="font-weight: 400;">(You)</span></strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>First Name <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" name="referrer_first_name" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" class="form-control" name="referrer_middle_name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Last Name <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" name="referrer_last_name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Department <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" name="referrer_department" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 15px"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Referral</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>First Name <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" name="referral_first_name" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" class="form-control" name="referral_middle_name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Last Name <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" name="referral_last_name" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Contact Number <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" name="referral_contact_number" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Email Address <small class="text-danger">*</small></label>
                            <input tyle="email" class="form-control" name="referral_email" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Position Applied <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" name="position_applied" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 15px"></div>
                <div class="form-group pull-right">
                    <button class="btn btn-primary btn_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$(function(e) {
    activeMenu($('#menu-referrals'));
});
</script>
@endsection