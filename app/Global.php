<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;

// *********** COSTUME METHOD ***********************************
function getNameFromNumber($num) {
    $numeric = ($num - 1) % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval(($num - 1) / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2) . $letter;
    } else {
        return $letter;
    }
}
function genderValue($gender)
{
	if ($gender == 'Female' || $gender == 'F' || $gender == 'FEMALE') {
		return 2;
	} else if ($gender == 'Male' || $gender == 'M' || $gender == 'MALE') {
		return 1;
	} else {
		return 0;
	}
}
function genderStringValue($gender)
{
	switch ($gender) {
		case '1':
			return "MALE";
		case 1:
			return "MALE";
		case '2';
			return "FEMALE";
		case 2:
			return "FEMALE";
		default:
			return "";
	}
}
function joinGrammar($prod_date)
{
	$prod_date_timestamp = strtotime($prod_date);
	$current_timestamp = time();

	if($prod_date_timestamp > $current_timestamp){
		return "Will join";
	}
	return "Joined";
}
function monthDay($prod_date)
{
	if (isset($prod_date)) {
        $dt = Carbon::parse($prod_date);
        return $dt->format('M d');
    } else {
        return "";
    } 
}
function slashedDate($prod_date)
{
	if (isset($prod_date)) {
        $dt = Carbon::parse($prod_date);
        return $dt->format('m/d/Y');
    } else {
        return "";
    } 
}

function prettyDate($prod_date)
{
	if (isset($prod_date)) {
        $dt = Carbon::parse($prod_date);
        return $dt->format('l, M d, Y');
    } else {
        return "";
    } 
}

function timeDate($date) {
    if (isset($date)) {
        $dt = Carbon::parse($date);
        return $dt->format('m/d/Y h:i A');
    } else {
        return "";
    }
}

function truncate($string, $length, $html = true)
{
    if (strlen($string) > $length) {
        if ($html) {
            // Grabs the original and escapes any quotes
            $original = str_replace('"', '\"', $string);
        }

        // Truncates the string
        $string = substr($string, 0, $length);

        // Appends ellipses and optionally wraps in a hoverable span
        if ($html) {
            $string = '<span title="' . $original . '">' . $string . '&hellip;</span>';
        } else {
            $string .= '...';
        }
    }

    return $string;
}
function curl_get_contents($url)
{
	$ch = curl_init();
	$timeout = 5;

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

	$data = curl_exec($ch);

	curl_close($ch);

	return $data;
}

function leaveCredits($leave_credit){
	if($leave_credit == 0){
		$leave_credit = "0 day";
	} else if($leave_credit == 0.5){
		$leave_credit = "1/2 day";
	} else if ($leave_credit == 1){
		$leave_credit = "1 day";
	} else if ($leave_credit > 1){
		$leave_credit = "$leave_credit day";
	}

	return "You have $leave_credit leave credits.";
}

function breadCrumbs(){
	$path = request()->path();

	return ucwords(join(' / ', explode('/', $path)));
}

function stringLimit($text = null, $max = 50){
    if(empty($text)) {
        return '---';
    }

    return (strlen(htmlentities($text)) > $max) ? substr(htmlentities($text), 0, $max)." ..." : htmlentities($text);
}

function timekeepingStatus($item = null){
	if(empty($item)) {
		return '---';
	}

    $status = $item->status;
    if($item->status == 'APPROVED' && !empty($item->approved_reason)) {
        $status = 'REVERTED';
    }
    if($item->status == 'PENDING') {
        if(empty($item->recommend_date)) {
            $status .= ' <br><small>(Recommendation / Approval)</small>';
        } else {
            $status .= ' <br><small>(Approval)</small>';
        }
    }

    return $status;
}

function leaveStatus($status = null){
	$txt = "Pending <br> <small>(Recommendation / Approval)</small>";
	if(empty($status)) {
		return $txt;
	}

    switch($status) {
        case 1:
            $txt = 'Approved';
            break;
        case 2:
            $txt = 'Not Approved';
            break;
        case 3:
            $txt = "Pending <br> <small>(Approval)</small>";
            break;
    }

    return $txt;
}

function timekeepingApprovedStatus($item = null){
	$txt = '<span class="fa fa-refresh"></span>&nbsp; Waiting for response';

	if(empty($item)) {
		return $txt;
	}

	switch($item->status) {
		case 'APPROVED':
			$txt = '<span class="fa fa-clock-o text-success"></span> Timekeeping';
			if(!empty($item->approved_reason)) {
				$txt = '<span class="fa fa-undo text-declined"></span> Reverted <br>Reason for incompletion <br>'.htmlentities($item->approved_reason);
			}
			if(!empty($item->date)) {
				$txt = '<span class="fa fa-check text-success"></span> Approved';
			}
			break;
		case 'DECLINED':
			$txt = '<span class="fa fa-thumbs-down text-declined"></span> Declined <br>Reason for disapproval <br>'.htmlentities($item->declined_reason);
			break;
		case 'VERIFYING':
			$txt = '<span class="fa fa-spinner text-verify"></span> Verifying';
			break;
		case 'COMPLETED':
			$txt = '<span class="fa fa-check text-success"></span> Completed';
	}

	return nl2br($txt);
}

function numberOfHours($time_in = null, $time_out = null, $undertime = false, $minutes = false){
	$no_of_hours = '';
	if(!empty($time_in) && !empty($time_out)) {
	    $start = new DateTime($time_in);
	    $end = $start->diff(new DateTime($time_out));
	    $end->d = $end->d * 24;
	    if($undertime) {
		    $end->h = ($end->h - 1) + $end->d;
		} else {
		    $end->h = $end->h + $end->d;
		}

		if($minutes) {
			$no_of_hours = "{$end->h} hrs";
			if($end->i > 0) { $no_of_hours.= " {$end->i} mins"; }
		} else {
		    $no_of_hours = number_format($end->h, 2);
		}
	}

	return $no_of_hours;
}