<template>
    <div class="fondo mt-4">
        <!-- Cintillo -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="text-primary mb-0">Vacunas</h6>
        </div>

        <!-- Formulario de Vacunas -->
        <div>
            <div v-for="(vacuna, index) in vacunas" :key="index" class="card mb-3 p-3 shadow-sm">
                <div class="card-body">
                    <!-- Seleccionar tipo de vacuna -->
                    <div class="mb-1">
                        <label for="tipoVacuna" class="form-label">Tipo de vacuna</label>
                        <input type="text" class="form-control" v-model="vacuna.tipovacuna" id="tipovacuna">
                    </div>

                    <!-- Marca y N° de serie -->
                    <div class="mb-3">
                        <label for="marcaSerie" class="form-label">Marca y N° de serie</label>
                        <input type="text" class="form-control" v-model="vacuna.marcaSerie" id="marcaSerie">
                    </div>

                    <div class="mb-3">
                        <label for="dosis" class="form-label">Dosis</label>
                        <input type="text" class="form-control" v-model="vacuna.dosis" id="dosis">
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label for="descripcionVacuna" class="form-label">Descripción</label>
                        <textarea class="form-control" v-model="vacuna.descripcion" rows="3"
                            placeholder="Opcional"></textarea>
                    </div>

                    <!-- Botón para eliminar -->
                    <div class="text-end">
                        <button class="btn btn-danger" @click="eliminarVacuna(index)">
                            <i class="bi bi-trash"></i> Borrar
                        </button>
                    </div>
                </div>
                <br />
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">Guardar</button>
                </div>
            </div>
        </div>

        <!-- Botón para agregar más vacunas -->
        <div class="text-end">
            <button class="btn btn-outline-info" @click="agregarVacuna">
                <i class="bi bi-plus-circle"></i> Agregar vacunas
            </button>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            vacunas: [],
        };
    },
    methods: {
        agregarVacuna() {
            this.vacunas.push({ tipo: '', marcaSerie: '', descripcion: '' });
        },
        eliminarVacuna(index) {
            this.vacunas.splice(index, 1);
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
