@extends('layouts.main')
@section('title')
Blog Posts > HR Progress
@endsection
@section('head')
<style type="text/css">
@include('post.style');
</style>
@endsection
@section('breadcrumb')
Blog Posts <span>></span> HR Progress
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default m-0">
			<div class="panel panel-heading m-0">
				Posts

				<a class="pull-right btn btn-primary" href="<?= url('posts/create') ?>"><span class="fa fa-plus"></span>&nbsp; Create New Post</a>
			</div>
		    <div class="pane-body panel m-0">
				<table id="post-table" class="table-striped table">
					<thead>
						<tr>
							<th>#</th>
							<th>Image</th>
							<th>Option</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($posts as $no=>$post){
						?>
						<tr>
							<td><?= ++$no ?></td>
							<td>
								<img src="<?= $post->image ?>" class="img-thumbnail post-image" alt="post image">
							</td>
							<td>
								<label class="switch" title="Enable/Disable">
									<input type="checkbox" value="1" id="progress1" tabIndex="1" class="primary" data-id="<?= $post->id ?>" <?= $post->enabled == 1 ? 'checked' : '' ?>>
									<span class="slider"></span>
								</label>
								<a href="#" class="btn-delete delete_btn" data-toggle="modal" data-target="#messageModal" title="Delete" data-id="<?= $post->id ?>">
									<i class="fa fa-trash"></i>
								</a>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
@include('post.js-script')
@endsection