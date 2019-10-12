<!--
   menu in side bar
   this components is for avoiding repeat HTML codes
 -->
<li class="">
   <a href="#" class="dropdown-toggle">
      <i class="menu-icon fa {{ isset($icon) ? $icon : '' }}"></i>
      <span class="menu-text"> {{ $menu_name }} </span>
      <span class="badge badge-primary">{{ isset($number) ? $menu_count["$number"] : '' }}</span>
      <span class="arrow fa fa-angle-down"></span>
   </a>
   <b class="arrow"></b>
   <ul class="submenu">
      <li class="">
         <a class="click_me" data-pjax href="{{ route($route_create) }}" data-path="{{ str_replace("","",route($route_create,[],false)) }}">
            <i class="menu-icon fa fa-caret-right"></i>
            {{ isset($subMenu) ? ucfirst($subMenu) : "Create" }}
         </a>
         <b class="arrow"></b>
      </li>
      <li class="">
         <a class="click_me" data-pjax href="{{ route($route_list) }}" data-path="{{ route($route_list,[],false) }}">
            <i class="menu-icon fa fa-caret-right"></i>
            {{ isset($secondSubMenu) ? ucfirst($secondSubMenu) : "Browse" }}
         </a>
         <b class="arrow"></b>
      </li>
   </ul>
</li>
