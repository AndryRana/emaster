<!--sidebar-menu-->
<div id="sidebar"><a href="{{ url('/admin/dashboard') }}" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li class="active"><a href="{{ url('/admin/dashboard') }}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Catégories</span> <span
          class="label label-important">2</span></a>
      <ul>
        <li><a href="{{ url('/admin/add-category') }}">Ajouter une catégorie</a></li>
        <li><a href="{{ url('/admin/view-categories') }}">Voir les catégories</a></li>
      </ul>
    </li>
    
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Produits</span> <span
          class="label label-important">2</span></a>
      <ul>
        <li><a href="{{ url('/admin/add-product') }}">Ajouter un produit</a></li>
        <li><a href="{{ url('/admin/view-products') }}">Voir les produits</a></li>
      </ul>
    </li>
  </ul>
</div>
<!--sidebar-menu-->