<template>
  <v-dialog
    v-model="dialog"
    fullscreen
    hide-overlay
  >
    <template v-slot:activator="{ on, attrs }">
      <v-btn
        color="primary"
        dark
        v-bind="attrs"
        v-on="on"
      >
        Edit
      </v-btn>
    </template>

    <v-card>
      <v-toolbar
        dark
        color="primary"
      >
        <v-btn
          icon
          dark
          @click="dialog = false"
        >
          <v-icon>mdi-close</v-icon>
        </v-btn>

        <v-toolbar-title>Edit Product</v-toolbar-title>
      </v-toolbar>

      <v-form
        ref="form"
        v-model="formValid"
        lazy-validation
      >
        <v-container class="ma-2">
          <v-row dense>
            <v-col
              cols="12"
            >
              <v-text-field
                v-model="name"
                label="Name"
                :rules="nameRules"
              />
            </v-col>
            <v-col
              cols="12"
            >
              <v-text-field
                v-model="price"
                type="number"
                label="Price (RM)"
                :rules="priceRules"
              />
            </v-col>
            <v-col
              cols="12"
            >
              <v-textarea
                v-model="description"
                label="Detail"
                :rules="descriptionRules"
              />
            </v-col>
            <v-col
              cols="12"
            >
              <v-radio-group v-model="isPublished">
                <template v-slot:label>
                  <div>Publish</div>
                </template>
                <v-radio
                  label="Yes"
                  :value="1"
                />
                <v-radio
                  label="No"
                  :value="0"
                />
              </v-radio-group>
            </v-col>

            <v-btn
              color="primary"
              :disabled="progressing"
              @click="editProduct"
            >
              Edit
            </v-btn>
          </v-row>
        </v-container>
      </v-form>
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
        formValid: true,
        progressing: false,
        name: this.product.name,
        nameRules: [
          v => !!v || 'Name is required',
          v => (v && v.length <= 250) || 'Name must be less than 250 characters',
        ],
        description: this.product.description,
        descriptionRules: [
          v => !!v || 'Description is required',
          v => (v && v.length <= 10000) || 'Description must be less than 10000 characters',
        ],
        price: this.product.price,
        priceRules: [
          v => !!v || 'Price is required',
          v => (v && v > 0 && v <= 100000) || 'Price must be more than 0, less than 100k',
        ],
        isPublished: this.product.is_published,
      }
    },
    computed: {
      formData () {
        return {
          name: this.name,
          description: this.description,
          price: this.price,
          is_published: this.isPublished,
        }
      },
    },
    watch: {
      dialog (value) {
        if (value === false) {
          this.reset()
        }
      },
    },
    methods: {
      editProduct () {
        if (!this.validate()) return

        this.progressing = true

        axios.patch(`/api/products/${this.product.id}`, this.formData)
          .then(response => {
            this.updated()
          })
          .catch(() => {})
          .then(() => { this.progressing = false })
      },
      updated () {
        this.dialog = false
        this.$emit('updated')
      },
      validate () {
        return this.$refs.form.validate()
      },
      reset () {
        this.$refs.form.resetValidation()
      },
    },
  }
</script>
