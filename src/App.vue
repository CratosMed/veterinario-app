Compartir


Tú dijiste:
<template>
  <div id="app">
    <div class="main-content">
      <div class="row no-gutters">
        <!-- Botón con tres puntos visible en todas las pantallas -->
        <div class="floating-button">
          <button class="btn btn-secondary" @click="toggleSidebar">
            &#8942; <!-- Siempre muestra los tres puntos -->
          </button>
        </div>

        <!-- Menú lateral -->
        <div :class="isSidebarOpen ? 'menu-lateral col-lg-3 col-md-4 col-sm-4 col-2' : 'menu-collapsed col-1'">
          <MenuLateral :isSidebarOpen="isSidebarOpen" @toggleSidebar="toggleSidebar" />
        </div>

        <!-- Contenido principal -->
        <div :class="isSidebarOpen ? 'col-lg-9 col-md-8 col-sm-7 col-10 container' : 'col-11 container'">
          <router-view />
          <br />
          <div class="navigation-buttons">
            <button @click="goBack" class="btn-atras">
              <i class="bi bi-arrow-left"></i> Atrás
            </button>

            <!-- Botón "Adelante" -->
            <button @click="goForward" class="btn-adelante">
              Adelante <i class="bi bi-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <br />
    <FooterVue />
  </div>
</template>

<script>
import MenuLateral from './components/MenuLateral.vue';
import FooterVue from './components/FooterVue.vue';

export default {
  name: 'DashboardView',
  components: {
    MenuLateral,
    FooterVue
  },
  data() {
    return {
      isSidebarOpen: false, // Empieza cerrado por defecto
    };
  },
  mounted() {
    window.addEventListener('resize', this.handleResize);
    this.handleResize();
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.handleResize);
  },
  methods: {
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen;
      console.log(this.isSidebarOpen);
    },
    handleResize() {
      const screenWidth = window.innerWidth;
      if (screenWidth < 768) {
        this.isSidebarOpen = false;
      }
    },
    goBack() {
      if (window.history.length > 1) {
        this.$router.go(-1); // Va hacia atrás en el historial
      } else {
        this.$router.push('/home'); // Opción de fallback si no hay historial
      }
    },
    goForward() {
      this.$router.go(1); // Va hacia adelante en el historial
    }
  }
};
</script>

<style scoped>
/* Estilos generales */
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
}

.row.no-gutters {
  margin-right: 0;
  margin-left: 0;
}

/* Asegura que el botón flotante esté siempre visible */
.floating-button {
  position: fixed;
  top: 10px;
  right: -15px;
  z-index: 9999;
}

/* Estilos para el menú lateral */
.menu-lateral {
  z-index: 1000;
  width: 250px;
  transition: width 0.3s ease;
}

.menu-collapsed {
  width: 60px;
  transition: width 0.3s ease;
}

.menu-collapsed .menu-item-text {
  display: none;
}

.menu-collapsed i {
  display: block;
  font-size: 24px;
}

/* Estilos para el botón de tres puntos */
button.btn-secondary {
  background-color: #045872;
  border: none;
  font-size: 24px;
  padding: 5px 0px;
  cursor: pointer;
}

button.btn-secondary:hover {
  background-color: #034a58;
}

/* Contenedor para los botones de navegación */
.navigation-buttons {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
}

.btn-atras,
.btn-adelante {
  background-color: #045872;
  color: white;
  border: none;
  padding: 10px 15px;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px;
  display: inline-flex;
  align-items: center;
}

.btn-atras:hover,
.btn-adelante:hover {
  background-color: #034a58;
}

footer {
  width: 100%;
  background-color: #f1f1f1;
  text-align: center;
  padding: 10px 0;
  position: absolute;
  bottom: 0;
  left: 0;
}

@media (max-width: 736px) {

  .menu-lateral,
  .menu-collapsed {
    display: none;
    /* Oculta el menú lateral en dispositivos móviles */
  }

  /* Asegura que el contenedor principal use todo el ancho */
  .col-10,
  .col-11 {
    width: 100% !important;
  }
}
</style>