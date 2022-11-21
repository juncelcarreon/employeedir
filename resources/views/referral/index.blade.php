@extends('layouts.main')
@section('title')
    Job Referrals
@endsection
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        Job Referrals
    </div>
    <div class="pane-body panel">
        <br>
        <br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Position Applied</th>
                    <th>Referral Name</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Referred By</th>
                    <th>Referred Date</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach($referrals as $idx=>$referral) {
            ?>
                <tr>
                    <td><?= ++$idx ?></td>
                    <td><?= $referral->position_applied ?></td>
                    <td><?= $referral->getReferralFullName() ?></td>
                    <td><?= $referral->referral_contact_number ?></td>
                    <td><?= $referral->referral_email ?></td>
                    <td><?= $referral->getReferrerFullName() ?></td>
                    <td><?= prettyDate($referral->created_at) ?></td>
                    <td>
                        <a href="<?= url("referral/{$referral->id}") ?>">
                            <span class="fa fa-eye"></span>
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
@endsection
@section('scripts')
<script type="text/javascript">
$(function(e) {
    activeMenu($('#menu-referrals'));
});
</script>
@endsection