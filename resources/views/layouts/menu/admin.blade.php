<li>
	<a id="menu-home" href="<?= url('dashboard') ?>">
		<em class="fa fa-dashboard">&nbsp;</em>
		Dashboard
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
	<a href="javascript:;" class="menu-has-child" id="employeesMenuLink" data-key="close">
		<em class="fa fa-user">&nbsp;</em>
		Employees
	</a>

	<ul class="menu-child" data-target="employeesMenuLink">
		<li>
			<a id="menu-active-employees" class="menu-child-item" href="<?= url('employees') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				Active Employees
			</a>
		</li>

		<li>
			<a id="menu-separated-employees" class="menu-child-item" href="<?= url('employees/separated') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				Separated Employees
			</a>
		</li>
	</ul>
</li>

<li>
	<a href="javascript:;" class="menu-has-child" id="blogpostMenuLink" data-key="close">
		<em class="fa fa-newspaper-o">&nbsp;</em>
		Blog Post
	</a>

	<ul class="menu-child" data-target="blogpostMenuLink">
		<li>
			<a id="menu-activities" class="menu-child-item" href="<?= url('activities') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				Activities
			</a>
		</li>

		<li>
			<a id="menu-events" class="menu-child-item" href="<?= url('events') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				Events
			</a>
		</li>

		<li>
			<a id="menu-hr-progress" class="menu-child-item" href="<?= url('posts') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				HR Progress
			</a>
		</li>
	</ul>
</li>

<li>
	<a href="javascript:;" class="menu-has-child" id="timekeepingMenuLink" data-key="close">
		<em class="fa fa-clock-o">&nbsp;</em>
		Timekeeping
<?php
	if((Auth::user()->undertimeRequestCount() + Auth::user()->overtimeRequestCount()) > 0) {
?>
		&nbsp;
		<span class="badge label-danger"><?= Auth::user()->undertimeRequestCount() + Auth::user()->overtimeRequestCount() ?></span>
<?php
	}
?>
	</a>

	<ul class="menu-child" data-target="timekeepingMenuLink">
		<li>
			<a id="menu-overtime" class="menu-child-item" href="<?= url('overtime') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				Overtime
<?php
	if(Auth::user()->overtimeRequestCount() > 0) {
?>
				&nbsp;
				<span class="badge label-secondary"><?= Auth::user()->overtimeRequestCount() ?></span>
<?php
	}
?>
			</a>
		</li>

		<li>
			<a id="menu-undertime" class="menu-child-item" href="<?= url('undertime') ?>">
				<em class="fa fa-circle-o">&nbsp;</em>
				Undertime
<?php
	if(Auth::user()->undertimeRequestCount() > 0) {
?>
				&nbsp;
				<span class="badge label-secondary"><?= Auth::user()->undertimeRequestCount() ?></span>
<?php
	}
?>
			</a>
		</li>
	</ul>
</li>

<li>
	<a id="menu-leaves" href="<?= url('leave') ?>">
		<em class="fa fa-calendar-o">&nbsp;</em>
		Leaves
<?php
	if(Auth::user()->leaveRequestCount() > 0) {
?>
		&nbsp;
		<span class="badge label-danger"><?= Auth::user()->leaveRequestCount() ?></span>
<?php
	}
?>
	</a>
</li>
<!-- 
<li>
	<a id="menu-dainfraction" href="<?= url('dainfraction') ?>">
		<em class="fa fa-warning">&nbsp;</em>
		DA Infractions
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
	<a id="menu-department" href="<?= url('department') ?>">
		<em class="fa fa-users">&nbsp;</em> 
		Departments
	</a>
</li>

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

<li>
	<a id="menu-setting" href="<?= url('setting') ?>">
		<em class="fa fa-cog">&nbsp;</em> 
		Setting
	</a>
</li>

<li>
	<a id="menu-employee-hierarchy" target="_blank" href="<?= asset('img/company-hierarchy.jpeg') ?>">
		<em class="fa fa-sitemap">&nbsp;</em>
		Employee Hierarchy
	</a>
</li>

<li>
	<a id="menu-logout" href="<?= route('logout') ?>">
		<em class="fa fa-power-off">&nbsp;</em>
		Logout
	</a>
</li>