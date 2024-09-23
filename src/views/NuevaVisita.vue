<template>
    <div>
        <br />
        <div class="d-flex justify-content-between align-items-center mb-3 sticky-top bg-white py-2">
            <h5 class="text-primary me-auto">Nueva Visita de :</h5>
            <button type="button" @click="NuevaVisita" class="btn btn-secondary">Guardar</button>
        </div>
        <div class="mb-3">
            <label for="fechaActual" class="form-label">Fecha actual:</label>
            <input type="date" class="form-control" id="fechaActual" v-model="fechaActual" />
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Motivo de la consulta</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div class="mb-4">
            <label for="exampleFormControlTextarea1" class="form-label">Anamnésticos</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div class="mb-4">
            <label for="exampleFormControlTextarea1" class="form-label">Veterinario que lo derivó</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <!-- Parámetros -->
        <div class="fondo2">
            <h6>
                Parámetros
                <!-- Ícono para mostrar/ocultar el formulario sin hover ni estilo de botón -->
                <i @click="toggleFormulario('parametros')"
                    :class="formularioParametrosVisible ? 'bi bi-chevron-up' : 'bi bi-chevron-down'"
                    class="icono-toggle">
                </i>
            </h6>
            <br />
            <!-- Formulario mostrado/oculto según el valor de formularioParametrosVisible -->
            <form v-if="formularioParametrosVisible">
                <div class="row">
                    <!-- Columna 1 -->
                    <div class="col-md-4 mb-3">
                        <!-- Transfusiones -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="transfusiones">
                            <label for="transfusiones" class="form-check-label">¿Tiene transfusiones?</label>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <!-- Reflejo tusígeno -->
                        <label for="reflejoTusigeno" class="form-label">Reflejo tusígeno</label>
                        <input type="text" class="form-control" id="reflejoTusigeno">
                    </div>

                    <div class="col-md-4 mb-3">
                        <!-- Temperatura -->
                        <label for="temperatura" class="form-label">Temperatura</label>
                        <input type="text" class="form-control" id="temperatura">
                    </div>
                </div>

                <div class="row">
                    <!-- Frecuencia Respiratoria -->
                    <div class="col-md-4 mb-3">
                        <label for="frecuenciaRespiratoria" class="form-label">Frecuencia Respiratoria/min</label>
                        <input type="text" class="form-control" id="frecuenciaRespiratoria">
                    </div>

                    <!-- Frecuencia cardíaca -->
                    <div class="col-md-4 mb-3">
                        <label for="frecuenciaCardiaca" class="form-label">Frecuencia cardíaca/min</label>
                        <input type="text" class="form-control" id="frecuenciaCardiaca">
                    </div>

                    <!-- Presión Arterial -->
                    <div class="col-md-4 mb-3">
                        <label for="presionArterial" class="form-label">Presión arterial</label>
                        <input type="text" class="form-control" id="presionArterial">
                    </div>
                </div>

                <div class="row">
                    <!-- Pulso -->
                    <div class="col-md-4 mb-3">
                        <label for="pulso" class="form-label">Pulso/min</label>
                        <input type="text" class="form-control" id="pulso">
                    </div>

                    <!-- Palmopercusión -->
                    <div class="col-md-4 mb-3">
                        <label for="palmopercusion" class="form-label">Palmopercusión</label>
                        <input type="text" class="form-control" id="palmopercusion">
                    </div>

                    <!-- Reflejo deglutorio -->
                    <div class="col-md-4 mb-3">
                        <label for="reflejoDeglutorio" class="form-label">Reflejo deglutorio</label>
                        <input type="text" class="form-control" id="reflejoDeglutorio">
                    </div>
                </div>
            </form>



        </div>
        <br />

        <h5>Exploración Física</h5>
        <br />

        <form>
            <div class="row">
                <!-- Columna 1 -->
                <div class="col-md-4 mb-3">
                    <label for="peso" class="form-label">Peso</label>
                    <input type="text" class="form-control" id="peso">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="oral" class="form-label">Oral</label>
                    <input type="text" class="form-control" id="oral">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="vulvarPrepucial" class="form-label">Vulvar/Prepucial</label>
                    <input type="text" class="form-control" id="vulvarPrepucial">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="rectal" class="form-label">Rectal</label>
                    <input type="text" class="form-control" id="rectal">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="ojos" class="form-label">Ojos</label>
                    <input type="text" class="form-control" id="ojos">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="oidos" class="form-label">Oídos</label>
                    <input type="text" class="form-control" id="oidos">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="condicionCorporal" class="form-label">Condición corporal</label>
                    <select class="form-select" id="condicionCorporal">
                        <option value="obeso">Obeso</option>
                        <option value="normal">Normal</option>
                        <option value="delgado">Delgado</option>
                        <option value="caquectico">Caquéctico</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="agresividad" class="form-label">Agresividad</label>
                    <input type="range" class="form-range" id="agresividad" min="1" max="10">
                    <div class="mt-2">
                        <span>Valor: {{ form.agresividad }}</span>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mucosas" class="form-label">Mucosas</label>
                    <select class="form-select" id="mucosas">
                        <option value="normal">Normal</option>
                        <option value="anormal">Anormal</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <!-- Columna 2 -->
                <div class="col-md-4 mb-3">
                    <label for="comida" class="form-label">Comida</label>
                    <input type="text" class="form-control" id="comida">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="nodulosLinfaticos" class="form-label">Nódulos Linfáticos</label>
                    <input type="text" class="form-control" id="nodulosLinfaticos">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="tonsilas" class="form-label">Tonsilas</label>
                    <input type="text" class="form-control" id="tonsilas">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="pielAnexos" class="form-label">Piel y Anexos</label>
                    <input type="text" class="form-control" id="pielAnexos">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="locomocion" class="form-label">Locomoción</label>
                    <input type="text" class="form-control" id="locomocion">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="musculoesqueletico" class="form-label">S. Musculoesquelético</label>
                    <input type="text" class="form-control" id="musculoesqueletico">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="sistemaNervioso" class="form-label">Sistema Nervioso</label>
                    <input type="text" class="form-control" id="sistemaNervioso">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="estadoDeshidratacion" class="form-label">Estado de deshidratación</label>
                    <select class="form-select" id="estadoDeshidratacion">
                        <option value="normal">Normal</option>
                        <option value="5%">5%</option>
                        <option value="6-7%">6-7%</option>
                        <option value="8-9%">8-9%</option>
                        <option value="10%+">10%+</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="heces" class="form-label">Heces</label>
                    <input type="text" class="form-control" id="heces">
                </div>
            </div>


            <div class="row">
                <!-- Columna 3 -->
                <div class="col-md-4 mb-3">
                    <label for="cardiovascular" class="form-label">S. Cardiovascular</label>
                    <input type="text" class="form-control" id="cardiovascular">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="respiratorio" class="form-label">S. Respiratorio</label>
                    <input type="text" class="form-control" id="respiratorio">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="digestivo" class="form-label">S. Digestivo</label>
                    <input type="text" class="form-control" id="digestivo">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="genitourinario" class="form-label">S. Genitourinario</label>
                    <input type="text" class="form-control" id="genitourinario">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="constantesFisiologicas" class="form-label">Constantes fisiológicas</label>
                    <select class="form-select" id="constantesFisiologicas">
                        <option value="astenico">Asténico</option>
                        <option value="apropietico">Apoplético</option>
                        <option value="linfatico">Linfático</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="orina" class="form-label">Orina</label>
                    <input type="text" class="form-control" id="orina">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="estadoReproductivo" class="form-label">Estado reproductivo</label>
                    <select class="form-select" id="estadoReproductivo">
                        <option value="castrado">Castrado</option>
                        <option value="gestacion">Gestación</option>
                        <option value="lactancia">Lactancia</option>
                        <option value="entero">Entero</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ultimoCelo" class="form-label">Último celo</label>
                    <input type="date" class="form-control" id="ultimoCelo">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ultimoCelo" class="form-label">Último Parto</label>
                    <input type="date" class="form-control" id="ultimoCelo">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="S.Reproductor" class="form-label">S. Reproductor</label>
                    <input type="text" class="form-control" id="S.Reproductor">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="SeñasParticulaares" class="form-label">Señas Particulares </label>
                    <input type="text" class="form-control" id="SeñasParticulaares">
                </div>
            </div>
        </form>


        <hr>

        <br />

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Diagnóstico</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Tratamiento</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <br />
        <br />
    </div>
</template>

<script>
export default {
    data() {
        return {
            fechaActual: '',
            formularioParametrosVisible: false, // Parámetros

            form: {

                agresividad: 5, // Valor inicial del slider (por defecto en 5)
            }
        };
    },
    mounted() {
        this.obtenerFechaActual();
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
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Mes en formato 2 dígitos
            const day = String(today.getDate()).padStart(2, '0'); // Día en formato 2 dígitos
            this.fechaActual = `${year}-${month}-${day}`;
        },
    },
};
</script>

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
