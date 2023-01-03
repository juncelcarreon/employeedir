@extends('layouts.main')
@section('title')
Referrals
@endsection
@section('head')
<style type="text/css">
@include('referral.style')
</style>
@endsection
@section('breadcrumb')
Referrals
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                Job Referrals
            </div>
            <div class="pane-body panel m-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="min-width: 50px;">#</th>
                            <th style="width: 150px;">Position Applied</th>
                            <th style="width: 100px;">Referral Name</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th style="width: 100px;">Referred By</th>
                            <th style="width: 100px;">Referred Date</th>
                            <th style="width: 80px;">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($referrals as $no=>$referral) {
                    ?>
                        <tr<?= ($referral->acknowledged == 0) ? ' class="unacknowledged"' : '' ?>>
                            <td><?= ++$no ?></td>
                            <td><?= $referral->position_applied ?></td>
                            <td><?= $referral->getReferralFullName() ?></td>
                            <td><?= $referral->referral_contact_number ?></td>
                            <td><?= $referral->referral_email ?></td>
                            <td><?= $referral->getReferrerFullName() ?></td>
                            <td><span><?= strtotime($referral->created_at) ?></span> <?= prettyDate($referral->created_at) ?></td>
                            <td class="text-center">
                                <a href="<?= url("referral/{$referral->id}") ?>">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('referral.js-script')
@endsection