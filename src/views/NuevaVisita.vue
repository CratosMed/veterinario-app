<template>
    <div>
        <br />
        <!-- Mensaje de éxito -->
        <div v-if="mensaje" class="alert alert-success">
            {{ mensaje }}
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3 sticky-top bg-white py-2">
            <!-- Botón de cerrar -->
            <h4 class="text-primary me-auto">Visita de :</h4>
            <button type="button" @click="guardarVisita()" class="btn btn-secondary">Guardar</button>
            <button type="button" @click="ishistorias" class="btn btn-danger m-2">✖</button>
        </div>
        <div class="mb-3">
            <label for="fechaActual" class="form-label">Fecha actual:</label>
            <input type="date" class="form-control" id="fechaActual" v-model="fechaActual" />
        </div>
        <div class="mb-3">
            <label for="Veterinario" class="form-label">Veterinario que lo derivó</label>
            <input type="text" class="form-control" id="Veterinario" v-model="Veterinario" />
        </div>
        <div class="mb-3">
            <label for="motivoConsulta" class="form-label">Motivo de la consulta</label>
            <textarea class="form-control" id="motivoConsulta" rows="3" v-model="motivoConsulta"></textarea>
        </div>
        <div class="mb-4">
            <label for="anamnesicos" class="form-label">Anamnésticos</label>
            <textarea class="form-control" id="anamnesicos" rows="3" v-model="anamnesicos"></textarea>
        </div>
        <div class="mb-4">
            <label for="antecedentesFamiliares" class="form-label">Antecedentes Familiares</label>
            <textarea class="form-control" id="antecedentesFamiliares" rows="3"
                v-model="antecedentesFamiliares"></textarea>
        </div>

        <div class="fondo2">
            <h6>
                Parámetros
                <i @click="toggleFormulario('parametros')"
                    :class="formularioParametrosVisible ? 'bi bi-chevron-up' : 'bi bi-chevron-down'"
                    class="icono-toggle">
                </i>
            </h6>
            <br />
            <form v-if="formularioParametrosVisible">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="transfusiones" v-model="transfusiones">
                            <label for="transfusiones" class="form-check-label">¿Tiene transfusiones?</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="reflejoTusigeno" class="form-label">Reflejo tusígeno</label>
                        <input type="text" class="form-control" id="reflejoTusigeno" v-model="reflejoTusigeno">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="temperatura" class="form-label">Temperatura</label>
                        <input type="text" class="form-control" id="temperatura" v-model="temperatura">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="frecuenciaRespiratoria" class="form-label">Frecuencia Respiratoria/min</label>
                        <input type="text" class="form-control" id="frecuenciaRespiratoria"
                            v-model="frecuenciaRespiratoria">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="frecuenciaCardiaca" class="form-label">Frecuencia cardíaca/min</label>
                        <input type="text" class="form-control" id="frecuenciaCardiaca" v-model="frecuenciaCardiaca">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="presionArterial" class="form-label">Presión arterial</label>
                        <input type="text" class="form-control" id="presionArterial" v-model="presionArterial">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="pulso" class="form-label">Pulso/min</label>
                        <input type="text" class="form-control" id="pulso" v-model="pulso">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="palmopercusion" class="form-label">Palmopercusión</label>
                        <input type="text" class="form-control" id="palmopercusion" v-model="palmopercusion">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="reflejoDeglutorio" class="form-label">Reflejo deglutorio</label>
                        <input type="text" class="form-control" id="reflejoDeglutorio" v-model="reflejoDeglutorio">
                    </div>
                </div>
            </form>
        </div>
        <br />

        <h5>Exploración Física</h5>
        <br />

        <form>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="peso" class="form-label">Peso</label>
                    <input type="text" class="form-control" id="peso" v-model="peso">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="oral" class="form-label">Oral</label>
                    <input type="text" class="form-control" id="oral" v-model="oral">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="vulvarPrepucial" class="form-label">Vulvar/Prepucial</label>
                    <input type="text" class="form-control" id="vulvarPrepucial" v-model="vulvarPrepucial">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="rectal" class="form-label">Rectal</label>
                    <input type="text" class="form-control" id="rectal" v-model="rectal">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ojos" class="form-label">Ojos</label>
                    <input type="text" class="form-control" id="ojos" v-model="ojos">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="oidos" class="form-label">Oídos</label>
                    <input type="text" class="form-control" id="oidos" v-model="oidos">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="condicionCorporal" class="form-label">Condición corporal</label>
                    <select class="form-select" id="condicionCorporal" v-model="condicionCorporal">
                        <option value="obeso">Obeso</option>
                        <option value="normal">Normal</option>
                        <option value="delgado">Delgado</option>
                        <option value="caquectico">Caquéctico</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="agresividad" class="form-label">Agresividad</label>
                    <input type="range" class="form-range" id="agresividad" min="1" max="10" v-model="agresividad">
                    <div class="mt-2">
                        <span>Valor: {{ agresividad }}</span>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mucosas" class="form-label">Mucosas</label>
                    <select class="form-select" id="mucosas" v-model="mucosas">
                        <option value="normal">Normal</option>
                        <option value="anormal">Anormal</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="comida" class="form-label">Comida</label>
                    <input type="text" class="form-control" id="comida" v-model="comida">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="nodulosLinfaticos" class="form-label">Nódulos Linfáticos</label>
                    <input type="text" class="form-control" id="nodulosLinfaticos" v-model="nodulosLinfaticos">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="temperaturaCorporal" class="form-label">Temperatura Corporal</label>
                    <input type="text" class="form-control" id="temperaturaCorporal" v-model="temperaturaCorporal">
                </div>
            </div>

            <hr />
            <div class="mb-3">
                <label for="diagnostico" class="form-label">Diagnóstico</label>
                <textarea class="form-control" id="diagnostico" rows="3" v-model="diagnostico"></textarea>
            </div>
            <div class="mb-3">
                <label for="tratamiento" class="form-label">Tratamiento</label>
                <textarea class="form-control" id="tratamiento" rows="3" v-model="tratamiento"></textarea>
            </div>
            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea class="form-control" id="observaciones" rows="3" v-model="observaciones"></textarea>
            </div>
        </form>
    </div>
