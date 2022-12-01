<div>
    <div style="text-align:center;">
        <small style="padding: 20px 0 20px 0;font-size: 14px;">eLink Systems &amp; Concepts Corp.</small>
    </div>

        Hello <?= $obj_details['leader_name'] ?>,
        <br>
        <br>
        Please verify and approve <?= $obj_details['emp_name'] ?> filed over time report for the following date/s:
        <br>
        <br>
                <table border="1" cellpadding="7">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>OT Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($obj_details['details'] as $detail):
                        $no_of_hours = '';
                        if(!empty($detail['time_in']) && !empty($detail['time_out'])) {
                            $start = new DateTime($detail['time_in']);
                            $end = $start->diff(new DateTime($detail['time_out']));

                            $no_of_hours = "{$end->h} hrs";
                            if($end->i > 0) { $no_of_hours.= " {$end->i} mins"; }
                        }
                    ?>
                        <tr>
                            <td><?= date('F d, Y',strtotime($detail['date'])) ?></td>
                            <td><?= $no_of_hours ?></td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                    </tbody>
                </table>
                <br>
                <br>
                Reason: <br>
                <div style="white-space: pre-line;"><?= nl2br(htmlentities($obj_details['reason'])) ?></div>
	            <br>
                <br>
        Kindly click on OT <a href="<?= $obj_details['url'] ?>">request</a> to approve/decline.

	<br>
	<br>
	Kind regards,
    <br>
    HR Department
</div>