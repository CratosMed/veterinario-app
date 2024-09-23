<template>
    <div class="container mt-4 fondo">
        <div class="d-grid gap-2">
            <div class="d-flex justify-content-between align-items-center mb-3 sticky-top py-2">
                <h2 class="text-primary me-auto">Historias de pacientes</h2>
            </div>
        </div>

        <!-- Campo de búsqueda -->
        <div class="mb-3">
            <input type="text" v-model="searchQuery" class="form-control" placeholder="Buscar paciente..." />
        </div>

        <!-- Tabla personalizada con datos de la API -->
        <table class="table custom-table align-middle">
            <thead>
                <tr>
                    <th @click="sortTable('id')">Nro <span :class="getSortIcon('id')"></span></th>
                    <th @click="sortTable('nombre')">Nombre <span :class="getSortIcon('nombre')"></span></th>
                    <th @click="sortTable('nombre_propietario')">Cliente <span
                            :class="getSortIcon('nombre_propietario')"></span></th>
                    <th @click="sortTable('genero')">Genero <span :class="getSortIcon('genero')"></span></th>
                    <th @click="sortTable('color')">Color <span :class="getSortIcon('color')"></span></th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(paciente, index) in filteredAndSortedpacientes" :key="index"
                    @click="selectpaciente(paciente)" :class="{ 'selected-paciente': selectedpaciente === paciente }">
                    <td>{{ paciente.id }}</td>
                    <td>{{ paciente.nombre }}</td>
                    <td>{{ paciente.nombre_propietario }}</td>
                    <td>{{ paciente.genero }}</td>
                    <td>{{ paciente.color }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary me-2" @click.stop="editPaciente(paciente.id)">
                            Editar
                        </button>
                        <button class="btn btn-sm btn-danger" @click.stop="deletePaciente(paciente)">
                            Eliminar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Paginación -->
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
import axios from 'axios';

export default {
    data() {
        return {
            searchQuery: "",
            pacientes: [],
            selectedpaciente: null,
            sortKey: "id",
            sortOrder: 1,
            currentPage: 1,
            totalPages: 3,
        };
    },
    computed: {
        filteredAndSortedpacientes() {
            let filteredPacientes = this.pacientes.filter((paciente) =>
                Object.values(paciente).join(" ").toLowerCase().includes(this.searchQuery.toLowerCase())
            );
            return filteredPacientes.sort((a, b) => {
                if (a[this.sortKey] < b[this.sortKey]) return -1 * this.sortOrder;
                if (a[this.sortKey] > b[this.sortKey]) return 1 * this.sortOrder;
                return 0;
            });
        },
    },
    methods: {
        async fetchHistorias() {
            try {
                const response = await axios.get(`http://localhost/veterinario-app/curso_apirest/pacientes?page=${this.currentPage}`);
                this.pacientes = response.data;
            } catch (error) {
                console.error("Error al cargar los datos:", error);
            }
        },
        sortTable(column) {
            if (this.sortKey === column) {
                this.sortOrder *= -1;
            } else {
                this.sortKey = column;
                this.sortOrder = 1;
            }
        },
        getSortIcon(column) {
            if (this.sortKey === column) {
                return this.sortOrder === 1 ? "bi bi-arrow-up" : "bi bi-arrow-down";
            }
            return "";
        },
        selectpaciente(paciente) {
            this.$router.push({ path: `/detalleshistorias/${paciente.id}` });
        },
        editPaciente(pacienteId) {
            // Redirigir a la página de edición del paciente
            this.$router.push({ path: `/editarPaciente/${pacienteId}` });
        },
        async deletePaciente(paciente) {
            const confirmed = confirm(`¿Estás seguro de que quieres eliminar al paciente ${paciente.nombre}?`);
            if (confirmed) {
                try {
                    const response = await axios.delete(`http://localhost/veterinario-app/curso_apirest/pacientes`, {
                        data: { id: paciente.id }
                    });
                    console.log(response); // Verifica la respuesta
                    this.pacientes = this.pacientes.filter(p => p.id !== paciente.id);
                    alert(`El paciente ${paciente.nombre} ha sido eliminado.`);
                } catch (error) {
                    alert("Error al intentar eliminar el paciente.");
                    console.error(error);
                }

            }
        },

        goToPage(page) {
            this.currentPage = page;
            this.fetchHistorias();
        },
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.fetchHistorias();
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.fetchHistorias();
            }
        },
    },
    mounted() {
        this.fetchHistorias();
    },
};
</script>

<style scoped>
/* Estilos de la tabla */
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
