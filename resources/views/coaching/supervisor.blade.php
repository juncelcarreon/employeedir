@extends('layouts.main')
@section('title')
Linking Sessions > New Linking Session
@endsection
@section('content')
<div class="container-fluid">
    <div class="panel panel-primary">
        @include('coaching.sub_menu')
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12" style="padding: 12px;"><b style="color: #0000FF; font-size: 16px;">New Linking Session</b></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <form id="main_form_linking">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="text" class="form-control" name="lnk_date" id="exampleInputDate" aria-describedby="Coaching Date" readonly="1" value="<?= date("F d, Y") ?>">
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label class="form-label">Linkee</label>
                                    <select id="main_linkee" name="lnk_linkee" class="form-control select2" aria-label="Select a Linkee" aria-describedby="lnk_linkeeHelp">
                                        <option value="0" selected>Select a Linkee</option>
                                        <?php
                                        foreach($names as $ss) {
                                        ?>
                                        <option value="<?= $ss->id ?>" email="<?= $ss->email ?>" full_name="<?= $ss->first_name." ".$ss->last_name ?>"<?= ($lastVal['lnk_linkee'] == $ss->id) ? " selected" : ""?>><?= $ss->last_name.", ".$ss->first_name ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <div id="lnk_linkeeHelp" class="form-text" style="color: red; display: none;">*Please select a linkee</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label class="form-label">Linking Type</label>
                                    <select id="lst_type" name="lnk_type" class="form-control select2" aria-label="Select Linking Type" aria-describedby="lnk_typeHelp">
                                        <option value="0" selected>Select Linking Type</option>
                                        <?php
                                        foreach($lt_types as $ss) {
                                        ?>
                                        <option value="<?= $ss->lt_id ?>"<?= ($lastVal['lnk_type'] == $ss->lt_id) ? " selected" : ""?>><?= $ss->lt_desc ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <div id="lnk_typeHelp" class="form-text" style="color: red; display: none;">*Please select a linking type</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <br>
                                    <input type="hidden" id="lnk_linker_name" name="lnk_linker_name" value="<?= $lastVal['lnk_linker_name'] ?>">
                                    <input type="hidden" id="lnk_linker_email" name="lnk_linker_email" value="<?= $lastVal['lnk_linker_email'] ?>">
                                    <input type="hidden" id="lnk_linkee_name" name="lnk_linkee_name" value="<?= $lastVal['lnk_linkee_name'] ?>">
                                    <input type="hidden" id="lnk_linkee_email" name="lnk_linkee_email" value="<?= $lastVal['lnk_linkee_email'] ?>">
                                    <input type="submit" name="process_linking" id="btn-process_submit" class="btn btn-lg btn-primary" value="START LINKING">
                                </div>
                            </div>
                        </div>
                    </form>  
                </div>
                <div class="col-md-6">
                    <br>
                    <br>
                    <?php
                    if (Auth::user()->usertype == 2 || Auth::user()->usertype == 3 || Auth::user()->isAdmin()) {
                    ?>
                    <a href="/download-linking2" type="button" class="btn btn-lg btn-primary">DOWNLOAD EXCEL REPORT</a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function initVals(){
    var linkee = <?= $lastVal['lnk_linkee'] ? 1 : 0 ?>;
    var lnk_type = <?= $lastVal['lnk_type'] ? 1 : 0 ?>;
    var flag = <?= $lastVal['flag'] ? 1 : 0 ?>;

    if(flag && linkee == 0){
        $("#lnk_linkeeHelp").show();
    }

    if(flag && lnk_type == 0){
        $("#lnk_typeHelp").show();
    }
}
$(function(){
    activeMenu($('#menu-linking-sessions'));

    $('#main_linkee').select2();
    initVals();

    $("#main_linkee").on("change",function(){
        var linkee = $('option:selected', this).attr("full_name");
        var email = $('option:selected', this).attr("email");

        $("#lnk_linkee_name").val(linkee);
        $("#lnk_linkee_email").val(email);
    });
});
</script>
@endsection