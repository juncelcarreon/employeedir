@extends('layouts.main')
@section('title')
Blog Post > Activities > Edit Activity
@endsection
@section('head')
<style type="text/css">
@include('activity.style');
</style>
@endsection
@section('breadcrumb')
Blog Post <span>/</span> Activities <span>></span> Edit Activity
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                Edit Activity

                <a href="<?= url('activities') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
            </div>
            <div class="panel-body timeline-container">
                <div class="flex-center position-ref full-height">
                    <form role="form" method="POST" action="<?= url("activities/{$activity->id}") ?>" accept-charset="UTF-8" enctype="multipart/form-data" autocomplete="off">
                        {{ Form::hidden('_method', 'PUT') }}
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="asterisk-required">Title</label>
                                    <input type="text" name="title" class="form-control" value="<?= $activity->title ?>" placeholder="Title..." required>
                                    <div class="form-text d-none"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="asterisk-required">Subtitle</label>
                                    <input type="text" name="subtitle" value="<?= $activity->subtitle ?>" class="form-control" placeholder="Subtitle..." required>
                                    <div class="form-text d-none"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea name="message" class="form-control" placeholder="Message..."><?= $activity->message ?></textarea>
                                </div>
                                <br>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="form-group">
                                    <img src="<?= $activity->image_url ?>" id="img_holder" alt="<?= $activity->title ?>">
                                    <br>
                                    <br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image Attachment</label>
                                    <input type="file" name="image_url" class="form-control" accept="image/png, image/jpg, image/jpeg">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="asterisk-required">Activity Date</label>
                                    <input type="text" name="activity_date" class="form-control datepicker" value="<?= slashedDate($activity->activity_date) ?>" placeholder="MM/DD/YYYY" required>
                                    <div class="form-text d-none"></div>
                                </div>
                            </div>
                        </div>
                        <div class="division"></div>
                        <div class="form-group pull-right">
                            <button class="btn btn-primary btn-submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('activity.js-script')
@endsection