<template>
    <div class="overlay">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <h5 class="card-title text-center">Nuevo Gasto</h5>
                <div class="mb-3">
                    <label for="concepto" class="form-label fw-bold">Concepto</label>
                    <input id="concepto" type="text" class="form-control" v-model="concepto"
                        placeholder="Descripción del gasto" required />
                </div>
                <div class="mb-3">
                    <label for="valor" class="form-label">Valor *</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input id="valor" type="number" class="form-control" v-model="valor" placeholder="0.00" min="0"
                            required />
                    </div>
                </div>
                <div class="mb-3">
                    <label for="medio-pago" class="form-label">Medio de Pago *</label>
                    <select id="medio-pago" class="form-select" v-model="medioPago" required>
                        <option value="" disabled>Selecciona un medio de pago</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Otros">Otros</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="fecha-hora" class="form-label">Fecha y Hora *</label>
                    <input id="fecha-hora" type="datetime-local" class="form-control" v-model="fechaHora" required />
                </div>
                <div class="mb-3">
                    <label for="estado" class="form-label">Estado *</label>
                    <select id="estado" class="form-select" v-model="estado" required>
                        <option value="" disabled>Selecciona un estado</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Pagado">Pagado</option>
                    </select>
                </div>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary" @click="registrarGasto">Registrar Gasto</button>
                    <button type="button" class="btn btn-secondary" @click="cerrarFormulario">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NuevoGasto",
    data() {
        return {
            concepto: "", // Estado para almacenar el concepto del gasto
            valor: 0, // Estado para almacenar el valor del gasto
            medioPago: "", // Estado para almacenar el medio de pago
            fechaHora: "", // Estado para almacenar la fecha y hora
            estado: "", // Estado para almacenar el estado
        };
    },
    methods: {
        registrarGasto() {
            if (this.valor > 0 && this.concepto && this.medioPago && this.fechaHora && this.estado) {
                alert(`Gasto registrado: \nConcepto: ${this.concepto} \nValor: $${this.valor.toFixed(2)} \nMedio de Pago: ${this.medioPago} \nFecha y Hora: ${this.fechaHora} \nEstado: ${this.estado}`);
                this.cerrarFormulario();
            } else {
                alert("Por favor, completa todos los campos.");
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
    z-index: 1999;
    /* Se asegura de estar encima del cintillo */
}

.card {
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    background: #fff;
}
</style>