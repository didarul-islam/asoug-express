<template>
  <div class="dashboard mt-5">
    
    <div class="row">
        <div class="col-4">
            <ul class="list-group">
            <li class="list-group-item">Create Product</li>
            <li class="list-group-item">Second item</li>
            <li class="list-group-item">Third item</li>
            </ul>
        </div>
        <div class="col-8">
            <create-product />
        </div>
    </div>

  </div>
</template>

<script>

import CreateProduct from './CreateProduct.vue'

export default{
    components: {
        CreateProduct
    }
}
</script>
