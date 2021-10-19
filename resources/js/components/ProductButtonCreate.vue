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
        Create
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

        <v-toolbar-title>Add Product</v-toolbar-title>
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
              @click="createProduct"
            >
              Create
            </v-btn>
          </v-row>
        </v-container>
      </v-form>
    </v-card>
  </v-dialog>
</template>

<script>
  export default {
    data () {
      return {
        dialog: false,
        formValid: true,
        progressing: false,
        name: '',
        nameRules: [
          v => !!v || 'Name is required',
          v => (v && v.length <= 250) || 'Name must be less than 250 characters',
        ],
        description: '',
        descriptionRules: [
          v => !!v || 'Description is required',
          v => (v && v.length <= 10000) || 'Description must be less than 10000 characters',
        ],
        price: '',
        priceRules: [
          v => !!v || 'Price is required',
          v => (v && v > 0 && v <= 100000) || 'Price must be more than 0, less than 100k',
        ],
        isPublished: 1,
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
      createProduct () {
        if (!this.validate()) return

        this.progressing = true

        console.log(this.formData)
        axios.post('/api/products', this.formData)
          .then(response => {
            this.created()
          })
          .then(() => { this.progressing = false })
      },
      created () {
        this.dialog = false
        this.$emit('created')
      },
      validate () {
        return this.$refs.form.validate()
      },
      reset () {
        this.name = ''
        this.description = ''
        this.price = ''
        this.isPublished = 1
        this.$refs.form.resetValidation()
      },
    },
  }
</script>
