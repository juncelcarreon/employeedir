@extends('layouts.main')
@section('title')
Linking Sessions > Goal Setting > View Session
@endsection
@section('head')
<style>
@include('coaching.style');
</style>
@endsection
@section('breadcrumb')
Linking Sessions <span>/</span> Goal Setting <span>></span> View Session
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
                Goal Setting Session
            </div>
            <div class="panel-body">
                <div class="row d-flex">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Accomplishments</label>
                            <input type="text" name="gs_accmpl" class="form-control" value="<?= $obj->gs_accmpl ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <table class="table-metric table-bordered table-striped">
                                <tr>
                                    <th>Num</th>
                                    <th>Metric</th>
                                    <th>Target</th>
                                    <th>Prev Month</th>
                                    <th>Cur Month</th>
                                </tr>
                                <tr>
                                    <td><strong>1</strong></td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_metric_01" class="form-control" value="<?= $obj->gs_metric_01 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_target_01" class="form-control" value="<?= $obj->gs_target_01 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_prev_01" class="form-control" value="<?= $obj->gs_prev_01 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_curr_01" class="form-control" value="<?= $obj->gs_curr_01 ?>" readonly>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>2</strong></td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_metric_02" class="form-control" value="<?= $obj->gs_metric_02 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_target_02" class="form-control" value="<?= $obj->gs_target_02 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_prev_02" class="form-control" value="<?= $obj->gs_prev_02 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_curr_02" class="form-control" value="<?= $obj->gs_curr_02 ?>" readonly>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>3</strong></td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_metric_03" class="form-control" value="<?= $obj->gs_metric_03 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_target_03" class="form-control" value="<?= $obj->gs_target_03 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_prev_03" class="form-control" value="<?= $obj->gs_prev_03 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_curr_03" class="form-control" value="<?= $obj->gs_curr_03 ?>" readonly>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>4</strong></td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_metric_04" class="form-control" value="<?= $obj->gs_metric_04 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_target_04" class="form-control" value="<?= $obj->gs_target_04 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_prev_04" class="form-control" value="<?= $obj->gs_prev_04 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_curr_04" class="form-control" value="<?= $obj->gs_curr_04 ?>" readonly>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>5</strong></td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_metric_05" class="form-control" value="<?= $obj->gs_metric_05 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_target_05" class="form-control" value="<?= $obj->gs_target_05 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_prev_05" class="form-control" value="<?= $obj->gs_prev_05 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_curr_05" class="form-control" value="<?= $obj->gs_curr_05 ?>" readonly>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>6</strong></td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_metric_06" class="form-control" value="<?= $obj->gs_metric_06 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_target_06" class="form-control" value="<?= $obj->gs_target_06 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_prev_06" class="form-control" value="<?= $obj->gs_prev_06 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_curr_06" class="form-control" value="<?= $obj->gs_curr_06 ?>" readonly>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>7</strong></td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_metric_07" class="form-control" value="<?= $obj->gs_metric_07 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_target_07" class="form-control" value="<?= $obj->gs_target_07 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_prev_07" class="form-control" value="<?= $obj->gs_prev_07 ?>" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="gs_curr_07" class="form-control" value="<?= $obj->gs_curr_07 ?>" readonly>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tip for the Month</label>
                            <textarea name="gs_tip" rows="5" class="form-control" readonly><?= $obj->gs_tip ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Commitment</label>
                            <textarea name="gs_com" rows="5" class="form-control" readonly><?= $obj->gs_com ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Feedback</label>
                            <textarea name="gs_feedback" rows="10" class="form-control" readonly><?= $obj->gs_feedback ?></textarea>
                            <div class="form-text d-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('coaching.js-script')
@endsection