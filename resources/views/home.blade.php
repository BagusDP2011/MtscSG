<html>

<!-- 
        <div class="container">
            <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
 -->
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<style>
    .hero-section {
        background: linear-gradient(135deg, #0f172a, #1e3a8a, #2563eb);
        min-height: 500px;
        color: white;
        border-radius: 0 0 30px 30px;
    }

    .hero-image {
        max-width: 100%;
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0);
        }
    }

    .feature-card {
        transition: all .3s ease;
        border-radius: 20px;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, .15) !important;
    }

    .stats-card {
        border-radius: 20px;
        transition: .3s;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .quick-card {
        transition: .3s;
        border-radius: 20px;
    }

    .quick-card:hover {
        transform: scale(1.03);
        background: #f8fafc;
    }

    .section-title {
        font-weight: 700;
        margin-bottom: 40px;
    }

    .icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        font-size: 32px;
    }
</style>

<body>
    <!-- HERO -->

    <section class="hero-section d-flex align-items-center">
        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-7">

                    <h1 class="display-3 fw-bold">
                        MTSC Inventory Management System
                    </h1>

                    <p class="lead mt-4">
                        A centralized platform to manage spare parts inventory,
                        monitor stock availability, track transactions,
                        and improve operational efficiency.
                    </p>

                    <div class="mt-4">
                        <a href="/"
                            class="btn btn-light btn-lg rounded-pill px-4">
                            Get Started
                        </a>
                    </div>

                </div>

                <div class="col-lg-5 text-center">
                    <img src="{{ asset('assets/img/mtsc-logo-rem.png') }}"
                        class="hero-image"
                        alt="Inventory">
                </div>

            </div>

        </div>

    </section>

    <!-- STATS -->

    <section class="container" style="margin-top:-50px;">

        <div class="row g-4">

            <div class="col-md-3">
                <div class="card shadow border-0 stats-card">
                    <div class="card-body text-center p-4">
                        <h2 class="fw-bold text-primary">1,250</h2>
                        <p class="mb-0">Total Inventory</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow border-0 stats-card">
                    <div class="card-body text-center p-4">
                        <h2 class="fw-bold text-danger">158</h2>
                        <p class="mb-0">Low Stock Items</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow border-0 stats-card">
                    <div class="card-body text-center p-4">
                        <h2 class="fw-bold text-success">32</h2>
                        <p class="mb-0">Categories</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow border-0 stats-card">
                    <div class="card-body text-center p-4">
                        <h2 class="fw-bold text-warning">99%</h2>
                        <p class="mb-0">Inventory Accuracy</p>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <!-- ABOUT -->

    <section class="container py-5">

        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body p-5">

                <h2 class="section-title text-center">
                    About MTSC Inventory
                </h2>

                <p class="text-center fs-5">
                    MTSC Inventory Management System is designed to streamline
                    spare parts management, stock monitoring, transaction tracking,
                    and reporting activities. The platform enables users to maintain
                    inventory accuracy while improving productivity and operational visibility.
                </p>

            </div>
        </div>

    </section>

    <!-- FEATURES -->

    <section class="container py-5">

        <h2 class="text-center section-title">
            Key Features
        </h2>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card feature-card border-0 shadow h-100">
                    <div class="card-body text-center p-4">

                        <div class="icon-circle bg-primary text-white">
                            <i class="bi bi-box-seam"></i>
                        </div>

                        <h4 class="mt-4">
                            Inventory Tracking
                        </h4>

                        <p>
                            Real-time monitoring of stock quantities and movements.
                        </p>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card border-0 shadow h-100">
                    <div class="card-body text-center p-4">

                        <div class="icon-circle bg-success text-white">
                            <i class="bi bi-search"></i>
                        </div>

                        <h4 class="mt-4">
                            Quick Search
                        </h4>

                        <p>
                            Find parts instantly using part number or description.
                        </p>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card border-0 shadow h-100">
                    <div class="card-body text-center p-4">

                        <div class="icon-circle bg-danger text-white">
                            <i class="bi bi-bar-chart"></i>
                        </div>

                        <h4 class="mt-4">
                            Reporting
                        </h4>

                        <p>
                            Generate inventory reports and transaction summaries.
                        </p>

                    </div>
                </div>
            </div>

        </div>

    </section>

    <!-- QUICK ACCESS

    <section class="container pb-5">

        <h2 class="text-center section-title">
            Quick Access
        </h2>

        <div class="row g-4">

            <div class="col-md-3">
                <a href="/inventory/list"
                    class="text-decoration-none text-dark">
                    <div class="card quick-card shadow border-0 h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-list-ul fs-1 text-primary"></i>
                            <h5 class="mt-3">
                                Inventory List
                            </h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="/inventory/add"
                    class="text-decoration-none text-dark">
                    <div class="card quick-card shadow border-0 h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-plus-circle fs-1 text-success"></i>
                            <h5 class="mt-3">
                                Add Item
                            </h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="/inventory/stockin"
                    class="text-decoration-none text-dark">
                    <div class="card quick-card shadow border-0 h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-arrow-down-circle fs-1 text-primary"></i>
                            <h5 class="mt-3">
                                Stock In
                            </h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="/inventory/stockout"
                    class="text-decoration-none text-dark">
                    <div class="card quick-card shadow border-0 h-100">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-arrow-up-circle fs-1 text-danger"></i>
                            <h5 class="mt-3">
                                Stock Out
                            </h5>
                        </div>
                    </div>
                </a>
            </div>

        </div> -->

    <!-- SYSTEM MODULES -->
    <section class="container py-5">

        <h2 class="text-center section-title">
            System Modules
        </h2>

        <div class="row g-4">

            <div class="col-md-3">
                <div class="card feature-card border-0 shadow h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam fs-1 text-primary"></i>
                        <h5 class="mt-3">Inventory Master</h5>
                        <p>Manage spare part information and stock records.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card feature-card border-0 shadow h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-down-circle fs-1 text-success"></i>
                        <h5 class="mt-3">Stock In</h5>
                        <p>Record incoming spare parts and inventory updates.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card feature-card border-0 shadow h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-up-circle fs-1 text-danger"></i>
                        <h5 class="mt-3">Stock Out</h5>
                        <p>Track spare parts usage and item withdrawals.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card feature-card border-0 shadow h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-file-earmark-bar-graph fs-1 text-warning"></i>
                        <h5 class="mt-3">Reports</h5>
                        <p>Generate inventory and transaction reports.</p>
                    </div>
                </div>
            </div>

        </div>

    </section>

    </section>
</body>

<!-- FOOTER -->

<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">

        <h5 class="fw-bold">
            MTSC Inventory Management System
        </h5>

        <p class="mb-0">
            Developed for efficient spare parts inventory control and operational excellence.
        </p>

    </div>

</footer>

</html>