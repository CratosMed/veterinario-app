import { createRouter, createWebHistory } from 'vue-router'

import HistoriasView from '../views/HistoriasView.vue'
import DashboardView from '../views/DashboardView.vue'
import DetallesHistorias from '../views/DetallesHistorias.vue'
import AgregarPaciente from '../views/AgregarPaciente.vue'
import AgregarCliente from '../views/AgregarCliente.vue'
import NuevaVisita from '../views/NuevaVisita.vue'
import CitasVue from '../views/CitasVue.vue'
import ActualizacionVue from '../views/ActualizacionVue.vue'
import DetallesClientes from '../views/DetallesClientes.vue'
import DeudoresVue from '../views/Deudores.Vue.vue'
import ImafenesVue from '../views/ImagenesVue.vue'
import ImagenesVue from '../views/ImagenesVue.vue'
import ListaClientes from '../views/ListaClientes.vue'
import ListaPacientes from '../views/ListaPacientes.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'inicio',
      component: DashboardView
    },

    {
      path: '/historias',
      name: 'Historias',
      component: HistoriasView
    },
    {
      path: '/detalleshistorias/:id',
      name: 'detalleshistorias',
      component: DetallesHistorias
    },
    {
      path: '/agregarPaciente',
      name: 'agregarPaciente',
      component: AgregarPaciente
    },
    {
      path: '/agregarPaciente/:id',
      name: 'editarPaciente',
      component: AgregarPaciente
    },
    {
      path: '/agregarCliente',
      name: 'agregarCliente',
      component: AgregarCliente
    },
    {
      path: '/agregarCliente/:id',
      name: 'editarCliente',
      component: AgregarCliente
    },
    {
      path: '/listaClientes',
      name: 'listaClientes',
      component: ListaClientes
    },
    {
      path: '/listaPacientes',
      name: 'listaPacientes',
      component: ListaPacientes
    },
    {
      path: '/nuevavisita/:id',
      name: 'nuevavisita',
      component: NuevaVisita
    },
    {
      path: '/citas',
      name: 'citas',
      component: CitasVue
    },
    {
      path: '/actualizacion',
      name: 'actualizacion',
      component: ActualizacionVue
    },
    {
      path: '/detallesclientes',
      name: 'detallesclientes',
      component: DetallesClientes
    },
    {
      path: '/deudores',
      name: 'deudores',
      component: DeudoresVue
    },
    {
      path: '/imagenes',
      name: 'imagenes',
      component: ImagenesVue
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue')
    }
  ]
})

export default router
