<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column js-activeable" data-widget="treeview" role="menu"
        data-accordion="false">
        <li class="nav-item">
            <a href="{{route('admin.home')}}" class="nav-link">
                <i class="nav-icon far fa-solid fa-clipboard"></i>

                <p>
                    Статистика
                    <span class="right badge badge-success">
                        {{ \App\Models\User::count() }}
                    </span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('users.index')}}" class="nav-link">
                <i class="nav-icon far fa-solid fa-user"></i>

                <p>
                    Користувачі
                    <span class="right badge badge-success">
                        {{ \App\Models\User::count() }}
                    </span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link">
                <i class="nav-icon fas fa-bars"></i>

                <p>
                    Категорії
                    <span class="right badge badge-success">
                        {{ \App\Models\Category::count() }}
                    </span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('attributes.index') }}" class="nav-link">
                <i class="nav-icon fas fa-arrow-right ml-4"></i>

                <p>
                    Атрибути
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('brands.index') }}" class="nav-link">
                <i class="nav-icon fas fa-star"></i>

                <p>
                    Бренди
                    <span class="right badge badge-success">
                        {{ \App\Models\Brand::count() }}
                    </span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('products.index') }}" class="nav-link">
                <i class="nav-icon fas fa-truck"></i>

                <p>
                    Товари
                    <span class="right badge badge-success">
                        {{ \App\Models\Product::count() }}
                    </span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('orders.index') }}" class="nav-link">
                <i class="nav-icon fas fa-shopping-cart"></i>


                <p>
                    Замовлення
                    <span class="right badge badge-success">
                        {{ \App\Models\Order::count() }}
                    </span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('news.index')}}" class="nav-link">
                <i class="nav-icon fas fa-newspaper"></i>

                <p>
                    Новини
                    <span class="right badge badge-success">
                        {{ \App\Models\Article::count() }}
                    </span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('static.index')}}" class="nav-link">
                <i class="nav-icon fas fa-thumbtack"></i>

                <p>
                    Статичні сторінки
                    <span class="right badge badge-success">
                        {{ \App\Models\StaticPage::count() }}
                    </span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('leads.index')}}" class="nav-link">
                <i class="nav-icon fas fa-envelope"></i>

                <p>
                    Розсилка
                    <span class="right badge badge-success">
                        {{ \App\Models\Lead::count() }}
                    </span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('notifications.index') }}" class="nav-link">
                <i class="nav-icon fas fa-arrow-right ml-4"></i>

                <p>
                    Заплановано
                </p>
            </a>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
