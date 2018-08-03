<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    {{--<li class="header">HEADER</li>--}}
    <!-- Optionally, you can add icons to the links -->
    <li class="nav-item"><a class="nav-link active" href="{{ route('dashboard') }}"><i class="fa fa-link"></i>
            <p>Dashboard</p></a>
    @if(Auth::user()->hasRole('admin')||Auth::user()->can('user-list'))
        <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}"><i class="fa fa-link"></i> <p>Người Dùng</p></a>
        </li>
    @endif
    @if(Auth::user()->can('role-list'))
        <li  class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}"><i class="fa fa-link"></i> <p>Quyền</p></a></li>
        @endif
        </li>
        <li  class="nav-item"><a class="nav-link" href="{{ route('categorypost.index') }}"><i class="fa fa-link"></i> <p>Chuyên Mục Bài Viết</p></a>
        </li>
        <li  class="nav-item"><a class="nav-link" href="{{ route('page.index') }}"><i class="fa fa-link"></i> <p>Trang</p></a>
        </li>
        <li  class="nav-item"><a class="nav-link" href="{{ route('post.index') }}"><i class="fa fa-link"></i> <p>Bài Viết</p></a>
        </li>
        <li  class="nav-item"><a class="nav-link" href="{{ route('categoryproduct.index') }}"><i class="fa fa-link"></i>
                <p>Chuyên Mục Sản Phẩm</p></a>
        </li>
        <li  class="nav-item"><a class="nav-link" href="{{ route('product.index') }}"><i class="fa fa-link"></i> <p>Sản Phẩm</p></a>
        </li>
        <li  class="nav-item"><a class="nav-link" href="{{ route('config.index') }}"><i class="fa fa-link"></i> <p>Cấu Hình</p></a>
        </li>

        {{--<li><a href="{{ route('tuyendung.index') }}"><i class="fa fa-link"></i> <span>Tuyển Dụng</span></a>--}}
        {{--</li>--}}
        {{--<li><a href="{{ route('menu.index') }}"><i class="fa fa-link"></i> <span>Quản Lý Menu</span></a>--}}
        {{--</li>--}}
        {{--<li class="treeview">--}}
        {{--<a href="#"><i class="fa fa-link"></i><span>Cấu Hình</span>--}}
        {{--<span class="pull-right-container">--}}
        {{--<i class="fa fa-angle-left pull-right"></i>--}}
        {{--</span>--}}
        {{--</a>--}}
        {{--<ul class="treeview-menu">--}}
        {{--<li><a href="#">Cấu Hình Chung</a></li>--}}
        {{--<li><a href="{{ route('config.email.index') }}">Email</a></li>--}}
        {{--<li><a href="{{ route('config.slider.index') }}"><i class="fa fa-link"></i>--}}
        {{--<span>Quản Lý Slider</span></a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</li>--}}
</ul>