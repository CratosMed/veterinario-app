<template>
    <div class="container mt-4 fondo">
        <div class="d-grid gap-2">
            <div class="d-flex justify-content-between align-items-center mb-3 sticky-top py-2">
                <h2 class="text-primary me-auto">Historias de pacientes</h2>
            </div>
        </div>

        <!-- Campo de búsqueda -->
        <div class="mb-3">
            <input type="text" v-model="searchQuery" class="form-control" placeholder="Buscar..." />
        </div>

        <!-- Tabla personalizada con datos de la API -->
        <table class="table custom-table align-middle">
            <thead>
                <tr>
                    <th @click="sortTable('historiaClinica')">
                        Historia clínica
                        <span :class="getSortIcon('historiaClinica')"></span>
                    </th>
                    <th @click="sortTable('nombre')">
                        Nombre
                        <span :class="getSortIcon('nombre')"></span>
                    </th>
                    <th @click="sortTable('cliente')">
                        Cliente
                        <span :class="getSortIcon('cliente')"></span>
                    </th>
                    <th @click="sortTable('comida')">
                        Comida
                        <span :class="getSortIcon('comida')"></span>
                    </th>
                    <th @click="sortTable('temperatura')">
                        Temperatura
                        <span :class="getSortIcon('temperatura')"></span>
                    </th>
                    <th @click="sortTable('frecuencia_cardiaca')">
                        Frecuencia cardiaca
                        <span :class="getSortIcon('frecuencia_cardiaca')"></span>
                    </th>
                    <th @click="sortTable('peso')">
                        Peso
                        <span :class="getSortIcon('peso')"></span>
                    </th>
                    <th @click="sortTable('motivo_consulta')">
                        Motivo consulta
                        <span :class="getSortIcon('motivo_consulta')"></span>
                    </th>
                    <th @click="sortTable('actitud')">
                        Actitud
                        <span :class="getSortIcon('actitud')"></span>
                    </th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in filteredAndSortedRows" :key="index" @click="selectRow(row)"
                    :class="{ 'selected-row': selectedRow === row }">
                    <td>{{ row.id }}</td>
                    <td>{{ row.nombre_paciente }}</td>
                    <td>{{ row.nombre_propietario }}</td>
                    <td>{{ row.comida }}</td>
                    <td>{{ row.temperatura }}</td>
                    <td>{{ row.frecuencia_cardiaca }}</td>
                    <td>{{ row.peso }}</td>
                    <td>{{ row.motivo_consulta }}</td>
                    <td>{{ row.actitud }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary me-2" @click.stop="editRow(row.id)">
                            Ver
                        </button>
                        <button class="btn btn-sm btn-danger" @click.stop="viewRow(row.id)">
                            Eliminar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Paginación (si es necesario) -->
        <nav>
            <ul class="pagination justify-content-end">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Anterior">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Siguiente">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
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
            rows: [],  // Inicialmente vacío, se llenará con datos de la API
            selectedRow: null,
            sortKey: "",
            sortOrder: 1, // 1 para ascendente, -1 para descendente
        };
    },
    computed: {
        filteredAndSortedRows() {
            // Filtrar por el campo de búsqueda
            let filteredRows = this.rows.filter((row) =>
                Object.values(row)
                    .join(" ")
                    .toLowerCase()
                    .includes(this.searchQuery.toLowerCase())
            );

            // Ordenar las filas
            return filteredRows.sort((a, b) => {
                if (a[this.sortKey] < b[this.sortKey]) return -1 * this.sortOrder;
                if (a[this.sortKey] > b[this.sortKey]) return 1 * this.sortOrder;
                return 0;
            });
        },
    },
    methods: {
        async fetchHistorias() {
            try {
                const response = await axios.get('http://localhost/veterinario-app/curso_apirest/historias?page=1'); // Reemplaza con la URL de tu API
                this.rows = response.data; // Asigna los datos recibidos a `rows`
                console.log(this.rows)
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
        selectRow(row) {
            this.$router.push({ path: `/detalleshistorias/${row.pacientes_id}` });
        },
        editRow(row) {
            alert(`Editar: ${row.nombre}`);
        },
        viewRow(row) {
            alert(`Ver: ${row.nombre}`);
        },
    },
    mounted() {
        this.fetchHistorias(); // Llama a la API al montar el componente
    },
};
</script>


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