</template>

<script>
import { reactive } from 'vue';
import axios from 'axios';

export default {
    data() {
        return {
            mensaje: '',
            // Propiedades del formulario
            id_historia: '',
            fechaActual: '',
            Veterinario: '',
            motivoConsulta: '',
            anamnesicos: '',
            antecedentesFamiliares: '',
            transfusiones: false,
            reflejoTusigeno: '',
            temperatura: '',
            frecuenciaRespiratoria: '',
            frecuenciaCardiaca: '',
            presionArterial: '',
            pulso: '',
            palmopercusion: '',
            reflejoDeglutorio: '',
            peso: '',
            oral: '',
            vulvarPrepucial: '',
            rectal: '',
            ojos: '',
            oidos: '',
            condicionCorporal: 'normal',
            agresividad: 5,
            mucosas: 'normal',
            comida: '',
            nodulosLinfaticos: '',
            temperaturaCorporal: '',
            diagnostico: '',
            tratamiento: '',
            observaciones: '',
            formularioParametrosVisible: false,
            paciente_id: null,
            pacientes_id: '',

        };
    },
    mounted() {
        this.obtenerFechaActual();
        this.id = this.$route.params.id || null;

        // Obtener el paciente_id desde la URL
        this.pacientes_id = this.$route.params.paciente_id || null;

        if (this.id) {
            // Si hay un id en la URL, es edición
            this.cargarHistoria(this.id); // Aquí cargas los datos de la historia para editar
        } else if (this.pacientes_id) {
            // Si solo hay paciente_id, es una nueva visita
            console.log('Creando nueva visita para el paciente con id:', this.pacientes_id);
        }
    },
    methods: {
        toggleFormulario(tipo) {
            if (tipo === 'parametros') {
                this.formularioParametrosVisible = !this.formularioParametrosVisible;
            }
        },
        obtenerFechaActual() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            this.fechaActual = `${year}-${month}-${day}`;
        },

        async cargarHistoria() {
            try {
                const $id = this.$route.params.id;
                const response = await axios.get(`http://localhost/veterinario-app/curso_apirest/historias?id=${$id}`);
                if (response.data.length) {
                    const historia = response.data[0];
                    console.log(historia)
                    // Rellena el formulario con los datos obtenidos
                    this.id_historia = historia.id || '';
                    this.fechaActual = historia.fecha || '';
                    this.Veterinario = historia.veterinario || '';
                    this.motivoConsulta = historia.motivo_consulta || '';
                    this.anamnesicos = historia.anamnesicos || '';
                    this.antecedentesFamiliares = historia.antecedentes_familiares || '';
                    this.peso = historia.peso || '';
                    this.reflejoTusigeno = historia.reflejo_tusigeno || '';
                    this.reflejoDeglutorio = historia.reflejo_deglutorio || '';
                    this.temperatura = historia.temperatura || '';
                    this.presionArterial = historia.presion_arterial || '';
                    this.frecuenciaCardiaca = historia.frecuencia_cardiaca || '';
                    this.frecuenciaRespiratoria = historia.frecuencia_respiratoria || '';
                    this.pulso = historia.pulso || '';
                    this.palmopercusion = historia.palmopercusion || '';
                    this.transfusiones = historia.transfusiones || false; // Suponiendo que es un booleano
                    this.oral = historia.oral || '';
                    this.vulvarPrepucial = historia.vulvar_prepucial || '';
                    this.rectal = historia.rectal || '';
                    this.ojos = historia.ojos || '';
                    this.oidos = historia.oidos || '';
                    this.nodulosLinfaticos = historia.nodulos || '';
                    this.condicionCorporal = historia.condicion_corporal || 'normal'; // Asignar valor por defecto
                    this.agresividad = historia.agresividad || 5; // Asignar valor por defecto
                    this.mucosas = historia.mucosa || 'normal'; // Asignar valor por defecto
                    this.comida = historia.comida || '';
                    this.diagnostico = historia.diagnostico || '';
                    this.tratamiento = historia.tratamiento || '';
                    this.observaciones = historia.observaciones || '';
                    this.ultimoCelo = historia.ultimo_celo || ''; // Si tienes este campo
                    this.ultimoParto = historia.ultimo_parto || ''; // Si tienes este campo
                    this.sistemaReproductor = historia.sistema_reproductor || ''; // Si tienes este campo
                    this.sistemaCardiovascular = historia.sistema_cardiovascular || ''; // Si tienes este campo
                    this.sistemaRespiratorio = historia.sistema_respiratorio || ''; // Si tienes este campo
                    this.sistemaDigestivo = historia.sistema_digestivo || ''; // Si tienes este campo
                    this.sistemaGenitourinario = historia.sistema_genitourinario || ''; // Si tienes este campo
                    this.estadoDeshidratacion = historia.estado_deshidratacion || ''; // Si tienes este campo
                    this.constantesFisiologicas = historia.constantes_fisiologicas || ''; // Si tienes este campo
                    this.temperaturaCorporal = historia.temperatura || ''; // Si es diferente del anterior
                    this.pacientes_id = historia.pacientes_id || ''; //
                    // Agrega más campos según sea necesario
                }
            } catch (error) {
                console.error('Error al cargar la historia:', error);
            }
        },

        async guardarVisita() {
            try {
                // Construir el objeto con los datos que realmente se van a enviar al backend
                const datosVisita = {
                    fecha: this.fechaActual,
                    veterinario: this.Veterinario,
                    motivo_consulta: this.motivoConsulta,
                    anamnesicos: this.anamnesicos,
                    antecedentes_familiares: this.antecedentesFamiliares,
                    transfusiones: this.transfusiones,
                    reflejo_tusigeno: this.reflejoTusigeno,
                    temperatura: this.temperatura,
                    frecuencia_respiratoria: this.frecuenciaRespiratoria,
                    frecuencia_cardiaca: this.frecuenciaCardiaca,
                    presion_arterial: this.presionArterial,
                    pulso: this.pulso,
                    palmopercusion: this.palmopercusion,
                    reflejo_deglutorio: this.reflejoDeglutorio,
                    peso: this.peso,
                    oral: this.oral,
                    vulvar_prepucial: this.vulvarPrepucial,
                    rectal: this.rectal,
                    ojos: this.ojos,
                    oidos: this.oidos,
                    nodulos: this.nodulosLinfaticos,
                    condicion_corporal: this.condicionCorporal,
                    agresividad: this.agresividad,
                    mucosa: this.mucosas,
                    comida: this.comida,
                    temperatura_corporal: this.temperaturaCorporal,
                    diagnostico: this.diagnostico,
                    tratamiento: this.tratamiento,
                    observaciones: this.observaciones,
                    pacientes_id: parseInt(this.pacientes_id, 10) // Este es el ID del paciente, que se usa para la relación
                };
                let response;

                // Verificar si estamos editando o creando
                if (this.id) {
                    // Si tienes el id de la historia, es una edición (PUT)
                    let direccion = `http://localhost/veterinario-app/curso_apirest/historias`
                    response = await axios.put(direccion, { ...datosVisita, id: this.id_historia });
                    console.log(datosVisita);
                } else if (this.paciente_id) {
                    // Si tienes el paciente_id pero no hay id de historia, es una creación (POST)
                    response = await axios.post('http://localhost/veterinario-app/curso_apirest/historias', { ...datosVisita, pacientes_id: this.pacientes_id });
                    console.log('Nueva historia creada con éxito:', response.data);
                }
                // Mostrar mensaje de éxito
                this.mensaje = this.id ? 'La visita se ha actualizado correctamente.' : 'La visita se ha guardado correctamente.';

                // Esperar 3 segundos y redirigir
                setTimeout(() => {
                    this.mensaje = ''; // Oculta el mensaje
                    this.$router.push({
                        path: `/detalleshistorias/${this.pacientes_id}`,
                        hash: '#historial'
                    });

                }, 3000);
            } catch (error) {
                console.error('Error al guardar la visita:', error);
                // Manejo de errores: puedes mostrar un mensaje de error si lo deseas
                this.mensaje = 'Error al guardar la visita. Por favor, intenta nuevamente.';
                setTimeout(() => {
                    this.mensaje = ''; // Oculta el mensaje después de 3 segundos
                }, 3000);
            }
        },

        ishistorias() {
            this.$router.push({ path: `/detalleshistorias/${this.paciente_id}` });
        },
    }
};
</script>

<style scoped>
/* Agrega tus estilos aquí */
.icono-toggle {
    cursor: pointer;
}
</style>


<style>
.fondo {
    background-color: #e8f0fc;
    padding: 10px;
    border-radius: 8px;
}

.fondo2 {
    background-color: #d2e1f8;
    padding: 10px;
    border-radius: 8px;
}

.icono-toggle {
    font-size: 1rem;
    cursor: pointer;
}

.icono-toggle:hover,
.icono-toggle:focus {
    text-decoration: none;
    outline: none;
}

.mt-4 {
    margin-top: 0.5rem !important;
}
</style>
