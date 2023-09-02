<header class="header web-header" id="header">
  <!-- Topbar -->
  @php
    $settings = DB::table('settings')->first();
    $categories = Helper::categories();
    $carts = Helper::cartItems();
  @endphp 
  <div class="topbar" id="mob-header">
    <div class="header-content">
      <button id="menu-btn" class="btn header-icon" onclick="showMenu()"><i class="fa-solid fa-bars icon" id="bars-icon"></i></button>                                       

      <div class="header-logo-title">
        <a href="{{route('home')}}" class="header-logo website-logo">
          <img src="{{$settings->logo}}" alt="logo">
        </a>

        <h1 class="header-title website-title">HerbalCare</h1>
      </div>

      <button id="mob-cart-btn" class="btn header-icon items-menu-btn">
        <a href="{{route('cart')}}">
          <i class="fa-solid fa-cart-shopping" id="cart-icon"></i>
          <div class="items-count"><span class="cart-count">{{ count($carts) }}</span></div>
        </a>
      </button>
    </div>

    <div class="search-bar" id= "search">
      <form method="post" action="{{route('product.search')}}" id="search-form" class="search-form">
        @csrf
        <input type="search" name="product_search" class="form-controller search-term" placeholder="Search Products..." autocomplete="off">                                                                
        <button type="submit" class="btn search-btn" value="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
      <button id="mob-fav-btn" class="btn fav-btn header-icon">
        <a href="{{ route('wishlists.index') }}">
        <i class="fa-solid fa-heart" id="fav-icon"></i>
        <div class="items-count"><span class="fav-qty">{{Helper::favCount()}}</span></div></a>
      </button>
    </div>      
  </div>
  
  <nav class="nav" id="mob-nav">
    <button type="button" class="btn close" id="close-btn" onclick="closeMenu()"><i class="fa-solid fa-xmark"></i></button>                  
    <div class="navbar-content">
      <ul class="menu">
        <li><a href="{{route('home')}}" class="nav-link mob-nav">Home</a></li>
        <li><a href="{{route('about.us')}}" class="nav-link mob-nav">About</a></li>
        <li id="shop">
          <a onclick="menu()" class="nav-link mob-nav dropdown-toggle">Shop</a>
          <i id="shop-dropdown-icon" class="bx bxs-down-arrow"></i>
          <ul class="collapse cat-menu" id="mob-cat-menu">
            @foreach ($categories as $cat)
              @php
                $subcat = $cat->subcats()->get();
              @endphp

              @if ($subcat->count() > 0)
                <li class="submenu-dropdown">
                  <a href="{{ route('cat.products', $cat->slug) }}" class="dropdown-item"> {{ $cat->name }}</a>

                  <ul class="cat-submenu">
                    @foreach ($subcat as $sub_menu)
                    <li>
                      <a href="{{ route('subcat.products', [$cat->slug, $sub_menu->slug]) }}" class="dropdown-item"> {{ $sub_menu->name }}</a>
                    </li>
                    @endforeach
                  </ul>
                </li>
              @else
                <li>
                  <a href="{{route('cat.products', $cat->slug)}}" class="dropdown-item"> {{$cat->name}} </a>
                </li>
              @endif
            @endforeach
          </ul>
        </li>
        <li><a href="{{route('contact')}}" class="nav-link mob-nav">Contact</a></li>
      </ul>
      <hr>
    
      <ul class="list-main">
        <li><i class="fa-solid fa-clipboard"></i></i><a class="user-nav" href="{{route('orders')}}">Order Details</a></li>
        @auth 
          @if(Auth::user()->type=='admin')
            <li><i class="fa-solid fa-user-tie"></i><a class="user-nav" href="{{route('admin')}}"  target="_blank">@if(Auth::user()->fname){{Auth::user()->fname}} {{Auth::user()->lname}}@else{{Auth::user()->cname}}@endif</a></li>
          @else 
            <li><i class="fa-solid fa-user"></i><a class="user-nav" href="javascript:void(0);">@if(Auth::user()->fname) {{Auth::user()->fname}} {{Auth::user()->lname}}@else{{Auth::user()->cname}}@endif</a></li>
          @endif
            <li><i class="fa-solid fa-right-from-bracket"></i><a class="user-nav" href="{{ route('logout.user') }}">Logout</a></li>
        @else
          <li><i class="fa-solid fa-right-to-bracket"></i><a class="user-nav" href="{{route('login.view')}}">Login</a></li>
          <li><i class="fa-solid fa-user-plus"></i><a class="user-nav" href="{{route('register.view')}}">Register</a></li>
        @endauth
      </ul>    
    </div>
  </nav>
  
  <div class="topbar" id="desktop-header">
    <div class="header-content">
      <div id="header-logo" class="header-logo">                   
        <a href="{{ route('home') }}"><img src="{{ $settings->logo }}" alt="logo" width="50" height="50"></a>
      </div>

      <div class="header-title-div">
        <h1 class="header-title">HerbalCare</h1>
      </div>
      
      <div class="user-menu">
        <i class="fa-solid fa-user"></i>
      </div>

      <div class="list-main-container collapse">
        <ul id="desktop-user-menu" class="list-main">
          <li><i class="fa-solid fa-clipboard"></i></i><a class="user-nav" href="{{route('orders')}}">Order Details</a></li>
          @auth
            @if(Auth::user()->type=='admin')
              <li><i class="fa-solid fa-user-tie d-user-icon"></i><a class="user-nav" href="{{ route('admin') }}"  target="_blank">@if (Auth::user()->fname) {{ Auth::user()->fname }} {{ Auth::user()->lname }} @else {{ Auth::user()->cname }} @endif</a></li>
            @else 
              <li><i class="fa-solid fa-user d-user-icon"></i><a class="user-nav" href="javascript:void(0);">@if (Auth::user()->fname) {{ Auth::user()->fname }} {{ Auth::user()->lname }} @else {{ Auth::user()->cname }} @endif</a></li>
            @endif
              <li><i class="fa-solid fa-right-from-bracket d-user-icon"></i><a class="user-nav" href="{{ route('logout.user') }}">Logout</a></li>
          @else
            <li><i class="fa-solid fa-right-to-bracket d-user-icon"></i><a class="user-nav" href="{{route('login.view')}}">Login</a></li>
            <li><i class="fa-solid fa-user-plus d-user-icon"></i><a class="user-nav" href="{{ route('register.view') }}">Register</a></li>
          @endauth
        </ul>
      </div>
    </div>
    
    <nav class="menu-bar" id="desktop-menu">
      <ul class="menu">
        <li><a href="{{route('home')}}" class="nav-link desktop-nav">Home</a></li>
        <li><a href="{{route('about.us')}}" class="nav-link desktop-nav">About</a></li>
        <li id = "shop">
          <a href="{{route('products')}}" class="nav-link desktop-nav dropdown-toggle">Shop</a>
          <div class="collapse shop-menu">
            <ul class="cat-menu" id="desktop-cat-menu">
              @foreach ($categories as $cat)

              @php
                $subcat = $cat->subcats()->get();
              @endphp

              @if ($subcat->count() > 0)
                <li class="submenu-dropdown">
                  <a href="{{ route('cat.products', $cat->slug) }}" class="dropdown-item"> {{ $cat->name }} </a>
              
                  <div class="collapse submenu">
                    <ul class="cat-submenu">
                      @foreach ($subcat as $sub_menu)
                        <li>
                          <a href="{{ route('subcat.products', [$cat->slug, $sub_menu->slug]) }}" class="dropdown-item"> {{ $sub_menu->name }}</a>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </li>
              @else
                <li>
                  <a href="{{ route('cat.products', $cat->slug) }}" class="dropdown-item"> {{ $cat->name }} </a>
                </li>
              @endif
              @endforeach
            </ul>
          </div>
        </li>
        <li><a href="{{ route('contact') }}" class="nav-link desktop-nav">Contact</a></li>
      </ul>

      <div class="search-bar">                                        
        <form method="post" action="{{ route('product.search') }}" class="search-form">
          @csrf
          <input type="search" name="search" class="form-controller search-term" placeholder="Search Products..." autocomplete="off">                                                                
          <button type="submit" class="btn search-btn" value="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
      </div>

      <button class="btn header-icon items-menu-btn">
        <a href="{{ route('wishlists.index') }}" class="header-icon">
        <i class="fa-solid fa-heart" id="fav-icon"></i>
        <div class="items-count"><span class="fav-qty" style="position: relative;top: 0.14em;">{{ Helper::favCount() }}</span></div></a>
      </button> 

      <div class="btn header-icon items-menu-btn">
        <button id="desktop-cart-btn" class="btn header-icon items-menu-btn">
          <a href="{{ route('cart') }}" class="header-icon">
            <i class="fa-solid fa-cart-shopping" id="cart-icon"></i>
            <div class="items-count"><span class="cart-count" style="position: relative;top: 0.14em;">{{ count($carts) }}</span></div>
          </a>
        </button>
        <div class="collapse shopping-item">
          <div class="dropdown-cart-header">
            <span class="cart-count-header">{{ count($carts) }} Items</span>
            <a href="{{ route('cart') }}">View Cart</a>
          </div>

          <ul class="shopping-list">
            @foreach( $carts as $cart )
              <li>
                <div class="product-det">
                  <h4><a class="prod-name" href="{{route('product.detail', $cart->attr->product->slug)}}" target="_blank"> {{ $cart->attr->product->name }} </a></h4>
                  <p class="font">@if ($cart->attr->form_id) {{ $cart->attr->form->name }} - @endif {{ $cart->attr->size }} {{ $cart->attr->unit }}</p>
                  <p class="font">{{ $cart->quantity }} x {{ number_format($cart->attr->price,2) }} AED</p>

                  <form action="{{ route('cart-items.destroy', $cart->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="remove font" title="Remove">Remove Item</button>
                  </form>

                </div>
                <a class="cart-img" href="#"><img src="{{ $cart->attr->product->photo }}" alt="product photo"></a>
              </li>
            @endforeach
          </ul>

          <div class="bottom">
            <div class="total">
                <span>Total = </span>
                <span class="total-amount">AED {{number_format(Helper::cartTotal(),2)}}</span>
            </div>
            <div class="btn anim-checkout-btn">
              <a href="{{route('checkout')}}">Checkout</a>
              <div class="hover"></div>
            </div>
          </div>              
        </div>
      </div> 
    </nav>
  </div> 
</header>
