<template>
    <div class="margen container-fluid ">
        <div class=" row d-flex justify-content-between align-items-center mb-3 py-2">
            <!-- Imagen de mascotas alineada al lado del menú lateral -->
            <div class="md-4">
                <div class="d-flex justify-content-center align-items-center mb-4 position-relative mascotas-container">
                    <img src="@/assets/mascotas.png" alt="Mascotas descansando"
                        class="img-fluid mascotas-img ext-primary me-auto" />

                    <h1 class="position-absolute top-10 start-50 translate-middle my-5 display-5 fw-bold ls-tight margen"
                        style="color: rgba(1, 157, 162, 0.25);">
                        Inversiones
                        <span class="texto" style="color: rgba(1, 157, 162, 0.75);"> CARU XV
                            <span class="peque" style="font-size: smaller; color: rgba(1, 157, 162, 0.75);">C.A.</span>
                        </span>
                    </h1>

                    <img src="@/assets/logo.png" alt="logo" class="img-fluid logo img-fluid" />
                </div>


                <!-- Contenido principal -->
                <main class="fondo">
                    <div class="row boxing-container">
                        <!-- Bloque Citas -->
                        <div class="col-12 col-md-6 mb-4">
                            <div class="box box-custom-size gradient-gray p-4">
                                <h5 class="box-title">Citas programadas para hoy</h5>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                </div>
                                <!-- Listado de citas -->
                                <ul class="list-group">
                                    <li v-for="(cita, index) in paginatedCitas" :key="index"
                                        class="list-group-item d-flex justify-content-between align-items-start p-3 mb-2 bg-light text-dark rounded">

                                        <!-- Contenedor principal -->
                                        <div class="d-flex flex-grow-1 mx-2 citas-item ">
                                            <!-- Título y Descripción -->
                                            <div class="flex-grow-1 d-flex flex-column citas-text">
                                                <h5 class="fw-bold mb-0 small-text">{{ cita.titulo }}</h5>
                                                <h6 class="mb-0 small-text">{{ cita.descripcion }}</h6>
                                            </div>

                                            <!-- Fecha, Hora y Recurrencia -->
                                            <div class="d-flex align-items-center ms-3 m-2 small-text fecha">
                                                {{ new Date(cita.fecha).toLocaleDateString('en-US') }} - {{ cita.hora }}
                                                - {{ cita.recurrencia }}
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <!-- Bloque 2 historias recientes -->
                        <div class="col-12 col-md-6 mb-4 table-responsive">
                            <div class="box box-custom-size gradient-gray p-4">
                                <h5 class="box-title mb-4">Historias recientes</h5>
                                <div class="box-content">
                                    <!-- Tabla de historias recientes -->
                                    <table class="table table-striped custom-table">
                                        <!-- Encabezado de la tabla -->
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Historia</th>
                                                <th scope="col" class="text-center">Nombre</th>
                                                <th scope="col" class="text-center">Cliente</th>
                                                <th scope="col" class="text-center">Motivo de Consulta</th>
                                            </tr>
                                        </thead>
                                        <!-- Cuerpo de la tabla -->
                                        <tbody>
                                            <tr v-for="historia in paginatedHistorias" :key="historia.id">
                                                <th scope="row" class="text-center">{{ historia.id }}</th>
                                                <td class="text-center">{{ historia.nombre_paciente }}</td>
                                                <td class="text-center">{{ historia.nombre_propietario }}</td>
                                                <td class="text-center">{{ historia.motivo_consulta }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary" type="button" @click="mostrarHistorias">Ver
                                            todas</button>
                                    </div>
                                </div>
                                <!-- <div class="pagination-controls">
                                    <button class="btn btn-secondary" @click="changePage(page - 1)"
                                        :disabled="page <= 1">
                                        Anterior
                                    </button>
                                    <span>Página {{ page }} de {{ totalPages }}</span>
                                    <button class="btn btn-secondary" @click="changePage(page + 1)"
                                        :disabled="page >= totalPages">
                                        Siguiente
                                    </button>
                                </div> -->
                            </div>
                        </div>

                        <!-- Bloque 3 -->
                        <hr />
                        <div class="col-12 col-md-6 mb-4 table-responsive margen">
                            <div class="box box-custom-size gradient-gray p-4">
                                <h5 class="box-title mb-4">Últimos registros de clientes</h5>
                                <div class="box-content">
                                    <!-- Tabla de registros de clientes -->
                                    <table class="table table-striped custom-table">
                                        <!-- Encabezado de la tabla -->
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Nombre</th>
                                                <th scope="col" class="text-center">Apellido</th>
                                                <th scope="col" class="text-center">Cédula</th>
                                                <th scope="col" class="text-center">Teléfono</th>
                                                <th scope="col" class="text-center">Deuda</th>
                                            </tr>
                                        </thead>
                                        <!-- Cuerpo de la tabla -->
                                        <tbody>
                                            <tr v-for="cliente in paginatedClientes" :key="cliente.cedula">
                                                <td class="text-center">{{ cliente.nombre }}</td>
                                                <td class="text-center">{{ cliente.apellido }}</td>
                                                <td class="text-center">{{ cliente.cedula }}</td>
                                                <td class="text-center">{{ cliente.telefono }}</td>
                                                <td class="text-center">{{ cliente.deuda }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary" type="button" @click="mostrarClientes">Ver
                                            todos</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Bloque 4 -->
                        <div class="col-12 col-md-6 mb-4 table-responsive">
                            <div class="box box-custom-size gradient-gray p-4  ">
                                <h5 class="box-title mb-4">Lista de deudores</h5>
                                <div class="box-content">
                                    <!-- Tabla de historias recientes -->
                                    <table class="table table-striped custom-table">
                                        <!-- Encabezado de la tabla -->
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Nombre</th>
                                                <th scope="col" class="text-center">Apellido</th>
                                                <th scope="col" class="text-center">Cédula</th>
                                                <th scope="col" class="text-center">Teléfono</th>
                                                <th scope="col" class="text-center">Deuda</th>
                                            </tr>
                                        </thead>
                                        <!-- Cuerpo de la tabla -->
                                        <tbody>
                                            <tr v-for="cliente in deudores" :key="cliente.cedula">
                                                <td class="text-center">{{ cliente.nombre }}</td>
                                                <td class="text-center">{{ cliente.apellido }}</td>
                                                <td class="text-center">{{ cliente.cedula }}</td>
                                                <td class="text-center">{{ cliente.telefono }}</td>
                                                <td class="text-center">{{ cliente.deuda }}</td>
                                            </tr>
                                        </tbody>

                                    </table>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary" type="button" @click="mostrarDeudores">Ver
                                            todos</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <ModalAgregarCliente />
                </main>
            </div>
        </div>
    </div>

</template>

<script>


import ModalAgregarCliente from '../components/ModalAgregarCliente.vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import ListaClientes from './ListaClientes.vue';

export default {
    name: 'DashboardView',
    setup() {
        const toast = useToast();

        function notify() {
            const audio = new Audio(require('@/assets/sounds/notification.mp3'));
            audio.play();
            toast.success('¡Esto es una notificación!');
        }

        return { notify };
    },
    components: {
        ModalAgregarCliente,
        ListaClientes
    },
    data() {
        return {
            historias: [],
            clientes: [],
            citas: [], // Para almacenar las historias recientes obtenidas de la API
            page: 1,
            pageSize: 10,
            isSidebarOpen: true,
            isDesktop: window.innerWidth >= 768,
            tiempoMinutos: 1, // Tiempo inicial en minutos
            tiempoRestante: 0, // Tiempo restante en segundos
            intervalo: null,
            mensaje: '',
        };
    },
    computed: {
        paginatedHistorias() {
            const start = (this.page - 1) * this.pageSize;
            const end = this.page * this.pageSize;
            return this.historias.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.historias.length / this.pageSize);
        },
        paginatedClientes() {
            const start = (this.page - 1) * this.pageSize;
            const end = this.page * this.pageSize;
            return this.clientes.slice(start, end);
        },
        totalPagesClientes() {
            return Math.ceil(this.clientes.length / this.pageSize);
        },
        paginatedCitas() {
            return this.citas.slice(0, 10); // Limita las citas a 10
        },
        deudores() {
            // Filtra a los clientes con deuda mayor a 0
            return this.clientes.filter(cliente => {
                const deudaValue = parseFloat(cliente.deuda.replace('$', '').replace(',', '').trim());
                return deudaValue > 0;
            });
        },
    },
    methods: {
        // Método para obtener historias recientes desde la API
        async fetchHistorias() {
            try {
                const response = await axios.get('http://localhost/veterinario-app/curso_apirest/historias?page=1'); // Reemplaza con tu URL
                this.historias = response.data;  // Asigna los datos obtenidos a 'historias'
                console.log(this.historias); //
            } catch (error) {
                console.error('Error al obtener las historias recientes:', error);
            }
        },
        mostrarHistorias() {
            this.$router.push('/historias');
        },
        Listaclientes() {
            this.$router.push('/listaclientes');
        },
        async fetchClientes() {
            try {
                const response = await axios.get("http://localhost/veterinario-app/curso_apirest/propietarios?page=1"); // Reemplaza con tu URL de clientes
                this.clientes = response.data;
            } catch (error) {
                console.error('Error al obtener los clientes:', error);
            }
        },
        async fetchCitas() {
            try {
                const response = await axios.get('http://localhost/veterinario-app/curso_apirest/citas?page=1');
                this.citas = response.data;
                console.log('Citas obtenidas:', this.citas); // Verifica los datos obtenidos
            } catch (error) {
                console.error('Error al obtener las citas:', error);
            }
        },
        mostrarClientes() {
            this.$router.push('/listaclientes');
        },
        mostrarDeudores() {
            this.$router.push('/deudores'); // Asegúrate de que esta ruta esté definida en tu router
        },
        toggleSidebar() {
            this.isSidebarOpen = !this.isSidebarOpen;
        },
        handleResize() {
            this.isDesktop = window.innerWidth >= 768;
            this.isSidebarOpen = this.isDesktop; // Muestra la sidebar si es desktop
        },
        changePage(newPage) {
            if (newPage > 0 && newPage <= this.totalPages) {
                this.page = newPage;
            }
        },
        estaCitaHoy(fecha) {
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0); // Ajustamos la hora de hoy a medianoche

            const citaFecha = new Date(fecha);
            citaFecha.setHours(0, 0, 0, 0); // Ajustamos la hora de la cita a medianoche

            return hoy.getTime() === citaFecha.getTime(); // Comparamos las fechas en milisegundos
        },
        filtrarCitasHoy() {
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0); // Ajustamos la hora a medianoche

            return this.citas.filter(cita => {
                const citaFecha = new Date(cita.fecha);
                citaFecha.setHours(0, 0, 0, 0); // Ajustamos la hora de la cita a medianoche
                return hoy.getTime() === citaFecha.getTime(); // Comparamos las fechas
            });
        },
    },
    mounted() {
        window.addEventListener('resize', this.handleResize);
        this.fetchHistorias(); // Llamada a la API al montar el componente
        this.fetchClientes();  // Llamada para cargar los clientes
        this.fetchCitas();     // Llamada para cargar las citas
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.handleResize);

    },
};

