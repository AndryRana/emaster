<!--Header-part-->
<div id="header">
    <h1><a href="{{ url('/admin/dashboard') }}">Emaster Admin</a></h1>
  </div>
  <!--close-Header-part--> 
  
  
  <!--top-Header-menu-->
  <div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav">
      <li class=""><a title="" href="#"> Bienvenue <span class="text uppercase">{{ Session::get('adminDetails')['username'] }} ({{ Session::get('adminDetails')['type'] }})</span></a></li>
      <li class=""><a title="" href="{{ url('/admin/settings') }}"><i class="icon icon-cog"></i> <span class="text">Paramètres du compte</span></a></li>
      <li class=""><a title="" href="{{ url('/logout') }}"><i class="icon icon-share-alt"></i> <span class="text"> Se déconnecter</span></a></li>
    </ul>
  </div>
  <!--close-top-Header-menu-->
  <!--start-top-serch-->
  <div id="search" class="flex items-center">
    <input type="text" placeholder="Rechercher ..." />
    <button type="submit" class="tip-bottom " title="Search"><i class="icon-search icon-white"></i></button>
  </div>
  <!--close-top-serch-->