@extends('layouts.main')
@section('title')
Blog Post > HR Progress > Add Post
@endsection
@section('head')
<style type="text/css">
@include('post.style');
</style>
@endsection
@section('breadcrumb')
Blog Post <span>/</span> HR Progress <span>></span> Add Post
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default m-0">
			<div class="panel panel-heading m-0">
				Create Post

		        <a href="<?= url('posts') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
			</div>
		    <div class="panel-body timeline-container">
		        <div class="flex-center position-ref full-height">
					<form id="post_form" method="POST" action="<?= url('posts') ?>" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="asterisk-required">Images</label>
									<input type="file" class="form-control" name="images_videos" id="images_videos" accept="image/png, image/jpg, image/jpeg" required>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<div class="gallery">
										<div class="gallery-row" id="div1"></div>
									</div>
								</div>
							</div>
						</div>
		                <div class="division"></div>
		                <div class="form-group pull-right">
		                    <input type="submit" class="btn btn-primary btn_submit" value="Save">
		                </div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
@include('post.js-script')
@endsection