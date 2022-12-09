<div class="panel-heading">
    <?php
    if($management == 1):
    ?>
    <a href="<?= url('coaching-session') ?>"<?= empty($new) ? '' : ' class="active"' ?>>New Linking</a>  |
    <a href="<?= url('linkee-pending') ?>"<?= empty($pending_menu) ? '' : ' class="active"' ?>>Pending</a>  |
    <?php
    else:
    ?>
    <a href="<?= url('coaching-session') ?>"<?= empty($pending_menu) ? '' : ' class="active"' ?>>Pending</a> | 
    <?php
    endif;
    ?>
    <a href="<?= url('gtky-list') ?>"<?= empty($gtky) ? '' : ' class="active"' ?>>GTKY</a> |
    <a href="<?= url('goal-setting-list') ?>"<?= empty($gs) ? '' : ' class="active"' ?>>GS</a> |
    <a href="<?= url('skill-building-list') ?>"<?= empty($sb) ? '' : ' class="active"' ?>>SB</a> |
    <a href="<?= url('skill-dev-act-list') ?>"<?= empty($sda) ? '' : ' class="active"' ?>>SDA</a> |
    <a href="<?= url('quick-link-list') ?>"<?= empty($ql) ? '' : ' class="active"' ?>>QL</a> | 
    <a href="<?= url('ce-expectation-list') ?>"<?= empty($ce) ? '' : ' class="active"' ?>>CE</a> | 
    <a href="<?= url('acc-set-list') ?>"<?= empty($as) ? '' : ' class="active"' ?>>AS</a>
    <?php
    if($management == 1):
    ?>
    | <a href="<?= url('own-linking') ?>"<?= empty($personal) ? '' : ' class="active"' ?>>Personal</a>
    <a href="<?= url('download-linking') ?>" class="btn btn-success pull-right"><i class="fa fa-download">&nbsp;</i> DOWNLOAD EXCEL REPORT</a>
    <?php
    endif;
    ?>
</div>