<template>
    <div class="lista-usuarios">
        <h2>Lista de Usuarios</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Código</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="usuario in usuarios" :key="usuario.id">
                    <td>{{ usuario.id }}</td>
                    <td>{{ usuario.nombre }}</td>
                    <td>{{ usuario.email }}</td>
                    <td>
                        <button class="btn btn-info" @click="copiarCodigo(usuario.codigo)">
                            {{ usuario.codigo }}
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'ListarUsuarios', //

    data() {
        return {
            usuarios: [
                { id: 1, nombre: 'Juan Pérez', email: 'juan@example.com', codigo: 'ABC123' },
                { id: 2, nombre: 'María Gómez', email: 'maria@example.com', codigo: 'XYZ456' },
                { id: 3, nombre: 'Luis Martínez', email: 'luis@example.com', codigo: 'LMN789' },
            ],
        };
    },
    methods: {
        copiarCodigo(codigo) {
            navigator.clipboard.writeText(codigo)
                .then(() => {
                    alert(`Código ${codigo} copiado al portapapeles.`);
                })
                .catch(err => {
                    console.error('Error al copiar el código:', err);
                });
        },
    },
};
</script>

<style scoped>
.lista-usuarios {
    padding: 20px;
}

.table {
    width: 100%;
    margin-top: 20px;
}
</style>