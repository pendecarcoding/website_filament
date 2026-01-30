<header class="header">

    <!-- header top -->
    <div class="header-top">
        <div class="container">
            <div class="header-top-wrap">
                    <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{Storage::url(setting('site_logo', 'default value'))}}">
                </a>
                <div class="header-top-left">
                    <div class="header-top-social">
                        <span>Ikuti Kami : </span>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="header-top-right">
                    <div class="header-top-contact">
                        <ul>
                            <!-- <li>
                                <a href="#"><i class="far fa-location-dot"></i> {{setting('site_address')}}</a>
                            </li> -->
                            <li>
                                <a href="mailto:{{setting('site_email')}}"><i class="far fa-envelopes"></i> {{setting('site_email')}}</a>
                            </li>
                            <li>
                                <a href="tel:{{setting("site_phone")}}"><i class="far fa-phone-volume"></i>{{setting("site_phone")}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-navigation">
        <nav class="navbar navbar-expand-lg">
            <div class="container position-relative">

                <div class="mobile-menu-right">
                    <div class="search-btn">
                        <button type="button" class="nav-right-link search-box-outer"><i
                                class="far fa-search"></i></button>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-mobile-icon"><i class="far fa-bars"></i></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="main_nav">
                    <ul class="navbar-nav">
                        @foreach(Biostate\FilamentMenuBuilder\Models\MenuItem::whereHas('menu', function($query) {
                        $query->where('name', 'WEBSITE');
                        })->whereNull('parent_id')
                        ->orderBy('_lft')
                        ->get() as $menuItem)
                        @if($menuItem->children->isEmpty())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->url() == $menuItem->link ? 'active' : '' }}"
                                href="{{ $menuItem->link }}"
                                target="{{ $menuItem->target }}">
                                {{ $menuItem->name }}
                            </a>
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->url() == $menuItem->link ? 'active' : '' }}"
                                href="{{ $menuItem->link }}"
                                data-bs-toggle="dropdown"
                                target="{{ $menuItem->target }}">
                                {{ $menuItem->name }}
                            </a>
                            <ul class="dropdown-menu fade-down">
                                @foreach($menuItem->children as $child)
                                @if($child->children->isEmpty())
                                <li>
                                    <a class="dropdown-item {{ request()->url() == $child->link ? 'active' : '' }}"
                                        href="{{ $child->link }}"
                                        target="{{ $child->target }}">
                                        {{ $child->name }}
                                    </a>
                                </li>
                                @else
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle {{ request()->url() == $child->link ? 'active' : '' }}"
                                        href="{{ $child->link }}"
                                        target="{{ $child->target }}">
                                        {{ $child->name }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach($child->children as $grandChild)
                                        <li>
                                            <a class="dropdown-item {{ request()->url() == $grandChild->link ? 'active' : '' }}"
                                                href="{{ $grandChild->link }}"
                                                target="{{ $grandChild->target }}">
                                                {{ $grandChild->name }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                    <div class="nav-right">
                        <div class="search-btn">
                            <button type="button" class="nav-right-link search-box-outer"><i
                                    class="far fa-search"></i></button>
                        </div>

                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
