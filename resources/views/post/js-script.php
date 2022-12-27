<script type="text/javascript">
$(function() {
    activeMenu($('#menu-hr-progress'));

    $(document).on('change', 'input[type=checkbox]', function(){
        $('body').css({'pointer-events':'none'});
        let enabled;
        let id = $(this).data('id');
        if($(this).is(":checked")){
            enabled = 1;
        }else{
            enabled = 0;
        }
        $.LoadingOverlay("show");
        setTimeout(function(){
            $.LoadingOverlay("hide");
            window.location.replace("<?= url('posts') ?>/" + id + "/enabled?enabled=" + enabled);
        }, 1000);
    });

    $('.delete_btn').click(function(){
        $('#messageModal .modal-title').html('Delete Post');
        $('#messageModal #message').html('Are you sure you want to delete the post ?');
        $('#messageModal .delete_form').attr('action', "<?= url('posts') ?>/" + $(this).attr("data-id"));
    });

    $('#messageModal #yes').click(function(){
        $('#messageModal .delete_form').submit();
    });

    var imagesPreview = function(input) {
    var counter = 0;
        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event){
                    $($.parseHTML('<img class="preview">')).attr('src', event.target.result).appendTo('#div' + ((counter++ % 4) + 1));
                }
                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#images_videos').on('change', function() {
    	$('div.gallery-row').empty();
        imagesPreview(this, 'div.gallery');
    });
});
</script>