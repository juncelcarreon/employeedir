@extends('layouts.main')
@section('title')
Referrals > View Referral
@endsection
@section('head')
<style type="text/css">
@include('referral.style')
</style>
@endsection
@section('breadcrumb')
Referrals <span>></span> View Referral
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                View Job Referral

                <a href="<?= url('referral') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
            </div>
            <div class="panel-body timeline-container">
                <div class="row">
                    <div class="col-md-12">
                        <table id="table-show">
                            <tr>
                                <td>Referral Name</td>
                                <td><?= $referral->getReferralFullName() ?></td>
                            </tr>
                            <tr>
                                <td>Position Applied</td>
                                <td><?= $referral->position_applied ?></td>
                            </tr>
                            <tr>
                                <td>Contact Number</td>
                                <td><?= $referral->referral_contact_number ?></td>
                            </tr>
                            <tr>
                                <td>Email Address</td>
                                <td><?= $referral->referral_email ?></td>
                            </tr>
                            <tr>
                                <td>Referrer Name</td>
                                <td><?= $referral->getReferrerFullName() ?></td>
                            </tr>
                            <tr>
                                <td>Referrer Department</td>
                                <td><?= $referral->referrer_department ?></td>
                            </tr>
                            <tr>
                                <td>Submitted Date</td>
                                <td><?= prettyDate($referral->created_at) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php
                    if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->dept_code == 'TLA01')) {
                ?>
                <div class="division"></div>
                <div class="form-group pull-right">
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#messageModal" title="Delete" data-id="<?= $referral->id ?>">Delete</a>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('referral.js-script')
@endsection