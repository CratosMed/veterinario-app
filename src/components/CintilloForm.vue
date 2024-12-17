<template>
    <header class="menu-bar d-flex align-items-center justify-content-between px-3 py-2 shadow-sm">
        <!-- Título del sistema -->
        <div class="system-title">
            <h2>Administración</h2>
        </div>

        <!-- Menú de navegación -->
        <nav class="d-flex flex-wrap">
            <a v-for="item in menuItems" :key="item.name" href="#" class="menu-item d-flex align-items-center"
                :class="{ active: activeItem === item.name }" @click.prevent="navigateTo(item)"
                :aria-label="'Ir a ' + item.name">
                <i :class="[item.icon, 'me-2']"></i>{{ item.name }}
            </a>
        </nav>

        <!-- Fecha y botones de acciones -->
        <div class="d-flex align-items-center">
            <span class="text-white me-3">{{ currentDate }}</span>
            <button class="btn btn-danger btn-sm me-3">Abrir Caja</button>
            <button class="btn btn-danger btn-sm me-3">Nueva Venta</button>
            <button class="btn btn-danger btn-sm">Nuevo Gasto</button>
        </div>
    </header>
</template>

<script>


export default {
    name: 'Cintilloform',
    components: {

    },

    data() {
        return {
            menuItems: [
                { id: 1, name: "Movimientos", path: '/movimientos', icon: "bi bi-cart" },
                { id: 2, name: "Estadísticas", path: '/estadisticas', icon: "bi bi-box" },
                { id: 3, name: "Inventario", path: '/inventario', icon: "bi bi-clock-history" },
                { id: 4, name: "Empleados", path: '/empleados', icon: "bi bi-people" },
                { id: 5, name: "Clientes", path: '/clientes', icon: "bi bi-people" },
                { id: 6, name: "Proveedores", path: '/proveedores', icon: "bi bi-cash-coin" },
            ],
            currentDate: "",
            activeItem: "Moviminentos", // Item activo predeterminado
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

<style scoped>
/* Estilos del menú */
.menu-bar {
    background-color: #007bff;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
}

.menu-item {
    color: #fff;
    text-decoration: none;
    margin-right: 15px;
    padding: 8px 12px;
    border-radius: 5px;
    transition: background-color 0.3s;
    display: inline-flex;
    align-items: center;
}

.menu-item:hover,
.menu-item.active {
    background-color: #0056b3;
    font-weight: bold;
}

.system-title h2 {
    font-size: 1.5rem;
    color: #fff;
    margin: 0;
}

.text-white {
    font-size: 0.9rem;
    font-weight: 500;
}

.btn-danger {
    font-size: 0.8rem;
    margin-bottom: 5px;
}

@media (max-width: 767px) {
    .menu-bar {
        flex-direction: column;
        align-items: flex-start;
    }

    .menu-item {
        margin: 5px 0;
    }

    .d-flex.align-items-center {
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .system-title {
        margin-bottom: 15px;
    }
}
</style>
