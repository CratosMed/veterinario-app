<template>
    <div class="fondo mt-4">
        <!-- Cintillo -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="text-primary mb-0">Hallazgos del examen</h6>
        </div>

        <!-- Formulario de Hallazgos -->

        <div v-for="(hallazgo, index) in hallazgos" :key="index" class="card mb-3 p-3 shadow-sm">
            <div class="card-body">
                <!-- Seleccionar tipo de examen -->
                <div class="mb-3">
                    <label for="fechaActual" class="form-label">Fecha actual:</label>
                    <input type="date" class="form-control" id="fechaActual" v-model="fechaActual" />
                </div>
                <div class="mb-1">
                    <label for="tipoExamen" class="form-label">Tipo de hallazgos del examen</label>
                    <select class="form-select" v-model="hallazgo.tipo" aria-label="Tipo de examen">
                        <option value="">Seleccione el tipo de hallazgos del examen</option>
                        <option value="1">Análisis de sangre</option>
                        <option value="2">Citología</option>
                        <option value="3">Histopatología</option>
                        <option value="4">Radiografía</option>
                        <option value="5">Ultrasonido</option>
                        <option value="6">Electrocardiograma</option>
                        <option value="7">Endoscopía</option>
                        <option value="8">Tomografía computarizada</option>
                        <option value="9">Resonancia magnética</option>
                        <option value="10">Otros</option>
                    </select>
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" v-model="hallazgo.descripcion" rows="3"
                        placeholder="Opcional"></textarea>
                </div>

                <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div v-for="(imageData, index) in images" :key="index"
                            :class="['carousel-item ', { active: index === 0 }]">
                            <img :src="imageData.url" class="d-block w-100 " alt="Imagen del carrusel"
                                @click="viewImage(imageData)" />
                            <div class="carousel-caption d-none d-md-block talla">
                                <p>{{ imageData.description }}</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel"
                        data-bs-slide="next">
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

            <!-- Botón para eliminar -->
            <div class="text-end">
                <button class="btn btn-danger" @click="eliminarHallazgo(index)">
                    <i class="bi bi-trash"></i> Borrar
                </button>
            </div>
            <br />

            <br />
            <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">Guardar</button>
            </div>
        </div>
        <!-- Botón para agregar más hallazgos -->
    </div>
    <br />
    <div class="text-end">
        <button class="btn btn-outline-info" @click="agregarHallazgo()">
            <i class="bi bi-plus-circle"></i> Agregar hallazgos de exámenes
        </button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            hallazgos: [],
            formularioHallazgosVisible: true,
            images: [],
            selectedImage: null,
            newDescription: '',
            fechaActual: ''
        };
    },
    mounted() {
        this.obtenerFechaActual();
    },
    methods: {
        agregarHallazgo() {
            this.hallazgos.push({ tipo: '', descripcion: '', imagen: '' });
        },
        eliminarHallazgo(index) {
            this.hallazgos.splice(index, 1);
        },
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
        obtenerFechaActual() {
            const hoy = new Date();
            const dia = hoy.getDate().toString().padStart(2, '0');
            const mes = (hoy.getMonth() + 1).toString().padStart(2, '0'); // Los meses van de 0 a 11
            const año = hoy.getFullYear();
            // Formato correcto para el input de tipo date: YYYY-MM-DD
            this.fechaActual = `${año}-${mes}-${dia}`;
        }
    }
}
</script>

<style scoped>
.fondo {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.25rem;
}

.card {
    border: 1px solid #ddd;
    border-radius: 0.25rem;
}

.carousel-item img {
    max-height: 100px;
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
    margin: auto;
    /* Asegura que la imagen se centre */
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

.talla {
    margin-left: 15%;
    margin-right: 15%;
}
</style>