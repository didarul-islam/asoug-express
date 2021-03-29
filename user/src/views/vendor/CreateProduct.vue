<template>
  <form @submit.prevent="createProduct">
        <div class="form-group">
            <label for="title">Product Name</label>
            <input
                type="text"
                class="form-control"
                required
                v-model="product_name"
                name="product_name"
            />
        </div>

        <div class="form-group">
            <label for="sel1">Select Category:</label>
            <select class="form-control" v-model="category">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
            </select>
        </div>

        <div class="form-group">
            <label for="sel1">Select Unit:</label>
            <select class="form-control" v-model="unit">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
            </select>
        </div>

        <div class="form-group">
            <label for="sel1">Select Currency:</label>
            <select class="form-control" v-model="currency">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
            </select>
        </div>

        <div class="form-group">
            <label for="title">Brand</label>
            <input
                type="text"
                class="form-control"
                required
                v-model="brand"
                name="brand"
            />
        </div>

        <div class="form-group">
            <label for="title">Stock</label>
            <input
                type="text"
                class="form-control"
                required
                v-model="stock"
                name="stock"
            />
        </div>

        <div class="form-group">
            <label for="title">Keywords</label>
            <input
                type="text"
                class="form-control"
                required
                v-model="keywords"
                name="product_name"
            />
        </div>

        <div class="form-group">
            <label for="title">Short Description</label>
            <input
                type="text"
                class="form-control"
                required
                v-model="short_description"
                name="short_description"
            />
        </div>
        
        <div class="form-group">
            <label for="title">Long Description</label>
            <input
                type="text"
                class="form-control"
                required
                v-model="long_description"
                name="long_description"
            />
        </div>
        <div v-if="validationError" class="alert alert-danger" role="alert">
            {{ validationError }}
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
  </form>
</template>


<script>

  import axios from "axios";
  import {Host} from '../../config/config';

  
  export default {
      
    data() {
      return {
       product_name: "",
       catgory: "",
       unit: "",
       currency: "",
       brand: "",
       stock: "",
       keywords: "",
       short_description: "",
       long_description: "",
       validationError: ""
      }
    },
    methods: {
      createProduct() {

          const data = {
              product_name: this.product_name,
              category: this.category,
              unit: this.unit,
              currency: this.currency,
              brand: this.brand,
              stock: this.stock,
              keywords: this.stock,
              keywords: this.keywords,
              short_description: this.short_description,
              long_description: this.long_description
          };

            axios
                .post(Host+"/vendor/create-product", data)
                .then(response => {

                    console.log(response.data);
                    
                })
                .catch(error => {
                    if (error.response) {
                        this.validationError = error.response.data;
                    }
                    
                });
        }
    }
  }
</script>