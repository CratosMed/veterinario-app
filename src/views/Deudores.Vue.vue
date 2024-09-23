<template>
    <div class="mt-4 fondo">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-primary me-auto">Lista de Clientes Deudores </h2>
        </div>

        <!-- Campo de búsqueda -->
        <div class="mb-3">
            <input type="text" v-model="searchQuery" class="form-control" placeholder="Buscar..." />
        </div>

        <!-- Tabla personalizada con ordenación -->
        <table class="table custom-table align-middle">
            <thead>
                <tr>
                    <th @click="sortTable('name')">
                        Nombre
                        <span :class="getSortIcon('name')"></span>
                    </th>
                    <th @click="sortTable('status')">
                        Apellido
                        <span :class="getSortIcon('status')"></span>
                    </th>
                    <th @click="sortTable('cedula')">
                        Cédula
                        <span :class="getSortIcon('cedula')"></span>
                    </th>
                    <th @click="sortTable('telefono')">
                        Teléfono
                        <span :class="getSortIcon('telefono')"></span>
                    </th>
                    <th @click="sortTable('telefono_auxiliar')">
                        Teléfono auxiliar
                        <span :class="getSortIcon('telefono_auxiliar')"></span>
                    </th>
                    <th @click="sortTable('email')">
                        E-mail
                        <span :class="getSortIcon('email')"></span>
                    </th>
                    <th @click="sortTable('parroquia')">
                        Parroquia
                        <span :class="getSortIcon('parroquia')"></span>
                    </th>
                    <th @click="sortTable('ciudad')">
                        Ciudad
                        <span :class="getSortIcon('ciudad')"></span>
                    </th>
                    <th @click="sortTable('deuda')">
                        Deuda
                        <span :class="getSortIcon('deuda')"></span>
                    </th>
                    <th>
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in filteredAndSortedRows" :key="index" @click="selectRow(row)"
                    :class="{ 'selected-row': selectedRow === row }">
                    <td>{{ row.name }}</td>
                    <td>{{ row.status }}</td>
                    <td>{{ row.cedula }}</td>
                    <td>{{ row.telefono }}</td>
                    <td>{{ row.telefono_auxiliar }}</td>
                    <td>{{ row.email }}</td>
                    <td>{{ row.parroquia }}</td>
                    <td>{{ row.ciudad }}</td>
                    <td>{{ row.deuda }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary me-2" @click.stop="editRow(row)">
                            Editar
                        </button>
                        <button class="btn btn-sm btn-secondary" @click.stop="viewRow(row)">
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
export default {
    name: "DeudoresVue",
    data() { // Cambiado de "ata()" a "data()"
        return {
            searchQuery: "",
            rows: [
                { name: "Juan Pérez", status: "Activo", cedula: "1234567890", telefono: "0991234567", telefono_auxiliar: "0987654321", email: "juan@example.com", parroquia: "Centro", ciudad: "Quito", deuda: "$500" },
                { name: "Ana Martínez", status: "Inactivo", cedula: "9876543210", telefono: "0999876543", telefono_auxiliar: "0981234567", email: "ana@example.com", parroquia: "Norte", ciudad: "Guayaquil", deuda: "$250" },
                { name: "Carlos Rodríguez", status: "Activo", cedula: "5647382910", telefono: "0998765432", telefono_auxiliar: "0984567891", email: "carlos@example.com", parroquia: "Sur", ciudad: "Cuenca", deuda: "$700" },
                { name: "Luisa Gómez", status: "Activo", cedula: "1092837465", telefono: "0992345678", telefono_auxiliar: "0986543212", email: "luisa@example.com", parroquia: "Centro", ciudad: "Quito", deuda: "$100" },
                { name: "María López", status: "Inactivo", cedula: "2083746521", telefono: "0993456789", telefono_auxiliar: "0985432109", email: "maria@example.com", parroquia: "Norte", ciudad: "Guayaquil", deuda: "$350" },
            ],
            selectedRow: null,
            sortKey: "",
            sortOrder: 1, // 1 para ascendente, -1 para descendente
        };
    },
    computed: {
        filteredAndSortedRows() {
            let filteredRows = this.rows.filter(row => {
                return row.name.toLowerCase().includes(this.searchQuery.toLowerCase());
            });

            if (this.sortKey) {
                filteredRows.sort((a, b) => {
                    let result = (a[this.sortKey] > b[this.sortKey]) ? 1 : (a[this.sortKey] < b[this.sortKey]) ? -1 : 0;
                    return result * this.sortOrder;
                });
            }
            return filteredRows;
        }
    },
    methods: {
        sortTable(key) {
            if (this.sortKey === key) {
                this.sortOrder = -this.sortOrder;
            } else {
                this.sortKey = key;
                this.sortOrder = 1;
            }
        },
        getSortIcon(key) {
            if (this.sortKey === key) {
                return this.sortOrder === 1 ? 'bi bi-arrow-up' : 'bi bi-arrow-down';
            }
            return '';
        },
        selectRow(row) {
            this.selectedRow = row;
        },
        editRow(row) {
            // Acción para editar la fila
            console.log("Editar", row);
        },
        viewRow(row) {
            // Acción para ver la fila
            console.log("Eliminar", row);
        }
    }
}
</script>
