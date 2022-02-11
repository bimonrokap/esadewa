<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark "  >
    <ul class="m-menu__nav ">
        @foreach($menus as $row)
            <li class="m-menu__item m-menu__item--submenu m-menu__item--rel"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                <a  href="{{ $row['route'] == null ? 'javascript:;' : route($row['route']) }}" class="m-menu__link m-menu__toggle {{ $row['route'] == null ? '' : 'ajaxify' }}">
                    <i class="m-menu__link-icon flaticon-{{ $row['icon'] }}"></i>
                    <span class="m-menu__link-text" data-title="{{ $row['name'] }}"> {{ $canCreateBackupSimak && $row['id'] == 37 ? 'Kirim Backup SIMAK' : $row['name'] }} </span>
                    @if(!empty($row['all_children']))
                    <i class="m-menu__hor-arrow la la-angle-down"></i>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                    @endif
                </a>
                @if(!empty($row['all_children']))
                <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                    <ul class="m-menu__subnav">
                        @foreach($row['all_children'] as $child)
                            @if(!empty($child['all_children']))
                                <li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                                    <a  href="{{ $child['route'] == null ? 'javascript:;' : route($child['route']) }}" class="m-menu__link m-menu__toggle {{ $child['route'] == null ? '' : 'ajaxify' }}">
                                        <i class="m-menu__link-icon flaticon-{{ $child['icon'] }}"></i>
                                        <span class="m-menu__link-text" data-title="{{ $child['name'] }}"> {{ $child['name'] }} </span>
                                        <i class="m-menu__hor-arrow la la-angle-right"></i>
                                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                                    </a>
                                    <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
                                        <span class="m-menu__arrow "></span>
                                        <ul class="m-menu__subnav">
                                            @foreach($child['all_children'] as $subChild)
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ $subChild['route'] == null ? 'javascript:;' : route($subChild['route']) }}" class="m-menu__link {{ $subChild['route'] == null ? '' : 'ajaxify' }} ">
                                                        <span class="m-menu__link-text" data-title="{{ $subChild['name'] }}"> {{ $subChild['name'] }} </span>
                                                    </a>
                                                </li>
                                                @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @else
                                <li class="m-menu__item "  aria-haspopup="true">
                                    <a href="{{ $child['type'] == 'external' ? asset($aboutApps->value) : ($child['route'] == null ? 'javascript:;' : route($child['route'])) }}" {{ $child['type'] == 'external' ? 'target="_blank"' : '' }} class="m-menu__link {{ $child['type'] == 'external' ? '' : ($child['route'] == null ? '' : 'ajaxify') }} ">
                                        <i class="m-menu__link-icon flaticon-{{ $child['icon'] }}"></i>
                                        <span class="m-menu__link-text" data-title="{{ $child['name'] }}"> {{ $child['name'] }} </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endif
            </li>
            @endforeach
    </ul>
</div>