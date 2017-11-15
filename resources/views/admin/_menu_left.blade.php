<div class="leftpanel">
    <div class="leftpanelinner">
        <div class="tab-content">
            <div class="tab-pane active" id="mainmenu">
                <ul class="nav nav-pills nav-stacked nav-quirk">
                    <li class="nav-parent active"><a href="#"><i class="fa fa-user"></i> <span>User and Authorization</span></a>
                        <ul class="children">
                            <li class="active"><a
                                        href="{{route('admin.user.list')}}">List User</a></li>
                            <li class="active"><a
                                        href="{{route('admin.user.add')}}">Add User</a></li>
                            <li class="active">
                                <a href="{{route('admin.role.index')}}">{{trans('Role')}}</a>
                            </li>
                            <li class="active">
                                <a href="{{route('admin.permission.index')}}">{{trans('Permission')}}</a>
                            </li>
                            <li class="active">
                                <a href="{{route('admin.add-permission-for-role',['role_id' => 1])}}">{{trans('Add Permission For Role')}}</a>
                            </li>
                        </ul>
                    </li>
                    {{--<li class="nav-parent active">
                        <a href="#"><i class="fa fa-sitemap"></i> <span>Role And Permission</span></a>
                        <ul class="children">
                            <li class="active">
                                <a href="{{route('admin.role.index')}}">{{trans('Role')}}</a>
                            </li>
                            <li class="active">
                                <a href="{{route('admin.permission.index')}}">{{trans('Permission')}}</a>
                            </li>
                            <li class="active">
                                <a href="{{route('admin.add-permission-for-role',['role_id' => 1])}}">{{trans('Add Permission For Role')}}</a>
                            </li>
                        </ul>
                    </li>--}}
                    <li class="nav-parent active">
                        <a href="#"><i class="fa fa-sitemap"></i> <span>Courses</span></a>
                        <ul class="children">
                            <li class="active">
                                <a href="{{route('admin.course.list')}}">{{trans('List')}}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div><!-- tab-pane -->
        </div><!-- tab-content -->

    </div><!-- leftpanelinner -->
</div><!-- leftpanel -->