@extends('layouts.admin')

@section('content')
    <div class="container py-5">
        <h4>Panel de Administración</h4>
        <p>Bienvenido, {{ auth()->user()->name }}.</p>
    </div>
    <!-- Tarjetas de pedidos -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="{{ route('admin.orders.status', 'recibida') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 bg-light h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-1 text-muted">Pedidos Recibidos</h6>
                            <h3 class="fw-bold mb-0">{{ \App\Models\Order::where('status', 'Recibida')->count() }}</h3>
                        </div>
                        <div class="text-primary fs-1">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!--grafico de pedidos-->
    <div class="container mb-4">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Desde</label>
                <input type="date" name="start_date" class="form-control" value="{{ $start }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Hasta</label>
                <input type="date" name="end_date" class="form-control" value="{{ $end }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa fa-chart-pie me-1"></i> Actualizar gráfico
                </button>
            </div>
        </form>
    </div>
    <div class="container">
        <canvas id="ordersChart" height="120"></canvas>
    </div>

 

    <!-- Gráfico dashboard de ordenes por estatus -->

@endsection
@section('scripts')
<script>
    const ctx = document.getElementById('ordersChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Pedidos por estatus',
                data: {!! json_encode($data) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Pedidos por estatus del {{ \Carbon\Carbon::parse($start)->format("d/m/Y") }} al {{ \Carbon\Carbon::parse($end)->format("d/m/Y") }}'
                }
            },
            onClick: (e, elements) => {
                if (elements.length > 0) {
                    const index = elements[0].index;
                    const status = {!! json_encode($statusKeys) !!}[index];
                    window.location.href = `/admin/orders/status/${status}`;
                }
            }
        }
    });
</script>


@endsection
