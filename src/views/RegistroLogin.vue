<template>
    <div class="auth-container">
        <h1>Registro de Usuario</h1>
        <form @submit.prevent="registerUser">
            <label>
                Nombre:
                <input type="text" v-model="userData.nombre" required />
            </label>

            <label>
                Correo Electrónico:
                <input type="email" v-model="userData.email" required />
            </label>

            <label>
                Tipo de Suscripción:
                <select v-model="userData.suscripcion" required>
                    <option value="mensual">Mensual</option>
                    <option value="anual">Anual</option>
                </select>
            </label>

            <label>
                Contraseña:
                <input type="password" v-model="userData.password" required />
            </label>

            <button type="submit">Registrar</button>
        </form>

        <div class="login-section">
            <h2>O inicia sesión con Google</h2>
            <button @click="loginWithGoogle">Iniciar sesión con Google</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useGoogleLogin } from '@react-oauth/google';

export default {
    name: 'RegistroLogin',
    data() {
        return {
            userData: {
                nombre: '',
                email: '',
                suscripcion: 'mensual',
                password: ''
            }
        };
    },
    methods: {
        async registerUser() {
            try {
                // Enviar los datos de registro al backend
                await axios.post('/api/register', this.userData, { withCredentials: true });
                alert('Usuario registrado exitosamente');
            } catch (error) {
                console.error('Error en el registro:', error);
                alert('Hubo un problema al registrar el usuario.');
            }
        },
        loginWithGoogle() {
            const login = useGoogleLogin({
                onSuccess: async (tokenResponse) => {
                    try {
                        // Enviar token de Google al backend
                        await axios.post('/api/google-auth', { token: tokenResponse.access_token }, { withCredentials: true });
                        alert('Inicio de sesión con Google exitoso');
                    } catch (error) {
                        console.error('Error en la autenticación con Google:', error);
                        alert('Hubo un problema al iniciar sesión con Google.');
                    }
                },
                onError: (error) => {
                    console.error('Error en el inicio de sesión con Google:', error);
                }
            });
            login();
        }
    }
};
</script>

<style scoped>
.auth-container {
    max-width: 400px;
    margin: auto;
}

label {
    display: block;
    margin-bottom: 8px;
}

input,
select {
    width: 100%;
    padding: 8px;
    margin-top: 4px;
}

button {
    margin-top: 16px;
    padding: 8px 16px;
    cursor: pointer;
}

.login-section {
    margin-top: 24px;
    text-align: center;
}
</style>