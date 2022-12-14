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
			<a id="menu-attendance" class="menu-child-item" target="_blank" href="<?= url('attachment/attendance.pdf') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				Attendance
			</a>
		</li>

		<li>
			<a id="menu-company-directives" class="menu-child-item" target="_blank" href="<?= url('attachment/directives.pdf') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				Company Directives
			</a>
		</li>

		<li>
			<a id="menu-dress-code" class="menu-child-item" target="_blank" href="<?= url('attachment/dresscode.pdf') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				Dress Code
			</a>
		</li>
	</ul>
</li>

<li>
	<a id="menu-offline-break-logger" href="<?= url('time-keeping') ?>">
		<em class="fa fa-clock-o">&nbsp;</em>
		Offline Break Logger
	</a>
</li>

<?php
if(Auth::check() && (Auth::user()->usertype == 2 || Auth::user()->usertype == 3)) {
?>
<li>
	<a id="menu-break-management" href="<?= url('sup-view') ?>">
		<em class="fa fa-clock-o">&nbsp;</em>
		Break Management 
	</a>
</li>
<?php
}
?>

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

<li>
	<a id="menu-leaves" href="<?= url('leave') ?>">
		<em class="fa fa-calendar">&nbsp;</em>
		Leaves
	</a>
</li>

<li>
	<a id="menu-referrals" href="<?= url('referral/create') ?>">
		<em class="fa fa-user-plus">&nbsp;</em>
		Job Referral
	</a>
</li>

<li>
	<a id="menu-events" href="<?= url('events/calendar') ?>">
		<em class="fa fa-calendar">&nbsp;</em>
		Events
	</a>
</li>

<li>
	<a id="menu-employee-hierarchy" target="_blank" href="<?= url('img/company-hierarchy.jpeg') ?>">
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