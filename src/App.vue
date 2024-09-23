<template>
  <div id="app">
    <div class="main-content">
      <div class="row">
        <div class="col-2">
          <MenuLateral />
        </div>
        <div class="col-10">
          <router-view />
        </div>
      </div>
    </div>

    <FooterVue />
  </div>
</template>

<script>
import MenuLateral from './components/MenuLateral.vue'
import FooterVue from './components/FooterVue.vue';

export default {
  name: 'DashboardView',

  components: {
    MenuLateral,
    FooterVue
  },
}
</script>

<style scoped>
/* Asegura que el footer esté al final de la página cuando hay suficiente contenido */
html,
body {
  height: 100%;
  margin: 0;
}

#app {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.main-content {
  flex: 1;
  margin-right: 2%;
  /* Ajusta el margen según sea necesario */
}

footer {
  /* Estilos para el footer si es necesario */
}
</style>
