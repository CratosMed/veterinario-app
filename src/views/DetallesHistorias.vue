<template>
    <div>
        <br />
        <div class="d-flex justify-content-between align-items-center mb-3  py-2">
            <h2 class="text-primary me-auto">Detalles de Historia </h2>
        </div>

        <div class="container-fluid alto">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-2 bg-light">
                    <div class="text-center">

                        <img :src="`http://192.168.10.1/veterinario-app/curso_apirest/${paciente.foto}`"
                            class="image-responsive mb-3" alt="Profile Picture">
                        <h4>{{ paciente.nombre }}</h4>



                    </div>

                    <!-- Sidebar Links -->
                    <ul class="nav flex-column sidebar-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'datos' }"
                                @click.prevent="setActiveSection('datos')">Datos del Paciente</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'historial' }"
                                @click.prevent="setActiveSection('historial')">Historial Clínico</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'vacunas' }"
                                @click.prevent="setActiveSection('vacunas')">Vacunas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'antiparasitarios' }"
                                @click.prevent="setActiveSection('antiparasitarios')">Antiparasitarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'procedimientos' }"
                                @click.prevent="setActiveSection('procedimientos')">Procedimiento</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'examenes' }"
                                @click.prevent="setActiveSection('examenes')">Examenes</a>
                        </li>
                    </ul>

                </div>
                <!-- Main Content -->
                <div class="col-md-10 p-4">
                    <!-- Card Containing Patient Details -->
                    <div v-if="activeSection === 'datos'">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <!-- Sección de Detalles del Paciente -->
                                <div class="row justify-content-center">
                                    <!-- Use justify-content-center to center the row -->
                                    <div class="col-md-4 col-sm-6 ">
                                        <!-- Add text-center class for centering -->
                                        <h5 class="text-primary">Fecha</h5>
                                        <p>{{ paciente.fecha || 'No disponible' }}</p>
                                        <h5 class="text-primary">Nombre</h5>
                                        <p>{{ paciente.nombre || 'No disponible' }}</p>
                                        <h5 class="text-primary">Cliente</h5>
                                        <p>{{ paciente.nombre_propietario || 'No disponible' }}</p>
                                        <p>CI: {{ paciente.cedula || 'No disponible' }}</p>

                                        <h5 class="text-primary">Fecha de nacimiento</h5>
                                        <p>{{ paciente.fecha_nacimiento || 'No disponible' }}</p>
                                        <h5 class="text-primary">Edad</h5>
                                        <p>{{ form.anos || 'No disponible' }}</p>
                                    </div>

                                    <!-- Columna 2 -->
                                    <div class="col-md-4 col-sm-6 ">
                                        <!-- Add text-center class for centering -->
                                        <h5 class="text-primary">Especie</h5>
                                        <p>{{ paciente.especie || 'No disponible' }}</p>
                                        <h5 class="text-primary">Raza</h5>
                                        <p>{{ paciente.raza || 'No disponible' }}</p>
                                        <h5 class="text-primary">Pelaje</h5>
                                        <p>{{ paciente.color || 'No disponible' }}</p>
                                        <h5 class="text-primary">Sexo</h5>
                                        <p>{{ paciente.sexo || 'No disponible' }}</p>
                                        <h5 class="text-primary">Alergías</h5>
                                        <p>{{ paciente.alergias || 'No disponible' }}</p>

                                    </div>
                                </div>
                            </div>
                            <!-- End of Card -->
                        </div>
                    </div>

                    <div>
                        <div v-if="activeSection === 'vacunas'">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="text-primary me-auto">Vacunas</h5>
                                        <button type="button" @click="vacunasTrue()" class="btn btn-secondary">
                                            Nueva vacuna
                                        </button>
                                    </div>
                                    <!-- Mostrar el componente de formulario de vacunas cuando 'isVacunasFormVisible' sea true -->
                                    <div v-if="isVacunasFormVisible">
                                        <VacunasForm />
                                    </div>
                                    <!-- Mostrar la tabla solo si el formulario no está visible -->
                                    <div v-else class="table-responsive">
                                        <div class="col-md-6 col-lg-12">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Tipo de vacuna</th>
                                                        <th scope="col">Número_serie</th>
                                                        <th scope="col">Dosis</th>
                                                        <th scope="col">Peso</th>
                                                        <th scope="col">Descripción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="vacuna in vacunas" :key="vacuna.id">
                                                        <th scope="row">{{ vacuna.fecha }}</th>
                                                        <td>{{ vacuna.tipo }}</td>
                                                        <td>{{ vacuna.numero_serie }}</td>
                                                        <td>{{ vacuna.dosis }}</td>
                                                        <td>{{ vacuna.peso }}</td>
                                                        <td>{{ vacuna.descripcion }}</td>
                                                        <td><button @click.stop="eliminarVacuna(vacuna)"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash"></i>
                                                            </button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Campos adicionales del historial clínico si es necesario -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Card -->
                    </div>
                    <div v-if="activeSection === 'antiparasitarios'">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="text-primary me-auto">Registro de Antiparasitarios
                                    </h5>
                                    <button type="button" @click="AntiparasitarioFormTrue()"
                                        class="btn btn-secondary">Nuevo
                                        Antiparasitarios
                                    </button>
                                </div>
                                <div v-if="AntiparasitarioForm">
                                    <AntiparasitarioForm />
                                </div>
                                <!-- Sección historial clínico -->
                                <div v-else class="table-responsive">
                                    <div class="col-md-6 col-lg-12">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Tipo de vacuna</th>
                                                    <th scope="col">Número_serie</th>
                                                    <th scope="col">Dosis</th>
                                                    <th scope="col">Peso</th>
                                                    <th scope="col">Descripción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(antiparasitario, index) in antiparasitarios" :key="index">
                                                    <th scope="row">{{ antiparasitario.fecha }}</th>
                                                    <td>{{ antiparasitario.tipo }}</td>
                                                    <td>{{ antiparasitario.numero_serie }}</td>
                                                    <td>{{ antiparasitario.dosis }}</td>
                                                    <td>{{ antiparasitario.peso }}</td>
                                                    <td>{{ antiparasitario.descripcion }}</td>
                                                    <td><button @click.stop="eliminarAntiparasitario(antiparasitario)"
                                                            class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash"></i>
                                                        </button></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- Agrega más campos según sea necesario -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Card -->
                    </div>

                    <div v-if="activeSection === 'historial'">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="text-primary me-auto">Visitas</h5>
                                    <div class="d-flex gap-2">
                                        <button type="button" @click="NuevaVisita()" class="btn btn-secondary">
                                            <i class="bi bi-plus me-2"></i> Nueva visita
                                        </button>
                                    </div>
                                </div>
                                <!-- Tabla de Parámetros -->
                                <div v-if="!mostrarhistorial" class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Motivo de consulta</th>
                                                <th>Diagnóstico</th>
                                                <th>Tratamiento</th>
                                                <th>Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="historia in historial" :key="historia.id"
                                                @click="selectParametro(historia)">
                                                <td>{{ historia.fecha }}</td>
                                                <td>{{ historia.motivo_consulta }}</td>
                                                <td>{{ historia.diagnostico || '' }}</td>
                                                <td>{{ historia.tratamiento || '' }}</td>
                                                <td>{{ historia.observaciones || '' }}</td>
                                                <td>
                                                    <button @click.stop="EditarVisita(historia.id)"
                                                        class="btn btn-warning btn-sm me-1">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button @click.stop="eliminarHistoria(historia)"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Detalles del Parámetro Seleccionado -->
                                <div v-if="mostrarhistorial">
                                    <div class="container mt-4">
                                        <h6>Datos Adicionales</h6>
                                        <div class="row">
                                            <!-- Columna 1 -->
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-primary">Fecha</h5>
                                                <p>{{ selectedParametro.fecha }}</p>
                                                <h5 class="text-primary">Motivo de consulta</h5>
                                                <p>{{ selectedParametro.motivo_consulta }}</p>
                                                <h5 class="text-primary">Veterinario que lo derivó</h5>
                                                <p>{{ selectedParametro.veterinario }}</p>
                                            </div>

                                            <!-- Columna 2 -->
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-primary">Diagnóstico</h5>
                                                <p>{{ selectedParametro.diagnostico }}</p>
                                                <h5 class="text-primary">Tratamiento</h5>
                                                <p>{{ selectedParametro.tratamiento }}</p>
                                                <h5 class="text-primary">Anamnesicos</h5>
                                                <p>{{ selectedParametro.anamnesicos }}</p>
                                                <h5 class="text-primary">Observaciones</h5>
                                                <p>{{ selectedParametro.observaciones }}</p>
                                            </div>
                                        </div>

                                        <h6 class="mt-4">Parámetros</h6>
                                        <div class="row">
                                            <!-- Columna 1 -->
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-primary">¿Tiene transfusiones?</h5>
                                                <p>{{ selectedParametro.transfusiones }}</p>
                                                <h5 class="text-primary">Reflejo tusígeno</h5>
                                                <p>{{ selectedParametro.reflejo_tusigeno }}</p>
                                                <h5 class="text-primary">Temperatura</h5>
                                                <p>{{ selectedParametro.temperatura }}</p>
                                            </div>

                                            <!-- Columna 2 -->
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-primary">Frecuencia Respiratoria/min</h5>
                                                <p>{{ selectedParametro.frecuencia_respiratoria }}</p>
                                                <h5 class="text-primary">Frecuencia cardíaca/min</h5>
                                                <p>{{ selectedParametro.frecuencia_cardiaca }}</p>
                                                <h5 class="text-primary">Presión Arterial</h5>
                                                <p>{{ selectedParametro.presion_arterial }}</p>
                                                <h5 class="text-primary">Reflejo deglutorio</h5>
                                                <p>{{ selectedParametro.reflejo_deglutorio }}</p>
                                            </div>
                                        </div>

                                        <h6 class="mt-4">Exploración Física</h6>
                                        <div class="row">
                                            <!-- Columna 1 -->
                                            <div class="col-md-4 mb-3">
                                                <h5 class="text-primary">Peso</h5>
                                                <p>{{ selectedParametro.peso }}</p>
                                                <h5 class="text-primary">Oral</h5>
                                                <p>{{ selectedParametro.oral }}</p>
                                                <h5 class="text-primary">Vulvar/Prepucial</h5>
                                                <p>{{ selectedParametro.vulvar_prepucial }}</p>
                                                <h5 class="text-primary">Rectal</h5>
                                                <p>{{ selectedParametro.rectal }}</p>
                                                <h5 class="text-primary">Ojos</h5>
                                                <p>{{ selectedParametro.ojos }}</p>
                                                <h5 class="text-primary">Oídos</h5>
                                                <p>{{ selectedParametro.oidos }}</p>
                                                <h5 class="text-primary">Condición corporal</h5>
                                                <p>{{ selectedParametro.condicion_corporal }}</p>
                                                <h5 class="text-primary">Agresividad</h5>
                                                <p>{{ selectedParametro.actitud }}</p>
                                                <h5 class="text-primary">Señas Particulares</h5>
                                                <p>{{ selectedParametro.senas_particulares }}</p>

                                            </div>

                                            <!-- Columna 2 -->
                                            <div class="col-md-4 mb-3">
                                                <h5 class="text-primary">Mucosa</h5>
                                                <p>{{ selectedParametro.mucosa }}</p>
                                                <h5 class="text-primary">Comida</h5>
                                                <p>{{ selectedParametro.comida }}</p>
                                                <h5 class="text-primary">Nódulos Linfáticos</h5>
                                                <p>{{ selectedParametro.nodulos }}</p>
                                                <h5 class="text-primary">Piel y Anexos</h5>
                                                <p>{{ selectedParametro.piel_anexos }}</p>
                                                <h5 class="text-primary">Locomoción</h5>
                                                <p>{{ selectedParametro.locomocion }}</p>
                                                <h5 class="text-primary">S. Musculoesquelético</h5>
                                                <p>{{ selectedParametro.sistema_musculoesqueletico }}</p>
                                                <h5 class="text-primary">Sistema Nervioso</h5>
                                                <p>{{ selectedParametro.sistema_nervioso }}</p>
                                                <h5 class="text-primary">Heces</h5>
                                                <p>{{ selectedParametro.heces }}</p>
                                                <h5 class="text-primary">Estado Reproductivo</h5>
                                                <p>{{ selectedParametro.estado_reproductivo }}</p>
                                            </div>

                                            <!-- Columna 3 -->
                                            <div class="col-md-4 mb-3">
                                                <h5 class="text-primary">S. Cardiovascular</h5>
                                                <p>{{ selectedParametro.sistema_cardiovascular }}</p>
                                                <h5 class="text-primary">S. Respiratorio</h5>
                                                <p>{{ selectedParametro.sistema_respiratorio }}</p>
                                                <h5 class="text-primary">S. Digestivo</h5>
                                                <p>{{ selectedParametro.sistema_digestivo }}</p>
                                                <h5 class="text-primary">S. Genitourinario</h5>
                                                <p>{{ selectedParametro.sistema_genitourinario }}</p>
                                                <h5 class="text-primary">Constantes fisiológicas</h5>
                                                <p>{{ selectedParametro.constantes_fisiologicas }}</p>
                                                <h5 class="text-primary">S. Reproductor</h5>
                                                <p>{{ selectedParametro.sistema_reproductor }}</p>
                                                <h5 class="text-primary">Orina</h5>
                                                <p>{{ selectedParametro.orina }}</p>
                                                <h5 class="text-primary">Estado de deshidratación</h5>
                                                <p>{{ selectedParametro.estado_deshidratacion }}</p>
                                                <h5 class="text-primary">Último Celo</h5>
                                                <p>{{ selectedParametro.ultimo_celo }}</p>
                                                <h5 class="text-primary">Último Parto</h5>
                                                <p>{{ selectedParametro.ultimo_parto }}</p>
                                            </div>
                                        </div>

                                        <!-- End of Card -->
                                    </div>
                                </div>

                                <ParametroVue v-if="selectedParametro2" />
                                <!-- End of Card -->
                            </div>
                        </div>
                    </div>

                    <div v-if="activeSection === 'procedimientos'">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="text-primary me-auto"> Procedimientos</h5>
                                    <button type="button" @click="ProcedimientoTrue()" class="btn btn-secondary">Nuevos
                                        Procedimientos</button>
                                </div>
                                <div v-if="isProcedimientosFormVisible">
                                    <ProcedimientosForm />
                                </div>
                                <!-- Sección parámetros -->
                                <div v-else class="table-responsive">
                                    <div class="col-md-6 col-lg-12">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col"> Anestesiólogo</th>
                                                    <th scope="col">Cirujano</th>
                                                    <th scope="col">Valoración ASA</th>
                                                    <th scope="col">Peso del paciente (kg)</th>
                                                    <th scope="col">Procedimiento</th>
                                                    <th scope="col">Patologías</th>
                                                    <th scope="col">Medicación las últimas 24 horas</th>
                                                    <th scope="col">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="procedimiento in procedimientos" :key="procedimiento.id">
                                                    <th scope="row">{{ procedimiento.fecha }}</th>
                                                    <td>{{ procedimiento.anestesiologo }}</td>
                                                    <td>{{ procedimiento.cirujano }}</td>
                                                    <td>{{ procedimiento.valoracion_asa }}</td>
                                                    <td>{{ procedimiento.peso }}</td>
                                                    <td>{{ procedimiento.procedimiento }}</td>
                                                    <td>{{ procedimiento.patologias }}</td>
                                                    <td>{{ procedimiento.medicacion }}</td>
                                                    <td>{{ procedimiento.observaciones }}</td>
                                                    <td><button @click.stop="eliminarProcedimiento(procedimiento)"
                                                            class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash"></i>
                                                        </button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Card -->
                        </div>
                    </div>

                    <div v-if="activeSection === 'examenes'">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="text-primary me-auto"> Exámenes</h5>
                                    <button type="button" @click="ExamenesTrue()" class="btn btn-secondary">Nuevos
                                        Exámenes</button>
                                </div>
                                <div v-if="isExamenesForm">
                                    <ExamenesForm />
                                </div>
                                <!-- Sección de la tabla -->
                                <div v-else class="table-responsive">
                                    <div class="col-md-12 col-lg-12">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Tipo de Examen</th>
                                                    <th scope="col">Descripción</th>
                                                    <th scope="col">Imágenes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="examene in examenes" :key="examene.id">
                                                    <th scope="row">{{ examene.fecha }}</th>
                                                    <td>{{ examene.tipo }}</td>
                                                    <td>{{ examene.descripcion }}</td>
                                                    <td>
                                                        <button @click="verImagen(examene.foto)" class="btn btn-link">
                                                            <i class="fas fa-eye"></i> <!-- Ícono de ojo -->
                                                        </button>
                                                    </td>
                                                    <td><button @click.stop="eliminarExamene(examene)"
                                                            class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash"></i>
                                                        </button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Card -->
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</template>

