<!-- Left sidebar -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">@lang('cruds.menu_top.menu')</li>
                <!-- Branches -->
                @can('statistics.show')

                <li class="{{ Request::is('statistics*') ? 'mm-active' : '' }}">
                    <a href="{{ route('statistics.show') }}"
                        class=" waves-effect {{ Request::is('statistics*') ? 'mm-active' : '' }}">
                        <i class="bx bx-home-circle"></i>

                        <span>@lang('global.dashboard')</span>
                    </a>
                </li>
                @endcan

                @can('apz.show')
                    <li class="{{ Request::is('clients*') || Request::is('apz-second') || Request::is('client/confirm') ? 'mm-active' : '' }}">
                        <a href="javascript: void(0);"
                            class="has-arrow waves-effect {{ Request::is('clients*') || Request::is('apz-second') || Request::is('client/confirm') ? 'mm-active' : '' }}">
                            <i class="bx bx-file"></i>

                            <span>@lang('cruds.branches.title')</span>
                        </a>
                        <ul class="sub-menu {{ Request::is('clients*') || Request::is('apz-second') || Request::is('client/confirm') ? ' ' : 'd-none' }}"
                            aria-expanded="false">
                            
                            <li class="{{ Request::is('clients*') ? 'mm-active' : '' }}">
                                <a href="{{ route('clientIndex') }}"
                                    class=" waves-effect {{ Request::is('clients*') ? 'mm-active' : '' }}">
                                    <i class="bx bx-map-alt"></i>
                                    <span>@lang('cruds.branches.title')</span>
                                </a>
                            </li>
        
                            <li class="{{ Request::is('apz-second*') ? 'mm-active' : '' }}">
                                <a href="{{ route('apz.second') }}"
                                    class=" waves-effect {{ Request::is('apz-second*') ? 'mm-active' : '' }}">
                                    <i class="bx bx-map-alt"></i>
                                    <span>@lang('cruds.branches.title') 2</span>
                                </a>
                            </li>
        
                            <li class="{{ Request::is('client/confirm') ? 'mm-active' : '' }}">
                                <a href="{{ route('clientFormConfirm') }}"
                                    class=" waves-effect {{ Request::is('client/confirm') ? 'mm-active' : '' }}">
                                    <i class="bx bx-map-alt"></i>
                                    <span>@lang('cruds.branches.title') Mobile</span>
                                </a>
                            </li>


                        </ul>
                    </li>
                @endcan

                
                @can('history.show')
                    <li class="{{ Request::is('history') || Request::is('request-confirm') ? 'mm-active' : '' }}">
                        <a href="javascript: void(0);"
                            class="has-arrow waves-effect {{ Request::is('history') || Request::is('request-confirm') ? 'mm-active' : '' }}">
                            <i class="bx bx-file"></i>

                            <span>@lang('cruds.history.title')</span>
                        </a>
                        <ul class="sub-menu {{ Request::is('history') || Request::is('request-confirm') ? ' ' : 'd-none' }}"
                            aria-expanded="false">
                            
                            <li class="{{ Request::is('history*') ? 'mm-active' : '' }}">
                                <a href="{{ route('history.index') }}"
                                    class=" waves-effect {{ Request::is('history*') ? 'mm-active' : '' }}">
                                    <i class="bx bx-info-circle"></i>
                                    <span>@lang('cruds.history.title')</span>
                                </a>
                            </li>
        
                            <li class="{{ Request::is('request-confirm*') ? 'mm-active' : '' }}">
                                <a href="{{ route('request.confirm') }}"
                                    class=" waves-effect {{ Request::is('request-confirm*') ? 'mm-active' : '' }}">
                                    <i class="bx bx-info-circle"></i>
                                    <span>@lang('cruds.history.title') 103</span>
                                </a>
                            </li>


                        </ul>
                    </li>
                @endcan

                @can('transaction.show')
                    <li class="{{ Request::is('import*') || Request::is('transactions*') ? 'mm-active' : '' }}">
                        <a href="javascript: void(0);"
                            class="has-arrow waves-effect {{ Request::is('import*') || Request::is('transactions*') ? 'mm-active' : '' }}">
                            <i class="bx bx-file"></i>

                            <span>@lang('cruds.transaction.title')</span>
                        </a>
                        <ul class="sub-menu {{ Request::is('import*') || Request::is('transactions*') ? ' ' : 'd-none' }}"
                            aria-expanded="false">
                            @can('import.show')
                                <li>
                                    <a href="{{ route('import') }}" class="{{ Request::is('import*') ? 'mm-active' : '' }}">
                                        <i class="bx bx-import" style="font-size: 14px; min-width: auto;"></i>

                                        @lang('global.app_import_data')
                                    </a>
                                </li>
                            @endcan

                            @can('import.show')
                                <li>
                                    <a href="{{ route('transactions.index') }}"
                                        class="{{ Request::is('transactions.index*') ? 'mm-active' : '' }}">
                                        <i class="bx bxs-bar-chart-square" style="font-size: 14px; min-width: auto;"></i>
                                        @lang('cruds.transaction.fields.all')
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('transactions.art') }}"
                                        class="{{ Request::is('transactions.art*') ? 'mm-active' : '' }}">
                                        <i class="bx bxs-bar-chart-square" style="font-size: 14px; min-width: auto;"></i>
                                        @lang('cruds.transaction.fields.apz')
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('transactions.ads') }}"
                                        class="{{ Request::is('transactions.ads*') ? 'mm-active' : '' }}">
                                        <i class="bx bxs-bar-chart-square" style="font-size: 14px; min-width: auto;"></i>
                                        @lang('cruds.transaction.fields.ads')
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('transactions.payers') }}"
                                        class="{{ Request::is('transactions.payers*') ? 'mm-active' : '' }}">
                                        <i class="bx bxs-bar-chart-square" style="font-size: 14px; min-width: auto;"></i>
                                        @lang('cruds.transaction.fields.payers')
                                    </a>
                                </li>
                            @endcan


                        </ul>
                    </li>
                @endcan

                @can('user.show')
                    <li
                        class="{{ Request::is('permission*') || Request::is('role*') || Request::is('user*') ? 'mm-active' : '' }}">
                        <a href="javascript: void(0);"
                            class="has-arrow waves-effect {{ Request::is('permission*') || Request::is('role*') || Request::is('user*') ? 'mm-active' : '' }}">
                            <i class="fas fa-users-cog"></i>
                            <span>@lang('cruds.userManagement.title')</span>
                        </a>
                        <ul class="sub-menu {{ Request::is('permission*') || Request::is('role*') || Request::is('user*') ? ' ' : 'd-none' }}"
                            aria-expanded="false">
                            @can('permission.show')
                                <li>
                                    <a href="{{ route('permissionIndex') }}"
                                        class="{{ Request::is('permission*') ? 'mm-active' : '' }}">
                                        <i class="bx bxs-key" style="font-size: 14px; min-width: auto;"></i>
                                        @lang('cruds.permission.title_singular')
                                    </a>
                                </li>
                            @endcan
                            @can('roles.show')
                                <li>
                                    <a href="{{ route('roleIndex') }}" class="{{ Request::is('role*') ? 'mm-active' : '' }}">

                                        <i class="bx bxs-lock-alt" style="font-size: 14px; min-width: auto;"></i>
                                        @lang('cruds.role.fields.roles')
                                    </a>
                                </li>
                            @endcan
                            @can('user.show')
                                <li>
                                    <a href="{{ route('userIndex') }}" class="{{ Request::is('user*') ? 'mm-active' : '' }}">
                                        <!-- <i class="fas fa-user-friends"></i> -->
                                        <i class="bx bxs-user-plus" style="font-size: 14px; min-width: auto;"></i>
                                        @lang('cruds.user.title')
                                    </a>
                                </li>
                            @endcan

                            {{-- @can('user.show')
                                <li>
                                    <a href="{{ route('clientIndex') }}" class="{{ Request::is('client*') ? 'mm-active':'' }}">
                                        <!-- <i class="fas fa-user-friends"></i> -->
                                        <i class="bx bxs-user-plus" style="font-size: 14px; min-width: auto;"></i>
                                        @lang('cruds.client.title')
                                    </a>
                                </li>
                            @endcan --}}
                        </ul>
                    </li>
                @endcan

                
                @can('backup.show')
                    <li class="{{ Request::is('backup*') ? 'mm-active' : '' }}">
                        <a href="{{ route('backup.index') }}"
                            class=" waves-effect {{ Request::is('backup*') ? 'mm-active' : '' }}">
                            <i class="bx bx-data"></i>
                            <span>@lang('cruds.backup.title')</span>
                        </a>
                    </li>
                @endcan

                @can('qurilish.show')
                    <li class="{{ Request::is('construction*') ? 'mm-active' : '' }}">
                        <a href="{{ route('construction.index') }}"
                            class=" waves-effect {{ Request::is('backup*') ? 'mm-active' : '' }}">
                            <i class="bx bxs-building-house"></i>
                            <span>@lang('cruds.construction.title')</span>
                        </a>
                    </li>
                @endcan

                <li class="{{ Request::is('chat*') ? 'mm-active' : '' }}">
                    <a href="{{ route('chat.index') }}"
                        class=" waves-effect {{ Request::is('chat*') ? 'mm-active' : '' }}">
                        <i class="bx bx-chat"></i>
                        <span>Chat</span>
                        {{-- <span class="badge rounded-pill bg-danger float-end">10</span> --}}
                    </a>
                </li>

              

              
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
