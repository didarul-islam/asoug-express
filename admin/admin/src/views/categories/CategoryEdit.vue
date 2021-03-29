<template>
  <!-- form -->
  <div class="card">
    <div class="card-header"><h3 class="mt-1">Edit Category</h3></div>
    <hr />
    <div class="card-body">
      <validation-observer ref="simpleRules">
        <b-form @submit.prevent="categoryUpdate" enctype="multipart/form-data">
          <b-row>
            <b-col md="6" offset-md="3">
              <b-form-group>
                <validation-provider
                  #default="{ errors }"
                  name="name"
                  rules="required"
                >
                  <b-form-input
                    v-model="name"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Category Name"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>

            <b-col md="6" offset-md="3">
              <b-form-group>
                <validation-provider
                  #default="{ errors }"
                  name="arabic_name"
                  rules="required"
                >
                  <b-form-input
                    v-model="arabic_name"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Arabic Name"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>

            <b-col md="6" offset-md="3">
              <b-form-group>
                <validation-provider
                  #default="{ errors }"
                  name="commision"
                 rules="required|integer"
                >
                  <b-form-input
                    v-model="commision"
                    :state="errors.length > 0 ? false : null"
                    placeholder="Commision"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
            </b-col>

            <b-col md="6" offset-md="3">
              <b-form-select
                name="parent_id"
                v-model="selectedCategory"
                id="CategoryAll"
                :options="categories"
              >
                <template v-slot:first> </template>
              </b-form-select>
            </b-col>

            <b-col md="6" offset-md="3" class="my-2">
              <b-form-file
                v-model="image"
                name="image"
                type="file"
                placeholder="Choose a file or drop it here..."
                drop-placeholder="Drop file here..."
              />
            </b-col>

            <b-col md="6" offset-md="3">
              <b-button variant="primary" type="submit" @click="validationForm">
                Submit
              </b-button>
            </b-col>
          </b-row>
        </b-form>
      </validation-observer>
    </div>
  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import {
  BFormInput,
  BFormGroup,
  BForm,
  BRow,
  BCol,
  BButton,
  BCardText,
  BFormFile,
  BFormSelect,
} from "bootstrap-vue";
import { required, email } from "@validations";
import axios from "axios";
import ToastificationContent from "@core/components/toastification/ToastificationContent";

export default {
  components: {
    ValidationProvider,
    ValidationObserver,
    BCardText,
    BFormInput,
    BFormGroup,
    BForm,
    BRow,
    BCol,
    BButton,
    BFormFile,
    BFormSelect,
  },
  data() {
    return {
      image: [],
      name: "",
      arabic_name: "",
      commision: "",
      parent_id: "",
      required,
      categories: [],
      selectedCategory: null,
    };
  },
  mounted() {
    this.getData();
  },

  methods: {
    onFileChange(event) {
      this.image = event.target.files[0];
      console.log(event.target.files[0]);
    },
    validationForm() {
      this.$refs.simpleRules.validate().then((success) => {
        if (success) {
        }
      });
    },
    getData() {
      this.$http
        .get(`admin/v1/category/${this.$route.params.id}`)
        .then((res) => {
          console.log(res.data);

          // Changed Some Code
          this.name = res.data.category.name;
          this.arabic_name = res.data.category.arabic_name;
          this.commision = res.data.category.commision;
          this.image = res.data.category.image;

          const categories = [];
          categories.push({ value: null, text: "Select Parent Category" });
          res.data.categories.forEach((category) => {
            if (res.data.category.parent_id === category.id) {
              this.selectedCategory = category.id;
            }

            categories.push({
              value: category.id,
              text: category.name,
            });
          });

          this.categories = categories;
        })
        .catch((error) => {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Something Wrong",
              icon: "EditIcon",
              variant: "error",
            },
          });
        });
    },

    categoryUpdate() {
      const formData = new FormData();
      formData.append("photo", this.image);
      formData.append("name", this.name);
      formData.append("arabic_name", this.arabic_name);
      formData.append("commision", this.commision);
      formData.append("parent_id", this.selectedCategory);

      this.$http
        .post(`admin/v1/update-category/${this.$route.params.id}`, formData)
        .then((response) => {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Category Updated",
              icon: "EditIcon",
              variant: "success",
            },
          });
          this.$router.push("/category");
        })
        .catch((error) => {
          console.log(error);
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Category Updated Failed",
              icon: "EditIcon",
              variant: "warning",
            },
          });
        });
    },
  },
};
</script>
