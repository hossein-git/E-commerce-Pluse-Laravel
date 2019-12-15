<div id="sidebar" class="sidebar responsive ace-save-state">
   <script type="text/javascript">
       try {
           ace.settings.loadState('sidebar')
       } catch (e) {
       }
   </script>

   <div class="sidebar-shortcuts" id="sidebar-shortcuts">
      <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
         <button class="btn btn-success">
            <i class="ace-icon fa fa-signal"></i>
         </button>

         <button class="btn btn-info">
            <i class="ace-icon fa fa-pencil"></i>
         </button>

         <button class="btn btn-warning">
            <i class="ace-icon fa fa-users"></i>
         </button>

         <button class="btn btn-danger">
            <i class="ace-icon fa fa-cogs"></i>
         </button>
      </div>

      <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
         <span class="btn btn-success"></span>

         <span class="btn btn-info"></span>

         <span class="btn btn-warning"></span>

         <span class="btn btn-danger"></span>
      </div>
   </div>
   <!-- /.sidebar-shortcuts -->

   <ul class="nav nav-list">
      <li class="">
         <a class="click_me" data-path="/admin/dashboard" href="{{ route('admin.dashboard') }}">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Dashboard </span>
         </a>

         <b class="arrow"></b>
      </li>

      @include('layout.admin._menu',
         ['menu_name' => 'Orders', 'number' => 'orders' ,'icon' => 'fa-pencil-square-o',
         'subMenu' => 'Not Sent Orders','secondSubMenu' => 'All Orders',
         'route_create' => 'order.not_sent' ,'route_list' => 'order.index'])

      @include('layout.admin._menu',
      ['menu_name' => 'Payments', 'number' => 'payments' ,'icon' => 'fa-credit-card',
      'subMenu' => 'Failed Payment','secondSubMenu' => 'All Payment',
      'route_create' => 'admin.dashboard' ,'route_list' => 'w'])

      @include('layout.admin._menu',
      ['menu_name' => 'Comments', 'number' => 'comments' ,'icon' => 'fa-comment',
      'subMenu' => 'All reviews','secondSubMenu' => 'New Reviews',
      'route_create' => 'comments.index' ,'route_list' => 'comments.new'])

      @include('layout.admin._menu',
     ['menu_name' => 'Users', 'numbe0r' => '' ,'icon' => 'fa-user',
     'subMenu' => 'All Users','secondSubMenu' => 'Add User',
     'route_create' => 'user.index' ,'route_list' => 'user.create'])

      <li class="">
         <a disabled="">
            <i class="menu-icon fa fa-shopping-basket"></i>
            <span class="menu-text"> E-commerce </span>
         </a>
      </li>

      @include('layout.admin._menu',
      ['menu_name' => 'Products', 'number' => 'products' ,'icon' => 'fa-globe', 'route_create' => 'product.create' ,'route_list' => 'product.index'])

      @include('layout.admin._menu',
        ['menu_name' => 'Attributes', 'number0' => '' ,'icon' => 'fa-globe',
        'subMenu' => 'Create New','secondSubMenu' => 'Attach to product',
        'route_create' => 'attribute.create' ])

      @include('layout.admin._menu',
      ['menu_name' => 'Categories','icon' => 'fa-list', 'number' => 'categories_count' , 'route_create' => 'category.create' ,'route_list' => 'category.index'])

      @include('layout.admin._menu',
      ['menu_name' => 'Brands', 'number' => 'brands' , 'icon' => 'fa-lemon-o', 'route_create' => 'brand.create' ,'route_list' => 'brand.index'])

      @include('layout.admin._menu',
      ['menu_name' => 'Gift cards', 'number' => 'gift_cards', 'icon' => 'fa-gift', 'route_create' => 'giftCard.create' ,'route_list' => 'giftCard.index'])


   </ul>
   <!-- /.nav-list -->

   <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
      <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state"
         data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
   </div>
</div>


