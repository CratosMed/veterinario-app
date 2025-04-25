<template>
    <div class="d-flex">
        <!-- Lista de productos -->
        <div class="w-75 pe-3">
            <CintilloForm />
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Inventario</h3>
                <div>
                    <button class="btn btn-outline-dark me-2">Categorías</button>
                    <button class="btn btn-dark" @click="toggleForm">
                        {{ showAddProductForm ? "Ocultar formulario" : "Agregar productos" }}
                        <i class="bi bi-caret-down-fill"></i>
                    </button>
                </div>
            </div>

            <!-- Barra de búsqueda -->
            <div class="input-group mb-4">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Buscar producto..."
                    v-model="searchQuery" />
            </div>

            <!-- Estadísticas -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card p-3 shadow-sm">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-archive fs-1 text-primary me-3"></i>
                            <div>
                                <p class="mb-1">Total de referencias</p>
                                <h5>{{ totalProducts }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3 shadow-sm">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-cash-coin fs-1 text-success me-3"></i>
                            <div>
                                <p class="mb-1">Costo total de inventario</p>
                                <h5>${{ totalInventoryCost }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de productos -->
            <div class="row g-3">
                <div class="col-md-3" v-for="product in filteredProducts" :key="product.id">
                    <div class="card p-3 shadow-sm text-center" @click="addToCart(product)">
                        <img :src="product.image" alt="Producto" class="img-fluid mx-auto mb-3" />
                        <h6>${{ product.price }}</h6>
                        <p class="mb-1"><strong>{{ product.name }}</strong></p>
                        <p class="text-muted">{{ product.stock }} disponibles</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carrito lateral -->
        <div class="w-25 bg-light p-3 shadow-sm">
            <h5>Carrito</h5>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center" v-for="item in cart"
                    :key="item.id">
                    <div>
                        <strong>{{ item.name }}</strong>
                        <p class="mb-1">Cantidad:
                            <button class="btn btn-sm btn-outline-secondary" @click="updateQuantity(item, -1)"
                                :disabled="item.quantity === 1">-</button>
                            {{ item.quantity }}
                            <button class="btn btn-sm btn-outline-secondary" @click="updateQuantity(item, 1)">+</button>
                        </p>
                        <p>Subtotal: ${{ item.quantity * item.price }}</p>
                    </div>
                    <button class="btn btn-danger btn-sm" @click="removeFromCart(item.id)">X</button>
                </li>
            </ul>

            <div>
                <h6>Total: ${{ cartTotal }}</h6>

                <!-- Campos de pago -->
                <div class="mb-3">
                    <label class="form-label">Tipo de pago</label>
                    <div class="d-flex justify-content-between">
                        <div class="form-check">
                            <input type="checkbox" id="debito" value="debito" v-model="selectedPaymentMethods"
                                class="form-check-input" />
                            <label for="debito" class="form-check-label">Débito</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="efectivo" value="efectivo" v-model="selectedPaymentMethods"
                                class="form-check-input" />
                            <label for="efectivo" class="form-check-label">Efectivo</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="dolares" value="dolares" v-model="selectedPaymentMethods"
                                class="form-check-input" />
                            <label for="dolares" class="form-check-label">Dólares</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="paymentAmount" class="form-label">Monto</label>
                    <input type="number" id="paymentAmount" class="form-control" v-model="paymentAmount" min="0" />
                </div>

                <div class="mb-3">
                    <h6 v-if="remainingAmount > 0">Vuelto: ${{ remainingAmount }}</h6>
                    <h6 v-if="remainingAmount < 0">Restante: ${{ Math.abs(remainingAmount) }}</h6>
                </div>

                <button class="btn btn-primary w-100 mt-3" @click="checkout">Finalizar Compra</button>
            </div>
        </div>

        <!-- Modal para agregar producto -->
        <div v-if="showAddProductForm" class="mt-4">
            <h5>Nuevo Producto</h5>
            <form @submit.prevent="addProduct" class="card p-3 shadow-sm">
                <div class="mb-3">
                    <label for="productName" class="form-label">Nombre del Producto</label>
                    <input type="text" id="productName" class="form-control" v-model="newProduct.name" required />
                </div>
                <div class="mb-3">
                    <label for="productPrice" class="form-label">Precio</label>
                    <input type="number" id="productPrice" class="form-control" v-model="newProduct.price" required />
                </div>
                <div class="mb-3">
                    <label for="productStock" class="form-label">Cantidad</label>
                    <input type="number" id="productStock" class="form-control" v-model="newProduct.stock" required />
                </div>
                <div class="mb-3">
                    <label for="productImage" class="form-label">Imagen (URL)</label>
                    <input type="text" id="productImage" class="form-control" v-model="newProduct.image" />
                </div>
                <button type="submit" class="btn btn-primary">Agregar Producto</button>
            </form>
        </div>
    </div>
</template>

<script>
import CintilloForm from "../components/CintilloForm.vue";

export default {
    name: "InventarioVue",
    components: {
        CintilloForm,
    },
    data() {
        return {
            searchQuery: "", // Query de búsqueda
            showAddProductForm: false,
            selectedPaymentMethods: [], // Almacena los métodos de pago seleccionados
            paymentAmount: 0,
            newProduct: {
                name: "",
                price: null,
                stock: null,
                image: "",
            },
            products: [
                { id: 1, name: "Ace", price: 35, stock: 300, image: "https://via.placeholder.com/50" },
                { id: 2, name: "Jabón", price: 25, stock: 220, image: "https://via.placeholder.com/50" },
                { id: 3, name: "Shampoo", price: 50, stock: 100, image: "https://via.placeholder.com/50" },
                { id: 4, name: "Detergente", price: 45, stock: 150, image: "https://via.placeholder.com/50" },
                { id: 5, name: "Desinfectante", price: 30, stock: 200, image: "https://via.placeholder.com/50" },
                { id: 6, name: "Limpiador Multisuperficies", price: 40, stock: 180, image: "https://via.placeholder.com/50" },
                { id: 7, name: "Bote de Basura", price: 12, stock: 500, image: "https://via.placeholder.com/50" },
                { id: 8, name: "Cloro", price: 28, stock: 250, image: "https://via.placeholder.com/50" },
                { id: 9, name: "Esponja de Cocina", price: 5, stock: 300, image: "https://via.placeholder.com/50" },
                { id: 10, name: "Cera para Piso", price: 60, stock: 120, image: "https://via.placeholder.com/50" },
                { id: 11, name: "Papel Higiénico", price: 15, stock: 400, image: "https://via.placeholder.com/50" },
                { id: 12, name: "Servilletas", price: 8, stock: 500, image: "https://via.placeholder.com/50" },
                { id: 13, name: "Aceite de Cocina", price: 70, stock: 150, image: "https://via.placeholder.com/50" },
                { id: 14, name: "Papel Toalla", price: 12, stock: 300, image: "https://via.placeholder.com/50" },
                { id: 15, name: "Limpia Vidrios", price: 20, stock: 220, image: "https://via.placeholder.com/50" },
                { id: 16, name: "Limón", price: 8, stock: 400, image: "https://via.placeholder.com/50" },
                { id: 17, name: "Sal", price: 2, stock: 700, image: "https://via.placeholder.com/50" },
                { id: 18, name: "Azúcar", price: 12, stock: 350, image: "https://via.placeholder.com/50" },
                { id: 19, name: "Café", price: 25, stock: 180, image: "https://via.placeholder.com/50" },
                { id: 20, name: "Galletas", price: 18, stock: 300, image: "https://via.placeholder.com/50" },
                // Productos veterinarios
                { id: 21, name: "Vacuna Canina", price: 100, stock: 150, image: "https://via.placeholder.com/50" },
                { id: 22, name: "Antiparasitario para Gatos", price: 45, stock: 200, image: "https://via.placeholder.com/50" },
                { id: 23, name: "Alimento para Perros", price: 60, stock: 250, image: "https://via.placeholder.com/50" },
                { id: 24, name: "Alimento para Gatos", price: 55, stock: 300, image: "https://via.placeholder.com/50" },
                { id: 25, name: "Sonda Urinaria", price: 30, stock: 120, image: "https://via.placeholder.com/50" },
                { id: 26, name: "Antibiótico para Animales", price: 80, stock: 100, image: "https://via.placeholder.com/50" },
                { id: 27, name: "Jeringas Veterinarias", price: 10, stock: 500, image: "https://via.placeholder.com/50" },
                { id: 28, name: "Collar Isabelino", price: 25, stock: 150, image: "https://via.placeholder.com/50" },
                { id: 29, name: "Pañales para Mascotas", price: 15, stock: 200, image: "https://via.placeholder.com/50" },
                { id: 30, name: "Pipetas Antipulgas", price: 35, stock: 180, image: "https://via.placeholder.com/50" },
                { id: 31, name: "Líquido Antiséptico", price: 50, stock: 250, image: "https://via.placeholder.com/50" },
                { id: 32, name: "Cinta Médica Veterinaria", price: 10, stock: 300, image: "https://via.placeholder.com/50" },
                { id: 33, name: "Suturas para Veterinaria", price: 20, stock: 200, image: "https://via.placeholder.com/50" },
                { id: 34, name: "Tijeras Quirúrgicas", price: 40, stock: 150, image: "https://via.placeholder.com/50" },
                { id: 35, name: "Bisturí Médico", price: 50, stock: 100, image: "https://via.placeholder.com/50" },
                { id: 36, name: "Termómetro Digital Veterinario", price: 15, stock: 400, image: "https://via.placeholder.com/50" },
                { id: 37, name: "Desparacitación Interna para Gatos", price: 60, stock: 180, image: "https://via.placeholder.com/50" },
                { id: 38, name: "Antiinflamatorio para Perros", price: 40, stock: 200, image: "https://via.placeholder.com/50" },
                { id: 39, name: "Cinta Elástica para Veterinaria", price: 8, stock: 300, image: "https://via.placeholder.com/50" },
                { id: 40, name: "Botiquín Veterinario", price: 100, stock: 120, image: "https://via.placeholder.com/50" },
                { id: 41, name: "Cuchilla de Despacho", price: 30, stock: 150, image: "https://via.placeholder.com/50" },
                { id: 42, name: "Pasta Antiparasitaria", price: 20, stock: 180, image: "https://via.placeholder.com/50" },
                { id: 43, name: "Crema Cicatrizante Veterinaria", price: 25, stock: 200, image: "https://via.placeholder.com/50" },
                { id: 44, name: "Válvula Inhalatoria para Animales", price: 150, stock: 50, image: "https://via.placeholder.com/50" },
                { id: 45, name: "Vacuna Contra Leucemia Felina", price: 80, stock: 120, image: "https://via.placeholder.com/50" },
                { id: 46, name: "Guantes Quirúrgicos", price: 5, stock: 400, image: "https://via.placeholder.com/50" },
                { id: 47, name: "Solución Salina", price: 12, stock: 350, image: "https://via.placeholder.com/50" },
                { id: 48, name: "Collares para Perros", price: 20, stock: 500, image: "https://via.placeholder.com/50" },
                { id: 49, name: "Correas para Gatos", price: 15, stock: 550, image: "https://via.placeholder.com/50" },
                { id: 50, name: "Paseadores para Perros", price: 30, stock: 250, image: "https://via.placeholder.com/50" },
            ],
            cart: [],
        };
    },
    computed: {
        filteredProducts() {
            return this.products.filter(product =>
                product.name.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },
        totalProducts() {
            return this.products.length;
        },
        totalInventoryCost() {
            return this.products.reduce((total, product) => total + (product.price * product.stock), 0);
        },
        cartTotal() {
            return this.cart.reduce((total, item) => total + (item.quantity * item.price), 0);
        },
        remainingAmount() {
            return this.paymentAmount - this.cartTotal;
        },
    },
    methods: {
        toggleForm() {
            this.showAddProductForm = !this.showAddProductForm;
        },
        addProduct() {
            this.products.push({ ...this.newProduct, id: this.products.length + 1 });
            this.newProduct = { name: "", price: null, stock: null, image: "" }; // Reset
            this.showAddProductForm = false;
        },
        addToCart(product) {
            const item = this.cart.find(i => i.id === product.id);
            if (item) {
                item.quantity++;
            } else {
                this.cart.push({ ...product, quantity: 1 });
            }
        },
        updateQuantity(item, delta) {
            item.quantity = Math.max(item.quantity + delta, 1);
        },
        removeFromCart(itemId) {
            this.cart = this.cart.filter(item => item.id !== itemId);
        },
        checkout() {
            if (this.remainingAmount >= 0) {
                alert("Compra finalizada");
            } else {
                alert("Monto insuficiente. Por favor, ingrese más dinero.");
            }
        },
    },
};
</script>

<style scoped>
/* Agrega tus estilos aquí */
</style>
