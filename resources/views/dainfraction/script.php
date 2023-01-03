<script type="text/javascript">
$(function () {
    activeMenu($('#menu-dainfraction'));

    $('.table').DataTable().destroy();

    $('.table').DataTable({"pageLength": 50});

    $('.select2').change(function() {
        var obj = $(this),
            position = $(obj).find(":selected").data('position'),
            department = $(obj).find(":selected").data('department');

        $('input[name="position"]').val(position);
        $('input[name="department"]').val(department);
    });

    $('.datepicker').datepicker();

    $('input[type="submit"], button[type="submit"]').click(function(e) {
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
            obj.val('Please wait');
            form.submit();
        }
    });

    $('input[type="reset"]').click(function(e) {
        e.preventDefault();

        var obj = $(this),
            form = obj.closest('form');

        form.find('select[required], input[required], textarea[required]').each(function() {
            $(this).val('');
        });
    });
});
</script>