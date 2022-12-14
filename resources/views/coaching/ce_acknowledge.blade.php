@extends('layouts.main')
@section('title')
Linking Sessions > Cementing Expectation > Acknowledge Session
@endsection
@section('breadcrumb')
Linking Sessions <span>/</span> Cementing Expectation <span>></span> Acknowledge Session
@endsection
@section('content')
<style>
@include('coaching.style');
</style>
<form action="<?= url('acknowledged-ce-expectation') ?>" method="post" autocomplete="off">
    {{ csrf_field() }}
    <input type="hidden" name="se_com_id" value="<?= $obj->se_com_id ?>">
    <input type="hidden" name="se_link_id" value="<?= $obj->se_link_id ?>">
    <div class="panel panel-primary">
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
            Cementing Expectation Session
        </div>
        <div class="panel-body">
            <div class="row d-flex">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Focus</label>
                        <input type="text" class="form-control" name="rf_focus" value="<?= $obj->fc_desc ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Behavior/Skill</label>
                        <input type="text" name="se_skill" class="form-control" value="<?= $obj->se_skill ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>When we use the Skill</label>
                        <input type="text" name="se_when_use" class="form-control" value="<?= $obj->se_when_use ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>How we use the Skill</label>
                        <input type="text" name="se_how_use" class="form-control" value="<?= $obj->se_how_use ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Why we use the Skill</label>
                        <input type="text" name="se_why_use" class="form-control" value="<?= $obj->se_why_use ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>My Expectations</label>
                        <input type="text" name="se_expectations" class="form-control" value="<?= $obj->se_expectations ?>" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Comments</label>
                        <textarea name="se_comments" rows="10" class="form-control" readonly><?= $obj->se_comments ?></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="asterisk-required">Feedback</label>
                        <textarea name="se_feedback" rows="10" class="form-control" required><?= $obj->se_feedback ?></textarea>
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
@include('coaching.js-script')
@endsection