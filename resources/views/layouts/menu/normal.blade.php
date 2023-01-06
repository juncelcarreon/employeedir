<li>
	<a id="menu-home" href="<?= url('home') ?>">
		<em class="fa fa-home">&nbsp;</em>
		Home
	</a>
</li>

<li>
	<a href="javascript:;" class="menu-has-child" id="policyMenuLink" data-key="close">
		<em class="fa fa-shield">&nbsp;</em>
		Company Policy
	</a>

	<ul class="menu-child" data-target="policyMenuLink">
		<li>
			<a id="menu-attendance" class="menu-child-item" target="_blank" href="<?= asset('attachment/attendance.pdf') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				Attendance
			</a>
		</li>

		<li>
			<a id="menu-company-directives" class="menu-child-item" target="_blank" href="<?= asset('attachment/directives.pdf') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				Company Directives
			</a>
		</li>

		<li>
			<a id="menu-dress-code" class="menu-child-item" target="_blank" href="<?= asset('attachment/dresscode.pdf') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				Dress Code
			</a>
		</li>
	</ul>
</li>

<li>
	<a href="javascript:;" class="menu-has-child" id="timekeepingMenuLink" data-key="close">
		<em class="fa fa-clock-o">&nbsp;</em>
		Timekeeping
	</a>

	<ul class="menu-child" data-target="timekeepingMenuLink">
		<li>
			<a id="menu-overtime" class="menu-child-item" href="<?= url('overtime') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				Overtime
			</a>
		</li>

		<li>
			<a id="menu-undertime" class="menu-child-item" href="<?= url('undertime') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				Undertime
			</a>
		</li>
	</ul>
</li>

<li>
	<a id="menu-leaves" href="<?= url('leave') ?>">
		<em class="fa fa-calendar-o">&nbsp;</em>
		Leaves
	</a>
</li>
<!-- 
<li>
	<a id="menu-dainfraction" href="<?= url('dainfraction') ?>">
		<em class="fa fa-warning">&nbsp;</em>
		DA Infractions
<?php
	if(Auth::check() && Auth::user()->scopeInfractionCount(Auth::user()->id) > 0) {
?>
		&nbsp;
		<span class="badge label-danger"><?= Auth::user()->scopeInfractionCount(Auth::user()->id) ?></span>
<?php
	}
?>
	</a>
</li>
 -->
<li>
	<a id="menu-linking-sessions" href="<?= url('coaching-session') ?>">
		<em class="fa fa-cogs">&nbsp;</em>
		Linking Sessions
	</a>
</li>

<li>
	<a id="menu-active-employees" href="<?= url('employees') ?>">
		<em class="fa fa-users">&nbsp;</em>
		Employees
	</a>
</li>

<?php
if(Auth::check() && Auth::user()->dept_code == 'TLA01') {
?>
<li>
	<a id="menu-referrals" href="<?= url('referral') ?>">
		<em class="fa fa-user-plus">&nbsp;</em>
		Referrals

<?php
	if(Auth::user()->scopeNewReferral() > 0) {
?>
		&nbsp;
		<span class="badge label-danger"><?= Auth::user()->scopeNewReferral() ?></span>
<?php
	}
?>
	</a>
</li>
<?php
} else {
?>
<li>
	<a id="menu-referrals" href="<?= url('referral/create') ?>">
		<em class="fa fa-user-plus">&nbsp;</em>
		Job Referral
	</a>
</li>
<?php
}
?>

<li>
	<a id="menu-events" href="<?= url('events/calendar') ?>">
		<em class="fa fa-calendar">&nbsp;</em>
		Events
	</a>
</li>

<li>
	<a id="menu-employee-hierarchy" target="_blank" href="<?= asset('img/company-hierarchy.jpeg') ?>">
		<em class="fa fa-sitemap">&nbsp;</em>
		Employee Hierarchy
	</a>
</li>

<?php
if(Auth::check()) {
?>
<li>
	<a id="menu-logout" href="<?= route('logout') ?>">
		<em class="fa fa-power-off">&nbsp;</em>
		Logout
	</a>
</li>
<?php
} else {
?>
<li>
	<a id="menu-login" href="<?= route('login') ?>">
		<em class="fa fa-sign-in">&nbsp;</em>
		Login
	</a>
</li>
<?php
}
?>