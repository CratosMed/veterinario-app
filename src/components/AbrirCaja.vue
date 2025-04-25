<template>
    <div class="overlay">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <h5 class="card-title text-center">Abrir caja</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">Responsable</label>
                    <p>{{ responsable }}</p>
                </div>
                <div class="mb-3">
                    <label for="monto-inicial" class="form-label">¿Con cuánto dinero empiezas el turno? *</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input id="monto-inicial" type="number" class="form-control" v-model="montoInicial"
                            placeholder="0.00" min="0" />
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary" @click="empezarTurno">Empezar turno</button>
                    <button type="button" class="btn btn-secondary" @click="cerrarFormulario">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AbrirCaja",
    data() {
        return {
            responsable: "Gabriela Tovar", // Puede venir de un prop o del store
            montoInicial: 0, // Estado para guardar el monto inicial ingresado
        };
    },
    methods: {
        empezarTurno() {
            if (this.montoInicial > 0) {
                alert(`Turno iniciado con $${this.montoInicial.toFixed(2)}`);
                this.cerrarFormulario();
            } else {
                alert("Por favor, ingresa un monto válido.");
            }
        },
        cerrarFormulario() {
            this.$emit("cerrar");
        },
    },
};
</script>

<style scoped>
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    /* Fondo semitransparente */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    /* Se asegura de estar encima del cintillo */
}

.card {
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    background: #fff;
}
</style>