<template>
  <v-dialog
    v-model="dialog"
    persistent
    max-width="290"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-btn
        color="error"
        dark
        v-bind="attrs"
        v-on="on"
      >
        Delete
      </v-btn>
    </template>
    <v-card>
      <v-card-title class="text-h5">
        Delete {{ product.name }}?
      </v-card-title>

      <v-card-actions>
        <v-spacer />
        <v-btn
          text
          :disabled="progressing"
          @click="dialog = false"
        >
          Cancel
        </v-btn>
        <v-btn
          color="error"
          text
          :disabled="progressing"
          @click="deleteProduct"
        >
          Delete
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
  export default {
    props: {
      product: {
        type: Object,
        default: () => {},
      },
    },
    data () {
      return {
        dialog: false,
        progressing: false,
      }
    },
    methods: {
      deleteProduct () {
        this.progressing = true

        axios.delete(`/api/products/${this.product.id}`)
          .then(response => {
            this.deleted()
          })
          .catch(() => {})
          .then(() => { this.progressing = false })
      },
      deleted () {
        this.dialog = false
        this.$emit('deleted')
      },
    },
  }
</script>

<style lang="scss" scoped>

</style>
