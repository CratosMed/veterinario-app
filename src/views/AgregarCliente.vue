<template>
    <br />
    <div class="d-flex justify-content-between align-items-center mb-3  bg-white py-2">
        <h2 class="text-primary me-auto">{{ editMode ? 'Editar Cliente' : 'Agregar Cliente' }}</h2>
    </div>
    <br />

    <div>
        <form @submit.prevent="submitForm">
            <div class="row mb-3">
                <!-- Fecha actual -->
                <div class="col-md-4 col-lg-4">
                    <label for="fechaActual" class="form-label">Fecha actual:</label>
                    <input type="date" class="form-control" id="fechaActual" v-model="form.fechaActual" />
                </div>

                <!-- Nombre -->
                <div class="col-md-4 col-lg-4">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" v-model="form.nombre" required>
                </div>

                <!-- Apellido -->
                <div class="col-md-4 col-lg-4">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" v-model="form.apellido" required>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Cédula -->
                <div class="col-md-4 col-lg-4">
                    <label for="cedula" class="form-label">Cédula</label>
                    <input type="number" class="form-control" id="cedula" v-model="form.cedula" required>
                </div>

                <!-- Dirección -->
                <div class="col-md-4 col-lg-4">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" v-model="form.direccion" required>
                </div>

                <!-- Teléfono -->
                <div class="col-md-4 col-lg-4">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" v-model="form.telefono" required>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Teléfono Auxiliar -->
                <div class="col-md-4 col-lg-4">
                    <label for="telefonoauxiliar" class="form-label">Teléfono Auxiliar</label>
                    <input type="text" class="form-control" id="telefonoauxiliar" v-model="form.telefonoauxiliar"
                        required>
                </div>

                <!-- Correo -->
                <div class="col-md-4 col-lg-4">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" v-model="form.correo" required>
                </div>

                <!-- Deuda -->
                <div class="col-md-4 col-lg-4">
                    <label for="deuda" class="form-label">Deuda</label>
                    <input type="text" class="form-control" id="deuda" v-model="form.deuda">
                </div>
            </div>


            <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">
                    {{ editMode ? 'Actualizar Cliente' : 'Guardar Cliente' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'AgregarCliente',
    data() {
        return {
            form: {
                cedula: '',
                nombre: '',
                apellido: '',
                direccion: '',
                telefono: '',
                correo: '',
                deuda: '',
                fechaActual: '',
            },
            editMode: false,
            clienteId: null
        };
    },
    created() {
        const id = this.$route.params.id;
        if (id) {
            this.loadCliente(id);
        }
    },
    mounted() {
        this.obtenerFechaActual();
    },
    methods: {
        loadCliente(id) {
            axios.get(`http://localhost/veterinario-app/curso_apirest/propietarios?id=${id}`)
                .then(response => {
                    const cliente = response.data[0];
                    this.form = {
                        cedula: cliente.cedula,
                        nombre: cliente.nombre,
                        apellido: cliente.apellido,
                        direccion: cliente.direccion,
                        telefono: cliente.telefono,
                        correo: cliente.correo,
                        deuda: cliente.deuda
                    };
                    this.editMode = true;
                    this.clienteId = id;
                })
                .catch(error => {
                    console.error('Error al cargar cliente:', error);
                });
        },
        clearForm() {
            // Reinicia el formulario para agregar un nuevo cliente
            this.form = {
                cedula: '',
                nombre: '',
                apellido: '',
                direccion: '',
                telefono: '',
                correo: '',
                deuda: ''
            };
            this.editMode = false; // Vuelve al modo de agregar
        },
        submitForm() {
            if (this.editMode) {
                axios.put(`http://localhost/veterinario-app/curso_apirest/propietarios`, { ...this.form, id: this.clienteId })
                    .then(() => {
                        alert('Cliente actualizado con éxito');
                        this.$router.push('/listaclientes'); // Redirigir después de actualizar
                    })
                    .catch(error => alert('Error al actualizar cliente'));
            } else {
                axios.post('http://localhost/veterinario-app/curso_apirest/propietarios', this.form)
                    .then(() => {
                        alert('Cliente agregado con éxito');
                        this.$router.push('/listacliente'); // Redirigir después de agregar
                    })
                    .catch(error => alert('Error al agregar cliente'));
            }
        },
        obtenerFechaActual() {
            const hoy = new Date();
            const dia = hoy.getDate().toString().padStart(2, '0');
            const mes = (hoy.getMonth() + 1).toString().padStart(2, '0'); // Los meses van de 0 a 11
            const año = hoy.getFullYear();
            // Formato correcto para el input de tipo date: YYYY-MM-DD
            this.form.fechaActual = `${año}-${mes}-${dia}`; // Asignar dentro de form
        },
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
