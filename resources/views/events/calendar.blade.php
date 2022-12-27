@extends('layouts.main')
@section('title')
<?php
    if(Auth::check() && Auth::user()->isAdmin()) {
        echo 'Blog Post > Events > Calendar';
    } else {
        echo 'Events Calendar';
    }
?>
@endsection
@section('head')
@include('events.style')
@endsection
@section('breadcrumb')
<?php
    if(Auth::check() && Auth::user()->isAdmin()) {
        echo 'Blog Post <span>/</span> Events <span>></span> Calendar';
    } else {
        echo 'Events Calendar';
    }
?>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div id="events_calendar"></div>
    </div>
</div>
<?php
    if(Auth::check() && Auth::user()->isAdmin()) {
?>
<div class="row">
    <div class="col-md-12">
        <div class="calendar-nav text-right">
            <a class="btn btn-primary" href="<?= url('events/create') ?>"><i class="fa fa-plus"></i>&nbsp; Add Event</a>
            <a href="<?= url('events') ?>" class="btn btn-danger"><i class="fa fa-chevron-left"></i>&nbsp; Back</a>
        </div>
    </div>
</div>
<?php
    }
?>
@endsection
@section('scripts')
@include('events.js-script')
@endsection