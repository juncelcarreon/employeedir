@extends('layouts.main')
@section('title')
Linking Sessions > New Linking Session
@endsection
@section('breadcrumb')
Linking Sessions &nbsp;/&nbsp; New Linking
@endsection
@section('content')
<style>
@include('coaching.style');
</style>
<div class="panel panel-primary">
    @include('coaching.sub_menu')
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form id="main_form_linking" method="get">
                    {{ csrf_field() }}
                    <input type="hidden" id="lnk_linkee_name" name="lnk_linkee_name">
                    <input type="hidden" id="lnk_linkee_email" name="lnk_linkee_email">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Date</label>
                                <input type="text" class="form-control" name="lnk_date" value="<?= date("F d, Y") ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Linkee</label>
                                <select id="main_linkee" name="lnk_linkee" class="form-control select2" required>
                                    <option value="" disabled selected>Select a Linkee</option>
                                    <?php
                                    foreach($names as $ss) {
                                    ?>
                                    <option value="<?= $ss->id ?>" email="<?= $ss->email ?>" full_name="<?= $ss->first_name." ".$ss->last_name ?>"><?= $ss->last_name.", ".$ss->first_name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="form-text d-none"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Linking Type</label>
                                <select id="lst_type" name="lnk_type" class="form-control select2" required>
                                    <option value="" disabled selected>Select Linking Type</option>
                                    <?php
                                    foreach($lt_types as $ss) {
                                    ?>
                                    <option value="<?= $ss->lt_id ?>"><?= $ss->lt_desc ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="form-text d-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group pull-right">
                                <br>
                                <input type="submit" name="process_linking" id="btn-process_submit" class="btn btn-lg btn-primary" value="START LINKING">
                            </div>
                        </div>
                    </div>
                </form>  
            </div>
        </div>
    </div>
</div>
@include('coaching.js-script')
@endsection