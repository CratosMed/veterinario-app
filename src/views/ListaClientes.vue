<template>
    <div class="container mt-4 fondo table-responsive">
        <div class="d-grid gap-2">
            <div class="d-flex justify-content-between align-items-center mb-3 py-2">
                <h4 class="text-primary me-auto">Lista Clientes</h4>
            </div>
        </div>
        <!-- Campo de búsqueda -->
        <input type="text" v-model="searchQuery" class="form-control" placeholder="Buscar..." />
        <br />

        <!-- Tabla de clientes -->
        <table class="table custom-table ">
            <thead>
                <tr>
                    <th @click="sortTable('nombre')">Nombre</th>
                    <th @click="sortTable('apellido')">Apellido</th>
                    <th @click="sortTable('cedula')">Cédula</th>
                    <th>Teléfono</th>
                    <th>E-mail</th>
                    <th>Deuda</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(cliente, index) in filteredAndSortedRows" :key="index" @click="selectcliente(cliente)"
                    :class="{ 'selected-cliente': selectedcliente === cliente }">
                    <td>{{ cliente.nombre }}</td>
                    <td>{{ cliente.apellido }}</td>
                    <td>{{ cliente.cedula }}</td>
                    <td>{{ cliente.telefono }}</td>
                    <td>{{ cliente.correo }}</td>
                    <td>{{ cliente.deuda }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning me-2" @click.stop="editarCliente(cliente.id)">
                            <i class="bi bi-pencil"></i> <!-- Icono de editar -->
                        </button>
                        <button class="btn btn-sm btn-danger" @click.stop="deleteCliente(cliente.id)">
                            <i class="bi bi-trash"></i> <!-- Icono de eliminar -->
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <nav>
            <ul class="pagination justify-content-end">
                <li class="page-item" v-if="currentPage > 1" @click="previousPage">
                    <a class="page-link" href="#" aria-label="Anterior">&laquo;</a>
                </li>
                <li class="page-item" v-for="page in totalPages" :key="page" @click="goToPage(page)">
                    <a class="page-link" href="#">{{ page }}</a>
                </li>
                <li class="page-item" v-if="currentPage < totalPages" @click="nextPage">
                    <a class="page-link" href="#" aria-label="Siguiente">&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            searchQuery: "",
            clientes: [],
            sortKey: "",
            sortOrder: 1,
            selectedcliente: null,
            currentPage: 1, // Página actual
            itemsPerPage: 10, // Elementos por página
        };
    },
    computed: {
        filteredAndSortedRows() {
            // Filtra los clientes con base en el término de búsqueda
            let filteredClientes = this.clientes.filter((cliente) =>
                Object.values(cliente).join(" ").toLowerCase().includes(this.searchQuery.toLowerCase())
            );

            // Ordenar los clientes si se seleccionó una columna de ordenación
            if (this.sortKey) {
                filteredClientes.sort((a, b) => {
                    if (a[this.sortKey] < b[this.sortKey]) return -1 * this.sortOrder;
                    if (a[this.sortKey] > b[this.sortKey]) return 1 * this.sortOrder;
                    return 0;
                });
            }

            // Calcular el índice inicial y final según la página actual y elementos por página
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = this.currentPage * this.itemsPerPage;

            // Retornar los elementos de la página actual
            return filteredClientes.slice(start, end);
        },
        totalPages() {
            // Calcular el total de páginas basado en el número de clientes filtrados
            return Math.ceil(
                this.clientes.filter((cliente) =>
                    Object.values(cliente).join(" ").toLowerCase().includes(this.searchQuery.toLowerCase())
                ).length / this.itemsPerPage
            );
        }
    },
    methods: {
        selectcliente(cliente) {
            this.$router.push({ path: `/detallesclientes/${cliente.id}` });
        },
        fetchClientes() {
            axios.get("http://192.168.10.1/veterinario-app/curso_apirest/propietarios?page=1")
                .then((response) => {
                    this.clientes = response.data.sort((a, b) => b.id - a.id);
                })
                .catch((error) => {
                    console.error("Error fetching clients:", error);
                });
        },
        sortTable(key) {
            this.sortKey = key;
            this.sortOrder *= -1;
        },
        editarCliente(id) {
            this.$router.push({ name: 'editarCliente', params: { id: id } });
        },
        deleteCliente(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este cliente?")) {
                axios
                    .delete(`http://192.168.10.1/veterinario-app/curso_apirest/propietarios`, {
                        data: { id: id },
                    })
                    .then((response) => {
                        if (response.status === 200) {
                            alert("Cliente eliminado correctamente");
                            this.fetchClientes();
                        }
                    })
                    .catch((error) => {
                        if (error.response && error.response.status === 409) {
                            alert("No se puede eliminar el cliente porque tiene pacientes asociados.");
                        } else {
                            alert("Ocurrió un error al intentar eliminar el cliente.");
                        }
                    });
            }
        },
        goToPage(page) {
            this.currentPage = page;
        },
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        }
    },
    mounted() {
        this.fetchClientes();
    }
};
</script>



<style scoped>
/* Estilos aquí */
</style>


<style scoped>
.container {
    max-width: 100%;
}

.custom-table {
    border-collapse: collapse;
    width: 100%;
}

.custom-table thead {
    background-color: #f8f9fa;
}

.custom-table th,
.custom-table td {
    padding: 12px;
    border-bottom: 1px solid #dee2e6;
}

.custom-table tbody tr:hover {
    background-color: #f1f1f1;
    cursor: pointer;
}

.custom-table tbody .selected-row {
    background-color: #e2e6ea;
}

.custom-table td {
    border-top: none;
    vertical-align: middle;
}

.custom-table th {
    border-top: none;
    border-bottom: 2px solid #dee2e6;
    cursor: pointer;
}

/* Iconos de Bootstrap */
.bi {
    margin-left: 5px;
}

/* Estilo para los botones */
.btn {
    margin-right: 10px;
}

.pagination .page-item .page-link {
    color: #007bff;
}

.fondo {
    background-color: #e8f0fc;
    margin-top: -60px;
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
</style>