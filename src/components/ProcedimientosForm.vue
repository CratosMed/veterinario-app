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
                        <label for="fechaActual" class="form-label">Fecha actual:</label>
                        <input type="date" class="form-control" id="fechaActual" v-model="fechaActual" />
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
                        <label for="valoracion_asa" class="form-label">Valoración ASA</label>
                        <select class="form-select" v-model="procedimiento.valoracion_asa">
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                        </select>
                    </div>

                    <!-- Peso del paciente -->
                    <div class="mb-3">
                        <label for="peso" class="form-label">Peso del paciente (kg)</label>
                        <input type="number" step="0.01" class="form-control" v-model="procedimiento.peso">
                    </div>

                    <!-- Procedimiento -->
                    <div class="mb-3">
                        <label for="procedimiento" class="form-label">Procedimiento</label>
                        <textarea class="form-control" v-model="procedimiento.procedimiento" rows="3"></textarea>
                    </div>

                    <!-- Patología preexistente -->
                    <div class="mb-3">
                        <label for="patologias" class="form-label">Patologías</label>
                        <textarea class="form-control" v-model="procedimiento.patologias" rows="3"></textarea>
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
                    <button type="button" class="btn btn-primary w-100" @click="guardarProcedimientos">Guardar</button>
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
import axios from 'axios'; // Asegúrate de importar axios

export default {
    data() {
        return {
            fechaActual: '',
            procedimientos: [],
            formularioProcedimientoVisible: false,
        };
    },
    mounted() {
        this.id = this.$route.params.id; // Captura el paciente_id de la URL
        this.obtenerFechaActual();
    },
    methods: {
        agregarProcedimiento() {
            this.procedimientos.push({
                fecha: '',
                anestesiologo: '',
                cirujano: '',
                valoracion_asa: '',
                peso: '',
                procedimiento: '',
                patologias: '',
                medicacion: '',
                observaciones: ''
            });
        },
        eliminarProcedimiento(index) {
            this.procedimientos.splice(index, 1);
        },
        obtenerFechaActual() {
            const hoy = new Date();
            const dia = hoy.getDate().toString().padStart(2, '0');
            const mes = (hoy.getMonth() + 1).toString().padStart(2, '0'); // Los meses van de 0 a 11
            const año = hoy.getFullYear();
            // Formato correcto para el input de tipo date: YYYY-MM-DD
            this.fechaActual = `${año}-${mes}-${dia}`;
        },
        async guardarProcedimientos() {
            if (!this.id) {
                alert('Paciente ID no definido. No se puede guardar la información.');
                return;
            }
            try {
                for (const procedimiento of this.procedimientos) {
                    await axios.post(`http://192.168.10.1/veterinario-app/curso_apirest/procedimientos`, {
                        fecha: this.fechaActual,
                        anestesiologo: procedimiento.anestesiologo,
                        cirujano: procedimiento.cirujano,
                        valoracion_asa: procedimiento.valoracion_asa,
                        peso: procedimiento.peso,
                        procedimiento: procedimiento.procedimiento,
                        patologias: procedimiento.patologias,
                        medicacion: procedimiento.medicacion,
                        observaciones: procedimiento.observaciones,
                        paciente_id: this.id
                    });
                }
                alert('Procedimientos guardados con éxito');
                // Opcionalmente puedes reiniciar el formulario
                this.procedimientos = [];
                this.obtenerFechaActual(); // Opcional: reiniciar la fecha actual
            } catch (error) {
                console.error('Error al guardar los procedimientos:', error);
                alert('Hubo un error al guardar los procedimientos');
            }
        }
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