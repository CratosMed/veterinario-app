<template>
    <div class="fondo mt-4">
        <!-- Cintillo -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="text-primary mb-0">Hallazgos del examen</h6>
        </div>

        <!-- Formulario de Hallazgos -->
        <div v-for="(hallazgo, index) in hallazgos" :key="index" class="card mb-3 p-3 shadow-sm">
            <div class="card-body">
                <!-- Seleccionar tipo de examen -->
                <div class="mb-3">
                    <label for="fechaActual" class="form-label">Fecha actual:</label>
                    <input type="date" class="form-control" id="fechaActual" v-model="fechaActual" />
                </div>
                <div class="mb-1">
                    <select class="form-select" v-model="hallazgo.tipo" aria-label="Tipo de examen">
                        <option value="">Seleccione el tipo de examen</option>
                        <option v-for="tipo in tiposExamen" :key="tipo.id" :value="tipo.tipo">{{ tipo.tipo }}</option>
                        <option value="otra">Otra</option> <!-- Opción para "Otra" -->
                    </select>
                </div>

                <!-- Campo de entrada que se muestra cuando se selecciona "Otra" -->
                <div v-if="hallazgo.tipo === 'otra'" class="mb-3">
                    <label for="otroHallazgo" class="form-label">Especifique otro tipo de examen</label>
                    <input type="text" class="form-control" id="otroHallazgo" v-model="hallazgo.otro"
                        placeholder="Especifique aquí el tipo de examen">
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" v-model="hallazgo.descripcion" rows="3"
                        placeholder="Opcional"></textarea>
                </div>

                <div class="col-md-4 col-lg-4">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="foto" @change="onFileChange($event, index)">


                </div>
            </div>

            <!-- Botón para eliminar -->
            <div class="text-end">
                <button class="btn btn-danger" @click="eliminarHallazgo(index)">
                    <i class="bi bi-trash"></i> Borrar
                </button>
            </div>
            <br />

            <div class="text-center">
                <button type="button" class="btn btn-primary w-100" @click="guardarHallazgos">Guardar</button>
            </div>
        </div>
    </div>
    <br />
    <div class="text-end">
        <button class="btn btn-outline-info" @click="agregarHallazgo()">
            <i class="bi bi-plus-circle"></i> Agregar hallazgos de exámenes
        </button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            hallazgos: [],
            images: [],
            selectedImage: null,
            newDescription: '',
            fechaActual: '',
            id: '',
            tiposExamen: []
        };
    },
    mounted() {
        this.id = this.$route.params.id;
        this.obtenerFechaActual();
        this.obtenerTiposExamen();
    },
    methods: {
        async obtenerTiposExamen() {
            try {
                const response = await axios.get('http://192.168.10.1/veterinario-app/curso_apirest/examenes?obtenerTiposExamen');
                this.tiposExamen = response.data;
                console.log(this.tiposExamen)
            } catch (error) {
                console.error('Error al obtener los tipos de examen:', error);
            }
        },

        onFileChange(event, index) {
            const file = event.target.files[0];
            this.hallazgos[index].imagen = file; // Guardamos el archivo en el hallazgo correspondiente
        },
        agregarHallazgo() {
            this.hallazgos.push({ tipo: '', descripcion: '', imagen: null }); // Cambiado de [] a null
        },
        eliminarHallazgo(index) {
            this.hallazgos.splice(index, 1);
        },
        async guardarHallazgos() {
            const formData = new FormData();
            try {
                this.hallazgos.forEach(hallazgo => {
                    // Si el tipo de examen es "Otra", envía el valor del campo "otro"
                    const tipoExamen = hallazgo.tipo === 'otra' ? hallazgo.otro : hallazgo.tipo;

                    formData.append('tipo', tipoExamen);
                    formData.append('descripcion', hallazgo.descripcion);
                    formData.append('paciente_id', this.id);

                    if (hallazgo.imagen) {
                        formData.append('foto', hallazgo.imagen);
                    }
                });

                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }

                const response = await axios.post('http://192.168.10.1/veterinario-app/curso_apirest/examenes', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });

                alert('Hallazgos guardados con éxito');
                this.hallazgos = [];
                this.obtenerFechaActual();
                this.obtenerTiposExamen();
            } catch (error) {
                console.error('Error al guardar los hallazgos:', error.response?.data || error.message);
                alert('Hubo un error al guardar los hallazgos: ' + (error.response?.data?.message || 'Error desconocido'));
            }
        },
        obtenerFechaActual() {
            const hoy = new Date();
            const dia = hoy.getDate().toString().padStart(2, '0');
            const mes = (hoy.getMonth() + 1).toString().padStart(2, '0');
            const año = hoy.getFullYear();
            this.fechaActual = `${año}-${mes}-${dia}`;
        }
    }

}
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

.img-thumbnail {
    max-height: 100px;
    object-fit: cover;
}

.text-center {
    margin-top: 10px;
}
</style>
