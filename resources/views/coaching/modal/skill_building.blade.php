<div class="modal fade" id="modal-history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= empty($linkee) ? $obj['lnk_linkee_name'] : $linkee->fullName2() ?>'s Skill Building History</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="table-history">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Focus</th>
                            <th>Linker</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($history as $lk) {
                            if(empty($obj->sb_com_num) || $obj->sb_com_num != $lk->sb_com_num) {
                                $url = url("skill-building-edit/{$lk->sb_com_num}");
                                if($lk->lnk_acknw) {
                                    $url = url("skill-building/{$lk->sb_com_num}");
                                }
                        ?>
                        <tr>
                            <td><span class="d-none"><?= strtotime($lk->created_at) ?></span> <?= date("F d, Y", strtotime($lk->lnk_date)) ?></td>
                            <td><?= $lk->fc_desc ?></td>
                            <td><?= strtoupper($lk->first_name.' '.$lk->last_name) ?></td>
                            <td><?= ($lk->lnk_acknw) ? 'Acknowledged' : 'Pending' ?></td>
                            <td><a class="btn btn-primary" href="<?= $url ?>" target="_blank">VIEW</a></td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>