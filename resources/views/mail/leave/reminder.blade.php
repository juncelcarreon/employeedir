<div>
    <center>
        <small style="padding: 20px 0 20px 0;font-size: 14px;">eLink Systems &amp; Concepts Corp.</small>
    </center>

        Hello {{ $obj_details['leader_name'] }},
        <br>
        <br>
        This is to remind you that {{ $obj_details['emp_name'] }} requested for a leave.  Please <a href="{{ url('leave').'/'.$obj_details['id'] }}">view</a> to approve or decline.

    <br>
    <br>
        Thank you!
    <br>
    <br>
    Kind regards,
    <br>
    HR Department
</div>