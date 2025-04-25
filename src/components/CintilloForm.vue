<template>
    <header class="menu-bar d-flex align-items-center justify-content-between px-3 py-2 shadow-sm">
        <!-- Título del sistema -->
        <div class="system-title">
            <h2>Administración</h2>
        </div>

        <!-- Menú de navegación -->
        <nav class="d-flex flex-wrap">
            <a v-for="item in menuItems" :key="item.id" href="#" class="menu-item d-flex align-items-center"
                :class="{ active: activeItem === item.name }" @click.prevent="navigateTo(item)"
                :aria-label="'Ir a ' + item.name">
                <i :class="[item.icon, 'me-2']"></i>{{ item.name }}
            </a>
        </nav>

        <!-- Fecha y botones de acciones -->
        <div class="d-flex align-items-center">
            <span class="text-white me-3">{{ currentDate }}</span>
            <button class="btn btn-danger btn-sm me-3" @click="mostrarAbrirCaja = true">
                Abrir Caja
            </button>
            <AbrirCaja v-if="mostrarAbrirCaja" @cerrar="mostrarAbrirCaja = false" />

            <!-- Botón para abrir formulario de nuevo gasto -->
            <button class="btn btn-success btn-sm me-3" @click="mostrarNuevoGasto = true">
                Nuevo Gasto
            </button>
            <NuevoGasto v-if="mostrarNuevoGasto" @cerrar="mostrarNuevoGasto = false" />
        </div>
    </header>
</template>

<script>
import AbrirCaja from "./AbrirCaja.vue";
import NuevoGasto from "./NuevoGasto.vue";

export default {
    name: "Cintilloform",
    components: {
        AbrirCaja,
        NuevoGasto, // Registro del componente NuevoGasto
    },
    data() {
        return {
            menuItems: [
                { id: 1, name: "Movimientos", path: "/ventasInventario", icon: "bi bi-cart" },
                { id: 2, name: "Estadísticas", path: "/estadisticas", icon: "bi bi-box" },
                { id: 3, name: "Ventas e Inventario", path: "/inventario", icon: "bi bi-clock-history" },
                { id: 4, name: "Usuarios", path: "/listarusuario", icon: "bi bi-people" },
                { id: 5, name: "Clientes", path: "/clientes", icon: "bi bi-people" },
                { id: 6, name: "Proveedores", path: "/proveedores", icon: "bi bi-cash-coin" },
            ],
            currentDate: "",
            activeItem: "Movimientos", // Item activo predeterminado corregido
            mostrarAbrirCaja: false, // Controla la visibilidad del modal
            mostrarNuevoGasto: false, // Controla la visibilidad del formulario de nuevo gasto
        };
    },
    mounted() {
        this.currentDate = new Date().toLocaleDateString("es-VE", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
        });
    },
    methods: {
        navigateTo(item) {
            this.activeItem = item.name; // Actualiza el ítem activo
            if (item.path) {
                this.$router.push(item.path); // Navega a la ruta
            }
        },
    },
};
</script>
