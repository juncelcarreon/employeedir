<div>
    <center>
        <small style="padding: 20px 0 20px 0;font-size: 14px;">eLink Systems &amp; Concepts Corp.</small>
    </center>

        Hello <?= $obj_details['emp_name'] ?>,
        <br>
        <br>
        You have a pending Linking Session for acknowledgement. To view, please log in to HR Portal and view linking session <a href="http://dir.elink.corp/quick-link-acknowledge/<?= $obj_details['id'] ?>">(link)</a>.

    <br>
    <br>
        Thank you!
    <br>
    <br>
    Kind regards,
    <br>
    <?= $obj_details['leaders_name'] ?>
</div>