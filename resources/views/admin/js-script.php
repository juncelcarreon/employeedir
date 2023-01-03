<script type="text/javascript">
function checkRequired(form){
  var result = true;
  form.find('input[required], textarea[required], select[required]').each(function(e) {
      if($(this).hasClass('select2')) {
        if($(this).val() === null){
            $(this).focus();
            $(this).closest('.form-group').find('.select2-container').css({'border':'1px solid #ff0000'});

            result = false;

            return false;
        }
      } else {
        if($(this).val() == ''){
            $(this).focus();
            $(this).css({'border':'1px solid #ff0000'});

            result = false;

            return false;
        }
        $(this).removeAttr('style');
      }
  });
  return result;
}

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
$(function(e) {
<?php
  if(!empty($departments)) {
?>
    var departments = [<?php foreach($departments as $department) { echo '"'.$department->department_code.'"'.","; } ?>];
<?php
  }
?>

    activeMenu($('#menu-department'));

    $('.table').DataTable().destroy();

    $('.table').DataTable({"pageLength": 50});

    $('.delete_btn').click(function(){
        $('#messageModal .modal-title').html('Delete Department');
        $('#messageModal #message').html('Are you sure you want to delete the department ?');
        $('#messageModal .delete_form').attr('action', "<?= url('department') ?>/" + $(this).attr("data-id"));
    });

    $('#messageModal #yes').click(function(){
        $('#messageModal .delete_form').submit();
    });

    $('#btn_save').click(function(e) {
        e.preventDefault();
        var result = true;

        result = checkRequired($(this).closest('form'));

        if(result && $.inArray($('input[name="department_code"]').val(), departments) !== -1) {
            alert('Department Code Already Exists');

            result = false;
        }

        if(result) {
            saveForm($(this));
        }
    });
});
</script>