<template>
  <v-dialog
    v-model="dialog"
    fullscreen
    hide-overlay
  >
    <template v-slot:activator="{ on, attrs }">
      <v-btn
        color="cyan"
        dark
        v-bind="attrs"
        v-on="on"
      >
        Show
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

        <v-toolbar-title>Show Product</v-toolbar-title>
      </v-toolbar>

      <v-container class="ma-2">
        <v-row>
          <v-col cols="2">
            <span>Name:</span>
          </v-col>
          <v-col cols="10">
            <span>{{ product.name }}</span>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="2">
            <span>Price:</span>
          </v-col>
          <v-col cols="10">
            <span> RM {{ product.price }}</span>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="2">
            <span>Details:</span>
          </v-col>
          <v-col cols="10">
            <span>{{ product.description }}</span>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="2">
            <span>Publish:</span>
          </v-col>
          <v-col cols="10">
            <span>{{ product.is_published ? 'Yes' : 'No' }}</span>
          </v-col>
        </v-row>
      </v-container>
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
      }
    },
  }
</script>
