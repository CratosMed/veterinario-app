<template>
    <div class="container my-5">
        <h3 class="mb-4 text-center">Futuras Actualizaciones</h3>

        <!-- Sección de Ventas -->
        <h4 class="mb-3">Ventas</h4>
        <div class="row">
            <div class="col-md-4 mb-3" v-for="(venta, index) in ventas" :key="index">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i :class="venta.icono" class="icono-card me-3"></i>
                        <div>
                            <h6 class="card-title">
                                <a href="#" class="text-decoration-none text-primary">{{ venta.nombre }}</a>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Servicios -->
        <h4 class="mb-3">Servicios</h4>
        <div class="row">
            <div class="col-md-4 mb-3" v-for="(servicio, index) in servicios" :key="index">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i :class="servicio.icono" class="icono-card me-3"></i>
                        <div>
                            <h6 class="card-title">
                                <a href="#" class="text-decoration-none text-primary">{{ servicio.nombre }}</a>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Otros -->
        <h4 class="mb-3">Otros</h4>
        <div class="row">
            <div class="col-md-4 mb-3" v-for="(otro, index) in otros" :key="index">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i :class="otro.icono" class="icono-card me-3"></i>
                        <div>
                            <h6 class="card-title">
                                <a href="#" class="text-decoration-none text-primary">{{ otro.nombre }}</a>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            ventas: [
                { nombre: 'Informe diario 2.0', icono: 'bi bi-bar-chart' },
                { nombre: 'Productos de las ventas', icono: 'bi bi-box-seam' },
                { nombre: 'Facturas electrónicas', icono: 'bi bi-receipt' },
                { nombre: 'Ventas por categoría', icono: 'bi bi-pie-chart' },
                { nombre: 'Informe diario 1.0', icono: 'bi bi-graph-up' },
                { nombre: 'Informe mensual', icono: 'bi bi-calendar' },
                { nombre: 'Productos vendidos', icono: 'bi bi-bag-check' },
                { nombre: 'Historial de productos vendidos', icono: 'bi bi-clipboard-data' },
                { nombre: 'Pagos de gastos', icono: 'bi bi-cash' },
                { nombre: 'Ingresos de estética', icono: 'bi bi-scissors' },
                { nombre: 'Ingresos de guardería', icono: 'bi bi-people' },
                { nombre: 'Ingresos de visitas', icono: 'bi bi-person-check' }
            ],
            servicios: [
                { nombre: 'Informe de asistencia', icono: 'bi bi-clipboard-check' },
                { nombre: 'Informe de vacunas', icono: 'bi bi-shield-check' },
                { nombre: 'Informe de visitas', icono: 'bi bi-file-earmark-person' },
                { nombre: 'Informe nuevos pacientes', icono: 'bi bi-person-plus' }
            ],
            otros: [
                { nombre: 'Zona de influencia', icono: 'bi bi-geo-alt' },
                { nombre: 'Control horario', icono: 'bi bi-clock' },
                { nombre: 'Informe de opiniones', icono: 'bi bi-chat-left-quote' },
                { nombre: 'Informe de calificaciones', icono: 'bi bi-star' }
            ]
        };
    }
};
</script>

<style scoped>
.icono-card {
    font-size: 24px;
    color: red;
}

.card {
    border: none;
    border-radius: 10px;
    background: #f8f9fa;
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
}
</style>