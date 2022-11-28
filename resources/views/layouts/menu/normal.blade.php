<li>
    <a id="menu-home" href="{{url('home')}}">
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
            <a id="menu-attendance" class="menu-child-item" target="_blank" href="{{ url('/./attachment/attendance.pdf') }}">
                <em class="fa fa-circle-o">&nbsp;</em>
                Attendance
            </a>
        </li>

        <li>
            <a id="menu-company-directives" class="menu-child-item" target="_blank" href="{{ url('/./attachment/directives.pdf') }}">
                <em class="fa fa-circle-o">&nbsp;</em>
                Company Directives
            </a>
        </li>

        <li>
            <a id="menu-dress-code" class="menu-child-item" target="_blank" href="{{ url('/./attachment/dresscode.pdf') }}">
                <em class="fa fa-circle-o">&nbsp;</em>
                Dress Code
            </a>
        </li>
    </ul>
</li>

<li <?php echo \Request::url() == url('time-keeping') ? 'class="active"' : ''; ?>>
    <a href="{{url('time-keeping')}}">
        <em class="fa fa-clock-o">&nbsp;</em>
        Offline Break Logger
    </a>
</li>

<li>
    <a id="menu-linking-sessions" href="{{url('coaching-session')}}">
        <em class="fa fa-cogs">&nbsp;</em>
        Linking Sessions
    </a>
</li>

<li>
    <a id="menu-active-employees" href="{{url('employees')}}">
        <em class="fa fa-users">&nbsp;</em>
        Employees
    </a>
</li>

<li>
    <a id="menu-leaves" href="{{url('leave/')}}">
        <em class="fa fa-calendar">&nbsp;</em>
        Leaves 
    </a>
</li>

<li>
    <a id="menu-referrals" href="{{url('referral/create')}}">
        <em class="fa fa-user-plus">&nbsp;</em>
        Job Referral
    </a>
</li>

<li>
    <a id="menu-events" href="{{url('events/calendar')}}">
        <em class="fa fa-calendar">&nbsp;</em>
        Events Calendar
    </a>
</li>

@auth
    @if(Auth::user()->leaveRequestCount() > 0)
        <!--<li <?php echo \Request::url() == url('leave') ? 'class="active"' : ''; ?>>
            <a href="{{url('leave')}}">
                <em class="fa fa-calendar">&nbsp;</em>
                Leave Requests&nbsp;&nbsp;<span class="badge label-danger">{{ Auth::user()->leaveRequestCount() }}</span>
            </a>
        </li>-->
    @endif
    @if(Auth::user()->usertype == 2 || Auth::user()->usertype == 3)
    <li <?php echo \Request::url() == url('sup-view') ? 'class="active"' : ''; ?>>
        <a href="{{url('sup-view')}}">
            <em class="fa fa-clock-o">&nbsp;</em>
            Break Management 
        </a>
    </li>
    @endif
@endauth

<li>
   <a target="_blank" href="{{ url('public/img/company-hierarchy.jpeg') }}">
        <em class="fa fa-sitemap">&nbsp;</em>
        Employee Hierarchy
    </a>
</li>

@guest
<li>
    <a href="{{ route('login')}}">
        <em class="fa fa-sign-in">&nbsp;</em>
        Login
    </a>
</li>
@endguest
@auth
<li>
    <a href="{{ route('logout')}}">
        <em class="fa fa-power-off">&nbsp;</em>
        Logout
    </a>
</li>
@endauth