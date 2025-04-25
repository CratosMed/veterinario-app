<template>
    <div class="container mt-4">
        <!-- Título -->
        <h1 class="text-center mb-4">Estadísticas de Ventas</h1>

        <!-- Grid de tarjetas -->
        <div class="row">
            <!-- Comparativa de Períodos -->
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Comparativa de Períodos</h5>
                        <p class="card-text">Este Mes: <strong>$25,000</strong></p>
                        <p class="card-text">Mes Anterior: <strong>$22,000</strong></p>
                        <p class="text-success">+13.6% de incremento</p>
                    </div>
                </div>
            </div>

            <!-- Productos Más Vendidos -->
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Productos Más Vendidos</h5>
                        <ul class="list-unstyled">
                            <li>Producto A: <strong>120 unidades</strong></li>
                            <li>Producto B: <strong>85 unidades</strong></li>
                            <li>Producto C: <strong>50 unidades</strong></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tendencia de Ventas -->
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Tendencia de Ventas</h5>
                        <p class="card-text">Última Semana: <strong>$7,500</strong></p>
                        <p class="card-text">Promedio Diario: <strong>$1,070</strong></p>
                        <p class="text-primary">Ventas estables</p>
                    </div>
                </div>
            </div>

            <!-- Gastos en Proveedores al Mes -->
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Gastos en Proveedores</h5>
                        <p class="card-text">Total del Mes: <strong>$12,000</strong></p>
                        <p class="card-text">Última Factura: <strong>$3,000</strong></p>
                        <p class="text-danger">Controla los gastos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "estadisticas",
};
</script>

<style>
.card {
    border-radius: 1rem;
}

.card-title {
    font-size: 1.2rem;
    font-weight: bold;
}

.card-text {
    font-size: 1rem;
}
</style>