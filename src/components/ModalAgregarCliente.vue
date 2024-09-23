<template>
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg">
      <div class="modal-content ">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Formulario de Registro</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input type="text" class="form-control" id="nombre" placeholder="Nombre">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="apellido" class="form-label">Apellido</label>
                  <input type="text" class="form-control" id="apellido" placeholder="Apellido">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="cedula" class="form-label">Cédula</label>
                  <input type="text" class="form-control" id="cedula" placeholder="Cédula">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="email" class="form-label">E-mail</label>
                  <input type="email" class="form-control" id="email" placeholder="E-mail">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="telefonoMovil" class="form-label">Teléfono Móvil</label>
                  <input type="tel" class="form-control" id="telefonoMovil" placeholder="Teléfono Móvil">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="telefonoAuxiliar" class="form-label">Teléfono Auxiliar</label>
                  <input type="tel" class="form-control" id="telefonoAuxiliar" placeholder="Teléfono Auxiliar">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="ciudad" class="form-label">Ciudad</label>
                  <input type="text" class="form-control" id="ciudad" placeholder="Ciudad">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="municipio" class="form-label">Municipio</label>
                  <input type="text" class="form-control" id="municipio" placeholder="Municipio">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="veterinarioDerivante" class="form-label">Veterinario Derivante</label>
                  <input type="text" class="form-control" id="veterinarioDerivante" placeholder="Veterinario Derivante">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="deuda" class="form-label">Deuda</label>
                  <input type="text" class="form-control" id="deuda">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary">Guardar</button>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: 'ModalAgregarCliente',
};
</script>
<style scoped>
.modal-body {
  padding: 20px;
}

.form-label {
  margin-bottom: 5px;
}

.form-control {
  margin-bottom: 10px;
}
</style>
