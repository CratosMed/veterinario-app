<template>
    <br />
    <div class="d-flex justify-content-between align-items-center mb-3  bg-white py-2">
        <h4 class="text-primary me-auto">{{ editMode ? 'Editar Cliente' : 'Agregar Cliente' }}</h4>
    </div>
    <br />
    <div v-if="message" v-show="message"
        :class="['alert', messageType === 'success' ? 'alert-success' : 'alert-danger']"
        style="position: fixed; top: 10px; left: 50%; transform: translateX(-50%); z-index: 9999; width: 50%;"
        role="alert">
        {{ message }}
    </div>
    <div>
        <form @submit.prevent="submitForm">
            <div class="row mb-3">
                <!-- Nombre -->
                <div class="col-md-4 col-lg-4">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" v-model="form.nombre">
                </div>

                <!-- Apellido -->
                <div class="col-md-4 col-lg-4">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" v-model="form.apellido">
                </div>

                <!-- Cédula -->
                <div class="col-md-4 col-lg-4">
                    <label for="cedula" class="form-label">Cédula</label>
                    <input type="text" class="form-control" id="cedula" v-model="form.cedula" @input="validateNumber"
                        required>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Dirección -->
                <div class="col-md-4 col-lg-4">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" v-model="form.direccion">
                </div>

                <!-- Teléfono -->
                <div class="col-md-4 col-lg-4">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" v-model="form.telefono"
                        @input="validateNumber" required>
                </div>

                <!-- Teléfono Auxiliar -->
                <div class="col-md-4 col-lg-4">
                    <label for="telefonoauxiliar" class="form-label">Teléfono Auxiliar</label>
                    <input type="text" class="form-control" id="telefonoauxiliar" v-model="form.telefonoauxiliar"
                        @input="validateNumber">
                </div>
            </div>

            <div class="row mb-3">
                <!-- Correo -->
                <div class="col-md-4 col-lg-4">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" v-model="form.correo">
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
            clienteId: null,
            message: null,   // Almacena el mensaje a mostrar
            messageType: '', // Tipo de mensaje: success o error
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
                    this.showMessage('Error al cargar cliente', 'error');
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
                        this.showMessage('Cliente actualizado con éxito', 'success', () => {
                            this.$router.push('/listaclientes'); // Redirigir después de mostrar el mensaje
                        });
                    })
                    .catch(error => alert('Error al actualizar cliente'));
            } else {
                axios.post('http://localhost/veterinario-app/curso_apirest/propietarios', this.form)
                    .then(() => {
                        this.showMessage('Cliente agregado con éxito', 'success', () => {
                            this.$router.push('/listaclientes'); // Redirigir después de mostrar el mensaje
                        });
                    })
                    .catch(error => this.showMessage('Error al agregar cliente', 'error'));
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
        // Método para validar que solo se ingresen números
        validateNumber(event) {
            const value = event.target.value;
            // Reemplaza todo lo que no sea un dígito
            event.target.value = value.replace(/\D/g, '');
            this.form[event.target.id] = event.target.value; // Sincronizar el valor con el modelo
        },
        showMessage(message, type, callback) {
            this.message = message;
            this.messageType = type;

            console.log('Mensaje:', this.message); // Verificar el mensaje
            console.log('Tipo de mensaje:', this.messageType); // Verificar el tipo de mensaje

            this.$nextTick(() => {
                const alertBox = document.querySelector('.alert');
                console.log('Elemento alertBox:', alertBox); // Verificar si se encuentra el elemento

                if (alertBox) {
                    // Mantener la alerta visible por 5 segundos antes de aplicar la animación de desaparición
                    setTimeout(() => {
                        alertBox.classList.add('alert-fade'); // Añadir clase de fade
                        console.log('Clase alert-fade añadida');

                        // Esperar 1 segundo más para permitir la animación de desaparición
                        setTimeout(() => {
                            this.message = null;
                            this.messageType = '';
                            console.log('Mensaje borrado después de 3 segundos');

                            // Llamar al callback si existe
                            if (callback) {
                                callback();
                            }
                        }, 1000);
                    }, 1000);
                }
            });

            // Limpiar el mensaje después de 6 segundos
            setTimeout(() => {
                this.message = null;
                this.messageType = '';
                console.log('Mensaje borrado después de 3 segundos');
            }, 1000);
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

.alert {
    margin-bottom: 20px;
    transition: opacity 0.5s ease;
}

.alert-fade {
    opacity: 0;
    transition: opacity 1s ease-out;
}
</style>