<script>
import NuevaVisita from '../views/NuevaVisita.vue';
import ParametroVue from '../components/ParametroVue.vue';
import VacunasForm from '../components/VacunasForm.vue';
import AntiparasitarioForm from '../components/AntiparasitarioForm.vue';
import ProcedimientosForm from '../components/ProcedimientosForm.vue';
import ExamenesForm from '../components/ExamenesForm.vue';
import axios from 'axios';


export default {

    name: 'DetallesHistorias',

    components: {
        NuevaVisita,
        ParametroVue,
        VacunasForm,
        AntiparasitarioForm,
        ProcedimientosForm,
        ExamenesForm
    },

    data() {
        return {
            form: {
                anos: ''
            },
            activeSection: null,
            mostrarhistorial: false,
            historial: [],
            paciente: [],
            vacunas: [],
            antiparasitarios: [], // Asegúrate de que esta línea está presente
            procedimientos: [],
            examenes: [],
            isVacunasFormVisible: null,
            AntiparasitarioForm: null,
            isProcedimientosFormVisible: null,
            isExamenesForm: null,

        };

    },
    mounted() {
        // Obtener el ID de la URL
        this.id = this.$route.params.id;

        const hash = this.$route.hash;
        if (hash) {
            const section = hash.replace('#', ''); // Extrae el nombre de la sección sin el #           
            this.activeSection = section; // Asigna la sección a 'activeSection' para cargarla

        } else {
            // Cargar los datos iniciales (datos del paciente)
            this.cargarSeccion('datos');
        }
        this.obtenerPacientes();

    },
    watch: {
        activeSection(newSection) {
            this.cargarSeccion(newSection);
            console.log(newSection)
        }
    },
    methods: {
        async obtenerPacientes() {
            const response = await axios.get(`http://192.168.10.1/veterinario-app/curso_apirest/pacientes?id=${this.id}`);
            const data = response.data;
            // Asegúrate de que la respuesta es una lista y toma el primer elemento
            this.paciente = Array.isArray(data) ? data[0] : null;
            if (this.paciente) {
                this.paciente.edad = this.calcularEdad(this.paciente.fecha_nacimiento);
            }
            console.log(this.paciente);
        },
        // Lógica para eliminar una historia
        eliminarHistoria(historia) {
            // Preguntar confirmación
            if (confirm("¿Estás seguro de que quieres eliminar esta historia?")) {
                // Hacer la petición DELETE enviando el ID en el cuerpo
                console.log(historia.id)
                axios.delete('http://192.168.10.1/veterinario-app/curso_apirest/historias', {
                    data: { id: historia.id }
                })
                    .then(response => {
                        // Filtrar la historia eliminada de la lista
                        console.log(response)
                        this.historial = this.historial.filter(p => p.id !== historia.id);
                        alert("Historia eliminada con éxito.");
                    })
                    .catch(error => {
                        // Manejar errores
                        console.error("Error al eliminar la historia:", error);
                        alert("Ocurrió un error al eliminar la historia.");
                    });
            }
        },
        eliminarVacuna(vacuna) {
            // Preguntar confirmación
            if (confirm("¿Estás seguro de que quieres eliminar esta vacuna?")) {
                // Hacer la petición DELETE enviando el ID en el cuerpo
                console.log(vacuna.id)
                axios.delete('http://192.168.10.1/veterinario-app/curso_apirest/vacunas', {
                    data: { id: vacuna.id }
                })
                    .then(response => {
                        // Filtrar la vacuna eliminada de la lista
                        console.log(response)
                        this.vacunas = this.vacunas.filter(p => p.id !== vacuna.id);
                        alert("vacuna eliminada con éxito.");
                    })
                    .catch(error => {
                        // Manejar errores
                        console.error("Error al eliminar la vacuna:", error);
                        alert("Ocurrió un error al eliminar la vacuna.");
                    });
            }
        },
        eliminarAntiparasitario(antiparasitario) {
            // Preguntar confirmación
            if (confirm("¿Estás seguro de que quieres eliminar esta antiparasitario?")) {
                // Hacer la petición DELETE enviando el ID en el cuerpo
                console.log(antiparasitario.id)
                axios.delete('http://192.168.10.1/veterinario-app/curso_apirest/antiparasitarios', {
                    data: { id: antiparasitario.id }
                })
                    .then(response => {
                        // Filtrar la antiparasitario eliminada de la lista
                        console.log(response)
                        this.antiparasitarios = this.antiparasitarios.filter(p => p.id !== antiparasitario.id);
                        alert("antiparasitario eliminada con éxito.");
                    })
                    .catch(error => {
                        // Manejar errores
                        console.error("Error al eliminar la antiparasitario:", error);
                        alert("Ocurrió un error al eliminar la antiparasitario.");
                    });
            }
        },
        eliminarProcedimiento(procedimiento) {
            // Preguntar confirmación
            if (confirm("¿Estás seguro de que quieres eliminar esta procedimiento?")) {
                // Hacer la petición DELETE enviando el ID en el cuerpo
                console.log(procedimiento.id)
                axios.delete('http://192.168.10.1/veterinario-app/curso_apirest/procedimientos', {
                    data: { id: procedimiento.id }
                })
                    .then(response => {
                        // Filtrar la procedimiento eliminada de la lista
                        console.log(response)
                        this.procedimientos = this.procedimientos.filter(p => p.id !== procedimiento.id);
                        alert("procedimiento eliminada con éxito.");
                    })
                    .catch(error => {
                        // Manejar errores
                        console.error("Error al eliminar la procedimiento:", error);
                        alert("Ocurrió un error al eliminar la procedimiento.");
                    });
            }
        },
        eliminarExamene(examene) {
            // Preguntar confirmación
            if (confirm("¿Estás seguro de que quieres eliminar esta examene?")) {
                // Hacer la petición DELETE enviando el ID en el cuerpo
                console.log(examene.id)
                axios.delete('http://192.168.10.1/veterinario-app/curso_apirest/examenes', {
                    data: { id: examene.id }
                })
                    .then(response => {
                        // Filtrar la examene eliminada de la lista
                        console.log(response)
                        this.examenes = this.examenes.filter(p => p.id !== examene.id);
                        alert("examene eliminada con éxito.");
                    })
                    .catch(error => {
                        // Manejar errores
                        console.error("Error al eliminar la examene:", error);
                        alert("Ocurrió un error al eliminar la examene.");
                    });
            }
        },
        calcularEdad(fechaNacimiento) {
            if (fechaNacimiento) {
                const today = new Date();
                const birthDate = new Date(fechaNacimiento);

                // Cálculo de la diferencia en años
                let ageYears = today.getFullYear() - birthDate.getFullYear();
                let ageMonths = today.getMonth() - birthDate.getMonth();

                // Ajuste para años y meses si el mes o día actual es anterior al de nacimiento
                if (ageMonths < 0 || (ageMonths === 0 && today.getDate() < birthDate.getDate())) {
                    ageYears--;
                    ageMonths += 12; // Añade 12 meses para el ajuste si restamos un año
                }

                // Cálculo de meses cuando la edad es menor a 1 año
                const totalMonths = ageYears * 12 + ageMonths;
                if (totalMonths < 12) {
                    this.form.anos = ageMonths + " meses"

                } else {
                    this.form.anos = ageYears + " años" + " y " + ageMonths + " meses"
                }
            }



            const hoy = new Date();
            const nacimiento = new Date(fechaNacimiento);
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            const mes = hoy.getMonth() - nacimiento.getMonth();

            // Si el mes actual es menor que el mes de nacimiento o es el mismo mes pero el día actual es menor que el día de nacimiento, resta 1 año
            if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
                edad--;
            }

            return edad;
        },
        verImagen(foto) {
            if (foto) {
                // Concatenar la ruta base con el nombre de la imagen desde la base de datos
                const imagenUrl = `http://192.168.10.1/veterinario-app/curso_apirest/${foto}`;
                window.open(imagenUrl, '_blank'); // Abre la imagen en una nueva pestaña
            } else {
                alert('No hay imagen disponible.');
            }
        },
        NuevaVisita() {
            this.$router.push({ path: `/nuevavisita/paciente_id/${this.id}` });
        },
        EditarVisita($id) {
            this.$router.push({ path: `/nuevavisita/${$id}` });
        },
        selectParametro(historia) {
            this.selectedParametro = historia;
            this.mostrarhistorial = true
        },


        vacunasTrue() {
            // Mostrar el formulario de vacunas
            this.isVacunasFormVisible = true;
        },
        ocultarVacunasForm() {
            // Ocultar el formulario de vacunas
            this.isVacunasFormVisible = false;
        },
        AntiparasitarioFormTrue() {
            this.AntiparasitarioForm = true;
        },
        ocultarAntiparasitarioForm() {
            this.AntiparasitarioForm = false;
        },
        ProcedimientoTrue() {
            this.isProcedimientosFormVisible = true;
        },
        ocultarProcedimientosForm() {
            this.isProcedimientosFormVisible = false;
        },
        ExamenesTrue() {
            this.isExamenesForm = true;
        },
        ocultarExamenesForm() {
            this.isExamenesForm = false;
        },
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

                } else if (seccion === 'vacunas') {
                    this.isVacunasFormVisible = false;
                    // Hacer la llamada a la API para obtener las vacunas del paciente
                    const response = await axios.get(`http://192.168.10.1/veterinario-app/curso_apirest/vacunas?paciente_id=${this.id}`);
                    this.vacunas = response.data; // Asignar los datos de las vacunas
                } else if (seccion === 'antiparasitarios') {
                    this.AntiparasitarioForm = false;
                    const response = await axios.get(`http://192.168.10.1/veterinario-app/curso_apirest/antiparasitarios?paciente_id=${this.id}`);
                    this.antiparasitarios = response.data;
                } else if (seccion === 'historial') {
                    const response = await axios.get(`http://192.168.10.1/veterinario-app/curso_apirest/historias?paciente_id=${this.id}`);
                    const data = response.data;
                    // Asegúrate de que los datos siempre sean un array
                    this.historial = Array.isArray(data) ? data : [];
                    this.mostrarhistorial = false
                } else if (seccion === 'procedimientos') {
                    this.isProcedimientosFormVisible = false;
                    const response = await axios.get(`http://192.168.10.1/veterinario-app/curso_apirest/procedimientos?paciente_id=${this.id}`);
                    this.procedimientos = response.data;
                } else if (seccion === 'examenes') {
                    this.isExamenesForm = false
                    const response = await axios.get(`http://192.168.10.1/veterinario-app/curso_apirest/examenes?paciente_id=${this.id}`);
                    this.examenes = response.data;

                }
            } catch (error) {
                console.error('Error al cargar los datos:', error);
            }
        }
    }
};
</script>


