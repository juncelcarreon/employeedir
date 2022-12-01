<div>
    <div style="text-align:center;">
        <small style="padding: 20px 0 20px 0;font-size: 14px;">eLink Systems &amp; Concepts Corp.</small>
    </div>

        Hi <?= $obj_details['emp_name'] ?>,
        <br>
        <br>
        Your request for over time on the following dates has been approved.
        <br>
        <br>
                <table border="1" cellpadding="7">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Estimated No. of Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($obj_details['details'] as $detail):
                    ?>
                        <tr>
                            <td><?= date('F d, Y',strtotime($detail['date'])) ?></td>
                            <td><?= $detail['no_of_hours'] ?> hrs</td>
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
	Kind regards,
	<br>
	HR Department
</div>