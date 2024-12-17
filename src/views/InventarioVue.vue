<template>
    <div>
        <CintilloForm />
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Inventario</h3>
            <div>
                <button class="btn btn-outline-dark me-2">Categorías</button>
                <button class="btn btn-dark">Agregar productos <i class="bi bi-caret-down-fill"></i></button>
            </div>
        </div>

        <div class="input-group mb-4">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control border-start-0" placeholder="Buscar producto...">
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-archive fs-1 text-primary me-3"></i>
                        <div>
                            <p class="mb-1">Total de referencias</p>
                            <h5>2</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-cash-coin fs-1 text-success me-3"></i>
                        <div>
                            <p class="mb-1">Costo total de inventario</p>
                            <h5>$13,400</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5>Productos</h5>
            <a href="#" class="text-muted text-decoration-none"><i class="bi bi-download"></i> Descargar reporte</a>
        </div>

        <div class="row g-3">
            <div class="col-md-3">
                <div class="card p-3 shadow-sm text-center">
                    <img src="https://via.placeholder.com/50" alt="Producto" class="img-fluid mx-auto mb-3">
                    <h6>$35</h6>
                    <p class="mb-1"><strong>ace</strong></p>
                    <p class="text-muted">300 disponibles</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 shadow-sm text-center">
                    <img src="https://via.placeholder.com/50" alt="Producto" class="img-fluid mx-auto mb-3">
                    <h6>$25</h6>
                    <p class="mb-1"><strong>jabón</strong></p>
                    <p class="text-muted">220 disponibles</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import CintilloForm from "../components/CintilloForm.vue";
export default {
    name: "InventarioVue",

    components: {
        CintilloForm,
    }

};

</script>

<style>
.card {
    border-radius: 8px;
}

.card img {
    max-width: 50px;
}

.input-group-text {
    border-right: none;
}

.input-group .form-control {
    border-left: none;
}
</style>