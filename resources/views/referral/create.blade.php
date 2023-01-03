@extends('layouts.main')
@section('title')
Job Referrals > Create
@endsection
@section('head')
<style type="text/css">
@include('referral.style')
</style>
@endsection
@section('breadcrumb')
Job Referral
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="<?= url('referral') ?>" method="POST">
        {{ csrf_field() }}
            <div class="panel panel-default m-0">
                <div class="panel-heading">
                    Referrer Information (You)
                </div>
                <div class="panel-body timeline-container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong class="asterisk-required">First Name</strong>
                                <input type="text" class="form-control" name="referrer_first_name" placeholder="Your First Name..." required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Middle Name</strong>
                                <input type="text" class="form-control" name="referrer_middle_name" placeholder="Your Middle Name...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong class="asterisk-required">Last Name</strong>
                                <input type="text" class="form-control" name="referrer_last_name" placeholder="Your Last Name..." required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong class="asterisk-required">Department</strong>
                                <input type="text" class="form-control" name="referrer_department" placeholder="Your Department Name..." required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-heading panel-subheading">
                    Referral Information
                </div>
                <div class="panel-body timeline-container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong class="asterisk-required">First Name</strong>
                                <input type="text" class="form-control" name="referral_first_name" placeholder="Referral First Name..." required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Middle Name</strong>
                                <input type="text" class="form-control" name="referral_middle_name" placeholder="Referral Middle Name...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong class="asterisk-required">Last Name</strong>
                                <input type="text" class="form-control" name="referral_last_name" placeholder="Referral Last Name..." required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong class="asterisk-required">Contact Number</strong>
                                <input type="text" class="form-control" name="referral_contact_number" placeholder="Referral Contact Number..." required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong class="asterisk-required">Email Address</strong>
                                <input type="email" class="form-control" name="referral_email" placeholder="Referral Email Address..." required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong class="asterisk-required">Position Applied</strong>
                                <input type="text" class="form-control" name="position_applied" placeholder="Referral Position Applied..." required>
                            </div>
                        </div>
                    </div>
                    <div class="division"></div>
                    <div class="form-group pull-right">
                        <button class="btn btn-primary" id="btn-submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
@include('referral.js-script')
@endsection