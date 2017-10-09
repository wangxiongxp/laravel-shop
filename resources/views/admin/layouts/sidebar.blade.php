<div class="page-sidebar navbar-collapse collapse">

<?php
    $menus = session('menus');
    $route = Route::current();
    $routeUri = '/'.$route->uri();

    if(count($menus)>0){
        foreach ($menus as &$menu) {
            $menu['active'] = false;
            if($menu['url'] == $routeUri) {
                $menu['active'] = true;
            }
            if($menu['hasChild']) {
                foreach ($menu['children'] as &$submenu) {
                    $submenu['active'] = false;
                    if($submenu['url'] == $routeUri) {
                        $submenu['active'] = true;
                        $menu['active'] = true;
                    }
                }
                unset($submenu);
            }
        }
        unset($menu);
    }

?>

    <!-- BEGIN SIDEBAR MENU -->
    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
        <li class="sidebar-toggler-wrapper hide">
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <div class="sidebar-toggler"> </div>
            <!-- END SIDEBAR TOGGLER BUTTON -->
        </li>
        <li class="sidebar-search-wrapper">
            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
            <form class="sidebar-search  " action="#" method="POST">
                <a href="javascript:;" class="remove">
                    <i class="icon-close"></i>
                </a>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <a href="javascript:;" class="btn submit">
                            <i class="icon-magnifier"></i>
                        </a>
                    </span>
                </div>
            </form>
            <!-- END RESPONSIVE QUICK SEARCH FORM -->
        </li>

        @if(count($menus)>0)
        @foreach ($menus as $menu)
            <li{!! $menu['active'] ? ' class="nav-item active"':' class="nav-item"' !!}>
                <a class="nav-link nav-toggle" href="{{ $menu['url'] }}">
                    <i class="{{ $menu['icon_class'] }}"></i>
                    <span class="title">{{ $menu['title'] }}</span>
                    @if ($menu['active'])
                        <span class="selected"></span>
                    @endif
                    @if ($menu['hasChild'])
                        <span class="arrow{!! $menu['active'] ? ' open':'' !!}"></span>
                    @endif
                </a>
                @if ($menu['hasChild'])
                    <ul class="sub-menu">
                        @foreach ($menu['children'] as $submenu)
                            <li{!! $submenu['active'] ? ' class="nav-item active"':' class="nav-item"' !!}>
                                <a class="nav-link nav-toggle" href="{{ $submenu['url'] }}">
                                    <span class="title">{{ $submenu['title'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
        @endif
    </ul>
    <!-- END SIDEBAR MENU -->
</div>