</script>



<style scoped>
.margen {
    right: 1px;
}

.table tbody tr {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    cursor: pointer;
}

.table tbody tr:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.table tbody tr:active {
    transform: translateY(-2px);
}

.list-group-item {
    border: none;
    border-radius: 10px;
    background: #f8f9fa;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    cursor: pointer;
    margin: 5px;
    min-height: 50px;
    /* Asegura un mínimo de altura */
    padding: 10px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    overflow: hidden;
    white-space: normal;
    /* Permite el salto de línea */
    word-wrap: break-word;
    /* Permite romper la palabra si es muy larga */
}

.citas-item {
    display: flex;
    justify-content: space-between;
    flex-direction: row;
    flex-wrap: wrap;
    /* Permite que el contenido se ajuste mejor */
    width: 100%;
    /* Asegura que ocupe todo el ancho disponible */
    align-items: center;
    /* Alinea verticalmente los elementos */
}

.citas-text {
    flex-grow: 1;
    /* Permite que el texto ocupe el espacio disponible */
    margin-right: 10px;
    /* Espacio entre el texto y la fecha */
    white-space: normal;
    /* Permite el salto de línea */
    word-wrap: break-word;
    /* Permite romper la palabra si es muy larga */
}

.fecha {
    flex-shrink: 0;
    /* Evita que la fecha se contraiga */
    min-width: 100px;
    /* Ancho mínimo para la fecha */
    text-align: right;
    /* Alinea la fecha a la derecha */
}

