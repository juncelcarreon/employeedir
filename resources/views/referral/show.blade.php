@extends('layouts.main')
@section('title')
    Job Referrals > View
@endsection
@section('content')
<style>
    table{
        width: 100%;
        margin: 10px;
    }
    table tr td {
        border-bottom: 1px dashed #dadada;
        font-size: 13px;
        padding-top: 15px;
        padding-bottom: 5px;
    }
    table tr td:nth-child(2){
        font-weight: 600;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        View Job Referral

        <a href="<?= url('referral') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel-body timeline-container">
        <div class="row">
            <div class="col-md-12">
                <table>
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