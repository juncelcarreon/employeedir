<div>
    <div style="text-align:center;">
        <small style="padding: 20px 0 20px 0;font-size: 14px;">eLink Systems &amp; Concepts Corp.</small>
    </div>

        Hello <?= $obj_details['emp_name'] ?>,
        <br>
        <br>
		<?= $obj_details['requester_name'] ?> requested for an Undertime on <?= $obj_details['date'] ?> for <?= $obj_details['no_of_hours'] ?>.
		<br>
		<br>
        Kindly click on <a href="<?= $obj_details['url'] ?>">request</a> to approve/decline.

	<br>
	<br>
	Kind regards,
	<br>
	HR Department
</div>