.list-group-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.list-group-item:active {
    transform: translateY(-2px);
}

.fondo {
    background-color: #e8f0fc;
    margin-top: -60px;
}

.p-4 {
    padding: 1.5rem !important;
}

.fondolateral {
    background: linear-gradient(to bottom, #045872, #034a58, #02343f);
    /* Azul oscuro para el fondo lateral */
}

/* Imagen de mascotas que sea responsiva */
.mascotas-img {
    max-width: 18%;
    /* Reducir tamaño de la imagen */
    height: 18%;
    position: relative;
    /* Hacer la imagen posicionable */
    z-index: 10;
    /* Poner la imagen delante de las tarjetas */
    margin-top: -10px;
    z-index: 0;
    /* Ajustar margen superior para acercar las patitas a las tarjetas */
}

.logo {
    max-width: 15%;
    /* Reducir tamaño de la imagen */
    height: 15%;
    position: relative;
    /* Hacer la imagen posicionable */
    z-index: 0;
    /* Poner la imagen delante de las tarjetas */
    /* Ajustar margen superior para acercar las patitas a las tarjetas */
}

/* Contenedor de la imagen para que quede alineado */
.mascotas-container {
    padding: 0;
    display: flex;
    justify-content: center;
    /* Centra la imagen */
}

/* Ajustes de las tarjetas */
.tarjetas-container {
    margin-top: -75px;
    padding: 1%;
    margin-left: 1px;
    /* Subir las tarjetas para colisionar con la imagen */

}


.card-custom-size {
    width: 100%;
    height: 700px;
    overflow: hidden;
    z-index: 1;
    /* Poner las tarjetas detrás de la imagen */
    position: relative;
    /* Hacer las tarjetas posicionables para aplicar z-index */

}

.card-body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    padding: 0;

}

