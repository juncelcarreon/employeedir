<script type="text/javascript">
$(function() {
<?php
    if(empty($undertime)) {
?>
    activeMenu($('#menu-overtime'));
<?php
    } else {
?>
    activeMenu($('#menu-undertime'));
<?php
    }
?>

    $('.table').DataTable().destroy();

    if($('#table-list').length > 0) {
        $('#table-list').DataTable({
            "paging"    :   false,
            "ordering"  :   false,
            "info"      :   false,
            "searching" :   false
        });
    } else if($('#table-timekeeping').length > 0) {
        $('#table-timekeeping').DataTable({
            "paging"    :   false,
            "ordering"  :   false,
            "info"      :   false,
            "searching" :   false
        });
    } else {
        $('.table').DataTable({"pageLength": 50});
    }

    $('.datepicker').datepicker();

    $('.datetimepicker').datetimepicker({ useCurrent: false });

<?php
    if(isset($timekeeping)) {
?>
    $(".time_in").on("dp.change", function (e) {
        var obj = $(this),
            row = obj.closest('tr');

        row.find('.time_out').data("DateTimePicker").minDate(e.date);
    });

    $(".time_out").on("dp.change", function (e) {
        var obj = $(this),
            row = obj.closest('tr');

        row.find('.time_in').data("DateTimePicker").maxDate(e.date);
    });
<?php
    } else {
?>
    $(".time_in").on("dp.change", function (e) {
        $('.time_out').data("DateTimePicker").minDate(e.date);
    });

    $(".time_out").on("dp.change", function (e) {
        $('.time_in').data("DateTimePicker").maxDate(e.date);
    });
<?php
    }

    if(isset($undertime->time_out)) {
?>
    if($('.time_in').length > 0) {
        $('.time_in').data("DateTimePicker").maxDate(new Date('<?= $undertime->time_out ?>'));
    }
<?php
    }

    if(isset($undertime->time_in)) {
?>
    if($('.time_out').length > 0) {
        $('.time_out').data("DateTimePicker").minDate(new Date('<?= $undertime->time_in ?>'));
    }
<?php
    }
?>

    $('.input_none').keydown(function(e) {
        e.preventDefault();
        return false;
    });

    $('.btn-add').click(function(e) {
        e.preventDefault();

        var obj = $(this),
            parent = obj.closest('.entry-content'),
            entry = parent.find('.row-entry:first'),
            entry_last = parent.find('.row-entry:last');

        var new_entry = entry.clone().insertAfter(entry_last);
            new_entry.find('.btn-add').html('<span class="fa fa-minus"></span>');
            new_entry.find('.btn-add').removeClass('btn-primary').addClass('btn-danger');
            new_entry.find('.btn-add').removeClass('btn-add').addClass('btn-remove')
            new_entry.find('.datepicker').removeAttr('id').removeClass('hasDatepicker').removeData('datepicker').unbind().datepicker();
            new_entry.find('.datepicker').val('');
            new_entry.find('.input_none').keydown(function(e) {
                e.preventDefault();
                return false;
            });
            new_entry.find('input[type="number"]').val('1.00');
            new_entry.find('.btn-remove').click(function(e) {
                e.preventDefault();
                $(this).closest('.row-entry').remove();
            });
    });

    $('.btn-remove').click(function(e) {
        e.preventDefault();
        $(this).closest('.row-entry').remove();
    });

    $('button[type="submit"], input[type="submit"]').click(function(e) {
        e.preventDefault();

        var obj = $(this),
            form = obj.closest('form'),
            result = true;

        form.find('input[required], textarea[required], select[required]').each(function(e) {
            if($(this).val() == ''){
                $(this).focus();
                $(this).css({'border':'1px solid #ff0000'});

                result = false;

                return false;
            }
            $(this).removeAttr('style');
        });

        if(result) {
            $('body').css({'pointer-events':'none'});
            obj.attr('disabled', true);
            if(obj.is('button')) {
                obj.text('Please wait');
            } else {
                obj.val('Please wait');
            }
            form.submit();
        }
    });

    $('input[type="reset"]').click(function(e) {
        e.preventDefault();

        var obj = $(this),
            form = obj.closest('form');

        form.find('input[required], textarea[required]').each(function() {
            $(this).val('');
            if($(this).attr('type') == 'number') {
                $(this).val('1.00');
            }
        });

        $('.datetimepicker').each(function() {
            $(this).data("DateTimePicker").clear();
            $(this).find('input').removeAttr('style');
        });
    });
});
</script>