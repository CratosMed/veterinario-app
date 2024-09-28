<template>
    <div class="container">
        <h5 class="box-title mb-4">Citas</h5>
        <input type="text" v-model="search" placeholder="Buscar citas..." class="form-control mb-4" />

        <ul class="list-group">
            <li v-for="(cita, index) in citasFiltradas" :key="index"
                class="list-group-item d-flex justify-content-between align-items-start p-3 mb-2"
                :class="{ 'pulse': cita.fechaCompleta === hoy, 'custom-hover': true }"> <!-- Clase para efecto hover -->
                <div class="d-flex flex-column align-items-center me-3">
                    <span class="badge bg-danger rounded-pill">{{ cita.dia }}</span>
                    <small class="text-muted">{{ cita.diaSemana }}</small>
                </div>
                <div class="d-flex flex-column">
                    <h5 class="fw-bold">{{ cita.titulo }}</h5>
                    <h6 class=""> {{ cita.descripcion }}</h6>
                    <small>{{ cita.hora }} - {{ cita.recurrencia }}</small>
                </div>
                <div class="d-flex align-items-center">
                    <button class="btn btn-warning btn-circle me-2" @click="editarCita(index)">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-danger btn-circle" @click="eliminarCita(index)">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </li>
        </ul>

        <!-- Formulario de agregar cita -->
        <form v-if="mostrarFormulario" @submit.prevent="submitCita" class="mt-4 fixed-form">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título de la cita</label>
                <input type="text" class="form-control" v-model="nuevaCita.titulo" required />
            </div>
            <div class="mb-3">
                <label for="Paciente" class="form-label">Paciente</label>
                <select class="form-select" v-model="nuevaCita.Paciente">
                </select>
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Descripción</label>
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
export default {
    data() {
        return {
            hoy: new Date().toLocaleDateString('sv-SE'), // Formato 'YYYY-MM-DD'
            search: '',
            citas: [],
            nuevaCita: {
                titulo: '',
                paciente: '',
                descripcion: '',
                fecha: '',
                hora: '',
                recurrencia: 'una vez'
            },
            citaEditando: null,
            mostrarFormulario: false // Inicializa el formulario como oculto
        };
    },
    computed: {
        citasFiltradas() {
            return this.citas.filter(cita => cita.titulo.toLowerCase().includes(this.search.toLowerCase()));
        },
    },
    methods: {
        submitCita() {
            if (this.citaEditando !== null) {
                this.citas[this.citaEditando] = { ...this.nuevaCita, dia: this.getDia(this.nuevaCita.fecha), diaSemana: this.getDiaSemana(this.nuevaCita.fecha), fechaCompleta: this.nuevaCita.fecha };
                this.citaEditando = null;
            } else {
                this.citas.push({ ...this.nuevaCita, dia: this.getDia(this.nuevaCita.fecha), diaSemana: this.getDiaSemana(this.nuevaCita.fecha), fechaCompleta: this.nuevaCita.fecha });
            }
            this.resetFormulario();
        },
        getDia(fecha) {
            return new Date(fecha).getDate().toString().padStart(2, '0');
        },
        getDiaSemana(fecha) {
            const opciones = { weekday: 'short' };
            return new Intl.DateTimeFormat('es-ES', opciones).format(new Date(fecha)).toUpperCase();
        },
        resetFormulario() {
            this.nuevaCita = { titulo: '', fecha: '', hora: '', recurrencia: 'una vez' };
            if (this.citaEditando === null) {
                this.mostrarFormulario = false; // Ocultar solo cuando no estamos en modo edición
            }
        },
        editarCita(index) {
            this.nuevaCita = { ...this.citas[index] };
            this.citaEditando = index;
            this.mostrarFormulario = true; // Mostrar el formulario para editar
        },
        eliminarCita(index) {
            if (confirm('¿Estás seguro de que quieres eliminar esta cita?')) {
                this.citas.splice(index, 1);
            }
        },
        toggleFormulario() {
            if (!this.mostrarFormulario) {
                this.resetFormulario(); // Limpiar el formulario solo cuando lo vamos a mostrar
            }
            this.mostrarFormulario = !this.mostrarFormulario;
        }
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
        /* Naranja claro */
    }

    25% {
        background-color: #fdd085;
        /* Naranja claro */
    }

    50% {
        background-color: #ff738b;
        /* Color intermedio entre el naranja y el rosa */
    }

    100% {
        background-color: #fdd085;
        /* Naranja claro */
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
}

.list-group-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
</style>
