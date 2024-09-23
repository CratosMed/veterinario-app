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
                <div class="col-md-4 col-lg-4">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" v-model="form.nombre" required>
                </div>

                <div class="col-md-4 col-lg-4">
                    <label for="cliente" class="form-label">Cliente</label>
                    <select class="form-select" id="cliente" v-model="form.cliente" required>
                        <option value="" disabled selected>Seleccionar Cliente</option>
                        <option v-for="propietario in propietarios" :key="propietario.id" :value="propietario.id">
                            {{ propietario.nombre }} - {{ propietario.cedula }}
                        </option>
                    </select>
                </div>

                <div class="col-md-4 col-lg-4">
                    <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
                    <input type="date" class="form-control" id="fechaNacimiento" v-model="form.fechaNacimiento"
                        required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 col-lg-4">
                    <label for="anos" class="form-label">Edad</label>
                    <input type="number" class="form-control" id="anos" v-model="form.anos">
                </div>

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

                <div class="col-md-4 col-lg-4">
                    <label for="especie" class="form-label">Especie</label>
                    <input type="text" class="form-control" id="especie" v-model="form.especie">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 col-lg-4">
                    <label for="sexo" class="form-label">Sexo</label>
                    <select class="form-select" id="sexo" v-model="form.sexo" required>
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="Macho">Macho</option>
                        <option value="Hembra">Hembra</option>
                    </select>
                </div>

                <div class="col-md-4 col-lg-4">
                    <label for="pelaje" class="form-label">Pelaje</label>
                    <input type="text" class="form-control" id="pelaje" v-model="form.pelaje">
                </div>

                <div class="col-md-4 col-lg-4">
                    <label for="comida" class="form-label">Comida que consume</label>
                    <input type="text" class="form-control" id="comida" v-model="form.comida">
                </div>
            </div>

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
                pelaje: '',
                comida: ''
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
    methods: {
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
                        pelaje: paciente.pelaje,
                        comida: paciente.comida
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
                pelaje: '',
                comida: ''
            };
            this.editMode = false;
        },
        submitForm() {
            if (this.editMode) {
                axios.put(`http://localhost/veterinario-app/curso_apirest/pacientes`, { ...this.form, id: this.pacienteId })
                    .then(() => {
                        alert('Paciente actualizado con éxito');
                        this.$router.push('/listapacientes');
                    })
                    .catch(error => alert('Error al actualizar paciente'));
            } else {
                axios.post('http://localhost/veterinario-app/curso_apirest/pacientes', this.form)
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
