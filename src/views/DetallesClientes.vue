<template>
    <div>
        <br />
        <div class="d-flex justify-content-between align-items-center mb-3 py-2">
            <h2 class="text-primary me-auto">Detalles Clientes</h2>
        </div>

        <div class="container-fluid alto">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-2 bg-light">
                    <div class="text-center">
                        <!-- Imagen de perfil y nombre -->
                        <img src="https://via.placeholder.com/150" class="rounded-circle mb-3" alt="Profile Picture">
                        <h4>Benito</h4>
                    </div>

                    <!-- Sidebar Links -->
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'datos' }"
                                @click="activeSection = 'datos'">Datos del Cliente</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" :class="{ active: activeSection === 'pacientesRelacionados' }"
                                @click="activeSection = 'pacientesRelacionados'">Pacientes del Cliente</a>
                        </li>

                    </ul>
                    <br />
                </div>

                <!-- Main Content -->
                <div class="col-md-10 p-4">
                    <!-- Card Containing Client Details -->
                    <div v-if="activeSection === 'datos'">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <h5>Nombre</h5>
                                        <p>{{ formData.name }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h5>Apellido</h5>
                                        <p>{{ formData.apellido }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <h5>Cédula</h5>
                                        <p>{{ formData.cedula }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h5>E-mail</h5>
                                        <p>{{ formData.email }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <h5>Teléfono Móvil</h5>
                                        <p>{{ formData.telefonoMovil }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h5>Teléfono Auxiliar</h5>
                                        <p>{{ formData.telefonoAuxiliar }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <h5>Ciudad</h5>
                                        <p>{{ formData.ciudad }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h5>Municipio</h5>
                                        <p>{{ formData.municipio }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <h5>Veterinario Derivante</h5>
                                        <p>{{ formData.veterinarioDerivante }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h5>Deuda</h5>
                                        <p>{{ formData.deuda }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="activeSection === 'pacientesRelacionados'">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="text-primary me-auto">Pacientes Relacionados</h5>
                                </div>

                                <!-- Table of related patients -->
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Especie</th>
                                            <th class="text-center">Pelaje</th>
                                            <th class="text-center">Sexo</th>
                                            <th class="text-center">Citas</th>
                                            <th class="text-center">Notificar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="parametro in parametros" :key="parametro.id"
                                            @click="selectParametro(parametro)">
                                            <td class="text-center">{{ parametro.Nombre }}</td>
                                            <td class="text-center">{{ parametro.Especie || 'no come' }}</td>
                                            <td class="text-center">{{ parametro.Pelaje || 'complejo b' }}</td>
                                            <td class="text-center">{{ parametro.Sexo || 'complejo b' }}</td>
                                            <td class="text-center citas-columna">
                                                <div v-for="cita in parametro.Citas" :key="cita.id"
                                                    class="d-flex align-items-center mb-2">
                                                    <span class="badge bg-danger rounded-pill me-2">{{ cita.dia
                                                        }}</span>
                                                    <div class="text-truncate" style="max-width: 150px;">
                                                        <strong>{{ cita.evento }}</strong>
                                                        <div class="text-muted">{{ cita.hora }} {{ cita.recurrencia }}
                                                        </div>
                                                    </div>
                                                    <span
                                                        :class="['badge', cita.recurrencia === 'every week' ? 'bg-success' : 'bg-danger']"></span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                            <td class="text-center">
                                                <a :href="`https://web.whatsapp.com/send?phone=${parametro.telefono}&text=Hola%20${encodeURIComponent(parametro.Nombre)},%20te%20habla%20la%20veterinaria%20Inversiones%20Caru.%20Te%20recordamos%20la%20cita%20que%20tienes%20hoy.%20Te%20esperamos,%20tu%20salud%20es%20nuestra%20prioridad.`"
                                                    target="_blank" rel="noopener noreferrer">
                                                    <i class="fab fa-whatsapp fa-2x text-success"></i>
                                                </a>
                                            </td>


                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'DetallesClientes',
    data() {
        return {
            activeSection: 'datos',
            parametros: [
                {
                    id: 1,
                    Nombre: "Firulais",
                    Especie: "Perro",
                    Pelaje: "Corto",
                    Sexo: "Macho",
                    Citas: [
                        {
                            id: 1,
                            evento: "Yogryrtytryhfffffffffffffffffffffffffffffffffffffffffffffffffffffffffftrhrthrthr",
                            dia: "THU",
                            hora: "16:40",
                            recurrencia: "every week"
                        },
                        {
                            id: 2,
                            evento: "Call John",
                            dia: "SAT",
                            hora: "15:20",
                            recurrencia: "once"
                        }
                    ]
                }
                // Más pacientes...
            ],
            formData: {
                name: "Juan Pérez",
                apellido: "López",
                cedula: "1234567890",
                email: "juan.perez@example.com",
                telefonoMovil: "04129638367",
                telefonoAuxiliar: "",
                ciudad: "Quito",
                municipio: "Pichincha",
                veterinarioDerivante: "Dr. Gómez",
                deuda: "$500",
            }
        };
    },
    methods: {
        selectParametro(parametro) {
            this.selectedParametro = parametro;
        }
    }
};
</script>

<style scoped>
.text-success {
    color: #25D366;
    /* Color verde de WhatsApp */
}

.alto {
    margin-top: 5%;
}

.nav-link.active {
    background-color: #e0f7fa;
    font-weight: bold;
}

.text-primary {
    color: #7b47da;
    font-weight: bold;
    border-left: 3px solid #7b47da;
    padding-left: 10px;
}

h5 {
    margin-bottom: 0.5rem;
}

p {
    margin-bottom: 1.5rem;
}

.card {
    border-radius: 10px;
    padding: 20px;
    background-color: #fff;
}

.card-body {
    padding: 20px;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.container-fluid {
    background-color: #e8f0fc;
}

/* Styles for table */
.table td,
.table th {
    text-align: center;
}

.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.text-center {
    text-align: center;
}

.citas-columna {
    vertical-align: middle;
}
</style>
