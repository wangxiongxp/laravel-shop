<ul class="nav navbar-nav pull-right">
    <!-- BEGIN NOTIFICATION DROPDOWN
    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <i class="icon-bell"></i>
            <span class="badge badge-default"> 7 </span>
        </a>
        <ul class="dropdown-menu">
            <li class="external">
                <h3>
                    <span class="bold">12 pending</span> notifications
                </h3>
                <a href="page_user_profile_1.html">view all</a>
            </li>
            <li>
                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                    <li>
                        <a href="javascript:;">
                            <span class="time">just now</span>
                            <span class="details">
                                <span class="label label-sm label-icon label-success">
                                    <i class="fa fa-plus"></i>
                                </span> New user registered.
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <!-- END NOTIFICATION DROPDOWN -->

    <!-- BEGIN INBOX DROPDOWN
    <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <i class="icon-envelope-open"></i>
            <span class="badge badge-default"> 4 </span>
        </a>
        <ul class="dropdown-menu">
            <li class="external">
                <h3>You have
                    <span class="bold">7 New</span> Messages</h3>
                <a href="app_inbox.html">view all</a>
            </li>
            <li>
                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                    <li>
                        <a href="#">
                            <span class="photo">
                                <img src="/assets/layouts/layout/img/avatar3.jpg" class="img-circle" alt="">
                            </span>
                            <span class="subject">
                                <span class="from"> Richard Doe </span>
                                <span class="time">46 mins </span>
                            </span>
                            <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <!-- END INBOX DROPDOWN -->

    <!-- BEGIN TODO DROPDOWN
    <li class="dropdown dropdown-extended dropdown-tasks" id="header_task_bar">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <i class="icon-calendar"></i>
            <span class="badge badge-default"> 3 </span>
        </a>
        <ul class="dropdown-menu extended tasks">
            <li class="external">
                <h3>You have
                    <span class="bold">12 pending</span> tasks</h3>
                <a href="app_todo.html">view all</a>
            </li>
            <li>
                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                    <li>
                        <a href="javascript:;">
                            <span class="task">
                                <span class="desc">New UI release</span>
                                <span class="percent">38%</span>
                            </span>
                            <span class="progress progress-striped">
                                <span style="width: 38%;" class="progress-bar progress-bar-important" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">
                                    <span class="sr-only">38% Complete</span>
                                </span>
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <!-- END TODO DROPDOWN -->

    <!-- BEGIN USER LOGIN DROPDOWN -->
    <?php $userInfo = Auth::user(); $roles = session('roles'); $curRole = session('curRole');?>
    <li class="dropdown dropdown-user">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <img alt="" style="width:30px;height:30px;" class="img-circle" src="{{ $userInfo->account_image or '/assets/layouts/layout/img/avatar3_small.jpg' }}" />
            <span class="username username-hide-on-mobile">
                [{{ $curRole->s_role_name }}] {{ $userInfo->account_name }}
            </span>
            <i class="fa fa-angle-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-default">
            <li class="divider"> </li>
            @foreach ($roles as $role)
                <li>
                    <a href="javascript:;" data-toggle="role" data-role-id="{{ $role->s_role_id }}" data-active-role-id="{{ $curRole->s_role_id }}">
                        @if ($role->s_role_id == $curRole->s_role_id)
                            <i class="fa fa-check-circle"></i>
                        @else
                            <i class="fa fa-circle-thin"></i>
                        @endif
                        <span class="title">{{ $role->s_role_name }}</span>
                    </a>
                </li>
            @endforeach
            <li class="divider"> </li>
            <li>
                <a href="/admin/profile">
                    <i class="icon-user"></i> 个人信息 </a>
            </li>
            <li>
                <a href="/admin/logout">
                    <i class="icon-key"></i> 安全退出</a>
            </li>
        </ul>
    </li>
    <!-- END USER LOGIN DROPDOWN -->
    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
    <li class="dropdown dropdown-quick-sidebar-toggler">
        <a href="javascript:;" class="dropdown-toggle">
            <i class="icon-logout"></i>
        </a>
    </li>
    <!-- END QUICK SIDEBAR TOGGLER -->
</ul>