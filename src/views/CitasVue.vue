<template>
    <div class="container">
        <h5 class="box-title mb-4">Citas</h5>
        <input type="text" v-model="search" placeholder="Buscar citas..." class="form-control mb-4" />

        <ul class="list-group">
            <li v-for="(cita, index) in citasFiltradas" :key="index"
                class="list-group-item d-flex justify-content-between align-items-center p-3 mb-2" :class="{
                    'pulse': estaCitaVencida(cita.fecha),
                    'custom-hover': true
                }">
                <div class="d-flex align-items-center me-3">
                    <span class="badge bg-danger rounded-pill">{{ cita.dia }}</span>
                    <span class="text-muted ms-2">{{ cita.diaSemana }}</span>
                </div>
                <div class="d-flex flex-grow-1 mx-2">
                    <div class="flex-grow-1 d-flex flex-column">
                        <h5 class="fw-bold mb-0">{{ cita.titulo }}</h5>
                        <h6 class="mb-0">{{ cita.descripcion }}</h6>
                    </div>
                    <div class="d-flex align-items-center ms-3 m-2">
                        {{ cita.fecha }} - {{ cita.hora }} - {{ cita.recurrencia }}
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <button class="btn btn-warning btn-circle me-2" @click="editarCita(cita, index)">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-danger btn-circle me-2" @click="eliminarCita(cita.id, index)">
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
            mostrarFormulario: false
        };
    },
    computed: {
        citasFiltradas() {
            return this.citas.filter(cita =>
                cita.titulo && cita.titulo.toLowerCase().includes(this.search.toLowerCase())
            );
        },
    },
    methods: {
        estaCitaVencida(fecha) {
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0); // Ajusta hoy a medianoche

            const citaFecha = new Date(fecha);
            citaFecha.setHours(0, 0, 0, 0); // Ajusta la fecha de la cita a medianoche

            console.log(`Fecha Cita: ${citaFecha.toLocaleDateString()}, Hoy: ${hoy.toLocaleDateString()}`);

            return citaFecha >= hoy && citaFecha <= new Date(hoy.setDate(hoy.getDate() + 2)); // Comparar fechas
        },
        async fetchCitas() {
            console.log('Iniciando fetchCitas');
            try {
                const response = await axios.get('http://localhost/veterinario-app/curso_apirest/citas?page=1');
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
                const response = await axios.get('http://localhost/veterinario-app/curso_apirest/pacientes?page=1'); // Cambia la URL según sea necesario
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
                const response = await axios.post('http://localhost/veterinario-app/curso_apirest/citas', this.nuevaCita);
                const fechaCita = new Date(`${this.nuevaCita.fecha}T${this.nuevaCita.hora}`); // Combina fecha y hora
                this.nuevaCita.fecha = fechaCita.toISOString().split('T')[0]; // Convierte a ISO y toma solo la fecha

                // Aquí se puede agregar la nueva cita directamente a la lista
                this.citas.push({ ...this.nuevaCita, id: response.data.result.id }); // Asegúrate de que `id` se agregue
                this.resetFormulario(); // Limpiar el formulario después de agregar la cita
            } catch (error) {
                console.error('Error al crear la cita:', error);
            }
        },


        async actualizarCita() {
            try {
                const response = await axios.put(`http://localhost/veterinario-app/curso_apirest/citas/${this.citas[this.citaEditando].id}`, this.nuevaCita);
                this.citas.splice(this.citaEditando, 1, response.data); // Actualizar la cita en la lista
            } catch (error) {
                console.error('Error al actualizar la cita:', error);
            }
        },
        async eliminarCita(id, index) {
            if (confirm('¿Estás seguro de que quieres eliminar esta cita?')) {
                try {
                    await axios.delete(`http://localhost/veterinario-app/curso_apirest/citas/${id}`);
                    this.citas.splice(index, 1); // Eliminar la cita de la lista
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

.pulse {
    animation: pulse-animation 3s infinite;
}

@keyframes pulse-animation {
    0% {
        background-color: #fdd085;
    }

    25% {
        background-color: #fdd085;
    }

    50% {
        background-color: #ff738b;
    }

    100% {
        background-color: #fdd085;
    }
}

.fixed-form {
    position: fixed;
    top: 20px;
    right: 20px;
    width: 300px;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    padding: 15px;
    z-index: 1000;
}

/* Efecto de superposición para las citas */
.list-group-item {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin: 5px;
    height: 70px;
}

.list-group-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
</style>
