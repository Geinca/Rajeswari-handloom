<!-- sidebar.php -->
<aside class="w-64 bg-gradient-to-b from-red-900 to-red-700 text-white min-h-screen shadow-xl flex flex-col p-6">
    <!-- Logo Section -->
    <div class="flex items-center gap-3 mb-10">
        <div class="bg-white p-2 rounded-full">
            <i class="fas fa-sun text-red-800 text-xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold">Rajeswari</h1>
            <p class="text-xs text-red-100">Admin Panel</p>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex flex-col gap-2 text-sm font-medium text-red-100">
        <span class="text-xs uppercase tracking-wider mb-1 text-red-200">Main</span>

        <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-150">
            <i class="fas fa-chart-pie text-white"></i>
            Dashboard
        </a>

        <a href="orders.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-150">
            <i class="fas fa-box-open text-white"></i>
            Orders
        </a>

        <a href="products.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-150">
            <i class="fas fa-tags text-white"></i>
            Products
        </a>

        <a href="customers.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-150">
            <i class="fas fa-users text-white"></i>
            Customers
        </a>

        <!-- Add section divider -->
        <span class="text-xs uppercase tracking-wider mt-6 mb-1 text-red-200">Settings</span>

        <a href="logout.php" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-600 bg-red-800 transition-all duration-150 text-white">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
    </nav>
</aside>
