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
                                <h5 class="box-title mb-4">Citas</h5>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="dropdown w-100">
                                        <button class="btn btn-outline-danger dropdown-toggle w-100" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Jan 2019
                                        </button>
                                    </div>
                                </div>

                                <!-- Listado de recordatorios -->
                                <ul class="list-group">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-start p-3 mb-2 bg-light text-dark rounded">
                                        <div class="d-flex flex-column align-items-center me-3">
                                            <span class="badge bg-danger rounded-pill">06</span>
                                            <small class="text-muted">THU</small>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="fw-bold">Yoga</h6>
                                            <small>16:40 every week</small>
                                        </div>

                                        <span class="badge bg-success align-self-center">Every Week</span>
                                    </li>

                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-start p-3 mb-2 bg-light text-dark rounded">
                                        <div class="d-flex flex-column align-items-center me-3">
                                            <span class="badge bg-danger rounded-pill">08</span>
                                            <small class="text-muted">SAT</small>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="fw-bold">Call John</h6>
                                            <small>15:20 once</small>
                                        </div>
                                        <span class="badge bg-danger align-self-center">Once</span>
                                    </li>

                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-start p-3 mb-2 bg-light text-dark rounded">
                                        <div class="d-flex flex-column align-items-center me-3">
                                            <span class="badge bg-danger rounded-pill">19</span>
                                            <small class="text-muted">TUE</small>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="fw-bold">Shopping</h6>
                                            <small>12:15 once</small>
                                        </div>
                                        <span class="badge bg-danger align-self-center">Once</span>
                                    </li>

                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-start p-3 mb-2 bg-light text-dark rounded">
                                        <div class="d-flex flex-column align-items-center me-3">
                                            <span class="badge bg-danger rounded-pill">25</span>
                                            <small class="text-muted">MON</small>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="fw-bold">Pool</h6>
                                            <small>16:15 every week</small>
                                        </div>
                                        <span class="badge bg-success align-self-center">Every Week</span>
                                    </li>

                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-start p-3 mb-2 bg-light text-dark rounded">
                                        <div class="d-flex flex-column align-items-center me-3">
                                            <span class="badge bg-danger rounded-pill">31</span>
                                            <small class="text-muted">SUN</small>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="fw-bold">House Cleaning</h6>
                                            <small>16:15 every month</small>
                                        </div>
                                        <span class="badge bg-warning align-self-center">Every Month</span>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <!-- Bloque 2 historias recientes -->
                        <div class="col-12 col-md-6 mb-4 table-responsive">
                            <div class="box box-custom-size gradient-gray p-4">
                                <h5 class="box-title mb-4">Historias recientes</h5>
                                <div class="box-content">
                                    <!-- Agregar la estructura de la tabla correctamente -->
                                    <table class="table table-striped ">
                                        <!-- Encabezado de la tabla -->
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Historia</th>
                                                <th scope="col" class="text-center">Nombre</th>
                                                <th scope="col" class="text-center">Estado reproductivo</th>
                                            </tr>
                                        </thead>
                                        <!-- Cuerpo de la tabla -->
                                        <tbody>
                                            <tr v-for="historia in paginatedHistorias" :key="historia.id">
                                                <th scope="row" class="text-center">{{ historia.id }}</th>
                                                <td class="text-center">{{ historia.nombre_paciente }}</td>
                                                <td class="text-center">{{ historia.estado_reproductivo }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" type="button" @click="mostrarHistorias">Ver
                                        todas</button>
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
                        <div class="col-12 col-md-6 mb-4  table-responsive">
                            <div class="box box-custom-size gradient-gray p-4">
                                <h5 class="box-title mb-4">Últimos registros de clientes</h5>
                                <div class="box-content">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    Nombre</th>
                                                <th scope="col">Apellido</th>
                                                <th scope="col">Cédula</th>
                                                <th scope="col">Teléfono </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>frf</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">4</th>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>@fat</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" type="button" @click="Listaclientes">Ver
                                        todos</button>
                                </div>
                            </div>
                        </div>
                        <!-- Bloque 4 -->
                        <div class="col-12 col-md-6 mb-4">
                            <div class="box box-custom-size gradient-gray p-4">
                                <h5 class="box-title mb-4">Recordatorios hoy</h5>
                                <div class="box-content">
                                    <form @submit.prevent="iniciarTemporizador">
                                        <div class="mb-3">
                                            <label for="tiempo" class="form-label">Tiempo en minutos</label>
                                            <input type="number" class="form-control" id="tiempo"
                                                v-model.number="tiempoMinutos" min="1" required />
                                        </div>
                                        <button type="submit" class="btn btn-primary">Iniciar Temporizador</button>
                                    </form>
                                    <p v-if="tiempoRestante > 0" class="mt-3">Tiempo restante: {{ tiempoRestante }}
                                        segundos</p>
                                    <p v-if="mensaje" class="mt-3 alert alert-success">{{ mensaje }}</p>
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
            historias: [],  // Para almacenar las historias recientes obtenidas de la API
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
        }
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
            this.$router.push('/listacliente');
        },
        toggleSidebar() {
            this.isSidebarOpen = !this.isSidebarOpen;
        },
        handleResize() {
            this.isDesktop = window.innerWidth >= 768;
            this.isSidebarOpen = this.isDesktop; // Muestra la sidebar si es desktop
        },
        iniciarTemporizador() {
            this.detenerTemporizador(); // Detén cualquier temporizador en curso
            this.tiempoRestante = this.tiempoMinutos * 60;
            this.intervalo = setInterval(() => {
                if (this.tiempoRestante > 0) {
                    this.tiempoRestante--;
                } else {
                    this.detenerTemporizador();
                    this.mensaje = '¡El tiempo ha terminado!';
                    setTimeout(() => this.mensaje = '', 5000); // Oculta el mensaje después de 5 segundos
                }
            }, 1000);
        },
        detenerTemporizador() {
            clearInterval(this.intervalo);
            this.intervalo = null;
        },
        changePage(newPage) {
            if (newPage > 0 && newPage <= this.totalPages) {
                this.page = newPage;
            }
        }
    },
    mounted() {
        window.addEventListener('resize', this.handleResize);
        this.fetchHistorias(); // Llamada a la API al montar el componente
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.handleResize);

    }
};

</script>



<style scoped>
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
</style>