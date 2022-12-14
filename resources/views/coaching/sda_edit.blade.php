@extends('layouts.main')
@section('title')
Linking Sessions > Skills Development Activities > Edit Session
@endsection
@section('head')
<style>
@include('coaching.style');
</style>
@endsection
@section('breadcrumb')
Linking Sessions <span>/</span> Skills Development Activities <span>></span> Edit Session
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="<?= url('update-skill-dev-act') ?>" method="post" autocomplete="off">
            {{ csrf_field() }}
            <input type="hidden" name="sda_com_id" value="<?= $obj->sda_com_id ?>">
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
                                <input type="text" class="form-control" name="lnk_linkee_name" value="<?= $linkee->fullName2() ?>" readonly>
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
                    Skill Development Activities Session

                    <a id="btn-history" class="btn btn-warning pull-right" href="#" data-toggle="modal" data-target="#modal-history"><i class="fa fa-history"></i>&nbsp; History</a>
                </div>
                <div class="panel-body">
                    <div class="row d-flex">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="asterisk-required">SDA Type</label>
                                <select class="form-control" name="sda_type" required>
                                    <option value="" class="d-none" selected>Select SDA Type</option>
                                    <option value="1"<?= ($obj->sda_type == 1) ? ' selected' : '' ?>>Call Listening Session</option>
                                    <option value="2"<?= ($obj->sda_type == 2) ? ' selected' : '' ?>>Mock Calls</option>
                                    <option value="3"<?= ($obj->sda_type == 3) ? ' selected' : '' ?>>Calibration Sessions</option>
                                </select>
                                <div class="form-text d-none"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="asterisk-required">Date of Call</label>
                                <input type="text" name="sda_date_call" class="form-control select-date" value="<?= date('m/d/Y', strtotime($obj->sda_date_call)) ?>" required>
                                <div class="form-text d-none"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="asterisk-required">Call Selection</label>
                                <input type="text" name="sda_call_sel" class="form-control" value="<?= $obj->sda_call_sel ?>" required>
                                <div class="form-text d-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="asterisk-required">What Went Well, You Said</label>
                                <textarea name="sda_www_u_said" rows="5" class="form-control" required><?= $obj->sda_www_u_said ?></textarea>
                                <div class="form-text d-none"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="asterisk-required">What Went Well, I Said</label>
                                <textarea name="sda_www_i_said" rows="5" class="form-control" required><?= $obj->sda_www_i_said ?></textarea>
                                <div class="form-text d-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="asterisk-required">What Could Make This Even Better, You Said</label>
                                <textarea name="sda_wcm_u_said" rows="5" class="form-control" required><?= $obj->sda_wcm_u_said ?></textarea>
                                <div class="form-text d-none"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="asterisk-required">What Could Make this Even Better, I Said</label>
                                <textarea name="sda_wcm_i_said" rows="5" class="form-control" required><?= $obj->sda_wcm_i_said ?></textarea>
                                <div class="form-text d-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="asterisk-required">Comments</label>
                                <textarea name="sda_comments" rows="10" class="form-control" required><?= $obj->sda_comments ?></textarea>
                                <div class="form-text d-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group pull-right">
                                <br>
                                <input type="submit" name="save_linking" id="btn-process_submit" class="btn btn-lg btn-primary" value="UPDATE LINKING">
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
@include('coaching.modal.skill_development_activities')
@endsection