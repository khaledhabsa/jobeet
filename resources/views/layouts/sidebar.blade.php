<aside id="minileftbar" class="minileftbar">
    <ul class="menu_list">
        <li>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href=""><img src="{{asset('assets/images/logo.png')}}" alt="Alpino"></a>
        </li>
        <li><a href="javascript:void(0);" class="menu-sm"><i class="zmdi zmdi-swap"></i></a></li>
{{--        <li class="notifications badgebit">--}}
{{--            <a href="javascript:void(0);">--}}
{{--                <i class="zmdi zmdi-notifications"></i>--}}
{{--                <div class="notify">--}}
{{--                    <span class="heartbit"></span>--}}
{{--                    <span class="point"></span>--}}
{{--                </div>--}}
{{--            </a>--}}
{{--        </li>--}}
        <li><a href="javascript:void(0);" class="fullscreen" data-provide="fullscreen"><i class="zmdi zmdi-fullscreen"></i></a></li>
        <li class="power">
            <a href="{{route('logout')}}" class="mega-menu"><i class="zmdi zmdi-power"></i></a>
        </li>
    </ul>
</aside>

<aside class="right_menu">
    <div id="leftsidebar" class="sidebar">
        <div class="menu">
            <ul class="list">
                <li>
                    <div class="user-info m-b-20">
                        <div class="image">
                            <a href="">
                                <a href="{{route('admins.profile.edit')}}">
                                    @if(auth()->user()->profile_image)
                                        <img src="{{getImageUrl(auth()->user()->profile_image)}}" alt="{{auth()->user()->name}}">
                                    @else
                                        <img src="{{asset('assets/images/profile_av.jpg')}}" alt="User">
                                    @endif
                                </a>
                            </a>
                        </div>
                        <div class="detail">
                            <h6>{{auth()->user()->name}}</h6>
                        </div>
                    </div>
                </li>
{{--                <li> <a href="{{url('/dashboard')}}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>--}}
                @can('roles.show')
                    <li><a href="{{route('roles.index')}}"><i class="zmdi zmdi-lock"></i><span>Roles</span></a></li>
                @endcan
                @can('admins.show')
                    <li><a href="{{route('admins.index')}}"><i class="zmdi zmdi-accounts"></i><span>Admins</span></a></li>
                @endcan
            </ul>
        </div>
    </div>
</aside>
