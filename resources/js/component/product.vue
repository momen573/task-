<template>
    <div class="container mt-4">
        <div class="search-form">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" v-model="searchQuery" placeholder="Search by name" class="form-control"/>
                </div>
                <div class="col-md-2">
                    <input type="number" v-model.number="minPrice" placeholder="Min Price" class="form-control"/>
                </div>
                <div class="col-md-2">
                    <input type="number" v-model.number="maxPrice" placeholder="Max Price" class="form-control"/>
                </div>
                <div class="col-md-2">
                    <button @click="search(1)" class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>

        <div class="product-list row">
            <div v-for="product in products" :key="product.id" class="product-item col-md-6">
                <h3>{{ product.name }}</h3>
                <ul>
                    <li v-for="variation in product.variations" :key="variation.id"  >

                        <span :style="{ backgroundColor: variation.color  }">
                             {{ variation.color }} - {{ variation.price }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center align-items-center">
        <Bootstrap5Pagination
            :data="pagination"
            @pagination-change-page="search"
        />
    </div>
</template>

<script>
import axios from 'axios';
import {Bootstrap5Pagination} from 'laravel-vue-pagination';

export default {
    name: "product",
    components: {
        Bootstrap5Pagination
    },
    data() {
        return {
            searchQuery: '',
            minPrice: null,
            maxPrice: null,
            products: [],
            pagination: [],
            errors:[]
        };
    },

    methods: {

        search(page = 1) {
            const params = {
                name: this.searchQuery,
                min_price: this.minPrice,
                max_price: this.maxPrice
            };


            axios.get(`/api/products?page=${page}`, {params})
                .then(response => {
                    this.products = response.data.data;
                    this.pagination = response.data.page;
                    this.links = response.data.page.links;

                })
                .catch(error => {
                    console.error(error);
                });
        },

    }
}
</script>

<style scoped>

</style>

