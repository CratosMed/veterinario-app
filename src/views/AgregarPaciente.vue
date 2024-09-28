<template>
    <br />
    <div class="d-flex justify-content-between align-items-center mb-3 bg-white py-2">
        <h2 class="text-primary me-auto">{{ editMode ? 'Editar Paciente' : 'Agregar Paciente' }}</h2>
    </div>
    <br />

    <div class="">
        <form @submit.prevent="submitForm">
            <!-- Campos obligatorios -->
            <div class="row mb-3">
                <!-- Fecha actual -->
                <div class="col-md-4 col-lg-4">
                    <label for="fechaActual" class="form-label">Fecha actual:</label>
                    <input type="date" class="form-control" id="fechaActual" v-model="fechaActual" />
                </div>

                <!-- Nombre -->
                <div class="col-md-4 col-lg-4">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" v-model="form.nombre" required>
                </div>

                <!-- Cliente -->
                <div class="col-md-4 col-lg-4">
                    <label for="cliente" class="form-label">Cliente</label>
                    <select class="form-select" id="cliente" v-model="form.cliente" required>
                        <option value="" disabled selected>Seleccionar Cliente</option>
                        <option v-for="propietario in propietarios" :key="propietario.id" :value="propietario.id">
                            {{ propietario.nombre }} - {{ propietario.cedula }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Fecha de Nacimiento -->
                <div class="col-md-4 col-lg-4">
                    <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
                    <input type="date" class="form-control" id="fechaNacimiento" v-model="form.fechaNacimiento"
                        @change="updateAgeFromDate" required>
                </div>

                <!-- Edad -->
                <div class="col-md-4 col-lg-4">
                    <label for="anos" class="form-label">Edad</label>
                    <input type="number" class="form-control" id="anos" v-model="form.anos" @change="updateDateFromAge">
                </div>

                <!-- Genero -->
                <div class="col-md-4 col-lg-4">
                    <label for="genero" class="form-label">Genero</label>
                    <select class="form-select" id="genero" v-model="form.genero" required>
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="caninos">Caninos</option>
                        <option value="felinos">Felinos</option>
                        <option value="aves">Aves</option>
                        <option value="equinos">Equinos</option>
                        <option value="conejos">Conejos</option>
                        <option value="peces">Peces</option>
                        <option value="reptiles">Reptiles</option>
                        <option value="roedores">Roedores</option>
                        <option value="anfibios">Anfibios</option>
                        <option value="bovinos">Bovinos</option>
                        <option value="caprino">Caprino</option>
                        <option value="ovino">Ovino</option>
                        <option value="porcino">Porcino</option>
                        <option value="otra">Otra</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Especie -->
                <div class="col-md-4 col-lg-4">
                    <label for="especie" class="form-label">Especie</label>
                    <input type="text" class="form-control" id="especie" v-model="form.especie">
                </div>

                <!-- Raza -->
                <div class="col-md-4 col-lg-4">
                    <label for="raza" class="form-label">Raza</label>
                    <input type="text" class="form-control" id="raza" v-model="form.raza">
                </div>

                <!-- Color -->
                <div class="col-md-4 col-lg-4">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" class="form-control" id="color" v-model="form.color">
                </div>
            </div>

            <div class="row mb-3">
                <!-- Sexo -->
                <div class="col-md-4 col-lg-4">
                    <label for="sexo" class="form-label">Sexo</label>
                    <select class="form-select" id="sexo" v-model="form.sexo" required>
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="Macho">Macho</option>
                        <option value="Hembra">Hembra</option>
                    </select>
                </div>

                <!-- Alergias -->
                <div class="col-md-4 col-lg-4">
                    <label for="alergias" class="form-label">Alergias</label>
                    <input type="text" class="form-control" id="alergias" v-model="form.alergias">
                </div>

                <!-- Foto -->
                <div class="col-md-4 col-lg-4">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="foto" @change="onFileChange">
                </div>
            </div>
            <br />

            <!-- Botón para guardar -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">
                    {{ editMode ? 'Actualizar Paciente' : 'Guardar Paciente' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
//import moment from 'moment'; // Puedes instalar moment.js o usar JavaScript nativo para el cálculo de fechas.

export default {
    name: 'AgregarPaciente',
    data() {
        return {
            form: {
                nombre: '',
                cliente: '',
                fechaNacimiento: '',
                anos: '',
                genero: '',
                especie: '',
                sexo: '',
                color: '',
                foto: '',
                alergias: '',
                fechaActual: ''
            },
            editMode: false,
            pacienteId: null,
            propietarios: [] // Lista de propietarios (clientes)
        };
    },
    created() {
        const id = this.$route.params.id;
        if (id) {
            this.loadPaciente(id);
        }
        this.loadPropietarios(); // Cargar clientes al montar el componente
    },
    mounted() {
        this.obtenerFechaActual();
    },
    methods: {
        // Actualiza la edad cuando se ingresa la fecha de nacimiento
        updateAgeFromDate() {
            if (this.form.fechaNacimiento) {
                const today = new Date();
                const birthDate = new Date(this.form.fechaNacimiento);
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDifference = today.getMonth() - birthDate.getMonth();
                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                this.form.anos = age;
            }
        },
        obtenerFechaActual() {
            const hoy = new Date();
            const dia = hoy.getDate().toString().padStart(2, '0');
            const mes = (hoy.getMonth() + 1).toString().padStart(2, '0'); // Los meses van de 0 a 11
            const año = hoy.getFullYear();
            // Formato correcto para el input de tipo date: YYYY-MM-DD
            this.fechaActual = `${año}-${mes}-${dia}`;
        },

        // Actualiza la fecha de nacimiento cuando se ingresa la edad
        updateDateFromAge() {
            if (this.form.anos) {
                const today = new Date();
                const birthYear = today.getFullYear() - this.form.anos;
                const birthDate = new Date(birthYear, today.getMonth(), today.getDate());
                this.form.fechaNacimiento = birthDate.toISOString().slice(0, 10); // Formato YYYY-MM-DD
            }
        },

        loadPropietarios() {
            axios.get('http://localhost/veterinario-app/curso_apirest/propietarios?page=1')
                .then(response => {
                    this.propietarios = response.data;
                })
                .catch(error => {
                    console.error('Error al cargar propietarios:', error);
                });
        },
        loadPaciente(id) {
            axios.get(`http://localhost/veterinario-app/curso_apirest/pacientes?id=${id}`)
                .then(response => {
                    const paciente = response.data[0];
                    this.form = {
                        nombre: paciente.nombre,
                        cliente: paciente.cliente,
                        fechaNacimiento: paciente.fechaNacimiento,
                        anos: paciente.anos,
                        genero: paciente.genero,
                        especie: paciente.especie,
                        sexo: paciente.sexo,
                        color: paciente.color,
                        alergias: paciente.alergias,
                        foto: paciente.foto,
                    };
                    this.editMode = true;
                    this.pacienteId = id;
                })
                .catch(error => {
                    console.error('Error al cargar paciente:', error);
                });
        },
        clearForm() {
            this.form = {
                nombre: '',
                cliente: '',
                fechaNacimiento: '',
                anos: '',
                genero: '',
                especie: '',
                sexo: '',
                color: '',
                foto: '',
                alergias: '',
            };
            this.editMode = false;
        },
        onFileChange(event) {
            const file = event.target.files[0];
            this.form.foto = file;  // Guardamos el archivo en el form
        },
        submitForm() {
            const formData = new FormData();

            // Asegúrate de que la fecha de nacimiento esté en formato 'YYYY-MM-DD'
            const fechaNacimiento = new Date(this.form.fechaNacimiento).toISOString().split('T')[0];

            // Agregamos todos los campos del formulario a FormData
            formData.append('datos', JSON.stringify({
                nombre: this.form.nombre,
                propietarios_id: this.form.cliente,
                fechaNacimiento: fechaNacimiento, // Usar la fecha formateada
                anos: this.form.anos,
                genero: this.form.genero,
                especie: this.form.especie,
                sexo: this.form.sexo,
                color: this.form.color,
                alergias: this.form.alergias
            }));

            // Agregamos la imagen solo si fue seleccionada
            if (this.form.foto) {
                formData.append('foto', this.form.foto);
            }

            if (this.editMode) {
                // Actualizar paciente existente
                formData.append('id', this.pacienteId);
                axios.put(`http://localhost/veterinario-app/curso_apirest/pacientes`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(() => {
                        alert('Paciente actualizado con éxito');
                        this.$router.push('/listapacientes');
                    })
                    .catch(error => alert('Error al actualizar paciente'));
            } else {
                // Crear nuevo paciente
                axios.post('http://localhost/veterinario-app/curso_apirest/pacientes', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(() => {
                        alert('Paciente agregado con éxito');
                        this.$router.push('/listapacientes');
                    })
                    .catch(error => alert('Error al agregar paciente'));
            }
        }

    }
};
</script>

<style scoped>
.container {
    max-width: 100%;
}

@media (min-width: 768px) {
    .container {
        max-width: 800px;
    }
}
</style>
