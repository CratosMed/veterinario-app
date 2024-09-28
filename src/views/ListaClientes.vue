<template>
    <div class="container mt-4 fondo table-responsive">
        <!-- Campo de búsqueda -->
        <input type="text" v-model="searchQuery" class="form-control" placeholder="Buscar..." />

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
                <tr v-for="(cliente, index) in filteredAndSortedRows" :key="index">
                    <td>{{ cliente.nombre }}</td>
                    <td>{{ cliente.apellido }}</td>
                    <td>{{ cliente.cedula }}</td>
                    <td>{{ cliente.telefono }}</td>
                    <td>{{ cliente.correo }}</td>
                    <td>{{ cliente.deuda }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary me-2" @click="editarCliente(cliente.id)">Editar</button>
                        <button class="btn btn-sm btn-danger" @click="deleteCliente(cliente.id)">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>
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
            sortOrder: 1
        };
    },
    computed: {
        filteredAndSortedRows() {
            let filteredClientes = this.clientes.filter((cliente) =>
                Object.values(cliente).join(" ").toLowerCase().includes(this.searchQuery.toLowerCase())
            );
            return filteredClientes.sort((a, b) => {
                if (a[this.sortKey] < b[this.sortKey]) return -1 * this.sortOrder;
                if (a[this.sortKey] > b[this.sortKey]) return 1 * this.sortOrder;
                return 0;
            });
        },
    },
    methods: {
        fetchClientes() {
            axios.get("http://localhost/veterinario-app/curso_apirest/propietarios?page=1")
                .then((response) => {
                    this.clientes = response.data;
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
            // Redirige a la vista de editar cliente con el ID del cliente
            this.$router.push({ name: 'editarCliente', params: { id: id } });
        },
        deleteCliente(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este cliente?")) {
                axios
                    .delete(`http://localhost/veterinario-app/curso_apirest/propietarios`, {
                        data: { id: id },
                    })
                    .then((response) => {
                        if (response.status === 200) {
                            // Cliente eliminado correctamente
                            alert("Cliente eliminado correctamente");
                            // Aquí actualiza la lista de clientes después de eliminar
                            this.fetchClientes();
                        }
                    })
                    .catch((error) => {
                        if (error.response && error.response.status === 409) {
                            // Error de restricción de clave foránea (409 Conflict)
                            alert(
                                "No se puede eliminar el cliente porque tiene pacientes asociados."
                            );
                        } else {
                            // Otro tipo de error
                            alert("Ocurrió un error al intentar eliminar el cliente.");
                        }
                    });
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