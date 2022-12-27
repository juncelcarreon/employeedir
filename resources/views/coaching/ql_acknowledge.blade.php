@extends('layouts.main')
@section('title')
Linking Sessions > Quick Link > Acknowledge Session
@endsection
@section('head')
<style>
@include('coaching.style');
</style>
@endsection
@section('breadcrumb')
Linking Sessions <span>/</span> Quick Link <span>></span> Acknowledge Session
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="<?= url('acknowledged-quick-link') ?>" method="post" autocomplete="off">
            {{ csrf_field() }}
            <input type="hidden" name="rf_lnk_id" value="<?= $obj->rf_lnk_id ?>">
            <div class="panel panel-primary m-0">
                @include('coaching.sub_menu')
                <div class="panel-body">
                    <div class="row d-flex">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Linker</label>
                                <input type="text" class="form-control" name="lnk_linker_name" value="<?= $linker->fullName2() ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Linkee</label>
                                <input type="text" class="form-control" name="lnk_linkee" value="<?= $linkee->fullName2() ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" class="form-control" value="<?= date('F d, Y', strtotime($obj->lnk_date)) ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-subheading">
                    Quick Link Session
                </div>
                <div class="panel-body">
                    <div class="row d-flex">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Focus</label>
                                <input type="text" class="form-control" name="rf_focus" value="<?= $obj->fc_desc ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Comments</label>
                                <textarea name="rf_comments" rows="10" class="form-control" readonly><?= $obj->rf_comments ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="asterisk-required">Feedback</label>
                                <textarea name="rf_feedback" rows="10" class="form-control" required><?= $obj->rf_feedback ?></textarea>
                                <div class="form-text d-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group pull-right">
                                <br>
                                <input type="submit" name="save_linking" id="btn-process_submit" class="btn btn-lg btn-primary" value="ACKNOWLEDGE LINKING">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
@include('coaching.js-script')
@endsection