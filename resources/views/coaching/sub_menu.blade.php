<div class="panel-heading" style="font-size: 12px;">
    <?php
    if($management == 1):
    ?>
    <a href="<?= url('coaching-session') ?>" style="color: white;">New Linking</a>  |
    <a href="<?= url('linkee-pending') ?>" style="color: white;">Pending</a>  |
    <?php
    else:
    ?>
    <a href="<?= url('coaching-session') ?>" style="color: white;">Pending</a> | 
    <?php
    endif;
    ?>
    <a href="<?= url('gtky-list') ?>" style="color: white;">GTKY</a> |
    <a href="<?= url('gs-list') ?>" style="color: white;">GS</a> |
    <a href="<?= url('sb-list') ?>" style="color: white;">SB</a> |
    <a href="<?= url('sda-list') ?>" style="color: white;">SDA</a> |
    <a href="<?= url('view-ql') ?>" style="color: white;">QL</a> | 
    <a href="<?= url('list-ce') ?>" style="color: white;">CE</a> | 
    <a href="<?= url('acc-list') ?>" style="color: white;">AS</a>
    <?php
    if($management == 1):
    ?>
    | <a href="<?= url('own-linking') ?>" style="color: white;">Personal</a>
    <?php
    endif;
    ?>
</div>