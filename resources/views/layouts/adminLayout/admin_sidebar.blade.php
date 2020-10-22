<?php $url = url()->current(); ?>
<!--sidebar-menu-->
<div id="sidebar"><a href="{{ url('/admin/dashboard') }}" class="visible-phone"><i class="icon icon-home"></i>
    Dashboard</a>
  <ul>
    <li <?php if (preg_match("/dashboard/i", $url )) { ?> class="active" <?php }  ?>><a
        href="{{ url('/admin/dashboard') }}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>

    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Catégories</span> <span
          class="label label-important">2</span></a>
      <ul @if (preg_match("/categor/i", $url)) style="display: block;" class="active" @endif>
        <li @if (preg_match("/add-category/i", $url)) class="active" @endif><a
            href="{{ url('/admin/add-category') }}">Ajouter une catégorie</a></li>
        <li @if (preg_match("/view-categories/i", $url)) class="active" @endif><a
            href="{{ url('/admin/view-categories') }}">Voir les catégories</a></li>
      </ul>
    </li>

    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Produits</span> <span
          class="label label-important">2</span></a>
      <ul @if (preg_match("/product/i", $url)) style="display: block;" class="active" @endif>
        <li @if (preg_match("/add-product/i", $url)) class="active" @endif><a
            href="{{ url('/admin/add-product') }}">Ajouter un produit</a></li>
        <li @if (preg_match("/view-products/i", $url)) class="active" @endif><a
            href="{{ url('/admin/view-products') }}">Voir les produits</a></li>
      </ul>
    </li>

    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Coupons</span> <span
          class="label label-important">2</span></a>
      <ul @if (preg_match("/coupon/i", $url)) style="display: block;" class="active" @endif>
        <li @if (preg_match("/add-coupon/i", $url)) class="active" @endif><a
            href="{{ url('/admin/add-coupon') }}">Ajouter un coupon</a></li>
        <li @if (preg_match("/view-coupons/i", $url)) class="active" @endif><a
            href="{{ url('/admin/view-coupons') }}">Voir les coupons</a></li>
      </ul>
    </li>

    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Commandes</span> <span
          class="label label-important">1</span></a>
      <ul @if (preg_match("/orders/i", $url)) style="display: block;" class="active" @endif>
        <li @if (preg_match("/view-orders/i", $url)) class="active" @endif><a
            href="{{ url('/admin/view-orders') }}">Voir les Commandes</a></li>
      </ul>
    </li>

    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Bannières</span> <span
          class="label label-important">2</span></a>
      <ul @if (preg_match("/banner/i", $url)) style="display: block;" class="active" @endif>
        <li @if (preg_match("/add-banner/i", $url)) class="active" @endif><a
            href="{{ url('/admin/add-banner') }}">Ajouter une bannière</a></li>
        <li @if (preg_match("/view-banners/i", $url)) class="active" @endif><a
            href="{{ url('/admin/view-banners') }}">Voir les bannières</a></li>
      </ul>
    </li>

    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Utilisateurs</span> <span
          class="label label-important">1</span></a>
      <ul @if (preg_match("/users/i", $url)) style="display: block;" class="active" @endif>
        <li @if (preg_match("/view-users/i", $url)) class="active" @endif><a href="{{ url('/admin/view-users') }}">Voir
            les utilisateurs</a></li>
      </ul>
    </li>

    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>CMS Pages</span> <span
          class="label label-important">2</span></a>
      <ul @if (preg_match("/cms-page/i", $url)) style="display: block;" class="active" @endif>
        <li @if (preg_match("/add-cms-page/i", $url)) class="active" @endif><a
            href="{{ url('/admin/add-cms-page') }}">Ajouter CMS Page</a></li>
        <li @if (preg_match("/view-cms-pages/i", $url)) class="active" @endif><a
            href="{{ url('/admin/view-cms-pages') }}">Voir CMS Page</a></li>
      </ul>
    </li>
    {{-- <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Demandes</span> <span class="label label-important">1</span></a>
      <ul <?php if (preg_match("/enquiries/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/view-enquiries/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-enquiries')}}">Voir les demandes</a></li>
      </ul>
    </li> --}}
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Livraisons</span> <span class="label label-important">1</span></a>
      <ul <?php if (preg_match("/shipping/i", $url)){ ?> style="display: block;" <?php } ?>>
        <li <?php if (preg_match("/view-shipping/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-shipping')}}">Voir les Frais de port</a></li>
      </ul>
    </li>
  </ul>
</div>
<!--sidebar-menu-->