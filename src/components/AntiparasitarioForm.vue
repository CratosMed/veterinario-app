<template>
    <div class="fondo mt-4">
        <!-- Cintillo -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="text-primary mb-0">Antiparasitarios</h6>
        </div>

        <!-- Formulario de Antiparasitarios -->
        <div>
            <div v-for="(antiparasitario, index) in antiparasitarios" :key="index" class="card mb-3 p-3 shadow-sm">
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
        };
    },
    methods: {
        agregarAntiparasitario() {
            this.antiparasitarios.push({ tipo: '', marcaSerie: '', descripcion: '' });
        },
        eliminarAntiparasitario(index) {
            this.antiparasitarios.splice(index, 1);
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