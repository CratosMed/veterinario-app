<template>
    <div class="margen container-fluid ">
        <div class=" row d-flex justify-content-between align-items-center mb-3 py-2">
            <!-- Imagen de mascotas alineada al lado del menú lateral -->
            <div class="md-4">
                <div class="d-flex justify-content-center align-items-center mb-4 position-relative mascotas-container">
                    <!-- Contenedor flexible para el texto y la imagen -->
                    <div class="d-flex align-items-center">
                        <!-- Título central -->
                        <h1 class="display-5 fw-bold ls-tight margen texto"
                            style="color: rgba(1, 157, 162, 0.25); margin-right: 10px;">
                            Inversiones
                            <span class="texto" style="color: rgba(1, 157, 162, 0.75);"> CARU XV
                                <span class="peque"
                                    style="font-size: smaller; color: rgba(1, 157, 162, 0.75);">C.A.</span>
                            </span>
                        </h1>

                        <!-- Imagen del logo al lado derecho del texto -->
                        <img src="@/assets/logo.png" alt="logo" class="img-fluid logo" style="max-width: 150px;" />
                    </div>
                </div>



                <!-- Contenido principal -->
                <main class="fondo">
                    <div class="row boxing-container">
                        <!-- Bloque Citas -->
                        <div class="col-12 col-md-6 mb-4">
                            <div class="box box-custom-size gradient-gray p-4">
                                <h5 class="box-title">Citas programadas para hoy</h5>
                                <ul class="list-group">
                                    <li v-for="(cita, index) in paginatedCitas" :key="index"
                                        class="list-group-item d-flex justify-content-between align-items-start p-3 mb-2 bg-light text-dark rounded">
                                        <div class="d-flex flex-grow-1 mx-2 citas-item">
                                            <div class="flex-grow-1 d-flex flex-column citas-text">
                                                <small class="text-muted" style="font-size: 0.99rem;">Paciente:
                                                    <span class="fw-bold">{{ obtenerNombrePaciente(cita.paciente_id)
                                                        }}</span>
                                                </small>
                                                <h5 class="fw-bold mb-0 small-text">{{ cita.titulo }}</h5>
                                                <h6 class="mb-0 small-text">{{ cita.descripcion }}</h6>
                                            </div>
                                            <div class="d-flex align-items-center ms-3 m-2 small-text fecha">
                                                {{ cita.fecha }} - {{ cita.hora }}
                                                - {{ cita.recurrencia }}
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Bloque Historias Recientes -->
                        <div class="col-12 col-md-6 mb-4 ">
                            <div class="box box-custom-size gradient-gray p-4">
                                <h5 class="box-title mb-4">Historias recientes</h5>
                                <div class="box-content table-responsive">
                                    <table class="table table-striped custom-table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Historia</th>
                                                <th scope="col" class="text-center">Nombre</th>
                                                <th scope="col" class="text-center">Cliente</th>
                                                <th scope="col" class="text-center">Motivo de Consulta</th>
                                            </tr>
                                        </thead>
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
                            </div>
                        </div>

                        <!-- Últimos Registros de Clientes -->
                        <div class="col-12 col-md-6 mb-4">
                            <div class="box box-custom-size gradient-gray p-4">
                                <h5 class="box-title mb-4">Últimos registros de clientes</h5>
                                <div class="box-content table-responsive">
                                    <table class="table table-striped custom-table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Nombre</th>
                                                <th scope="col" class="text-center">Apellido</th>
                                                <th scope="col" class="text-center">Cédula</th>
                                                <th scope="col" class="text-center">Teléfono</th>
                                                <th scope="col" class="text-center">Deuda</th>
                                            </tr>
                                        </thead>
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

                        <!-- Lista de Deudores -->
                        <div class="col-12 col-md-6 mb-4">
                            <div class="box box-custom-size gradient-gray p-4">
                                <h5 class="box-title mb-4">Lista de deudores</h5>
                                <div class="box-content table-responsive">
                                    <table class="table table-striped custom-table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Nombre</th>
                                                <th scope="col" class="text-center">Apellido</th>
                                                <th scope="col" class="text-center">Cédula</th>
                                                <th scope="col" class="text-center">Teléfono</th>
                                                <th scope="col" class="text-center">Deuda</th>
                                            </tr>
                                        </thead>
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
            pacientes: [],
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
            // Ordenar las historias por ID en orden descendente
            const sortedHistorias = this.historias.sort((a, b) => b.id - a.id);

            const start = (this.page - 1) * this.pageSize;
            const end = this.page * this.pageSize;
            return sortedHistorias.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.historias.length / this.pageSize);
        },
        paginatedClientes() {
            const sortedClientes = this.clientes.sort((a, b) => b.id - a.id);
            const start = (this.page - 1) * this.pageSize;
            const end = this.page * this.pageSize;
            return sortedClientes.slice(start, end);
        },
        totalPagesClientes() {
            return Math.ceil(this.clientes.length / this.pageSize);
        },
        paginatedCitas() {
            const citasHoy = this.filtrarCitasHoy(); // Obtiene las citas de hoy
            return citasHoy.slice(0, 7); // Limita las citas a 10
        },
        deudores() {
            // Filtra a los clientes con deuda mayor a 0 y los ordena por ID en orden descendente
            return this.clientes
                .filter(cliente => {
                    const deudaValue = parseFloat(cliente.deuda.replace('$', '').replace(',', '').trim());
                    return deudaValue > 0; // Filtra los deudores
                })
                .sort((a, b) => b.id - a.id) // Ordena por ID en orden descendente
                .slice(0, 10); // Limita el array resultante a 10 elementos
        },
    },
    methods: {
        obtenerNombrePaciente(paciente_id) {
            const paciente = this.pacientes.find(p => p.id === paciente_id);
            return paciente ? paciente.nombre : 'Desconocido';
        },
        // Método para obtener historias recientes desde la API
        async fetchHistorias() {
            try {
                const response = await axios.get('http://192.168.10.1/veterinario-app/curso_apirest/historias?page=1'); // Reemplaza con tu URL
                this.historias = response.data;  // Asigna los datos obtenidos a 'historias'
                console.log(this.historias); //
            } catch (error) {
                console.error('Error al obtener las historias recientes:', error);
            }
        },
        mostrarHistorias() {
            this.$router.push('/listapacientes');
        },
        Listaclientes() {
            this.$router.push('/listaclientes');
        },
        async fetchClientes() {
            try {
                const response = await axios.get("http://192.168.10.1/veterinario-app/curso_apirest/propietarios?page=1"); // Reemplaza con tu URL de clientes
                this.clientes = response.data;
            } catch (error) {
                console.error('Error al obtener los clientes:', error);
            }
        },
        async fetchPacientes() {
            console.log('Iniciando fetchPacientes');
            try {
                const response = await axios.get('http://192.168.10.1/veterinario-app/curso_apirest/pacientes?page=1'); // Cambia la URL según sea necesario
                console.log('Respuesta de la API para pacientes:', response.data);

                // Asegúrate de que la respuesta sea un array
                this.pacientes = Array.isArray(response.data) ? response.data : [];
                console.log('Pacientes asignados:', this.pacientes);
            } catch (error) {
                console.error('Error al consultar la API de pacientes:', error);
            }
        },
        async fetchCitas() {
            try {
                const response = await axios.get('http://192.168.10.1/veterinario-app/curso_apirest/citas?page=1');
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

                // Sumar un día a la fecha de la cita
                citaFecha.setDate(citaFecha.getDate() + 1);

                // Calculamos la diferencia en milisegundos
                const diferencia = citaFecha - hoy;

                // Convertimos la diferencia a días
                const diferenciaEnDias = Math.floor(diferencia / (1000 * 60 * 60 * 24));

                // Mostrar la diferencia en días en la consola
                console.log(`Diferencia para la cita ${cita.fecha}: ${diferenciaEnDias} días`);

                // Puedes asignar valores según la diferencia
                if (diferenciaEnDias === 0) {
                    // Cita es hoy (después de sumar un día)
                    return true; // Mantener la cita
                } else if (diferenciaEnDias > 0) {
                    // Cita es en el futuro
                    // Puedes hacer algo aquí si lo necesitas
                    return false; // O mantener o no la cita según lo que necesites
                } else {
                    // Cita es en el pasado
                    // Puedes hacer algo aquí si lo necesitas
                    return false; // O mantener o no la cita según lo que necesites
                }
            });
        },




    },
    mounted() {
        window.addEventListener('resize', this.handleResize);
        this.fetchHistorias(); // Llamada a la API al montar el componente
        this.fetchClientes();  // Llamada para cargar los clientes
        this.fetchCitas();     // Llamada para cargar las citas
        this.fetchPacientes();     // Llamada para cargar las citas

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
.logo {
    max-width: 11%;
    /* Reducir tamaño de la imagen */
    height: 11%;
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

    .custom-table {
        table-layout: fixed;
        width: 100%;
        word-wrap: break-word;
    }

    .custom-table th,
    .custom-table td {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .table-responsive {
        max-height: 300px;
        /* Limita la altura de la tabla, ajusta según sea necesario */
        overflow-y: auto;
        /* Activa el desplazamiento vertical si el contenido excede */
        width: 100%;
        /* Asegura que las tablas ocupen todo el ancho disponible */


    }

    .box-custom-size {
        max-height: 400px;
        /* Limita la altura de cada caja para evitar crecimiento excesivo */
        overflow-y: auto;

    }

    .texto {
        font-size: 4vw;
    }

    .boxing-container {
        display: flex;
        /* Usa flex para que se muestren en fila */
        flex-wrap: wrap;
        /* Permite que los elementos se ajusten si no caben en una fila */
    }

    .col-12 {
        flex: 1 0 50%;
        /* Ajusta el ancho para ocupar aproximadamente la mitad de la fila */
        margin: 1%;
        /* Espaciado entre las columnas */
    }



    /* Ajusta el tamaño del texto si es necesario */
    .small-text {
        font-size: 1.1rem;
        /* Ajusta el tamaño del texto */
    }

    .texto {
        font-size: 3vw;
        /* Ajusta el tamaño del texto en pantalla grande */
    }
}

@media (max-width: 1024px) {
    .texto {
        font-size: 2.5vw;
    }
}



.custom-table {
    table-layout: fixed;
    width: 100%;
    word-wrap: break-word;
}

.custom-table th,
.custom-table td {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.table-responsive {
    max-height: 300px;
    /* Limita la altura de la tabla, ajusta según sea necesario */
    overflow-y: auto;
    /* Activa el desplazamiento vertical si el contenido excede */
}

.box-custom-size {
    max-height: 400px;
    /* Limita la altura de cada caja para evitar crecimiento excesivo */
    overflow-y: auto;
}

/* Para ajustar la relación de tamaño en diferentes resoluciones */
@media (max-width: 768px) {
    h1 {
        font-size: 1.5rem;

        /* Espacio entre el texto y el logo */
        /* Reducir el tamaño del texto en pantallas pequeñas */
    }

    .logo {
        max-width: 40px;


        /* Reducir el tamaño de la imagen en pantallas pequeñas */
    }
}

.table-responsive {
    overflow-x: auto;
    /* Mantiene el comportamiento responsivo */
}

table {
    table-layout: fixed;
    /* Mantiene el ancho fijo de las celdas */
    width: 100%;
    /* Hace que la tabla ocupe el 100% del contenedor */
}

th,
td {
    white-space: normal;
    /* Permite que el contenido ocupe varias líneas */
    word-wrap: break-word;
    /* Fuerza al texto a ajustarse dentro de las celdas */
}

td {
    max-width: 150px;
    /* Ajusta este valor según el diseño para evitar la expansión */
}
</style>