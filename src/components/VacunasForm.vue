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
                    <div class="mb-3">
                        <label for="fechaActual" class="form-label">Fecha actual:</label>
                        <input type="date" class="form-control" id="fechaActual" v-model="fechaActual" />
                    </div>
                    <div class="mb-1">
                        <label for="tipoVacuna" class="form-label">Tipo de vacuna</label>
                        <input type="text" class="form-control" v-model="vacuna.tipovacuna" id="tipovacuna">
                    </div>

                    <!-- Marca y N° de serie -->
                    <div class="mb-3">
                        <label for="numero_serie" class="form-label">Número_serie</label>
                        <input type="text" class="form-control" v-model="vacuna.numero_serie" id="numero_serie">
                    </div>

                    <div class="mb-3">
                        <label for="dosis" class="form-label">Dosis</label>
                        <input type="text" class="form-control" v-model="vacuna.dosis" id="dosis">
                    </div>
                    <div class="mb-3">
                        <label for="peso" class="form-label">Peso</label>
                        <input type="text" class="form-control" v-model="vacuna.peso" id="peso">
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
                    <button type="button" class="btn btn-primary w-100" @click="guardarVacunas">Guardar</button>
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
import axios from 'axios'; // Asegúrate de importar axios

export default {
    data() {
        return {
            vacunas: [],
            fechaActual: '',
            id: '',
        };
    },
    mounted() {
        this.id = this.$route.params.id; // Captura el paciente_id de la URL
        this.obtenerFechaActual();
    },
    methods: {
        agregarVacuna() {
            this.vacunas.push({ tipovacuna: '', numero_serie: '', dosis: '', peso: '', descripcion: '' });
        },

        eliminarVacuna(index) {
            this.vacunas.splice(index, 1);
        },
        obtenerFechaActual() {
            const hoy = new Date();
            const dia = hoy.getDate().toString().padStart(2, '0');
            const mes = (hoy.getMonth() + 1).toString().padStart(2, '0'); // Los meses van de 0 a 11
            const año = hoy.getFullYear();
            // Formato correcto para el input de tipo date: YYYY-MM-DD
            this.fechaActual = `${año}-${mes}-${dia}`;
        },
        async guardarVacunas() {
            try {
                for (const vacuna of this.vacunas) {
                    const response = await axios.post('http://192.168.10.1/veterinario-app/curso_apirest/vacunas', {
                        fecha: this.fechaActual,
                        tipo: vacuna.tipovacuna,
                        numero_serie: vacuna.numero_serie,
                        dosis: vacuna.dosis,
                        peso: vacuna.peso,
                        descripcion: vacuna.descripcion,
                        paciente_id: this.id // Asegúrate de incluir el paciente_id
                    });
                    console.log('Vacuna guardada:', response.data);
                }
                alert('Vacunas guardadas con éxito.');
                this.$router.push({
                    path: `/detalleshistorias/${this.id}`,
                    hash: '#vacunas'
                })
                this.vacunas = []; // Opcionalmente puedes reiniciar el formulario
                this.obtenerFechaActual(); // Opcional: reiniciar la fecha actual
            } catch (error) {
                console.error('Error al guardar las vacunas:', error);
                alert('Error al guardar las vacunas. Intenta nuevamente.');
            }
        }
    }
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
