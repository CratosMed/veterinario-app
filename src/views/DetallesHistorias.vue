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
                        <!-- Imagen de perfil y nombre -->
                        <img src="https://via.placeholder.com/150" class="rounded-circle mb-3" alt="Profile Picture">
                        <h4>Benito</h4>
                    </div>

                    <!-- Sidebar Links -->
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'datos' }"
                                @click.prevent="setActiveSection('datos')">Datos del Paciente</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'parametros' }"
                                @click.prevent="setActiveSection('parametros')">Historial Clínico</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'vacunas' }"
                                @click.prevent="setActiveSection('vacunas')">Vacunas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'Antiparasitarios' }"
                                @click.prevent="setActiveSection('Antiparasitarios')">Antiparasitarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'Procedimiento' }"
                                @click.prevent="setActiveSection('Procedimiento')">Procedimiento</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'Examenes' }"
                                @click.prevent="setActiveSection('Examenes')">Examenes</a>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="text-primary">Nombre</h5>
                                        <p>{{ paciente.nombre || 'No disponible' }}</p>
                                        <h5 class="text-primary">Cliente</h5>
                                        <p>{{ paciente.nombre_propietario || 'No disponible' }}
                                        <p>CI: {{ paciente.cedula || 'No disponible' }}</p>
                                        </p>

                                        <h5 class="text-primary">Fecha de nacimiento</h5>
                                        <p>{{ paciente.fecha_nacimiento || 'No disponible' }}</p>
                                        <h5 class="text-primary">Edad</h5>
                                        <p>{{ paciente.edad || 'No disponible' }}</p>

                                    </div>
                                    <!-- Columna 2 -->
                                    <div class="col-md-6">
                                        <h5 class="text-primary">Especie</h5>
                                        <p>{{ paciente.genero || 'No disponible' }}</p>
                                        <h5 class="text-primary">Pelaje</h5>
                                        <p>{{ paciente.color || 'No disponible' }}</p>
                                        <h5 class="text-primary">Sexo</h5>
                                        <p>{{ paciente.sexo || 'No disponible' }}</p>

                                        <h5 class="text-primary">Comida que consume</h5>
                                        <p>Gatsy</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Card -->
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
                                    <div v-else>
                                        <div class="row">
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
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Campos adicionales del historial clínico si es necesario -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Card -->
                    </div>
                    <div v-if="activeSection === 'Antiparasitarios'">
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
                                <div class="row" v-if="!AntiparasitarioForm">
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

                    <!-- Historial Clinico -->
                    <div v-if="activeSection === 'parametros'">
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
                                <div v-if="!selectedParametro">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Motivo de consulta</th>
                                                <th>Diagnóstico</th>
                                                <th>Tratamiento</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="parametro in parametros" :key="parametro.id"
                                                @click="selectParametro(parametro)">
                                                <td>1991/07/01</td>
                                                <td>{{ parametro.motivo_consulta }}</td>
                                                <td>{{ parametro.diagnostico || 'no come' }}</td>
                                                <td>{{ parametro.tratamiento || 'complejo b' }}</td>


                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Detalles del Parámetro Seleccionado -->
                                <div v-if="selectedParametro">
                                    <div class="container mt-4">
                                        <h6>Datos Adicionales</h6>
                                        <div class="row">
                                            <!-- Columna 1 -->
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-primary">Fecha</h5>
                                                <p>{{ selectedParametro.fecha }}</p>

                                                <h5 class="text-primary">Motivo de consulta</h5>
                                                <p>{{ selectedParametro.motivoConsulta }}</p>
                                                <h5 class="text-primary">Veterianrio que lo derivo</h5>
                                                <p>{{ selectedParametro.motivoConsulta }}</p>
                                            </div>

                                            <!-- Columna 2 -->
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-primary">Diagnóstico</h5>
                                                <p>{{ selectedParametro.diagnostico }}</p>

                                                <h5 class="text-primary">Tratamiento</h5>
                                                <p>{{ selectedParametro.tratamiento }}</p>

                                                <h5 class="text-primary"> Anamnésticos</h5>
                                                <p>{{ selectedParametro.Anamnésticos }}</p>
                                            </div>
                                        </div>

                                        <h6 class="mt-4">Parámetros</h6>
                                        <div class="row">
                                            <!-- Columna 1 -->
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-primary">¿Tiene transfusiones?</h5>
                                                <p>{{ selectedParametro.transfusiones }}</p>
                                                <h5 class="text-primary">Reflejo tusígeno</h5>
                                                <p>{{ selectedParametro.reflejoTusigeno }}</p>
                                                <h5 class="text-primary">Temperatura</h5>
                                                <p>{{ selectedParametro.temperatura }}</p>
                                                <h5 class="text-primary">Palmopercusión</h5>
                                                <p>{{ selectedParametro.palmopercusion }}</p>
                                            </div>

                                            <!-- Columna 2 -->
                                            <div class="col-md-6 mb-3">
                                                <h5 class="text-primary">Frecuencia Respiratoria/min</h5>
                                                <p>{{ selectedParametro.frecuenciaRespiratoria }}</p>
                                                <h5 class="text-primary">Frecuencia cardíaca/min</h5>
                                                <p>{{ selectedParametro.frecuenciaCardiaca }}</p>
                                                <h5 class="text-primary">Presión Arterial</h5>
                                                <p>{{ selectedParametro.presionArterial }}</p>
                                                <h5 class="text-primary">Pulso/min</h5>
                                                <p>{{ selectedParametro.pulso }}</p>
                                                <h5 class="text-primary">Reflejo deglutorio</h5>
                                                <p>{{ selectedParametro.reflejoDeglutorio }}</p>
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
                                                <p>{{ selectedParametro.vulvarPrepucial }}</p>
                                                <h5 class="text-primary">Rectal</h5>
                                                <p>{{ selectedParametro.rectal }}</p>
                                                <h5 class="text-primary">Ojos</h5>
                                                <p>{{ selectedParametro.ojos }}</p>
                                                <h5 class="text-primary">Oídos</h5>
                                                <p>{{ selectedParametro.oidos }}</p>
                                                <h5 class="text-primary">Condición corporal</h5>
                                                <p>{{ selectedParametro.condicionCorporal }}</p>
                                                <h5 class="text-primary">Agresividad</h5>
                                                <p>{{ selectedParametro.agresividad }}</p>



                                            </div>

                                            <!-- Columna 2 -->
                                            <div class="col-md-4 mb-3">
                                                <h5 class="text-primary">Mucosa</h5>
                                                <p>{{ selectedParametro.mucosa }}</p>
                                                <h5 class="text-primary">Comida</h5>
                                                <p>{{ selectedParametro.comida }}</p>
                                                <h5 class="text-primary">Nódulos Linfáticos</h5>
                                                <p>{{ selectedParametro.nodulosLinfaticos }}</p>
                                                <h5 class="text-primary">Tonsilas</h5>
                                                <p>{{ selectedParametro.tonsilas }}</p>
                                                <h5 class="text-primary">Piel y Anexos</h5>
                                                <p>{{ selectedParametro.pielAnexos }}</p>
                                                <h5 class="text-primary">Locomoción</h5>
                                                <p>{{ selectedParametro.locomocion }}</p>
                                                <h5 class="text-primary">A. Musculoesquelético</h5>
                                                <p>{{ selectedParametro.musculoesqueletico }}</p>
                                                <h5 class="text-primary">Sistema Nervioso</h5>
                                                <p>{{ selectedParametro.sistemaNervioso }}</p>
                                                <h5 class="text-primary">Heces</h5>
                                                <p>{{ selectedParametro.Heces }}</p>
                                                <h5 class="text-primary">Estado Reproductivo</h5>
                                                <p>{{ selectedParametro.estadoreproductivo }}</p>
                                            </div>

                                            <!-- Columna 3 -->
                                            <div class="col-md-4 mb-3">
                                                <h5 class="text-primary">A. Cardiovascular</h5>
                                                <p>{{ selectedParametro.cardiovascular }}</p>
                                                <h5 class="text-primary">A. Respiratorio</h5>
                                                <p>{{ selectedParametro.respiratorio }}</p>
                                                <h5 class="text-primary">A. Digestivo</h5>
                                                <p>{{ selectedParametro.digestivo }}</p>
                                                <h5 class="text-primary">A. Genitourinario</h5>
                                                <p>{{ selectedParametro.genitourinario }}</p>
                                                <h5 class="text-primary">Constantes fisiológicas</h5>
                                                <p>{{ selectedParametro.constantesFisiologicas }}</p>
                                                <h5 class="text-primary">A. Reproductor</h5>
                                                <p>{{ selectedParametro.cardiovascular }}</p>
                                                <h5 class="text-primary">Orina</h5>
                                                <p>{{ selectedParametro.Orina }}</p>
                                                <h5 class="text-primary">Estado de deshidratación</h5>
                                                <p>{{ selectedParametro.estadoDeshidratacion }}</p>
                                                <h5 class="text-primary">Último Celo</h5>
                                                <p>{{ selectedParametro.ultimoCelo }}</p>
                                            </div>
                                        </div>


                                        <!-- End of Card -->
                                    </div>
                                    <ParametroVue v-if="selectedParametro2" />
                                    <!-- End of Card -->
                                </div>

                            </div>
                        </div>
                    </div>
                    <div v-if="activeSection === 'Procedimiento'">
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
                                <div class="row" v-if="!isProcedimientosFormVisible">
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

                    <div v-if="activeSection === 'Examenes'">
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
                                <div class="row" v-if="!isExamenesForm">
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
                                                    <td>Perfil 20</td>
                                                    <td>Todo normal</td>
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
            mostrarParametros: false,
            parametros: [
                // Datos de ejemplo
                //{ id: 1, fecha: '05/05/2024', nombre: 'Parámetro 1', peso: '3.6kg', temperatura: '38.5°C', hidratacion: 'Normal', pulso: '80 bpm', frecuenciaCardiaca: '120 bpm', frecuenciaRespiratoria: '20 rpm', mucosas: 'Normal', llenadoCapilar: '2 seg', presionArterial: '120/80 mmHg', reflejoDeglutorio: 'Normal', linfonodos: 'Normal', reflejoTugiseno: 'Normal', palpacionAbdominal: 'Normal', palmopercusion: 'Normal', condicionCorporal: 'Obeso', tonsilas: 'Normal', conciencia: 'Alerta', anamnesis: 'Sin novedades', estadoReproductivo: 'Normal', constantesFisiologicas: 'Asténico', comida: 'Conejarina' }
                // Más parámetros aquí
            ],
            paciente: [], // Datos del paciente
            historial: [],  // Historial del paciente
            vacunas: [],    // Vacunas del paciente
            antiparasitarios: [], // Datos de antiparasitarios
            Procedimientos: [],
            examenes: [], // Datos de antiparasitarios
            // Datos de antiparasitarios
            selectedParametro2: false,
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
            this.$router.push('/nuevavisita');
        },
        selectParametro(parametro) {
            this.selectedParametro = parametro;
        },
        Parametros() {
            this.selectedParametro2 = true;
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
                this.activeSection = section; // Actualiza con la nueva sección
            });
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
                } else if (seccion === 'historial') {
                    const response = await axios.get(`https://api.example.com/pacientes/${this.id}/historial`);
                    this.historial = response.data;
                } else if (seccion === 'vacunas') {
                    this.isVacunasFormVisible = false
                    //const response = await axios.get(`https://api.example.com/pacientes/${this.id}/vacunas`);
                    //this.vacunas = response.data;
                } else if (seccion === 'antiparasitarios') {
                    const response = await axios.get(`https://api.example.com/pacientes/${this.id}/antiparasitarios`);
                    this.antiparasitarios = response.data;
                } else if (seccion === 'parametros') {
                    const response = await axios.get(`http://localhost/veterinario-app/curso_apirest/historias?id=${this.id}`);
                    const data = response.data;
                    // Asegúrate de que los datos siempre sean un array
                    this.parametros = Array.isArray(data) ? data : [];
                    console.log(this.parametros);  // Verifica qué datos estás recibiendo
                } else if (seccion === 'Procedimiento') {

                } else if (seccion === 'examenes') {

                }
            } catch (error) {
                console.error('Error al cargar los datos:', error);
            }
        }
    }
};
</script>


<style scoped>
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
</style>
