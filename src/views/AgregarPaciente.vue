<template>
    <br />
    <div class="d-flex justify-content-between align-items-center mb-3  bg-white py-2">
        <h2 class="text-primary me-auto">Nuevo Paciente</h2>
    </div>
    <br />

    <div class="">
        <form @submit.prevent="submitForm">
            <!-- Campos obligatorios -->
            <div class="row mb-3">
                <div class="col-md-4 col-lg-4">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" v-model="form.nombre" required>
                </div>

                <div class="col-md-4 col-lg-4">
                    <label for="adopcion" class="form-label">Cliente</label>
                    <select class="form-select" id="adopcion" v-model="form.adopcion">
                        <option value="" disabled selected>Seleccionar</option>
                    </select>
                </div>

                <div class="col-md-4 col-lg-4">
                    <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
                    <input type="date" class="form-control" id="fechaNacimiento" v-model="form.fechaNacimiento"
                        required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 col-lg-4">
                    <label for="anos" class="form-label">Edad</label>
                    <input type="number" class="form-control" id="anos" v-model="form.anos">
                </div>

                <div class="col-md-4 col-lg-4">
                    <label for="especie" class="form-label">Especie</label>
                    <select class="form-select" id="especie" v-model="form.especie">
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="caninos">Caninos</option>
                        <option value="felinos">Felinos</option>
                        <option value="aves">Aves</option>
                        <option value="equinos">Equinos</option>
                        <option value="conejos">Conejos</option>
                        <option value="peces">Peces</option>
                        <option value="reptiles">Reptiles</option>
                        <option value="roedores">Roedores</option>
                        <option value="anfibios">Anfibios</option>
                        <option value="bovinos">Bovinos</option>
                        <option value="caprino">Caprino</option>
                        <option value="ovino">Ovino</option>
                        <option value="porcino">Porcino</option>
                        <option value="otra">otra</option>
                    </select>
                </div>

                <div class="col-md-4 col-lg-4">
                    <label for="raza" class="form-label">Raza</label>
                    <input type="text" class="form-control" id="raza" v-model="form.raza">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 col-lg-4">
                    <label for="sexo" class="form-label">Sexo</label>
                    <select class="form-select" id="sexo" v-model="form.sexo">
                        <option value="" disabled selected>Seleccionar</option>
                        <option value="Macho">Macho</option>
                        <option value="Hembra">Hembra</option>
                    </select>
                </div>

                <div class="col-md-4 col-lg-4">
                    <label for="pelaje" class="form-label">Pelaje</label>
                    <input type="text" class="form-control" id="pelaje" v-model="form.pelaje">
                </div>

                <div class="col-md-4 col-lg-4">
                    <label for="comida" class="form-label">Comida que consume</label>
                    <input type="text" class="form-control" id="comida" v-model="form.comida">
                </div>

            </div>




            <!-- Sección de checkboxes -->

            <br />
            <br />
            <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">Guardar </button>
            </div>
        </form>
    </div>

</template>

<script>
export default {
    name: 'AgregarPaciente',
    data() {
        return {
            form: {
                historiaClinica: '',
                nombre: '',
                cliente: '',
                fechaNacimiento: '',
                anos: '',
                meses: '',
                especie: '',
                raza: '',
                sexo: '',
                pelaje: '',
                peso: '',
                veterinario: '',
                comida: '',
                vivienda: '',
                ultimoCelo: '',
                chip: '',
                pedigree: '',
                fallecio: false,
                donante: false,
                transfusiones: false,
                reproductor: false,
                castrado: false,
                factor: '',
                adopcion: '',
                agresividad: '',
                patologias: '',
                agresividad: 5, // Valor inicial del slider (por defecto en 5)
            }
        };
    },
    methods: {
        submitForm() {
            console.log(this.form);
            // Aquí iría la lógica para enviar el formulario a la API o procesarlo
        }
    }
};
</script>

<style scoped>
.container {
    max-width: 100%;
}

@media (min-width: 768px) {
    .container {
        max-width: 800px;
    }
}

.form-range {
    width: 100%;
}
</style>
