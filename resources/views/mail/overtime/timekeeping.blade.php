<div>
    <div style="text-align:center;">
        <small style="padding: 20px 0 20px 0;font-size: 14px;">eLink Systems &amp; Concepts Corp.</small>
    </div>

        Hello Timekeeping,
        <br>
        <br>
		Sample Email for TIMEKEEPING.
		<br>
		<br>
                <table border="1" cellpadding="7">
                    <thead>
                        <tr>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>No. of Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($obj_details['details'] as $detail):
                        $no_of_hours = '';
                        $start = new DateTime($detail->time_in);
                        $end = $start->diff(new DateTime($detail->time_out));

                        $no_of_hours = "{$end->h} hrs";
                        if($end->i > 0) { $no_of_hours.= " {$end->i} mins"; }
                    ?>
                        <tr>
                            <td><?= date('F d, Y H:i A',strtotime($detail->time_in)) ?></td>
                            <td><?= date('F d, Y H:i A',strtotime($detail->time_out)) ?></td>
                            <td><?= $no_of_hours ?></td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                    </tbody>
                </table>

	<br>
	<br>
	Kind regards,
	<br>
	HR Department
</div>