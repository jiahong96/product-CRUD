<template>
  <v-card>
    <v-card-title>
      Products
      <v-spacer />
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      />
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="products"
      :items-per-page="5"
      :page.sync="page"
      :server-items-length="totalProducts"
      :loading="loading"
      height="70vh"
      class="elevation-1"
    />
  </v-card>
</template>

<script>
  export default {
    data () {
      return {
        headers: [
          {
            text: 'No',
            sortable: false,
            value: 'id',
          },
          {
            text: 'Name',
            sortable: false,
            value: 'name',
          },
          {
            text: 'Price (RM)',
            sortable: false,
            value: 'price',
          },
          {
            text: 'Details',
            sortable: false,
            value: 'description',
          },
          {
            text: 'Published',
            sortable: false,
            value: 'is_published',
          },
        ],
        search: '',
        loading: false,
        products: [],
        totalProducts: 0,
        page: 1,
      }
    },
    watch: {
      page () {
        this.loadProducts()
      },
      search (value) {
        clearTimeout(this._searchTimerId)
        this._searchTimerId = setTimeout(() => {
          this.loadProducts()
        }, 500)
      },
    },
    mounted () {
      this.loadProducts()
    },
    methods: {
      loadProducts () {
        this.loading = true

        axios.get(`/api/products?page=${this.page}&search=${this.search}`)
          .then(response => {
            this.products = response.data.data
            this.totalProducts = response.data.total
            console.log(response.data)
          })
          .then(() => { this.loading = false })
      },
    },
  }
</script>
