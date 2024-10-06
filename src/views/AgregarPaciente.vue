<template>
    <br />
    <div class="d-flex justify-content-between align-items-center mb-3 bg-white py-2">
        <h4 class="text-primary me-auto">{{ editMode ? 'Editar Paciente' : 'Agregar Paciente' }}</h4>
    </div>
    <br />
    <!-- Alertas -->
    <div v-if="message" v-show="message"
        :class="['alert', messageType === 'success' ? 'alert-success' : 'alert-danger']"
        style="position: fixed; top: 10px; left: 50%; transform: translateX(-50%); z-index: 9999; width: 50%;"
        role="alert">
        {{ message }}
    </div>

    <div class="">
        <form @submit.prevent="submitForm">
            <!-- Campos obligatorios -->
            <div class="row mb-3">
                <!-- Nombre -->
                <div class="col-md-4 col-lg-4">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" v-model="form.nombre" required>
                </div>

                <!-- Cliente -->
                <div class="col-md-4 col-lg-4">
                    <label for="cliente" class="form-label">Cliente</label>
                    <select class="form-select" id="cliente" v-model="form.cliente" required>
                        <option value="" disabled>Seleccionar Cliente</option>
                        <option v-for="propietario in propietarios" :key="propietario.id" :value="propietario.id">
                            {{ propietario.nombre }} - {{ propietario.cedula }}
                        </option>
                    </select>
                </div>

                <!-- Especie -->
                <div class="col-md-4 col-lg-4">
                    <label for="especie" class="form-label">Especie</label>
                    <input type="text" class="form-control" id="especie" v-model="form.especie">
                </div>
            </div>

            <div class="row mb-3">
                <!-- Raza -->
                <div class="col-md-4 col-lg-4">
                    <label for="raza" class="form-label">Raza</label>
                    <input type="text" class="form-control" id="raza" v-model="form.raza">
                </div>

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
            </div>

            <div class="row mb-3">
                <!-- Color -->
                <div class="col-md-4 col-lg-4">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" class="form-control" id="color" v-model="form.color">
                </div>

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
                    <input type="text" class="form-control" id="color" v-model="form.alergias">
                </div>

                <div class="col-md-4 col-lg-4">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="foto" @change="onFileChange">
                    <img id="image-preview" :src="`http://localhost/veterinario-app/curso_apirest/${form.foto}`"
                        alt="Imagen del paciente" class="img-fluid mt-2" />
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
                id: '',
                nombre: '',
                cliente: '',
                fechaNacimiento: '',
                anos: '',
                raza: '',
                especie: '',
                sexo: '',
                color: '',
                foto: '',
                alergias: '',
                fechaActual: ''
            },
            editMode: false,
            pacienteId: null,
            propietarios: [],// Lista de propietarios (clientes)
            message: null,   // Almacena el mensaje a mostrar
            messageType: '', // Tipo de mensaje: success o error
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
                    this.showMessage('Error al cargar propietarios', 'error');
                });
        },
        loadPaciente(id) {
            axios.get(`http://localhost/veterinario-app/curso_apirest/pacientes?id=${id}`)
                .then(response => {
                    const paciente = response.data[0];
                    this.form = {
                        id: paciente.id,
                        nombre: paciente.nombre,
                        cliente: paciente.propietarios_id, // Asignar el cliente correspondiente
                        fechaNacimiento: paciente.fecha_nacimiento,
                        anos: '', // Lo calcularemos basado en la fecha de nacimiento
                        raza: paciente.raza,
                        especie: paciente.especie,
                        sexo: paciente.sexo,
                        color: paciente.color,
                        alergias: paciente.alergias,
                        foto: paciente.foto,
                    };
                    this.editMode = true;
                    this.pacienteId = id;
                    console.log(response.data[0])

                    // Actualizar la edad basado en la fecha de nacimiento
                    this.updateAgeFromDate();

                    // Mostrar vista previa de la foto
                    this.previewImage(paciente.foto);
                })
                .catch(error => {
                    this.showMessage('Error al cargar paciente', 'error');
                });
        },
        updateAgeFromDate() {
            if (this.form.fechaNacimiento) {
                const today = new Date();
                const birthDate = new Date(this.form.fechaNacimiento);
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDifference = today.getMonth() - birthDate.getMonth();
                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                this.form.anos = age; // Asignar la edad calculada
            }
        },

        // Mostrar una vista previa de la imagen seleccionada o existente
        previewImage(imagePath) {
            if (imagePath) {
                const fullPath = `http://localhost/veterinario-app/${imagePath}`;
                // Aquí puedes mostrar la imagen actual en el formulario
                document.getElementById('image-preview').src = fullPath;
            }
        },
        clearForm() {
            this.form = {
                nombre: '',
                fecha: '',
                cliente: '',
                fechaNacimiento: '',
                anos: '',
                raza: '',
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
            console.log('Datos a enviar:', this.form); // Verificar los datos
            const formData = new FormData();

            // Asegúrate de que la fecha de nacimiento esté en formato 'YYYY-MM-DD'
            const fechaNacimiento = new Date(this.form.fechaNacimiento).toISOString().split('T')[0];

            // Agregar todos los campos del formulario directamente a FormData
            //formData.append('id', this.form.id); // Agregar ID directamente
            formData.append('nombre', this.form.nombre);
            formData.append('propietarios_id', this.form.cliente);
            formData.append('fechaNacimiento', fechaNacimiento); // Usar la fecha formateada            
            formData.append('raza', this.form.raza);
            formData.append('especie', this.form.especie);
            formData.append('sexo', this.form.sexo);
            formData.append('color', this.form.color);
            formData.append('alergias', this.form.alergias);
            console.log('Form Data being sent:', Array.from(formData.entries()));

            // Agregamos la imagen solo si fue seleccionada
            if (this.form.foto) {
                formData.append('foto', this.form.foto);
            }

            if (this.editMode) {
                // Actualizar paciente existente
                formData.append('id', this.form.id);

                axios.post(`http://localhost/veterinario-app/curso_apirest/pacientes`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                const successMessage = this.editMode
                    ? 'Paciente actualizado con éxito'
                    : 'Paciente agregado con éxito';
                this.showMessage(successMessage, 'success', () => {
                    this.$router.push('/listapacientes');
                })

                    .catch(error => {
                        this.showMessage('Error al guardar paciente', 'error');
                    });
            } else {
                // Crear nuevo paciente
                axios.post('http://localhost/veterinario-app/curso_apirest/pacientes', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(() => {
                        // Mostrar mensaje de éxito
                        this.showMessage('Paciente agregado con éxito', 'success', () => {
                            this.$router.push('/listapacientes');
                        });
                    })
                    .catch(error => {
                        // Mostrar mensaje de error
                        this.showMessage('Error al agregar paciente', 'error');
                    });
            }
        },
        showMessage(message, type, callback) {
            this.message = message;
            this.messageType = type;

            setTimeout(() => {
                this.message = null;
                this.messageType = '';
                if (callback) {
                    callback();
                }
            }, 3000);
        },

    }
};
</script>

<style scoped>
.container {
    max-width: 100%;
    margin-right: 1px;
}

@media (min-width: 768px) {
    .container {
        max-width: 800px;
    }
}
</style>
