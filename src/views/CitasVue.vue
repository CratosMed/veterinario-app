<template>
    <div class="container">
        <div v-if="mensajeExito" class="alert alert-success text-center p-3" style="max-width: 500px; margin: 0 auto;">
            {{ mensajeExito }}
        </div>

        <br />
        <div class="d-grid gap-2">
            <div class="d-flex justify-content-between align-items-center mb-3 py-2">
                <h4 class="text-primary me-auto">Citas</h4>
            </div>
        </div>
        <input type="text" v-model="search" placeholder="Buscar citas..." class="form-control mb-4" />

        <ul class="list-group">
            <li v-for="(cita, index) in citasFiltradas" :key="index"
                class="list-group-item d-flex justify-content-between align-items-center p-3 mb-2" :class="{
                    'vencida': estaCitaVencida(cita.fecha) === 'vencida',
                    'hoy': estaCitaVencida(cita.fecha) === 'hoy',
                    'custom-hover': true
                }" @click="selectParametro(cita)">
                <!-- Resto del código de la lista -->

                <div class="w-100">
                    <div class="d-flex align-items-center text-dark">
                        <div class="d-flex align-items-center me-3">
                            <span class="badge bg-danger rounded-pill">{{ cita.dia }}</span>
                            <span class="text-muted ms-2">{{ cita.diaSemana }}</span>
                        </div>

                        <div class="d-flex flex-grow-1 mx-2">
                            <div class="flex-grow-1 d-flex flex-column">
                                <small class="text-muted" style="font-size: 0.99rem;">Paciente:
                                    <span class="fw-bold">{{ obtenerNombrePaciente(cita.paciente_id) }}</span>
                                    <span class="fw-bold ms-5">{{ cita.titulo }}</span> <!-- Añadido aquí -->
                                </small>
                                <h6 class="mb-0">{{ cita.descripcion }}</h6>
                            </div>
                            <div class="d-flex align-items-center ms-3 m-2">
                                {{ cita.fecha }} - {{ cita.hora }} - {{ cita.recurrencia }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de edición y eliminación fuera del router-link -->
                <div class="d-flex align-items-center ms-auto">
                    <button class="btn btn-warning btn-circle me-2" @click.stop="editarCita(cita, index)">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-danger btn-circle me-2" @click.stop="eliminarCita(cita.id, index)">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </li>
        </ul>



        <!-- Formulario de agregar/editar cita -->
        <form v-if="mostrarFormulario" @submit.prevent="submitCita" class="mt-4 fixed-form">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título de la cita</label>
                <input type="text" class="form-control" v-model="nuevaCita.titulo" required />
            </div>
            <div class="mb-3">
                <label for="Paciente" class="form-label">Paciente</label>
                <select class="form-select" v-model="nuevaCita.paciente_id" required>
                    <option v-for="paciente in pacientes" :key="paciente.id" :value="paciente.id">
                        {{ paciente.nombre }}
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" class="form-control" v-model="nuevaCita.descripcion" required />
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" v-model="nuevaCita.fecha" required />
            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" class="form-control" v-model="nuevaCita.hora" required />
            </div>
            <div class="mb-3">
                <label for="recurrencia" class="form-label">Recurrencia</label>
                <select class="form-select" v-model="nuevaCita.recurrencia">
                    <option value="una vez">Una vez</option>
                    <option value="cada semana">Cada semana</option>
                    <option value="cada mes">Cada mes</option>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">
                {{ citaEditando !== null ? 'Actualizar Cita' : 'Agregar Cita' }}
            </button>
        </form>

        <!-- Botón para mostrar/ocultar el formulario -->
        <div class="d-grid gap-2" style="position: fixed; bottom: 20px; right: 20px;">
            <button class="btn btn-danger rounded-circle" type="button" style="width: 50px; height: 50px;"
                @click="toggleFormulario">
                <i :class="['bi', mostrarFormulario ? 'bi-dash-lg' : 'bi-plus-lg']"></i>
            </button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            hoy: new Date().toLocaleDateString('sv-SE'), // Formato 'YYYY-MM-DD'
            search: '',
            citas: [],
            pacientes: [], // Agregar pacientes para cargar desde la API
            nuevaCita: {
                titulo: '',
                paciente_id: '',
                descripcion: '',
                fecha: '',
                hora: '',
                recurrencia: 'una vez'
            },
            citaEditando: null,
            mostrarFormulario: false,
            mensajeExito: '' // Variable para mostrar mensajes
        };
    },
    computed: {
        citasFiltradas() {
            return this.citas
                .sort((a, b) => {
                    const fechaCitaA = new Date(`${a.fecha}T${a.hora}`);
                    const fechaCitaB = new Date(`${b.fecha}T${b.hora}`);
                    return fechaCitaA - fechaCitaB; // Ordenar de más cercana a más lejana
                })
                .filter(cita =>
                    cita.titulo && cita.titulo.toLowerCase().includes(this.search.toLowerCase())
                );

        },
    },
    methods: {
        selectParametro(cita) {
            this.$router.push({ path: `/detalleshistorias/${cita.paciente_id}` }); // Cambiar para usar paciente_id
        },

        obtenerNombrePaciente(paciente_id) {
            const paciente = this.pacientes.find(p => p.id === paciente_id);
            return paciente ? paciente.nombre : 'Desconocido';
        },
        estaCitaVencida(fecha) {
            const fechaCita = new Date(fecha);
            const fechaHoy = new Date();
            fechaHoy.setHours(0, 0, 0, 0); // Establecer hora a 00:00:00 para comparación
            const fechaFinHoy = new Date(fechaHoy);
            fechaFinHoy.setHours(23, 59, 59, 999); // Establecer hora a 23:59:59 para comparación

            // Calcular la diferencia en días
            const diferenciaDias = Math.ceil((fechaCita - fechaHoy) / (1000 * 60 * 60 * 24));
            console.log(`Diferencia de días: ${diferenciaDias}, Cita: ${fechaCita.toISOString()}`);

            if (diferenciaDias < 0) {
                return "vencida"; // Cita pasada
            } else if (diferenciaDias === 0) {
                return "hoy"; // Cita de hoy
            } else {
                return "futura"; // Cita futura
            }
        },

        async fetchCitas() {
            console.log('Iniciando fetchCitas');
            try {
                const response = await axios.get('http://192.168.10.1/veterinario-app/curso_apirest/citas?page=1');
                console.log('Respuesta de la API:', response.data);


                // Asegúrate de que la respuesta sea un array
                this.citas = Array.isArray(response.data) ? response.data : [];

                console.log('Citas asignadas:', this.citas);
            } catch (error) {
                console.error('Error al consultar la API:', error);
            }
        },
        async fetchPacientes() {
            console.log('Iniciando fetchPacientes');
            try {
                const response = await axios.get('http://192.168.10.1/veterinario-app/curso_apirest/pacientes?page=1'); // Cambia la URL según sea necesario
                console.log('Respuesta de la API para pacientes:', response.data);

                // Asegúrate de que la respuesta sea un array
                this.pacientes = Array.isArray(response.data) ? response.data : [];
                console.log('Pacientes asignados:', this.pacientes);
            } catch (error) {
                console.error('Error al consultar la API de pacientes:', error);
            }
        },


        async submitCita() {
            try {
                if (this.citaEditando !== null) {
                    await this.actualizarCita();
                } else {
                    await this.crearCita();
                }
                this.resetFormulario();
            } catch (error) {
                console.error('Error al guardar la cita:', error);
            }
        },
        async crearCita() {
            try {
                const response = await axios.post('http://192.168.10.1/veterinario-app/curso_apirest/citas', this.nuevaCita);
                const fechaCita = new Date(`${this.nuevaCita.fecha}T${this.nuevaCita.hora}`); // Combina fecha y hora
                this.nuevaCita.fecha = fechaCita.toISOString().split('T')[0]; // Convierte a ISO y toma solo la fecha

                await this.fetchCitas(); // Recargar la lista de citas
                this.mensajeExito = 'Cita agregada exitosamente.';
                setTimeout(() => {
                    this.mensajeExito = '';
                }, 3000);
                this.resetFormulario(); // Limpiar el formulario después de agregar la cita
            } catch (error) {
                console.error('Error al crear la cita:', error);
            }
        },
        async actualizarCita() {
            try {
                const datosActualizados = { ...this.nuevaCita, id: this.citas[this.citaEditando].id };
                await axios.put('http://192.168.10.1/veterinario-app/curso_apirest/citas', datosActualizados);
                await this.fetchCitas(); // Recargar la lista de citas después de la actualización
                this.mensajeExito = 'Cita actualizada exitosamente.';
                setTimeout(() => {
                    this.mensajeExito = '';
                }, 3000);
                this.resetFormulario(); // Limpia el formulario después de actualizar
            } catch (error) {
                console.error('Error al actualizar la cita:', error.response ? error.response.data : error.message);
            }
        },
        async eliminarCita(id, index) {
            if (confirm('¿Estás seguro de que quieres eliminar esta cita?')) {
                try {
                    await axios.delete('http://192.168.10.1/veterinario-app/curso_apirest/citas', {
                        data: { id: id }
                    });
                    await this.fetchCitas(); // Recargar la lista de citas después de eliminar
                    this.mensajeExito = 'La cita ha sido eliminada con éxito.'; // Mensaje de éxito
                    setTimeout(() => {
                        this.mensajeExito = '';
                    }, 3000);
                } catch (error) {
                    console.error('Error al eliminar la cita:', error);
                }
            }

        },


        editarCita(cita, index) {
            this.nuevaCita = { ...cita };
            this.citaEditando = index;
            this.mostrarFormulario = true;
        },
        resetFormulario() {
            this.nuevaCita = { titulo: '', paciente_id: '', descripcion: '', fecha: '', hora: '', recurrencia: 'una vez' };
            this.citaEditando = null;
            this.mostrarFormulario = false;
        },
        toggleFormulario() {
            if (!this.mostrarFormulario) {
                this.resetFormulario();
            }
            this.mostrarFormulario = !this.mostrarFormulario;
        }
    },
    async mounted() {
        await this.fetchCitas();
        // Aquí puedes cargar los pacientes si tienes una API para ello
        this.fetchPacientes();
    }
};
</script>

