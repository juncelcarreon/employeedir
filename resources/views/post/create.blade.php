@extends('layouts.main')
@section('title')
Blog Posts > HR Progress > Add Post
@endsection
@section('breadcrumb')
Blog Posts <span>/</span> HR Progress <span>></span> Add Post
@endsection
@section('content')
<style type="text/css">
ol.breadcrumb li span{
    display: inline-block;
    color: #ccc;
    padding: 0 5px;
}
img.preview{
    width: 100%;
	height: 100%;
	float: left;
}
div.gallery{
	display: inline-block;
}
</style>
<div class="panel panel-default">
	<div class="panel panel-heading">
		Create Post

        <a href="<?= url('posts') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
	</div>
    <div class="panel-body timeline-container">
        <div class="flex-center position-ref full-height">
			<form id="post_form" method="POST" action="<?= url('posts') ?>" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Images</label>
							<input type="file" name="images_videos" id="images_videos" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="gallery">
							<div class="gallery-row" id="div1"></div>
						</div>
					</div>
				</div>
                <div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 15px"></div>
                <div class="form-group pull-right">
                    <input type="submit" class="btn btn-primary btn_submit" value="Save">
                </div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$(function() {
    activeMenu($('#menu-hr-progress'));

    // Multiple images preview in browser
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
@endsection