<script type="text/javascript">
function checkRequired(form){
    var result = true;
    form.find('input[required], textarea[required], select[required]').each(function(e) {
        if($(this).val() == ''){
            $(this).focus();
            $(this).addClass('border-required');

            result = false;

            return false;
        }
        $(this).removeClass('border-required');
    });
    return result;
}

function saveForm(obj){
    $('body').css({'pointer-events':'none'});
    obj.attr('disabled', true);
    obj.text('Please wait');
    obj.closest('form').submit();
}
$(function(e) {
    activeMenu($('#menu-referrals'));

    $('.delete_btn').click(function(){
        $('#messageModal .modal-title').html('Delete Referral Information');
        $('#messageModal #message').html('Are you sure you want to delete this information?');
        $('#messageModal .delete_form').attr('action', "<?= url('referral') ?>/" + $(this).attr("data-id"));
    });

    $('#messageModal #yes').click(function(){
        $('#messageModal .delete_form').submit();
    });

    $('.table').DataTable().destroy();

    $('.table').DataTable({"pageLength": 50});

    $('#btn-submit').click(function(e) {
        e.preventDefault();

        if(checkRequired($(this).closest('form'))) {
          saveForm($(this));
        }
    });
});
</script>