<style scoped>
.image-responsive {
    width: 150px;
    /* o el tamaño que desees */
    height: 150px;
    /* o el tamaño que desees */
    object-fit: cover;
    /* Mantiene la proporción y recorta la imagen */
    border-radius: 50%;
    /* Hace que la imagen sea circular */
}

@media (max-width: 768px) {
    .image-responsive {
        max-width: 100%;
        /* Se asegura de que la imagen no exceda el ancho de su contenedor */
        height: auto;
        /* Mantiene la proporción de la imagen */
    }
}

@media (max-width: 1124px) {
    .image-responsive {
        max-width: 100%;
        /* Se asegura de que la imagen no exceda el ancho de su contenedor */
        height: auto;
        /* Mantiene la proporción de la imagen */
    }
}

.alto {
    margin-top: 1%;
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

/* Estilos generales para el menú */
.nav {
    padding: 0;
    /* Elimina el padding por defecto */
}

/* Estilos generales para el menú */
.nav {
    padding: 0;
    /* Elimina el padding por defecto */
}

/* Estilos para pantallas grandes (desktop) */
@media (min-width: 992px) {

    /* Pantallas más grandes */
    .sidebar-menu {
        position: relative;
        /* Se asegura de que el menú se mantenga en su lugar */
        display: flex;
        /* Por defecto, el menú es una fila */
        flex-direction: column;
        /* Coloca los elementos en columna */
    }
}

/* Estilos para pantallas de tablet (por ejemplo, 768px a 991px) */
@media (max-width: 991px) {
    .sidebar-menu {
        display: flex;
        /* Muestra el menú como una fila */
        flex-direction: column;
        /* Coloca los elementos en columna */
        align-items: flex-start;
        /* Alinea los elementos al inicio */
        width: 100%;
        /* Ocupará el 100% del ancho disponible */
    }

    .nav {
        margin-bottom: 15px;
        /* Espacio entre el menú y la imagen */
    }
}

/* Estilos para pantallas pequeñas (móviles) */
@media (max-width: 767px) {
    .sidebar-menu {
        display: block;
        /* El menú se verá como bloque */
    }

    .nav-link {
        padding: 10px;
        /* Ajusta el padding para que sea más cómodo en móviles */
        font-size: 16px;
        /* Aumenta el tamaño de fuente para que sea legible */
    }
}

.table-responsive {
    overflow-x: auto;
    /* Mantiene el comportamiento responsivo */
}

table {
    table-layout: fixed;
    /* Mantiene el ancho fijo de las celdas */
    width: 100%;
    /* Hace que la tabla ocupe el 100% del contenedor */
}

th,
td {
    white-space: normal;
    /* Permite que el contenido ocupe varias líneas */
    word-wrap: break-word;
    /* Fuerza al texto a ajustarse dentro de las celdas */
}

td {
    max-width: 150px;
    /* Ajusta este valor según el diseño para evitar la expansión */
}
</style>
