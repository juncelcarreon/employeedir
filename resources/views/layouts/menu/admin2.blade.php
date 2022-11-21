<style type="text/css">
.dropdown-menu{
    position: static;
    width: 100%;
    background: unset;
    box-shadow: none;
    float: none;
    padding: 0;
    border: 0;
}
.dropdown-menu li a{
    height: auto !important;
    padding: 5px 5px 5px 40px;
}
</style>
<li <?php echo \Request::url() == url('dashboard') ? 'class="active"' : ''; ?>>
    <a href="{{url('dashboard')}}">
        <em class="fa fa-dashboard">&nbsp;</em>
        Dashboard
    </a>
</li>

<li <?php echo (\Request::url() == url('employees') || \Request::url() == url('employees/separated')) ? 'class="open"' : ''; ?>>
   <a href="javascript:;" class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <em class="fa fa-user">&nbsp;</em>
        Employees
    </a>

    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <li <?php echo \Request::url() == url('employees') ? 'class="active"' : ''; ?>><a class="dropdown-item" href="{{url('employees')}}">Active Employees</a></li>
        <li <?php echo \Request::url() == url('employees/separated') ? 'class="active"' : ''; ?>><a class="dropdown-item" href="{{url('employees/separated')}}">Separated Employees</a></li>
    </ul>
</li>

<li <?php echo \Request::url() == url('time-keeping') ? 'class="active"' : ''; ?>>
    <a href="{{url('time-keeping')}}">
        <em class="fa fa-clock-o">&nbsp;</em>
        Offline Break Logger
     </a>
 </li>
<li <?php echo \Request::url() == url('sup-view') ? 'class="active"' : ''; ?>>
    <a href="{{url('sup-view')}}">
       <em class="fa fa-clock-o">&nbsp;</em>
       Break Management 
    </a>
</li>
 <li <?php echo \Request::url() == url('coaching-session') ? 'class="active"' : ''; ?>>
    <a href="{{url('coaching-session')}}">
        <em class="fa fa-cogs">&nbsp;</em>
        Linking Sessions
     </a>
 </li>

<li <?php echo \Request::url() == url('department') ? 'class="active"' : ''; ?>>
    <a href="{{url('department')}}">
        <em class="fa fa-users">&nbsp;</em> 
        Departments
    </a>
</li>

<li <?php echo \Request::url() == url('activities') ? 'class="active"' : ''; ?>>
    <a href="{{url('activities')}}">
        <em class="fa fa-calendar">&nbsp;</em>
        Activities
    </a>
</li>

<li <?php echo \Request::url() == url('events') ? 'class="active"' : ''; ?>>
    <a href="{{url('events')}}">
        <em class="fa fa-calendar">&nbsp;</em>
        Events
    </a>
</li>

<li <?php echo \Request::url() == url('posts') ? 'class="active"' : ''; ?>>
    <a href="{{url('posts')}}">
        <em class="fa fa-calendar-o">&nbsp;</em> 
        HR Progress
    </a>
</li>

<li <?php echo \Request::url() == url('leave') ? 'class="active"' : ''; ?>>
    <a href="{{url('leave')}}">
        <em class="fa fa-calendar">&nbsp;</em>
        Leaves
        @if(Auth::user()->leaveRequestCount() > 0)
            <span class="badge label-danger">{{ Auth::user()->leaveRequestCount() }}</span>
        @endif
    </a>
</li>

<li <?php echo \Request::url() == url('leave') ? 'class="active"' : ''; ?>>
    <a href="\for-approval">
        <em class="fa fa-calendar">&nbsp;</em>
        Team Leave Request&nbsp;&nbsp;<span class="badge label-danger"></span>
    </a>
</li>

<li <?php echo \Request::url() == url('referral') ? 'class="active"' : ''; ?>>
    <a href="{{url('referral')}}">
        <em class="fa fa-user-plus">&nbsp;</em>
        Referrals
    </a>
</li>

<li <?php echo \Request::url() == url('hierarchy') ? 'class="active"' : ''; ?>>
    <a href="{{url('hierarchy')}}" style="font-size: 11px;">
        <em class="fa fa-sitemap">&nbsp;</em> 
        Update Employee Hierarchy
    </a>
</li>

<li >
   <a target="_blank" href="{{ url('/public/img/company-hierarchy.jpeg') }}">
        <span class="fa fa-sitemap">
        
        </span>
        Employee hierarchy
    </a>
</li>

<li>
    <a href="{{ route('logout')}}">
        <em class="fa fa-power-off">&nbsp;</em>
        Logout
    </a>
</li>