<!DOCTYPE html>
<html>

<head>
    <title>Islam Pharmacy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Make sidebar full height */
        .sidebar {
            min-height: 100vh;
        }

        /* Hide sidebar on mobile */
        @media(max-width: 768px) {
            .sidebar {
                display: none;
            }
        }

        /* Show toggle button only on mobile */
        .mobile-toggle {
            display: none;
        }

        @media(max-width: 768px) {
            .mobile-toggle {
                display: inline-block;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">

        <!-- Sidebar -->
        <div id="sidebarMenu" class="bg-dark text-white p-3 sidebar">

            <h4>Dashboard</h4>

            @auth
                <div class="p-2 text-white">
                    <strong>Logged in as:</strong> {{ auth()->user()->name }} <br>
                    <strong>Role:</strong> {{ auth()->user()->role }}
                </div>
            @endauth

            <ul class="nav flex-column mt-4">

                @auth
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="nav-link btn btn-link text-white">Logout</button>
                    </form>
                </li>

                <li class="nav-item mb-2"><a href="{{ url('/home') }}" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item mb-2"><a href="{{ route('medicines.index') }}" class="nav-link text-white">Medicines</a></li>
                <li class="nav-item mb-2"><a href="{{ route('purchases.index') }}" class="nav-link text-white">Purchases</a></li>
                <li class="nav-item mb-2"><a href="{{ route('sales.index') }}" class="nav-link text-white">Sales</a></li>
                <li class="nav-item mb-2"><a href="{{ route('stocks.index') }}" class="nav-link text-white">Stock</a></li>
                <li class="nav-item mb-2"><a href="{{ route('reports.index') }}" class="nav-link text-white">Reports</a></li>
                <li class="nav-item mb-2"><a href="{{ route('accounts.index') }}" class="nav-link text-white">Accounts</a></li>
                <li class="nav-item mb-2"><a href="{{ route('extra_income.index') }}" class="nav-link text-white">Extra Income</a></li>

                @if(auth()->user()->role == 'superadmin')
                    <li class="nav-item mb-2"><a href="{{ route('investors.index') }}" class="nav-link text-white">Investors</a></li>
                    <li class="nav-item mb-2"><a href="{{ route('investments.index') }}" class="nav-link text-white">Investments</a></li>
                    <li class="nav-item mb-2"><a href="{{ route('users.index') }}" class="nav-link text-white">Users</a></li>
                @endif

                @endauth
            </ul>
        </div>

        <!-- Mobile Toggle Button -->
        <button class="btn btn-dark mobile-toggle m-2" onclick="toggleSidebar()">☰ Menu</button>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>

    <script>
        function toggleSidebar() {
            let sidebar = document.getElementById("sidebarMenu");
            if (sidebar.style.display === "none" || sidebar.style.display === "") {
                sidebar.style.display = "block";
            } else {
                sidebar.style.display = "none";
            }
        }
    </script>

</body>

</html>
