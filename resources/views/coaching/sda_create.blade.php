@extends('layouts.main')
@section('title')
Linking Sessions > Skills Development Activities > New Session
@endsection
@section('breadcrumb')
Linking Sessions > Skills Development Activities > New Session
@endsection
@section('content')
<style>
@include('coaching.style');
</style>
<form action="<?= url('add-skill-dev-act') ?>" method="post" autocomplete="off">
    {{ csrf_field() }}
    <input type="hidden" name="lnk_linkee" value="<?= $obj['lnk_linkee'] ?>">
    <input type="hidden" name="lnk_linkee_email" value="<?= $obj['lnk_linkee_email'] ?>">
    <input type="hidden" name="lnk_date" value="<?= $obj['lnk_date'] ?>">
    <div class="panel panel-primary">
        @include('coaching.sub_menu')
        <div class="panel-body">
            <div class="row d-flex">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Linker</label>
                        <input type="text" class="form-control" name="lnk_linker_name" value="<?= Auth::user()->fullName2() ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Linkee</label>
                        <input type="text" class="form-control" name="lnk_linkee_name" value="<?= $obj['lnk_linkee_name'] ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="text" class="form-control" value="<?= $obj['lnk_date'] ?>" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-subheading">
            Skill Development Activities Session

            <a id="btn-history" class="btn btn-warning pull-right" href="#" data-toggle="modal" data-target="#modal-history"><i class="fa fa-history"></i> History</a>
        </div>
        <div class="panel-body">
            <div class="row d-flex">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">SDA Type</label>
                        <select class="form-control select2" name="sda_type" required>
                            <option value="0" disabled selected>Select SDA Type</option>
                            <option value="1">Call Listening Session</option>
                            <option value="2">Mock Calls</option>
                            <option value="3">Calibration Sessions</option>
                        </select>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Date of Call</label>
                        <input type="text" name="sda_date_call" class="form-control select-date" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Call Selection</label>
                        <input type="text" name="sda_call_sel" class="form-control" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk-required">What Went Well, You Said</label>
                        <textarea name="sda_www_u_said" rows="5" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk-required">What Went Well, I Said</label>
                        <textarea name="sda_www_i_said" rows="5" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk-required">What Could Make This Even Better, You Said</label>
                        <textarea name="sda_wcm_u_said" rows="7" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk-required">What Could Make this Even Better, I Said</label>
                        <textarea name="sda_wcm_i_said" rows="7" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="asterisk-required">Comments</label>
                        <textarea name="sda_comments" rows="10" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group pull-right">
                        <br>
                        <input type="submit" name="save_linking" id="btn-process_submit" class="btn btn-lg btn-primary" value="SAVE LINKING">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@include('coaching.modal.skill_development_activities')
@include('coaching.js-script')
@endsection