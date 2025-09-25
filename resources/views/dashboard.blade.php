@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Dashboard</h2>
	 <p class="mb-4">
        <span class="badge bg-info text-dark">
            You are logged in as: {{ ucfirst(Auth::user()->role) }}
        </span>
    </p>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary mb-3 shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Categories</h5>
                    <p class="card-text fs-3">{{ $totalCategories }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-success mb-3 shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text fs-3">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Products -->
    <h4>Latest Products</h4>
    <table class="table table-bordered table-striped shadow">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($latestProducts as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->stock }}</td>
                <td>₱{{ number_format($product->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Top Selling Products Chart -->
    <h4 class="mt-5">Top Selling Products (This Month)</h4>
    <canvas id="topProductsChart" height="100"></canvas>

    <!-- Products per Category Chart -->
    <h4 class="mt-5">Products per Category</h4>
    <canvas id="categoryChart" height="100"></canvas>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Top Selling Products Chart
        const ctxTop = document.getElementById('topProductsChart');
        new Chart(ctxTop, {
            type: 'bar',
            data: {
                labels: @json($topSelling->pluck('product.name')),
                datasets: [{
                    label: 'Units Sold',
                    data: @json($topSelling->pluck('total_quantity')),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Top 5 Products Sold (This Month)'
                    }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Products per Category Pie Chart
        const ctxCat = document.getElementById('categoryChart');
        new Chart(ctxCat, {
            type: 'pie',
            data: {
                labels: @json($categories->pluck('name')),
                datasets: [{
                    label: 'Products Count',
                    data: @json($categories->pluck('products_count')),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Products Distribution per Category'
                    }
                }
            }
        });
    </script>
@endsection
