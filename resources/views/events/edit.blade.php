@extends('layouts.main')
@section('title')
Blog Post > Events > Edit Event
@endsection
@section('head')
@include('events.style')
@endsection
@section('breadcrumb')
Blog Post <span>/</span> Events <span>></span> Edit Event
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                Edit Event

                <a href="<?= url()->previous() ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
            </div>
            <div class="panel-body timeline-container">
                <div class="flex-center position-ref full-height">
                    <form role="form" method="POST" action="<?= url("events/{$event->id}") ?>" accept-charset="UTF-8" enctype="multipart/form-data" autocomplete="off">
                        {{ Form::hidden('_method', 'PUT') }}
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="asterisk-required">Event Name</label>
                                    <input class="form-control" name="event_name" placeholder="Event Name..." value="<?= $event->event_name ?>" required>
                                    <div class="form-text d-none"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="asterisk-required">Start Date</label>
                                    <input class="form-control datetimepicker" name="start_date" id="start_date" placeholder="MM/DD/YYYY HH:MM AM" value="<?= timeDate($event->start_date) ?>" required>
                                    <div class="form-text d-none"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="asterisk-required">End Date</label>
                                    <input class="form-control datetimepicker" name="end_date" id="end_date" placeholder="MM/DD/YYYY HH:MM AM" value="<?= timeDate($event->end_date) ?>" required>
                                    <div class="form-text d-none"></div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="asterisk-required">Event Color</label>
                                    <input type="text" id="event_color" name="event_color" value="<?= $event->event_color ?>" required>
                                    <div class="form-text d-none"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="asterisk-required">Event Description</label>
                                    <textarea class="form-control" name="event_description" placeholder="Description..." required><?= $event->event_description ?></textarea>
                                    <div class="form-text d-none"></div>
                                </div>
                            </div>
                        </div>
                        <div class="division"></div>
                        <div class="form-group pull-right">
                            <input type="submit" class="btn btn-primary btn-submit" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('events.js-script')
@endsection