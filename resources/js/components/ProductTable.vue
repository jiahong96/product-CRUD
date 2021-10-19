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
      <product-button-create @created="loadProducts" />
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="products"
      :items-per-page="itemsPerPage"
      :page.sync="page"
      :server-items-length="totalProducts"
      :loading="loading"
      :footer-props="{
        disableItemsPerPage: true,
      }"
      height="70vh"
      class="elevation-1"
    >
      <template v-slot:item.published="{ item }">
        {{ item.is_published ? 'Yes' : 'No' }}
      </template>
      <template v-slot:item.action="{ item }">
        <product-button-show
          :product="item"
        />

        <product-button-edit
          :product="item"
          @updated="loadProducts"
        />

        <product-button-delete
          :product="item"
          @deleted="loadProducts"
        />
      </template>
    </v-data-table>
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
            value: 'published',
          },
          {
            text: 'Actions',
            sortable: false,
            value: 'action',
          },
        ],
        search: '',
        loading: false,
        products: [],
        totalProducts: 0,
        itemsPerPage: 10,
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
          })
          .catch(() => {})
          .then(() => { this.loading = false })
      },
    },
  }
</script>
