<template>
    <div>
        <br />
        <div class="d-flex justify-content-between align-items-center mb-3 py-2">
            <h2 class="text-primary me-auto">Detalles Clientes</h2>
        </div>

        <div class="container-fluid alto">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-2 bg-light">
                    <div class="text-center">

                        <!-- Sidebar --><br>
                        <!-- Sidebar --><br>
                        <h4>{{ cliente.nombre }}</h4>
                    </div>
                    <br>
                    <!-- Sidebar --><br>
                    <!-- Sidebar --><br>
                    <!-- Sidebar Links -->
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'datos' }"
                                @click="activeSection = 'datos'">Datos del Cliente</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'pacientesRelacionados' }"
                                @click="activeSection = 'pacientesRelacionados'">Pacientes del Cliente</a>
                        </li>

                    </ul>
                    <br />
                </div>

                <!-- Main Content -->
                <div class="col-md-10 p-4">
                    <!-- Card Containing Client Details -->
                    <div v-if="activeSection === 'datos'">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-4 col-sm-6">
                                        <h5>Nombre</h5>
                                        <p>{{ cliente.nombre }}</p>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <h5>Apellido</h5>
                                        <p>{{ cliente.apellido }}</p>
                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-md-4 col-sm-6">
                                        <h5>Cédula</h5>
                                        <p>{{ cliente.cedula }}</p>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <h5>E-mail</h5>
                                        <p>{{ cliente.correo }}</p>
                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-md-4 col-sm-6">
                                        <h5>Teléfono Móvil</h5>
                                        <p>{{ cliente.telefono }}</p>
                                    </div>

                                    <div class="col-md-4 col-sm-6">
                                        <h5>Deuda</h5>
                                        <p>{{ cliente.deuda }}</p>
                                    </div>

                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-md-4 col-sm-6">
                                        <h5>Dirección</h5>
                                        <p>{{ cliente.direccion }}</p>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                    </div>
                                </div>



                            </div>

                        </div>


                    </div>
                    <div v-if="activeSection === 'pacientesRelacionados'">
                        <div class="card shadow-sm">
                            <div class="card-body hovertable-responsive">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="text-primary me-auto">Pacientes Relacionados</h5>
                                </div>

                                <!-- Table of related patients -->
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Nombre</th>
                                                <th class="text-center">Especie</th>
                                                <th class="text-center">Pelaje</th>
                                                <th class="text-center">Sexo</th>
                                                <th class="text-center">Citas</th>
                                                <th class="text-center">Notificar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="parametro in parametros" :key="parametro.id"
                                                @click="selectParametro(parametro)" class="table-row">
                                                <td class="text-center">{{ parametro.nombre }}</td>
                                                <td class="text-center">{{ parametro.especie || 'No disponible' }}
                                                </td>
                                                <td class="text-center">{{ parametro.color || 'No disponible' }}
                                                </td>
                                                <td class="text-center">{{ parametro.sexo || 'No disponible' }}</td>
                                                <td class="text-center citas-columna">
                                                    <div v-for="cita in parametro.citas" :key="cita.id"
                                                        class="d-flex align-items-center mb-2">
                                                        <span class="badge bg-danger rounded-pill me-2">{{ cita.dia
                                                            }}</span>
                                                        <div class="text-truncate" style="max-width: 150px;">
                                                            <strong>{{ cita.evento }}</strong>
                                                            <div class="text-muted">{{ cita.hora }} {{
                                                                cita.recurrencia }}</div>
                                                        </div>
                                                        <span
                                                            :class="['badge', cita.recurrencia === 'every week' ? 'bg-success' : 'bg-danger']"></span>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a :href="`https://web.whatsapp.com/send?phone=${parametro.telefono}&text=Hola%20${encodeURIComponent(parametro.Nombre)},%20te%20habla%20la%20veterinaria%20Inversiones%20Caru.%20Te%20recordamos%20la%20cita%20que%20tienes%20hoy.%20Te%20esperamos,%20tu%20salud%20es%20nuestra%20prioridad.`"
                                                        target="_blank" rel="noopener noreferrer"
                                                        aria-label="Notificar a través de WhatsApp">
                                                        <i class="fab fa-whatsapp fa-2x text-success"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import axios from 'axios';

export default {
    name: 'DetallesClientes',
    data() {
        return {
            activeSection: null,
            cliente: [],
            parametros: [], // Aquí cargarás tus pacientes relacionados
            pacientesRelacionados: true
        };
    },
    mounted() {
        // Obtener el ID de la URL
        this.id = this.$route.params.id;
        // Cargar los datos iniciales (datos del paciente)
        this.cargarSeccion('datos');

    },
    watch: {
        activeSection(newSection) {
            this.cargarSeccion(newSection);
            console.log(newSection)
        }
    },
    methods: {
        setActiveSection(section) {
            this.activeSection = null; // Resetea la sección activa primero
            this.$nextTick(() => {
                this.activeSection = section.toLowerCase();// Actualiza con la nueva sección
            });
            console.log(this.activeSection)
        },

        async cargarSeccion(seccion) {
            this.activeSection = seccion;

            try {
                if (seccion === 'datos') {
                    const response = await axios.get(`http://localhost/veterinario-app/curso_apirest/propietarios?id=${this.id}`);
                    const data = response.data;
                    console.log(data); // Verifica aquí la respuesta

                    // Asigna el cliente correctamente dependiendo del formato de la respuesta
                    this.cliente = Array.isArray(data) ? data[0] : data;
                } else if (seccion === 'pacientesRelacionados') {
                    this.pacientesRelacionados = true;
                    try {
                        const response = await axios.get(`http://localhost/veterinario-app/curso_apirest/pacientes?propietario_id=${this.id}`); // Reemplaza con la URL de tu API
                        this.parametros = response.data; // Asumiendo que la respuesta contiene un array de pacientes
                        console.log(this.parametros)
                    } catch (error) {
                        console.error('Error al obtener pacientes:', error);
                    }
                }
            } catch (error) {
                console.error('Error al cargar los datos:', error.response ? error.response.data : error.message);
            }
        },



    }
};
</script>

<style scoped>
.text-success {
    color: #25D366;
    /* Color verde de WhatsApp */
}

.alto {
    margin-top: 5%;
}

.nav-link.active {
    background-color: #e0f7fa;
    font-weight: bold;
}

.text-primary {
    color: #7b47da;
    font-weight: bold;
    border-left: 3px solid #7b47da;
    padding-left: 10px;
}

h5 {
    margin-bottom: 0.5rem;
}

p {
    margin-bottom: 1.5rem;
}

.card {
    border-radius: 10px;
    padding: 20px;
    background-color: #fff;
}

.card-body {
    padding: 20px;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.container-fluid {
    background-color: #e8f0fc;
}

/* Styles for table */
.table td,
.table th {
    text-align: center;
}

.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 150px;
    /* Puedes ajustar este valor si es necesario */
}

.text-center {
    text-align: center;
}

.citas-columna {
    vertical-align: middle;
}
</style>