.main-content {
    width: 100%;
    margin-left: 250px;
    /* Ajusta este valor según el ancho de tu barra lateral */
    position: relative;
    z-index: 1;
}

.footer {
    color: #ffffff;
    /* Texto blanco */
    padding: 20px 0;
    /* Espaciado vertical */
    text-align: center;
    /* Centra el texto */
    position: relative;
    /* Cambia a "absolute" si necesitas que esté detrás del contenido */
    z-index: 0;
    /* Asegura que el footer esté detrás del contenido */
}

.footer h5 {
    font-weight: bold;
}

.footer p {
    margin-bottom: 0;
}

/* Asegura que el footer esté al final de la página cuando hay suficiente contenido */
html,
body {
    height: 100%;
    margin: 0;
    overflow-x: hidden;
}

.nav {
    color: #ffffff;
    font-size: 16px;
    font-family: 'Poppins', sans-serif;
    margin-top: 50%;
    padding-left: 20%;
}

.img-fluid {
    /* Asegúrate de que no haya sombras aplicadas */
    box-shadow: none;
    opacity: 1;
    /* Asegúrate de que la opacidad esté al 100% */
}

.peque {
    font-size: 25px;
}

.pagination-controls {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 1rem;
}

.pagination-controls button {
    margin: 0 0.5rem;
}

.d-flex.flex-grow-1 {
    width: 100%;
    /* Asegúrate de que el contenedor principal ocupe todo el ancho */
}

.flex-grow-1.d-flex.flex-column {
    flex: 1;
    /* Permitir que este contenedor crezca para ocupar el espacio disponible */
}


.small-text {
    font-size: 1rem;
    white-space: normal;
    word-wrap: break-word;
    /* Evita que el texto muy largo salga del contenedor */
}

/* Ajustes para pantallas más pequeñas */
@media (max-width: 768px) {
    .small-text {
        font-size: 0.9rem;
        /* Ajusta el tamaño del texto en pantallas pequeñas */
    }

    .list-group-item {
        padding: 5px;
        /* Reduce el padding para más espacio en pantallas pequeñas */
    }

    .citas-item {
        flex-direction: column;
        /* Cambia a columna en pantallas más pequeñas */
    }

    .fecha {
        min-width: 70px;
        /* Reduce el ancho mínimo para pantallas pequeñas */
    }
}

@media (max-width: 767.98px) {

    .custom-table th,
    .custom-table td {
        font-size: 0.8rem;
        /* Ajusta este valor según tus necesidades */
    }
}
</style>