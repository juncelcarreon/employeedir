<script type="text/javascript">
function saveForm(obj){
  $('body').css({'pointer-events':'none'});
  obj.attr('disabled', true);
  if(obj.is('button')) {
    obj.text('Please wait');
  } else {
    obj.val('Please wait');
  }
  obj.closest('form').submit();
}
function requiredFields(form){
  var result = true;
  form.find('input[required], textarea[required], select[required]').each(function(e) {
    var label = $(this).closest('.form-group').find('label').text();
    if($(this).hasClass('select2')) {
        if($(this).val() === null){
            $(this).focus();
            $(this).closest('.form-group').find('.select2-container').css({'border':'1px solid #ff0000'});
            $(this).closest('.form-group').find('.form-text').text('* '+label+' is required.').removeClass('d-none');

            result = false;

            return false;
        }
    } else {
        if($(this).val() == ''){
            $(this).focus();
            $(this).css({'border':'1px solid #ff0000'});
            $(this).closest('.form-group').find('.form-text').text('* '+label+' is required.').removeClass('d-none');

            result = false;

            return false;
        }
    }
    $(this).removeAttr('style');
    $(this).closest('.form-group').find('.select2-container').removeAttr('style').css({'width' : '100%'});
    $(this).closest('.form-group').find('.form-text').addClass('d-none');
  });
  return result;
}
$(function(){
    activeMenu($('#menu-linking-sessions'));

    $('.select').select2();

    $('.select-date').keydown(function(e){
        e.preventDefault();

        return false;
    });

    $('.select-date').datetimepicker({
        format: 'MM/DD/YYYY',
        useCurrent: false
    });

    $('#table-history').DataTable({
        order: [[0, 'desc']],
        pageLength: 5
    });

    $('#table-list').DataTable({
        order: [[0, 'desc']]
    });

    $("#main_linkee").on("change",function(){
        var linkee = $('option:selected', this).attr("full_name");
        var email = $('option:selected', this).attr("email");

        $("#lnk_linkee_name").val(linkee);
        $("#lnk_linkee_email").val(email);
    });

    $('#btn-process_submit').click(function(e) {
        e.preventDefault();

        if(requiredFields($(this).closest('form'))) {
          saveForm($(this));
        }
    });
});
</script>