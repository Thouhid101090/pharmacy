<!DOCTYPE html>
<html>

<head>
    <title>Islam Pharmacy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->

        <div class="bg-dark text-white p-3" style="width: 220px;">

            <h4>Dashboard</h4>
            <ul class="nav flex-column mt-4">

                @auth
                <div class="p-2 text-white">
                    <strong>Logged in as:</strong> {{ auth()->user()->name }} <br>
                    <strong>Role:</strong> {{ auth()->user()->role }}
                </div>

                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="nav-link btn btn-link text-white" style="cursor: pointer;">Logout</button>
                    </form>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ url('/home') }}" class="nav-link text-white">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('medicines.index') }}" class="nav-link text-white">Medicines</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('purchases.index') }}" class="nav-link text-white">Purchases</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('sales.index') }}" class="nav-link text-white">Sales</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('stocks.index') }}" class="nav-link text-white">Stock</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('reports.index') }}" class="nav-link text-white">Reports</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('accounts.index') }}" class="nav-link text-white">Accounts</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('extra_income.index') }}" class="nav-link text-white">Extra Income</a>
                </li>



            @endauth

                @auth
                    @if (auth()->user()->role === 'superadmin')
                        <li class="nav-item mb-2">
                            <a href="{{ route('investors.index') }}" class="nav-link text-white">Investors</a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="{{ route('investments.index') }}" class="nav-link text-white">Investments</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('users.index') }}" class="nav-link text-white">Users</a>
                        </li>

                    @endif
                @endauth


                <!-- Add more menu items here later -->
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>
</body>



</html>
