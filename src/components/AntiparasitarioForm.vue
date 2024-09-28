<template>
    <div class="fondo mt-4">
        <!-- Cintillo -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="text-primary mb-0">Antiparasitarios</h6>
        </div>

        <!-- Formulario de Antiparasitarios -->
        <div>
            <div v-for="(antiparasitario, index) in antiparasitarios" :key="index" class="card mb-3 p-3 shadow-sm">
                <div class="mb-3">
                    <label for="fechaActual" class="form-label">Fecha actual:</label>
                    <input type="date" class="form-control" id="fechaActual" v-model="fechaActual" />
                </div>
                <div class="card-body">
                    <!-- Seleccionar tipo de antiparasitario -->
                    <div class="mb-1">
                        <label for="tipoAntiparasitario" class="form-label">Tipo de antiparasitario</label>
                        <select class="form-select" v-model="antiparasitario.tipo" aria-label="Tipo de antiparasitario">
                            <option value="1">Inyectable</option>
                            <option value="2">Externa</option>
                            <option value="3">Suspensión oral</option>
                            <option value="4">Pasta Oral</option>
                            <option value="5">Otros</option>
                        </select>
                    </div>

                    <!-- Marca y N° de serie -->
                    <div class="mb-3">
                        <label for="marcaSerieAntiparasitario" class="form-label">Marca y N° de serie</label>
                        <input type="text" class="form-control" v-model="antiparasitario.marcaSerie"
                            id="marcaSerieAntiparasitario">
                    </div>
                    <div class="mb-3">
                        <label for="dosis" class="form-label">Dosis</label>
                        <input type="text" class="form-control" v-model="antiparasitario.dosis" id="dosis">
                    </div>
                    <div class="mb-3">
                        <label for="peso" class="form-label">Peso</label>
                        <input type="text" class="form-control" v-model="antiparasitario.peso" id="peso">
                    </div>
                    <!-- Descripción -->
                    <div class="mb-3">
                        <label for="descripcionAntiparasitario" class="form-label">Descripción</label>
                        <textarea class="form-control" v-model="antiparasitario.descripcion" rows="3"
                            placeholder="Opcional"></textarea>
                    </div>

                    <!-- Botón para eliminar -->
                    <div class="text-end">
                        <button class="btn btn-danger" @click="eliminarAntiparasitario(index)">
                            <i class="bi bi-trash"></i> Borrar
                        </button>
                    </div>
                    <br />
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100">Guardar</button>
                    </div>
                </div>
            </div>

            <!-- Botón para agregar más antiparasitarios -->
            <div class="text-end">
                <button class="btn btn-outline-info" @click="agregarAntiparasitario">
                    <i class="bi bi-plus-circle"></i> Agregar antiparasitarios
                </button>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            antiparasitarios: [],
            fechaActual: '',
        };
    },
    mounted() {
        this.obtenerFechaActual();
    },
    methods: {
        agregarAntiparasitario() {
            this.antiparasitarios.push({ tipo: '', marcaSerie: '', descripcion: '' });
        },
        eliminarAntiparasitario(index) {
            this.antiparasitarios.splice(index, 1);
        },
        obtenerFechaActual() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Mes en formato 2 dígitos
            const day = String(today.getDate()).padStart(2, '0'); // Día en formato 2 dígitos
            this.fechaActual = `${year}-${month}-${day}`;
        },
    },
};
</script>

<style scoped>
.fondo {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.25rem;
}

.card {
    border: 1px solid #ddd;
    border-radius: 0.25rem;
}
</style>