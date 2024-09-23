<template>
    <div class="container mt-4">
        <h5 class="text-primary">Carrusel de Imágenes</h5>

        <!-- Carrusel -->
        <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div v-for="(imageData, index) in images" :key="index"
                    :class="['carousel-item', { active: index === 0 }]">
                    <img :src="imageData.url" class="d-block w-100" alt="Imagen del carrusel"
                        @click="viewImage(imageData)" />
                    <div class="carousel-caption d-none d-md-block">
                        <p>{{ imageData.description }}</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>

        <!-- Formulario para subir imágenes -->
        <div class="mt-3">
            <input type="file" @change="handleFileUpload" multiple accept="image/*" class="form-control" />
            <input v-model="newDescription" type="text" placeholder="Descripción de la imagen"
                class="form-control mt-2" />
        </div>

        <!-- Imagen ampliada -->
        <div v-if="selectedImage" class="fullscreen-modal">
            <img :src="selectedImage.url" class="img-fluid" alt="Imagen ampliada" />
            <p class="text-white text-center mt-2">{{ selectedImage.description }}</p>
            <button class="close-btn" @click="closeImage">
                <i class="bi bi-x-circle"></i>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            images: [],
            selectedImage: null,
            newDescription: '',
        };
    },
    methods: {
        handleFileUpload(event) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.images.push({
                        url: e.target.result,
                        description: this.newDescription || 'Sin descripción', // Asignar descripción
                    });
                    this.newDescription = ''; // Limpiar el campo de descripción
                };
                reader.readAsDataURL(file);
            }
        },
        viewImage(imageData) {
            this.selectedImage = imageData; // Mostrar la imagen seleccionada
        },
        closeImage() {
            this.selectedImage = null; // Ocultar la imagen
        },
    },
};
</script>

<style scoped>
.carousel-item img {
    max-height: 400px;
    object-fit: cover;
}

.fullscreen-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1050;
}

.fullscreen-modal img {
    max-width: 90%;
    max-height: 90%;
}

.close-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    background: none;
    border: none;
    color: white;
    font-size: 2rem;
    cursor: pointer;
}

.carousel-caption {
    background: rgba(0, 0, 0, 0.5);
    /* Fondo semi-transparente para la descripción */
}

.fullscreen-modal p {
    position: absolute;
    bottom: 20px;
    /* Espaciado desde la parte inferior */
    left: 50%;
    transform: translateX(-50%);
    color: white;
    /* Color del texto */
}
</style>