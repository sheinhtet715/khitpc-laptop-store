@extends('admin.layouts.master')

@section('page-title', 'Sales Report')
@section('page-subtitle', 'Annual Financial Overview')

@section('content')

<style>

    .admin-card {
        background-color: #ffffff;
        border: 1px solid rgba(30, 58, 95, 0.06);
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(30, 58, 95, 0.02);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
   .admin-input:focus {
    border-color: #FFBF00;
    box-shadow: 0 0 0 3px rgba(255, 191, 0, 0.15);
	}
	
	.btn-admin-primary {
	    background-color: #1E3A5F;
	    color: white;
	    transition: all 0.2s ease;
	}
	
	.btn-admin-primary:hover {
	    background-color: #FFBF00;
	    color: #1E3A5F;
	}


    .admin-table th {
        background-color: #1E3A5F !important;
        color: #ffffff !important;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-size: 0.75rem;
        border-bottom: none;
    }
    .admin-table td {
        vertical-align: middle;
        color: #1F2937;
        font-weight: 500;
        font-size: 0.9rem;
        border-bottom: 1px solid rgba(30, 58, 95, 0.05);
    }

    .kpi-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /*  PDF  */
    @media print {
	
	     body {
	    -webkit-print-color-adjust: exact;
	    print-color-adjust: exact;
	}
	
	.navbar, 
	.sidebar, 
	.btn, 
	form, 
	footer, 
	.topbar {
	    display: none !important;
	}
	
	body, 
	#wrapper #content-wrapper, 
	#main-content-wrapper {
	    background-color: #fff !important;
	    width: 100%;
	    margin: 0;
	    padding: 0 !important;
	}
	
	.container-fluid {
	    padding: 0;
	    width: 100%;
	}
	
	.admin-card {
	    border: 1px solid #ddd !important;
	    box-shadow: none !important;
	    margin-bottom: 15px;
	    page-break-inside: avoid;
	}
	
	.row {
	    display: flex !important;
	    flex-wrap: wrap !important;
	}
	
	.col-md-6 {
	    width: 50% !important;
	    flex: 0 0 50% !important;
	    max-width: 50% !important;
	}
	
	.col-lg-7 {
	    width: 58.33333% !important;
	    flex: 0 0 58.33333% !important;
	    max-width: 58.33333% !important;
	}
	
	.col-lg-5 {
	    width: 41.66667% !important;
	    flex: 0 0 41.66667% !important;
	    max-width: 41.66667% !important;
	}
	
	canvas {
	    max-width: 100% !important;
	    height: auto !important;
	}
	
	.print-header {
	    display: block !important;
	    text-align: center;
	    margin-bottom: 20px;
	    padding-bottom: 10px;
	    border-bottom: 2px solid #1E3A5F;
	}
	
	.print-header h2 {
	    font-weight: bold;
	    color: #1E3A5F;
	    margin-bottom: 5px;
	}
	
	.print-header p {
	    color: #6c757d;
	    font-size: 0.9rem;
	}
	
	.print-header {
	    display: none;
	}
</style>

<div class="py-3 container-fluid">

    <div class="print-header">
        <h2>Khit PC - Annual Sales Report</h2>
        <p>Generated on {{ date('F j, Y') }} | Reporting Year: {{ $year }}</p>
    </div>

    <div class="gap-3 mb-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <h4 class="mb-0 fw-bold text-navy text-uppercase d-none d-md-block" style="letter-spacing: 0.5px;">Report Overview</h4>

        <div class="gap-2 d-flex">
            <form method="GET" action="{{ route('admin#salesReport') }}" class="d-flex align-items-center">
                <select name="year" class="shadow-sm form-select form-select-sm admin-input fw-bold text-navy me-2" onchange="this.form.submit()" style="cursor: pointer;">
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>Fiscal Year: {{ $y }}</option>
                    @endforeach
                </select>
            </form>

            <button onclick="window.print()" class="px-3 shadow-sm btn btn-sm btn-admin-primary fw-bold text-nowrap">
                <i class="fas fa-file-pdf me-1 text-gold"></i> Save PDF / Print
            </button>
        </div>
    </div>

    <div class="mb-3 row g-3">

        <div class="col-6 col-md-6">
            <div class="p-3 border-4 admin-card h-100 border-start" style="border-left-color: #10b981 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="mb-1 text-xs fw-bold text-success text-uppercase" style="letter-spacing: 0.5px;">Total Revenue ({{ $year }})</div>
                        <div class="mb-0 text-dark fs-4 fw-bolder">K{{ number_format($totalRevenue) }}</div>
                    </div>
                    <div class="kpi-icon-box" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-6">
            <div class="p-3 border-4 admin-card h-100 border-start" style="border-left-color: #1E3A5F !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="mb-1 text-xs fw-bold text-navy text-uppercase" style="letter-spacing: 0.5px;">Total Orders ({{ $year }})</div>
                        <div class="mb-0 text-dark fs-4 fw-bolder">{{ number_format($totalOrders) }} <span class="fs-6 text-muted fw-medium">Orders</span></div>
                    </div>
                    <div class="kpi-icon-box" style="background: rgba(30, 58, 95, 0.1); color: #1E3A5F;">
                        <i class="fas fa-shopping-bag text-gold"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3">

        <div class="col-12 col-lg-7">
            <div class="admin-card h-100 d-flex flex-column">
                <div class="p-3 border-bottom bg-light rounded-top-3">
                    <h6 class="m-0 fw-bold text-navy text-uppercase small" style="letter-spacing: 0.5px;">
                        <i class="fa-solid fa-chart-line me-2 text-gold"></i> Monthly Earnings ({{ $year }})
                    </h6>
                </div>
                <div class="p-3 card-body flex-grow-1">
                    <div class="chart-area" style="height: 280px; width: 100%;">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="admin-card h-100 d-flex flex-column">
                <div class="p-3 border-bottom bg-light rounded-top-3">
                    <h6 class="m-0 fw-bold text-navy text-uppercase small" style="letter-spacing: 0.5px;">
                        <i class="fa-solid fa-trophy me-2 text-gold"></i> Top 5 Products
                    </h6>
                </div>
                <div class="p-0 card-body flex-grow-1">
                    <div class="table-responsive h-100">
                        <table class="table mb-0 align-middle admin-table table-hover h-100">
                            <thead>
                                <tr>
                                    <th class="px-3 py-2">Product Name</th>
                                    <th class="px-3 py-2 text-center">Qty Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $product)
                                <tr>
                                    <td class="px-3 py-2 fw-bold text-dark text-truncate" style="max-width: 180px;" title="{{ $product->product_name }}">
                                        {{ $product->product_name }}
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="px-2 py-1 text-white shadow-sm rounded-2 fw-bold" style="background-color: #1E3A5F; font-size: 0.75rem;">
                                            {{ $product->total_sold }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="py-4 text-center text-muted small">
                                        <i class="mb-2 opacity-25 fa-solid fa-chart-pie fs-4 d-block"></i>
                                        No sales data found for this year.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
  
        Chart.defaults.font.family = 'Inter, -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif';
        Chart.defaults.color = '#6c757d';


        var chartData = @json($chartData);

        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Revenue (K)",
                    lineTension: 0.35, 
                    backgroundColor: "rgba(30, 58, 95, 0.08)", 
                    borderColor: "#1E3A5F", 
                    pointRadius: 4,
                    pointBackgroundColor: "#FFBF00", 
                    pointBorderColor: "#ffffff", 
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: "#1E3A5F", 
                    pointHoverBorderColor: "#FFBF00", 
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: chartData,
                    fill: true,
                }],
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { maxTicksLimit: 12, font: { size: 11, weight: 500 } }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            maxTicksLimit: 6,
                            padding: 10,
                            font: { size: 11, weight: 500 },
                            callback: function(value) {
                                return 'K' + value.toLocaleString();
                            }
                        },
                        grid: {
                            color: "rgba(30, 58, 95, 0.06)",
                            drawBorder: false,
                            borderDash: [5, 5]
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: "#1E3A5F", 
                        titleColor: '#FFBF00', 
                        bodyColor: '#ffffff',
                        titleMarginBottom: 6,
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 13, weight: 'bold' },
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'K' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });
</script>

@endsection
