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

                        <img src="http://localhost/veterinario-app/curso_apirest/imagenes_pacientes/66f2fa5bdc5b5.png"
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
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'procedimiento' }"
                                @click.prevent="setActiveSection('procedimiento')">Procedimiento</a>
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
                                        <p>{{ paciente.edad || 'No disponible' }}</p>
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
                                                        <th scope="col">Marca y N° de vacuna</th>
                                                        <th scope="col">Observaciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">2024-09-15</th>
                                                        <td>Parvovirus</td>
                                                        <td>MarcaY - 67890</td>
                                                        <td>Vacuna administrada con leve fiebre post-inmunización
                                                        </td>
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
                                                    <th scope="col">Tipo de Antiparasitarios</th>
                                                    <th scope="col">Marca y N° de Antiparasitarios</th>
                                                    <th scope="col">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">2024-08-25</th>
                                                    <td>Antiparasitario A</td>
                                                    <td>ParasiteY</td>
                                                    <td>Sin efectos secundarios observados</td>
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
                                                <td>{{ historia.diagnostico || 'no come' }}</td>
                                                <td>{{ historia.tratamiento || 'complejo b' }}</td>
                                                <td>{{ historia.observaciones || 'complejo b' }}</td>
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
                                                <h5 class="text-primary">Antecedentes Familiares</h5>
                                                <p>{{ selectedParametro.antecedentes }}</p>
                                            </div>

                                            <!-- Columna 2 -->
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-primary">Diagnóstico</h5>
                                                <p>{{ selectedParametro.diagnostico }}</p>
                                                <h5 class="text-primary">Tratamiento</h5>
                                                <p>{{ selectedParametro.tratamiento }}</p>
                                                <h5 class="text-primary">Anamnésticos</h5>
                                                <p>{{ selectedParametro.anamnesticos }}</p>
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
                                                <h5 class="text-primary">Palmopercusión</h5>
                                                <p>{{ selectedParametro.palmopercusion }}</p>
                                            </div>

                                            <!-- Columna 2 -->
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-primary">Frecuencia Respiratoria/min</h5>
                                                <p>{{ selectedParametro.frecuencia_respiratoria }}</p>
                                                <h5 class="text-primary">Frecuencia cardíaca/min</h5>
                                                <p>{{ selectedParametro.frecuencia_cardíaca }}</p>
                                                <h5 class="text-primary">Presión Arterial</h5>
                                                <p>{{ selectedParametro.presion_arterial }}</p>
                                                <h5 class="text-primary">Pulso/min</h5>
                                                <p>{{ selectedParametro.pulso }}</p>
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
                                                <p>{{ selectedParametro.agresividad }}</p>
                                                <h5 class="text-primary">Señas Particulares</h5>
                                                <p>{{ selectedParametro.señas_particulares }}</p>
                                                <h5 class="text-primary">Alergias</h5>
                                                <p>{{ selectedParametro.alergias }}</p>
                                            </div>

                                            <!-- Columna 2 -->
                                            <div class="col-md-4 mb-3">
                                                <h5 class="text-primary">Mucosa</h5>
                                                <p>{{ selectedParametro.mucosa }}</p>
                                                <h5 class="text-primary">Comida</h5>
                                                <p>{{ selectedParametro.comida }}</p>
                                                <h5 class="text-primary">Nódulos Linfáticos</h5>
                                                <p>{{ selectedParametro.nodulos_linfaticos }}</p>
                                                <h5 class="text-primary">Tonsilas</h5>
                                                <p>{{ selectedParametro.tonsilas }}</p>
                                                <h5 class="text-primary">Piel y Anexos</h5>
                                                <p>{{ selectedParametro.piel_anexos }}</p>
                                                <h5 class="text-primary">Locomoción</h5>
                                                <p>{{ selectedParametro.locomocion }}</p>
                                                <h5 class="text-primary">S. Musculoesquelético</h5>
                                                <p>{{ selectedParametro.musculoesqueletico }}</p>
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

                    <div v-if="activeSection === 'procedimiento'">
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
                                                    <th scope="col">Patología preexistente</th>
                                                    <th scope="col">Medicación las últimas 24 horas</th>
                                                    <th scope="col">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">2024-09-12</th>
                                                    <td>Dr. Juan Pérez</td>
                                                    <td>Dr. Ana Gómez</td>
                                                    <td>Clase II</td>
                                                    <td>25.5</td>
                                                    <td>Diabetes Mellitus tipo 2</td>
                                                    <td>Insulina 10 UI, Paracetamol 500 mg</td>
                                                    <td>Procedimiento realizado sin complicaciones</td>
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
                                    <h5 class="text-primary me-auto"> Examenes</h5>
                                    <button type="button" @click="ExamenesTrue()" class="btn btn-secondary">Nuevos
                                        Examenes</button>
                                </div>
                                <div v-if="isExamenesForm">
                                    <ExamenesForm />
                                </div>
                                <!-- Sección parámetros -->
                                <div v-else class="table-responsive">
                                    <div class="col-md-6 col-lg-12">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col"> Tipo de Examenes</th>
                                                    <th scope="col">Observaciones</th>
                                                    <th scope="col">Imágenes</th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">2024-09-12</th>
                                                    <td>Perfil 20 </td>
                                                    <td>Todo normal Lorem, ipsum dolor sit amet consectetur adipisicing
                                                        elit. Itaque nisi amet odio? Placeat officiis illo, rem cum amet
                                                        repellat? Illum ut laboriosam numquam libero laudantium nemo
                                                        magnam inventore corporis similique.</td>
                                                    <td>agrega el link de la imagen aqui</td>

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
        <h2> arreglado por super conejoss :)</h2>
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
            activeSection: null,
            mostrarhistorial: false,
            historial: [
                // Datos de ejemplo
                //{ id: 1, fecha: '05/05/2024', nombre: 'Parámetro 1', peso: '3.6kg', temperatura: '38.5°C', hidratacion: 'Normal', pulso: '80 bpm', frecuenciaCardiaca: '120 bpm', frecuenciaRespiratoria: '20 rpm', mucosas: 'Normal', llenadoCapilar: '2 seg', presionArterial: '120/80 mmHg', reflejoDeglutorio: 'Normal', linfonodos: 'Normal', reflejoTugiseno: 'Normal', palpacionAbdominal: 'Normal', palmopercusion: 'Normal', condicionCorporal: 'Obeso', tonsilas: 'Normal', conciencia: 'Alerta', anamnesis: 'Sin novedades', estadoReproductivo: 'Normal', constantesFisiologicas: 'Asténico', comida: 'Conejarina' }
                // Más parámetros aquí
            ],
            paciente: [], // Datos del paciente

            vacunas: [],    // Vacunas del paciente
            antiparasitarios: [], // Datos de antiparasitarios
            Procedimientos: [],
            examenes: [], // Datos de antiparasitarios 

            isVacunasFormVisible: null,
            AntiparasitarioForm: null,
            isProcedimientosFormVisible: null,
            isExamenesForm: null,

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
        calcularEdad(fechaNacimiento) {
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
        NuevaVisita() {
            this.$router.push({ path: `/nuevavisita/${this.id}` });
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
                    const response = await axios.get(`http://localhost/veterinario-app/curso_apirest/pacientes?id=${this.id}`);
                    const data = response.data;
                    // Asegúrate de que la respuesta es una lista y toma el primer elemento
                    this.paciente = Array.isArray(data) ? data[0] : null;
                    if (this.paciente) {
                        this.paciente.edad = this.calcularEdad(this.paciente.fecha_nacimiento);
                    }
                    console.log(this.paciente);
                } else if (seccion === 'vacunas') {
                    this.isVacunasFormVisible = false
                    //const response = await axios.get(`https://api.example.com/pacientes/${this.id}/vacunas`);
                    //this.vacunas = response.data;
                } else if (seccion === 'antiparasitarios') {
                    this.AntiparasitarioForm = false
                    //   const response = await axios.get(`https://api.example.com/pacientes/${this.id}/antiparasitarios`);
                    //  this.antiparasitarios = response.data;
                } else if (seccion === 'historial') {
                    const response = await axios.get(`http://localhost/veterinario-app/curso_apirest/historias?paciente_id=${this.id}`);
                    const data = response.data;
                    // Asegúrate de que los datos siempre sean un array
                    this.historial = Array.isArray(data) ? data : [];
                    console.log(this.historial);  // Verifica qué datos estás recibiendo
                    console.log(this.id)
                    this.mostrarhistorial = false
                } else if (seccion === 'procedimiento') {
                    this.isProcedimientosFormVisible = false


                } else if (seccion === 'examenes') {
                    this.isExamenesForm = false


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
</style>
