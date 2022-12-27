<div class="panel-heading">
<?php
if($management == 1) {
?>
    <a href="<?= url('coaching-session') ?>" title="Add New Session"<?= empty($new) ? '' : ' class="active"' ?>>New Linking</a>  |
    <a href="<?= url('linkee-pending') ?>" title="Linkees Pending Sessions"<?= empty($pending_menu) ? '' : ' class="active"' ?>>Pending</a>  |
<?php
} else {
?>
    <a href="<?= url('coaching-session') ?>" title="Pending Sessions"<?= empty($pending_menu) ? '' : ' class="active"' ?>>Pending</a> | 
<?php
}
?>
    <a href="<?= url('gtky-list') ?>" title="Getting To Know You List"<?= empty($gtky) ? '' : ' class="active"' ?>>GTKY</a> |
    <a href="<?= url('goal-setting-list') ?>" title="Goal Setting List"<?= empty($gs) ? '' : ' class="active"' ?>>GS</a> |
    <a href="<?= url('skill-building-list') ?>" title="Skill Building List"<?= empty($sb) ? '' : ' class="active"' ?>>SB</a> |
    <a href="<?= url('skill-dev-act-list') ?>" title="Skills Development Activities List"<?= empty($sda) ? '' : ' class="active"' ?>>SDA</a> |
    <a href="<?= url('quick-link-list') ?>" title="Quick Link List"<?= empty($ql) ? '' : ' class="active"' ?>>QL</a> | 
    <a href="<?= url('ce-expectation-list') ?>" title="Cementing Expectation List"<?= empty($ce) ? '' : ' class="active"' ?>>CE</a> | 
    <a href="<?= url('acc-set-list') ?>" title="Accountability Setting List"<?= empty($as) ? '' : ' class="active"' ?>>AS</a>
<?php
if($management == 1) {
?>
    | <a href="<?= url('own-linking') ?>" title="Personal Linking Sessions"<?= empty($personal) ? '' : ' class="active"' ?>>Personal</a>
    <a href="<?= url('download-linking') ?>" class="btn btn-success pull-right"><i class="fa fa-download"></i>&nbsp; DOWNLOAD EXCEL REPORT</a>
<?php
}
?>
</div>