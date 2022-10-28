<div>
	<center>
		<small style="padding: 20px 0 20px 0;font-size: 14px;">eLink Systems &amp; Concepts Corp.</small>
	</center>

        Hello {{ $obj_details['emp_name'] }},
        <br>
        <br>
		{{ $obj_details['requester_name'] }} requested for a {{ $obj_details['type'] }} leave.
		<br>
		<br>
                <table border="1" cellpadding="7">
                    <thead>
                        <tr>
                            <th>Leave Date</th>
                            <th>Length</th>
                            <th>Pay Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    for($i = 0; $i < count($obj_details['details']['leave_date']); $i++):
                    ?>
                        <tr>
                            <td>{{ date('F d, Y',strtotime($obj_details['details']['leave_date'][$i])) }}</td>
                            <td>{{ $obj_details['details']['length'][$i] == 1 ? "Whole Day" : "Half Day" }}</td>
                            <td>{{ $obj_details['details']['pay_type'][$i] == 1 ? "With Pay" : "Without Pay" }}</td>
                        </tr>
                    <?php
                    endfor;
                    ?>
                    </tbody>
                </table>
                <br>
                <br>
		Kindly click Leave Request <a href="{{ url('leave').'/'.$obj_details['id'] }}">(link)</a> to view.

	<br>
	<br>
	Kind regards,
	<br>
	HR Department
</div>