<template>
    <div>
        <div class="row d-flex">
            <!-- Menú lateral -->
            <nav :class="['sidebar', 'fondolateral', isSidebarOpen ? 'sidebar-open' : 'sidebar-collapsed']"
                id="sidebar">
                <div class="position-sticky top-0">
                    <div class="separacion"></div>
                    <ul class="nav flex-column">
                        <div class="alto"></div>
                        <li v-for="item in menuItems" :key="item.id" class="menu-item" @click="navigateTo(item)">
                            <i :class="item.icon" class="menu-icon"></i>
                            <!-- Solo se muestra el texto si el menú está abierto -->
                            <span v-if="isSidebarOpen" class="menu-label">{{ item.label }}</span>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isSidebarOpen: {
            type: Boolean,
            required: true,
        },
    },
    data() {
        return {
            menuItems: [
                { id: 1, label: 'Inicio', path: '/', icon: 'bi bi-house-door' },
                { id: 2, label: 'Agregar Paciente', path: '/agregarPaciente', icon: 'bi bi-person-plus' },
                { id: 3, label: 'Lista de Pacientes', path: '/listaPacientes', icon: 'bi bi-list-ul' },
                { id: 4, label: 'Agregar Cliente', path: '/agregarCliente', icon: 'bi bi-person-plus' },
                { id: 5, label: 'Lista de Clientes', path: '/listaClientes', icon: 'bi bi-list-ul' },
                { id: 6, label: 'Citas', path: '/citas', icon: 'bi bi-calendar-event' },
                { id: 7, label: 'Deudores', path: '/deudores', icon: 'bi bi-receipt' },
                { id: 8, label: 'Actualizaciones', path: '/actualizacion', icon: 'bi bi-arrow-clockwise' },
            ]
        };
    },
    methods: {
        navigateTo(item) {
            if (item.path === '/logout') {
                this.$router.push('/');
            } else {
                this.$router.push(item.path);
            }
        }
    }
};
</script>

<style scoped>
.fondolateral {
    background: linear-gradient(to bottom, #045872, #034a58, #02343f);
    z-index: 1000;
}

/* Estilo del menú colapsado */
.sidebar-collapsed {
    width: 60px;
    /* Ajusta según el tamaño que prefieras */
    transition: width 0.3s ease;
}

.sidebar-open {
    width: 220px;
    /* Ancho del menú cuando está abierto */
    transition: width 0.3s ease;
}

.alto {
    margin-top: 60%;
}

.d-flex {
    display: flex;
    min-height: 100vh;
}

/* Estilo del menú */
.menu-item {
    display: flex;
    align-items: center;
    padding: 10px 10px;
    color: #ffffff;
    font-size: 16px;
    font-family: 'Poppins', sans-serif;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.menu-item:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.menu-icon {
    margin-right: 15px;
    font-size: 20px;
}

/* Esconde el texto cuando el menú está colapsado */
.sidebar-collapsed .menu-label {
    display: none;
}

/* Ajusta la alineación de los íconos en el menú colapsado */
.sidebar-collapsed .menu-icon {
    margin-right: 0;
    text-align: center;
    width: 100%;
}

.menu-label {
    margin-left: 5px;
}

.separacion {
    height: 60px;
}
</style>
