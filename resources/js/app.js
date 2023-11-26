
import {createApp} from 'vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.js'

import App from './App.vue'
import product from './component/product.vue'
const app = createApp(App)
app.component('product', product)
app.mount('#app')
