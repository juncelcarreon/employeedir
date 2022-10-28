<div>
    <div>
        <small style="padding: 20px 0 20px 0;font-size: 11px; color: #a2aec7;">eLink&nbsp;&nbsp;&nbsp;F&nbsp;A&nbsp;L&nbsp;C&nbsp;O&nbsp;N&nbsp;&nbsp;&nbsp;∞&nbsp;&nbsp;&nbsp;HR Portal</small>
    </div>
<br>
<br>
Hello, 
<br>
<br>
<br>
This is to remind you that {{ $obj_details['emp_name'] }} who was hired last {{ $obj_details['date_hired'] }} is due for a 5-Month Performance review on {{ $obj_details['date'] }}.  Kindly submit your Performance Evaluation before {{ $obj_details['due_date'] }}. 
<br>
<br>
Please disregard this notice if performance evaluation has already been submitted. 
<br>
<br>
Thank you!
<br>
<br>
<br>
Kind regards,
HR Department
<br>
<br>
<br>
<br>
<div>
    <small style="padding: 20px 0 20px 0;font-size: 12px;"><a href="http://{{ $_SERVER['HTTP_HOST'] }}/stop-reminder/{{ $obj_details['id'] }}">For HR: (Click here to complete this item.)</a></small>
</div>
</div>