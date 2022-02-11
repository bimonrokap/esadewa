<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div
        id="m_ver_menu"
        class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
        m-menu-vertical="1"
        m-menu-scrollable="0" m-menu-dropdown-timeout="500"
    >

        <ul class="m-menu__nav ">

            <li class="m-menu__item  m-menu__item--submenu {{ Request::segment(2) == 'asset' ? 'm-menu__item--open' : '' }}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
                <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">
                        Data Aset
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
                            <span class="m-menu__link">
                                <span class="m-menu__link-text">
                                    Data Aset
                                </span>
                            </span>
                        </li>

                        @foreach($menus as $menu)
                            <li class="m-menu__item {{ strpos(url()->current(), @$menu['url']) !== false  ? 'm-menu__item--active' : '' }} {{ !isset($menu['route']) ? 'm-menu__item--inactive' : '' }}" aria-haspopup="true"  m-menu-link-redirect="1">
                                <a href="{{ isset($menu['route']) && !is_null($menu['route']) ? route($menu['route']) : '' }}" class="m-menu__link ajaxify">
{{--                                    <span class="m-menu__item-here"></span>--}}
                                    <i class="m-menu__link-icon {{ $menu['icon'] }}"></i>
                                    <span class="m-menu__link-text" data-title="{{ $menu['name'] }}"> {{ $menu['name'] }} </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>

            @foreach($addon as $row)
                <li class="m-menu__section m-menu__section--first">
                    <h4 class="m-menu__section-text"> {{ $row['name'] }} </h4>
                    <i class="m-menu__section-icon flaticon-more-v3"></i>
                </li>

                @if(!empty($row['all_children']))
                    @foreach($row['all_children'] as $child)
                        @php
                            $thisRoute = explode('.', $child['route']);
                            $thisRoute = array_slice($thisRoute, 0, 3);
                        @endphp
                    <li class="m-menu__item {{ $curRoute == $thisRoute ? 'm-menu__item--active' : '' }}" aria-haspopup="true"  m-menu-link-redirect="1">
                        <a href="{{ isset($child['route']) && !is_null($child['route']) ? ($child['type'] == 'external' ? asset($aboutApps->value) :  route($child['route'])) : '' }}" class="m-menu__link {{ $child['type'] == 'external' ? '' :  'ajaxify' }}">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-{{ $child['icon'] }}"></i>
                            <span class="m-menu__link-text" data-title="{{ $child['name'] }}">
                                {{ $child['name'] }}
                            </span>
                        </a>
                    </li>
                    @endforeach
                @endif
            @endforeach

        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>