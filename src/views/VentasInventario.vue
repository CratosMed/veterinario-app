<template>
    <div>
        <CintilloForm />
        <hr />
        <br />
        <div class="contenedor-botones">
            <button class="btn btn-dark me-2">Transacciones</button>
            <button class="btn btn-outline-dark">Cierres de caja</button>
        </div>
        <br />

        <!-- Navegación superior -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Opciones de filtro -->
            <div class="d-flex align-items-center">
                <i class="bi bi-sliders"></i> Filtrar
                <select class="form-select me-2" style="width: auto">
                    <option value="semanal">Semanal</option>
                    <option value="mensual">Mensual</option>
                    <option value="anual">Anual</option>
                </select>
                <div class="input-group">
                    <input type="date" class="form-control" />
                    <span class="mx-2"> - </span>
                    <input type="date" class="form-control" />
                </div>
            </div>

            <!-- Búsqueda y reporte -->
            <div class="d-flex align-items-center ms-auto">
                <input type="text" class="form-control me-3" placeholder="Buscar concepto..." />
            </div>
            <a href="ruta/del/reporte.pdf" download><i class="bi bi-download"></i>Reporte</a>
        </div>

        <!-- Tarjetas resumen -->
        <div class="row text-center mb-4">
            <div class="col-12 col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body carAncho">
                        <i class="bi bi-graph-up text-success fs-3"></i>
                        <h5 class="card-title">Ganancias</h5>
                        <p class="card-text">${{ balance }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body carAncho">
                        <i class="bi bi-currency-dollar text-primary fs-3"></i>
                        <h5 class="card-title">Ventas totales</h5>
                        <p class="card-text">${{ totalVentas }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body carAncho">
                        <i class="bi bi-cash-coin text-danger fs-3"></i>
                        <h5 class="card-title">Gastos totales</h5>
                        <p class="card-text">${{ totalGastos }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs e icono principal -->
        <div class="text-center">
            <ul class="nav nav-tabs justify-content-center border-0">
                <li class="nav-item ancho">
                    <a class="nav-link " :class="{ active: activeTab === 'ingresos' }" href="#"
                        @click.prevent="activeTab = 'ingresos'">Ingresos</a>
                </li>
                <li class="nav-item ancho">
                    <a class="nav-link  " :class="{ active: activeTab === 'egresos' }" href="#"
                        @click.prevent="activeTab = 'egresos'">Egresos</a>
                </li>
                <li class="nav-item ancho">
                    <a class="nav-link" :class="{ active: activeTab === 'porCobrar' }" href="#"
                        @click.prevent="activeTab = 'porCobrar'">Por cobrar</a>
                </li>
                <li class="nav-item ancho">
                    <a class="nav-link" :class="{ active: activeTab === 'porPagar' }" href="#"
                        @click.prevent="activeTab = 'porPagar'">Por pagar</a>
                </li>
            </ul>

            <!-- Listado de registros -->
            <div class="my-4">
                <table class="table table-bordered" v-if="activeData.length > 0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Concepto</th>
                            <th>Valor</th>
                            <th>Medio de Pago</th>
                            <th>Fecha y Hora</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in activeData" :key="item.id">
                            <td>{{ item.id }}</td>
                            <td>{{ item.concepto }}</td>
                            <td>${{ item.valor }}</td>
                            <td>{{ item.medioPago }}</td>
                            <td>{{ item.fechaHora }}</td>
                            <td>{{ item.estado }}</td>
                        </tr>
                    </tbody>
                </table>

                <div v-else>
                    <i class="bi bi-card fs-1 text-muted"></i>
                    <p class="text-muted">
                        Aún no tienes registros en esta sección.<br />
                        Empieza agregando uno con las acciones correspondientes.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CintilloForm from "../components/CintilloForm.vue";

export default {
    name: "VentasInventario",
    components: {
        CintilloForm,
    },
    data() {
        return {
            balance: 1500,
            totalVentas: 3000,
            totalGastos: 1500,
            activeTab: "ingresos",
            ingresos: [
                { id: 1, concepto: "2 jabones, 1 champú", valor: 120, medioPago: "Tarjeta", fechaHora: "16/dic/2024 5:00 PM", estado: "Pagada" },
                { id: 2, concepto: "3 aceites", valor: 90, medioPago: "Efectivo", fechaHora: "17/dic/2024 10:30 AM", estado: "Pagada" },
                { id: 3, concepto: "1 pasta, 2 cepillos", valor: 45, medioPago: "Transferencia", fechaHora: "18/dic/2024 2:15 PM", estado: "Pagada" },
            ],
            egresos: [
                { id: 1, concepto: "Compra de mercancía", valor: 200, medioPago: "Transferencia", fechaHora: "15/dic/2024 9:00 AM", estado: "Pagado" },
                { id: 2, concepto: "Alquiler del local", valor: 500, medioPago: "Tarjeta", fechaHora: "16/dic/2024 8:00 PM", estado: "Pagado" },
                { id: 3, concepto: "Servicios públicos", valor: 100, medioPago: "Efectivo", fechaHora: "18/dic/2024 3:00 PM", estado: "Pagado" },
            ],
            porCobrar: [
                { id: 1, concepto: "Venta a crédito", valor: 300, medioPago: "Crédito", fechaHora: "15/dic/2024 5:30 PM", estado: "Pendiente" },
                { id: 2, concepto: "Pedido especial", valor: 180, medioPago: "Crédito", fechaHora: "19/dic/2024 3:00 PM", estado: "Pendiente" },
                { id: 3, concepto: "Venta de productos", valor: 60, medioPago: "Efectivo", fechaHora: "17/dic/2024 1:00 PM", estado: "Pendiente" },
            ],
            porPagar: [
                { id: 1, concepto: "Compra de inventario", valor: 250, medioPago: "Transferencia", fechaHora: "20/dic/2024 4:00 PM", estado: "Pendiente" },
                { id: 2, concepto: "Reparación de equipo", valor: 80, medioPago: "Efectivo", fechaHora: "22/dic/2024 11:30 AM", estado: "Pendiente" },
                { id: 3, concepto: "Material de limpieza", valor: 35, medioPago: "Tarjeta", fechaHora: "21/dic/2024 9:00 AM", estado: "Pendiente" },
            ],
        };
    },
    computed: {
        activeData() {
            return this[this.activeTab];
        },
    },
};
</script>

<style scoped>
.nav-tabs .nav-link {
    color: #6c757d;
}

.nav-tabs .nav-link.active {
    color: #000;
    font-weight: bold;
    border-color: #000;
}

.card-title {
    font-size: 1.2rem;
}

.card-text {
    font-size: 1rem;
    color: #000;
}

.btn-dark {
    background-color: #000;
    border-color: #000;
    width: 49%;
}

.btn-outline-dark {
    color: #000;
    border-color: #000;
    width: 50%;
}

/* Diseño responsivo para tablas */
.table {
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .carAncho {
        text-align: center;
    }
}

.ancho {
    width: 22%;
}
</style>
