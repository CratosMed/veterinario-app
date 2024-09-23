<template>
    <div>
        <div class="row d-flex">
            <!-- Menú lateral -->
            <nav :class="['sidebar', isSidebarOpen ? '' : 'd-none', 'col-md-12', 'col-lg-12', 'fondolateral']"
                id="sidebar">
                <div class="position-sticky top-0">
                    <!-- Botón de cierre "X" para pantallas pequeñas -->
                    <div class="d-md-none text-end pe-3 pt-2">
                        <button class="btn-close" @click="toggleSidebar"></button>
                    </div>
                    <div class="separacion"></div>
                    <ul class="nav flex-column">
                        <div class="alto"></div>
                        <li v-for="item in menuItems" :key="item.id" class="menu-item" @click="navigateTo(item)">
                            <i :class="item.icon" class="menu-icon"></i>
                            <span class="menu-label">{{ item.label }}</span>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isSidebarOpen: true,
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
        toggleSidebar() {
            this.isSidebarOpen = !this.isSidebarOpen;
        },
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
}

.alto {
    margin-top: 80%;
}

.d-flex {
    display: flex;
    min-height: 100vh;
    /* Se asegura de que el contenedor ocupe toda la altura de la pantalla */
}

.sidebar {
    height: 100vh;
    position: sticky;
    top: 0;
    z-index: 1;
    width: 276px;
    transition: transform 0.3s ease-in-out;
}

/* Estilo del menú */
.menu-item {
    display: flex;
    align-items: center;
    padding: 10px 20px;
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

/* Espaciado entre ícono y texto */
.menu-icon {
    margin-right: 15px;
    font-size: 20px;
}

.menu-label {
    margin-left: 5px;

    /* Sidebar ocultable para pantallas pequeñas */
    @media (max-width: 768px) {
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
            transform: translateX(-100%);
        }

        .sidebar.d-none {
            transform: translateX(-100%);
        }

        .sidebar:not(.d-none) {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
        }
    }

    /* Sidebar siempre visible en pantallas grandes */
    @media (min-width: 768px) {
        .sidebar {
            transform: none;
        }
    }
}
</style>
