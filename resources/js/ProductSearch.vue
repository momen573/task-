<template>
    <div class="container mt-4">
        <div class="search-form">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" v-model="searchQuery" placeholder="Search by name" class="form-control" />
                </div>
                <div class="col-md-2">
                    <input type="number" v-model.number="minPrice" placeholder="Min Price" class="form-control" />
                </div>
                <div class="col-md-2">
                    <input type="number" v-model.number="maxPrice" placeholder="Max Price" class="form-control" />
                </div>
                <div class="col-md-2">
                    <button @click="search" class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>

        <div class="product-list row">
            <div v-for="product in products" :key="product.id" class="product-item col-md-4">
                <h3>{{ product.name }}</h3>
                <ul>
                    <li v-for="variation in product.variations" :key="variation.id">

                        <span :style="{ backgroundColor: variation.color  }">
                             {{ variation.color }} - {{ variation.price }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li v-for="link in links"  class="m-1 page-item">
                <button :class="{ 'disabled': link.disabled, 'active': link.active }" v-html="link.label" @click="fetchPage(link.url)" class="btn btn-primary"></button>
            </li>
        </ul>
    </nav>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            searchQuery: '',
            minPrice: null,
            maxPrice: null,
            products: [],
            pagination: null,
        };
    },
    methods: {
        search() {
            const params = {
                name: this.searchQuery,
                min_price: this.minPrice,
                max_price: this.maxPrice
            };

            // Make the API request
            axios.get('/api/products', { params })
                .then(response => {
                    this.products = response.data.data;
                    this.pagination = response.data;
                    this.links=response.data.links;

                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchPage(url) {
            const params = {
                name: this.searchQuery,
                min_price: this.minPrice,
                max_price: this.maxPrice
            };
            axios.get(url ,{ params })
                .then(response => {
                    this.products = response.data.data;
                    this.pagination = response.data;
                    this.links=response.data.links;

                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
}
</script>

<style scoped>

.search-form {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.search-input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-right: 10px;
    width: 200px;
    font-size: 14px;
}

.price-input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-right: 10px;
    width: 100px;
    font-size: 14px;
}

.search-button {
    padding: 8px 16px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.search-button:hover {
    background-color: #45a049;
}
.active{
    background-color: aqua;
}
</style>

