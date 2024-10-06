<template>
    <div class="fondo2">
        <h5>Parámetros</h5>
        <form @submit.prevent="submitForm">
            <div class="row">
                <!-- Primera fila -->
                <div class="col-md-4 mb-3">
                    <label for="date" class="form-label">Fecha</label>
                    <input v-model="fecha" type="date" class="form-control" id="fecha">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="peso" class="form-label">Peso</label>
                    <input v-model="parametros.peso" type="text" class="form-control" id="peso">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="temperatura" class="form-label">Temperatura</label>
                    <input v-model="parametros.temperatura" type="text" class="form-control" id="temperatura">
                </div>
            </div>

            <div class="row">
                <!-- Segunda fila -->
                <div class="col-md-4 mb-3">
                    <label for="hidratacion" class="form-label">Hidratación</label>
                    <input v-model="parametros.hidratacion" type="text" class="form-control" id="hidratacion">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="pulso" class="form-label">Pulso/min</label>
                    <input v-model="parametros.pulso" type="text" class="form-control" id="pulso">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="frecuenciaCardiaca" class="form-label">Frecuencia cardíaca/min</label>
                    <input v-model="parametros.frecuenciaCardiaca" type="text" class="form-control"
                        id="frecuenciaCardiaca">
                </div>
            </div>

            <div class="row">
                <!-- Tercera fila -->
                <div class="col-md-4 mb-3">
                    <label for="frecuenciaRespiratoria" class="form-label">Frecuencia respiratoria/min</label>
                    <input v-model="parametros.frecuenciaRespiratoria" type="text" class="form-control"
                        id="frecuenciaRespiratoria">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mucosas" class="form-label">Mucosas</label>
                    <select v-model="parametros.mucosas" class="form-select" id="mucosas">
                        <option value="normal">Normal</option>
                        <option value="anormal">Anormal</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="llenadoCapilar" class="form-label">Tiempo de llenado capilar</label>
                    <input v-model="parametros.llenadoCapilar" type="text" class="form-control" id="llenadoCapilar">
                </div>
            </div>

            <div class="row">
                <!-- Cuarta fila -->
                <div class="col-md-4 mb-3">
                    <label for="presionArterial" class="form-label">Presión arterial</label>
                    <input v-model="parametros.presionArterial" type="text" class="form-control" id="presionArterial">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="reflejoDeglutorio" class="form-label">Reflejo deglutorio</label>
                    <input v-model="parametros.reflejoDeglutorio" type="text" class="form-control"
                        id="reflejoDeglutorio">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="linfonodos" class="form-label">Linfonodos / ganglios</label>
                    <input v-model="parametros.linfonodos" type="text" class="form-control" id="linfonodos">
                </div>
            </div>

            <div class="row">
                <!-- Quinta fila -->
                <div class="col-md-4 mb-3">
                    <label for="reflejoTusigeno" class="form-label">Reflejo tusígeno</label>
                    <input v-model="parametros.reflejoTusigeno" type="text" class="form-control" id="reflejoTusigeno">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="palpacionAbdominal" class="form-label">Palpación abdominal</label>
                    <input v-model="parametros.palpacionAbdominal" type="text" class="form-control"
                        id="palpacionAbdominal">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="palmopercusion" class="form-label">Palmopercusión</label>
                    <input v-model="parametros.palmopercusion" type="text" class="form-control" id="palmopercusion">
                </div>
            </div>

            <div class="row">
                <!-- Sexta fila -->
                <div class="col-md-4 mb-3">
                    <label for="condicionCorporal" class="form-label">Condición corporal</label>
                    <select v-model="parametros.condicionCorporal" class="form-select" id="condicionCorporal">
                        <option value="obeso">Obeso</option>
                        <option value="normal">Normal</option>
                        <option value="delgado">Delgado</option>
                        <option value="caquectico">Caquéctico</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tonsilas" class="form-label">Tonsilas</label>
                    <input v-model="parametros.tonsilas" type="text" class="form-control" id="tonsilas">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="conciencia" class="form-label">Conciencia</label>
                    <input v-model="parametros.conciencia" type="text" class="form-control" id="conciencia">
                </div>
            </div>

            <div class="row">
                <!-- Séptima fila -->
                <div class="col-md-4 mb-3">
                    <label for="anamnesis" class="form-label">Anamnesis</label>
                    <input v-model="parametros.anamnesis" type="text" class="form-control" id="anamnesis">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="estadoReproductivo" class="form-label">Estado reproductivo</label>
                    <select v-model="parametros.estadoReproductivo" class="form-select" id="estadoReproductivo">
                        <option value="astenico">Castrado</option>
                        <option value="apropietico">Gestación</option>
                        <option value="linfatico">Lactancia</option>
                        <option value="linfatico">Entero</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="constantesFisiologicas" class="form-label">Constantes fisiológicas</label>
                    <select v-model="parametros.constantesFisiologicas" class="form-select" id="constantesFisiologicas">
                        <option value="astenico">Asténico</option>
                        <option value="apropietico">Apropietico</option>
                        <option value="linfatico">Linfático</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <!-- Octava fila -->
                <div class="col-md-4 mb-3">
                    <label for="comida" class="form-label">Comida</label>
                    <input v-model="parametros.comida" type="text" class="form-control" id="comida">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="estadoDeshidratacion" class="form-label">Estado de deshidratación</label>
                    <select v-model="parametros.estadoDeshidratacion" class="form-select" id="estadoDeshidratacion">
                        <option value="normal">Normal</option>
                        <option value="5%">Deshidratación 0-5%</option>
                        <option value="6-7%">Deshidratación 6-7%</option>
                        <option value="8-9%">Deshidratación 8-9%</option>
                        <option value="10%+">Deshidratación 10% +</option>
                    </select>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">Guardar</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: 'Parametrovue',

    data() {
        return {
            parametros: {
                peso: '',
                temperatura: '',
                hidratacion: '',
                pulso: '',
                frecuenciaCardiaca: '',
                frecuenciaRespiratoria: '',
                mucosas: 'normal',
                llenadoCapilar: '',
                presionArterial: '',
                reflejoDeglutorio: '',
                linfonodos: '',
                reflejoTusigeno: '',
                palpacionAbdominal: '',
                palmopercusion: '',
                condicionCorporal: 'normal',
                tonsilas: '',
                conciencia: '',
                anamnesis: '',
                estadoReproductivo: '',
                constantesFisiologicas: 'astenico',
                comida: '',
                estadoDeshidratacion: 'normal'
            },
            editMode: false,
        };
    },
    created() {
        const id = this.$route.params.id;
        if (id) {
            this.loadHistoria(id);
        }
    },
    methods: {
        loadCliente(id) {
            axios.get(`http://localhost/veterinario-app/curso_apirest/historia?paciente_id=${id}`)
                .then(response => {
                    const cliente = response.data[0];
                    this.parametros = {
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
            this.parametros = {
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
                axios.put(`http://localhost/veterinario-app/curso_apirest/historias`, { ...this.parametros, id: this.clienteId })
                    .then(() => {
                        this.showMessage('Cliente actualizado con éxito', 'success', () => {
                            this.$router.push('/listaclientes'); // Redirigir después de mostrar el mensaje
                        });
                    })
                    .catch(error => alert('Error al actualizar cliente'));
            } else {
                axios.post('http://localhost/veterinario-app/curso_apirest/propietarios', this.parametros)
                    .then(() => {
                        this.showMessage('Cliente agregado con éxito', 'success', () => {
                            this.$router.push('/listaclientes'); // Redirigir después de mostrar el mensaje
                        });
                    })
                    .catch(error => this.showMessage('Error al agregar cliente', 'error'));
            }
        },
    }
};
</script>

<style scoped>
.fondo2 {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
}
</style>