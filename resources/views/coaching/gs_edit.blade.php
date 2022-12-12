@extends('layouts.main')
@section('title')
Linking Sessions > Goal Setting > Edit Session
@endsection
@section('breadcrumb')
Linking Sessions <span>/</span> Goal Setting <span>></span> Edit Session
@endsection
@section('content')
<style>
@include('coaching.style');
</style>
<form action="<?= url('update-goal-setting') ?>" method="post" autocomplete="off">
    {{ csrf_field() }}
    <input type="hidden" name="gs_com_id" value="<?= $obj->gs_com_id ?>">
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
            Goal Setting Session

            <a id="btn-history" class="btn btn-warning pull-right" href="#" data-toggle="modal" data-target="#modal-history"><i class="fa fa-history"></i> History</a>
        </div>
        <div class="panel-body">
            <div class="row d-flex">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="asterisk-required">Accomplishments</label>
                        <input type="text" name="gs_accmpl" class="form-control" value="<?= $obj->gs_accmpl ?>" required>
                        <div class="form-text d-none"></div>
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
                                        <input type="text" name="gs_metric_01" class="form-control" value="<?= $obj->gs_metric_01 ?>" required>
                                        <div class="form-text d-none"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_target_01" class="form-control" value="<?= $obj->gs_target_01 ?>" required>
                                        <div class="form-text d-none"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_prev_01" class="form-control" value="<?= $obj->gs_prev_01 ?>" required>
                                        <div class="form-text d-none"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_curr_01" class="form-control" value="<?= $obj->gs_curr_01 ?>" required>
                                        <div class="form-text d-none"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>2</strong></td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_metric_02" class="form-control" value="<?= $obj->gs_metric_02 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_target_02" class="form-control" value="<?= $obj->gs_target_02 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_prev_02" class="form-control" value="<?= $obj->gs_prev_02 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_curr_02" class="form-control" value="<?= $obj->gs_curr_02 ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>3</strong></td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_metric_03" class="form-control" value="<?= $obj->gs_metric_03 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_target_03" class="form-control" value="<?= $obj->gs_target_03 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_prev_03" class="form-control" value="<?= $obj->gs_prev_03 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_curr_03" class="form-control" value="<?= $obj->gs_curr_03 ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>4</strong></td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_metric_04" class="form-control" value="<?= $obj->gs_metric_04 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_target_04" class="form-control" value="<?= $obj->gs_target_04 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_prev_04" class="form-control" value="<?= $obj->gs_prev_04 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_curr_04" class="form-control" value="<?= $obj->gs_curr_04 ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>5</strong></td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_metric_05" class="form-control" value="<?= $obj->gs_metric_05 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_target_05" class="form-control" value="<?= $obj->gs_target_05 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_prev_05" class="form-control" value="<?= $obj->gs_prev_05 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_curr_05" class="form-control" value="<?= $obj->gs_curr_05 ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>6</strong></td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_metric_06" class="form-control" value="<?= $obj->gs_metric_06 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_target_06" class="form-control" value="<?= $obj->gs_target_06 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_prev_06" class="form-control" value="<?= $obj->gs_prev_06 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_curr_06" class="form-control" value="<?= $obj->gs_curr_06 ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>7</strong></td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_metric_07" class="form-control" value="<?= $obj->gs_metric_07 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_target_07" class="form-control" value="<?= $obj->gs_target_07 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_prev_07" class="form-control" value="<?= $obj->gs_prev_07 ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="gs_curr_07" class="form-control" value="<?= $obj->gs_curr_07 ?>">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk-required">Tip for the Month</label>
                        <textarea name="gs_tip" rows="5" class="form-control" required><?= $obj->gs_tip ?></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="asterisk-required">Commitment</label>
                        <textarea name="gs_com" rows="5" class="form-control" required><?= $obj->gs_com ?></textarea>
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
@include('coaching.modal.goal_setting')
@include('coaching.js-script')
@endsection