<style scoped>
.container {
    background-color: #e8f0fc;
}

.vencida {
    background-color: rgb(230, 114, 114);
    /* Color de fondo para las citas vencidas */
    color: white;
    /* Texto blanco para que sea legible */
}

.hoy {
    background-color: #fdd835;
    /* Color de fondo para las citas de hoy */
    animation: pulse-animation 3s infinite;
    /* Aplicar animación para citas de hoy */
}

@keyframes pulse-animation {
    0% {
        background-color: #fdd835;
        /* Color inicial */
    }

    50% {
        background-color: #ff738b;
        /* Color durante la animación */
    }

    100% {
        background-color: #fdd835;
        /* Regresar al color inicial */
    }
}

.custom-hover:hover {
    background-color: #e0e0e0;
    /* Color de fondo al pasar el mouse, ajusta si es necesario */
}

.fixed-form {
    position: fixed;
    top: 20px;
    right: 20px;
    width: 100%;
    max-width: 300px;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    padding: 15px;
    z-index: 1000;
    overflow-y: auto;
}

.list-group-item {
    flex-wrap: wrap;
    /* Permite que los elementos se envuelvan cuando no quepan en una sola línea */
    word-wrap: break-word;
    /* Rompe las palabras largas para evitar el desbordamiento */
    word-break: break-all;
    /* Rompe las palabras que son demasiado largas */
    overflow-wrap: break-word;
    /* Rompe las palabras largas al final de una línea */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin: 5px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 120px;
}

.list-group-item .flex-grow-1 {
    flex-basis: 100%;
    /* Permite que el contenido tome el 100% del ancho disponible */
    min-width: 0;
    /* Asegura que el contenedor no colapse y el contenido se ajuste */
}

.list-group-item .d-flex {
    flex-wrap: wrap;
    /* Asegura que los elementos dentro del flex se acomoden en varias líneas si es necesario */
}

.d-flex.align-items-center.ms-3.m-2 {
    white-space: normal;
    /* Permite que las líneas de texto se ajusten */
    overflow: hidden;
    /* Evita el desbordamiento horizontal */
    text-overflow: ellipsis;
    /* Agrega puntos suspensivos cuando el texto es demasiado largo */
    flex-shrink: 1;
    /* Permite que el contenido reduzca su tamaño si es necesario */
}

@media (max-width: 576px) {
    .fixed-form {
        top: 0;
        right: 0;
        width: 100%;
        max-width: 100%;
        height: 100%;
    }

    .container {
        padding: 10px;
    }

    .list-group-item {
        flex-wrap: wrap;
    }
}

.list-group-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.btn-circle {
    width: 35px;
    height: 35px;
    margin-top: -116px;
}

.btn-circle i {
    font-size: 14px;
}
</style>
