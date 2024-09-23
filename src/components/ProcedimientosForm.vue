<template>
    <div class="fondo mt-4">
        <!-- Cintillo -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="text-primary mb-0">Procedimientos</h6>
        </div>

        <!-- Formulario de Procedimientos -->
        <div>
            <div v-for="(procedimiento, index) in procedimientos" :key="index" class="card mb-3 p-3 shadow-sm">
                <div class="card-body">
                    <!-- Fecha -->
                    <div class="mb-3">
                        <label for="fechaProcedimiento" class="form-label">Fecha</label>
                        <input type="date" class="form-control" v-model="procedimiento.fecha">
                    </div>

                    <!-- Anestesiólogo -->
                    <div class="mb-3">
                        <label for="anestesiologo" class="form-label">Anestesiólogo/a</label>
                        <input type="text" class="form-control" v-model="procedimiento.anestesiologo">
                    </div>

                    <!-- Cirujano -->
                    <div class="mb-3">
                        <label for="cirujano" class="form-label">Cirujano/a</label>
                        <input type="text" class="form-control" v-model="procedimiento.cirujano">
                    </div>

                    <!-- Valoración ASA -->
                    <div class="mb-3">
                        <label for="valoracionASA" class="form-label">Valoración ASA</label>
                        <select class="form-select" v-model="procedimiento.asa">
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                        </select>
                    </div>

                    <!-- Peso del paciente -->
                    <div class="mb-3">
                        <label for="pesoPaciente" class="form-label">Peso del paciente (kg)</label>
                        <input type="number" step="0.01" class="form-control" v-model="procedimiento.peso">
                    </div>

                    <!-- Procedimiento -->
                    <div class="mb-3">
                        <label for="procedimientoDescripcion" class="form-label">Procedimiento</label>
                        <textarea class="form-control" v-model="procedimiento.descripcion" rows="3"></textarea>
                    </div>

                    <!-- Patología preexistente -->
                    <div class="mb-3">
                        <label for="patologiaPreexistente" class="form-label">Patología preexistente</label>
                        <textarea class="form-control" v-model="procedimiento.patologia" rows="3"></textarea>
                    </div>

                    <!-- Medicación en las últimas 24 horas -->
                    <div class="mb-3">
                        <label for="medicacionUltimas24" class="form-label">Medicación las últimas 24 horas</label>
                        <textarea class="form-control" v-model="procedimiento.medicacion" rows="3"></textarea>
                    </div>

                    <!-- Observaciones -->
                    <div class="mb-3">
                        <label for="observacionesProcedimiento" class="form-label">Observaciones</label>
                        <textarea class="form-control" v-model="procedimiento.observaciones" rows="3"></textarea>
                    </div>

                    <!-- Botón para eliminar -->
                    <div class="text-end">
                        <button class="btn btn-danger" @click="eliminarProcedimiento(index)">
                            <i class="bi bi-trash"></i> Borrar
                        </button>
                    </div>

                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">Guardar</button>
                </div>
            </div>

            <!-- Botón para agregar más procedimientos -->
            <div class="text-end">
                <button class="btn btn-outline-info" @click="agregarProcedimiento">
                    <i class="bi bi-plus-circle"></i> Agregar Procedimiento
                </button>
            </div>
            <br />

        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            procedimientos: [],
            formularioProcedimientoVisible: false,
        };
    },
    methods: {
        agregarProcedimiento() {
            this.procedimientos.push({
                fecha: '',
                anestesiologo: '',
                cirujano: '',
                asa: '',
                peso: '',
                descripcion: '',
                patologia: '',
                medicacion: '',
                observaciones: ''
            });
        },
        eliminarProcedimiento(index) {
            this.procedimientos.splice(index, 1);
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