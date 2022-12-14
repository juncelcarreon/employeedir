@extends('layouts.main')
@section('title')
Linking Sessions > Skill Building > View Session
@endsection
@section('head')
<style>
@include('coaching.style');
</style>
@endsection
@section('breadcrumb')
Linking Sessions <span>/</span> Skill Building <span>></span> View Session
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
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
                            <input type="text" class="form-control" name="lnk_linker_name" value="<?= $linkee->fullName2() ?>" readonly>
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
                Skill Building Session
            </div>
            <div class="panel-body">
                <div class="row d-flex">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Focus</label>
                            <input type="text" name="sb_focus" class="form-control" value="<?= $obj->fc_desc ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Behavior/Skill</label>
                            <input type="text" name="sb_skill" class="form-control" value="<?= $obj->sb_skill ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>When we use the Skill</label>
                            <input type="text" name="sb_when_skill" class="form-control" value="<?= $obj->sb_when_skill ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>How we use the Skill</label>
                            <input type="text" name="sb_how_skill" class="form-control" value="<?= $obj->sb_how_skill ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Why we use the Skill</label>
                            <input type="text" name="sb_why_skill" class="form-control" value="<?= $obj->sb_why_skill ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Timeframe for Quick Link</label>
                            <input type="text" name="sb_timeframe" class="form-control" value="<?= $obj->sb_timeframe ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Takeaways from activity</label>
                            <textarea name="sb_takeaway" rows="10" class="form-control" readonly><?= $obj->sb_takeaway ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Feedback</label>
                            <textarea name="sb_feedback" rows="10" class="form-control" readonly><?= $obj->sb_feedback ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('coaching.js-script')
@endsection