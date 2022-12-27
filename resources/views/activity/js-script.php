<script type="text/javascript">
function saveForm(obj){
    $('body').css({'pointer-events':'none'});
    obj.attr('disabled', true);
    obj.text('Please wait');
    obj.closest('form').submit();
}
function requiredFields(form){
    var result = true;
    form.find('input[required], textarea[required], select[required]').each(function(e) {
        var label = $(this).closest('.form-group').find('label').text();
        if($(this).val() == ''){
            $(this).focus();
            $(this).addClass('border-required');
            $(this).closest('.form-group').find('.form-text').text('* '+label+' is required.').removeClass('d-none');

            result = false;

            return false;
        }

        $(this).removeClass('border-required');
        $(this).closest('.form-group').find('.form-text').addClass('d-none');
    });
    return result;
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img_holder').closest('.col-md-12').removeClass('d-none');
            $('#img_holder').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$(function() {
    activeMenu($('#menu-activities'));

    $('.delete_btn').click(function(){
        $('#messageModal .modal-title').html('Delete Activity');
        $('#messageModal #message').html('Are you sure you want to delete the activity ?');
        $('#messageModal .delete_form').attr('action', "<?= url('activities') ?>/" + $(this).attr("data-id"));
    });

    $('#messageModal #yes').click(function(){
        $('#messageModal .delete_form').submit();
    });

    $('.btn-submit').click(function(e) {
        e.preventDefault();

        if(requiredFields($(this).closest('form'))) {
          saveForm($(this));
        }
    });

    $("input[name=image_url]").change(function() {
      readURL(this);
    });
});
</script>