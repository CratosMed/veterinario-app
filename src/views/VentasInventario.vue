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
            <!-- Botones principales -->


            <!-- Opciones de filtro -->
            <div class="d-flex align-items-center">
                <i class="bi bi-sliders"></i> Filtrars
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
            <div class="col-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body carAncho">
                        <i class="bi bi-graph-up text-success fs-3"></i>
                        <h5 class="card-title">Balance</h5>
                        <p class="card-text">$0</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body carAncho">
                        <i class="bi bi-currency-dollar text-primary fs-3"></i>
                        <h5 class="card-title">Ventas totales</h5>
                        <p class="card-text">$0</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body carAncho">
                        <i class="bi bi-cash-coin text-danger fs-3"></i>
                        <h5 class="card-title">Gastos totales</h5>
                        <p class="card-text">$0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs e icono principal -->
        <div class="text-center">
            <ul class="nav nav-tabs justify-content-center border-0">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Ingresos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Egresos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Por cobrar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Por pagar</a>
                </li>
            </ul>

            <div class="my-4">
                <i class="bi bi-card fs-1 text-muted"></i>
                <p class="text-muted">
                    Aún no tienes registros creados en esta fecha.<br />
                    Empieza agregando uno con las acciones de <strong>Nueva venta</strong>
                    y <strong>Nuevo gasto</strong>.
                </p>
            </div>
        </div>
    </div>
</template>


<script>
import CintilloForm from '../components/cintilloForm.vue';

export default {
    name: "DashboardView",

    components: {
        CintilloForm
    }

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
    width: 100%;
}

.btn-outline-dark {
    color: #000;
    border-color: #000;
    width: 100%;
}

.contenedor-botones {
    display: flex;
    justify-content: center;
    /* Centra el contenedor */
    width: 100%;
    /* Ocupa la mitad de la pantalla */
    margin: 0 auto;
    /* Centra horizontalmente */
}

.contenedor-botones button {
    margin-right: 8px;
    /* Espacio entre botones */
}

.contenedor-botones button:last-child {
    margin-right: 0;
    /* Quita margen del último botón */
}

.carAncho {
    height: 100px;
    padding: 0px;

}
</style>
