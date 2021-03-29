<template>
  <section>
    <div class="d-flex justify-content-end">
      <router-link class="btn btn-primary my-2" :to="{ name: 'unit-add' }">
        <span>Add Unit</span>
      </router-link>
    </div>

    <div>
      <!-- search input -->
      <div class="custom-search d-flex justify-content-end">
        <b-form-group>
          <div class="d-flex align-items-center">
            <label class="mr-1">Search</label>
            <b-form-input
              v-model="searchTerm"
              placeholder="Search"
              type="text"
              class="d-inline-block"
            />
          </div>
        </b-form-group>
      </div>

      <!-- table -->
      <vue-good-table
        :columns="columns"
        :rows="rows"
        :rtl="direction"
        :search-options="{
          enabled: true,
          externalQuery: searchTerm,
        }"
        :select-options="{
          enabled: true,
          selectOnCheckboxOnly: true, // only select when checkbox is clicked instead of the row
          selectionInfoClass: 'custom-class',
          selectionText: 'rows selected',
          clearSelectionText: 'clear',
          disableSelectInfo: true, // disable the select info panel on top
          selectAllByGroup: true, // when used in combination with a grouped table, add a checkbox in the header row to check/uncheck the entire group
        }"
        :pagination-options="{
          enabled: true,
          perPage: pageLength,
        }"
      >
        <template slot="table-row" slot-scope="props">
          <!-- Column: Name -->
          <span v-if="props.column.field === 'name'" class="text-nowrap">
            <span class="text-nowrap">{{ props.row.name }}</span>
          </span>
          <!-- Column: Name -->
          
          

          <!-- Column: Status -->
          <span v-else-if="props.column.field === 'status'">
            <b-badge :variant="statusVariant(props.row.status)">
              {{ props.row.status }}
            </b-badge>
          </span>

          <!-- Column: Action -->
          <span v-else-if="props.column.field === 'action'">
            <span>
              <b-dropdown
                variant="link"
                toggle-class="text-decoration-none"
                no-caret
              >
                <template v-slot:button-content>
                  <feather-icon
                    icon="MoreVerticalIcon"
                    size="16"
                    class="text-body align-middle mr-25"
                  />
                </template>
                <b-dropdown-item>
                  <router-link
                    :to="{
                      name: 'unit-edit',
                      params: { id: props.row.id },
                    }"
                  >
                    <feather-icon icon="Edit2Icon" class="mr-50" />
                    <span>Edit</span></router-link
                  >
                </b-dropdown-item>
                <b-dropdown-item>
                  <a href="" @click.prevent="deleteData(props.row.id)">
                    <feather-icon icon="TrashIcon" class="mr-50" />
                    <span> Delete </span>
                  </a>
                </b-dropdown-item>
              </b-dropdown>
            </span>
          </span>

          <!-- Column: Common -->
          <span v-else>
            {{ props.formattedRow[props.column.field] }}
          </span>
        </template>

        <!-- pagination -->
        <template slot="pagination-bottom" slot-scope="props">
          <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-center mb-0 mt-1">
              <span class="text-nowrap"> Showing 1 to </span>
              <b-form-select
                v-model="pageLength"
                :options="['3', '5', '10']"
                class="mx-1"
                @input="
                  (value) => props.perPageChanged({ currentPerPage: value })
                "
              />
              <span class="text-nowrap"> of {{ props.total }} entries </span>
            </div>
            <div>
              <b-pagination
                :value="1"
                :total-rows="props.total"
                :per-page="pageLength"
                first-number
                last-number
                align="right"
                prev-class="prev-item"
                next-class="next-item"
                class="mt-1 mb-0"
                @input="(value) => props.pageChanged({ currentPage: value })"
              >
                <template #prev-text>
                  <feather-icon icon="ChevronLeftIcon" size="18" />
                </template>
                <template #next-text>
                  <feather-icon icon="ChevronRightIcon" size="18" />
                </template>
              </b-pagination>
            </div>
          </div>
        </template>
      </vue-good-table>
    </div>
  </section>
</template>

<script>
import {
  BAvatar,
  BBadge,
  BPagination,
  BFormGroup,
  BFormInput,
  BFormSelect,
  BDropdown,
  BDropdownItem,
} from "bootstrap-vue";
import { VueGoodTable } from "vue-good-table";
import "vue-good-table/dist/vue-good-table.css";
import store from "@/store/index";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
export default {
  components: {
    VueGoodTable,
    BAvatar,
    BBadge,
    BPagination,
    BFormGroup,
    BFormInput,
    BFormSelect,
    BDropdown,
    BDropdownItem,
  },
  data() {
    return {
      pageLength: 3,
      dir: false,
      columns: [
        {
          label: "Name",
          field: "name",
        },
        {
          label: "Action",
          field: "action",
        },
      ],
      rows: [],
      searchTerm: "",
      status: [
        {
          1: "Current",
          2: "Professional",
          3: "Rejected",
          4: "Resigned",
          5: "Applied",
        },
        {
          1: "light-primary",
          2: "light-success",
          3: "light-danger",
          4: "light-warning",
          5: "light-info",
        },
      ],
    };
  },
  computed: {
    statusVariant() {
      const statusColor = {
        /* eslint-disable key-spacing */
        Current: "light-primary",
        Professional: "light-success",
        Rejected: "light-danger",
        Resigned: "light-warning",
        Applied: "light-info",
        /* eslint-enable key-spacing */
      };
      return (status) => statusColor[status];
    },
    direction() {
      if (store.state.appConfig.isRTL) {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.dir = true;
        return this.dir;
      }
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.dir = false;
      return this.dir;
    },
  },
  created() {
    this.UnitData();
  },
  methods: {
    UnitData() {
      this.$http.get("admin/v1/unit").then((res) => {
        this.rows = res.data.Unit
        
      });
    },
    deleteData(id) {
      // eslint-disable-next-line no-undef
      this.$bvModal
        .msgBoxConfirm("Please confirm that you want to delete everything.", {
          title: "Please Confirm",
          size: "sm",
          okVariant: "primary",
          okTitle: "Yes",
          cancelTitle: "No",
          cancelVariant: "outline-secondary",
          hideHeaderClose: false,
          centered: true,
        })
        .then((value) => {
          if (value) {
            this.$http
              .delete(`admin/v1/unit/${id}`)
              .then((res) => {
                this.UnitData();
                this.$toast({
                  component: ToastificationContent,
                  props: {
                    title: "Unit Deleted",
                    icon: "EditIcon",
                    variant: "success",
                  },
                });
              })
              .catch((error) => {
                this.$toast({
                  component: ToastificationContent,
                  props: {
                    title: "Something Wrong",
                    icon: "EditIcon",
                    variant: "eror",
                  },
                });
              });
          }
        });
    },
  },
};
</script>
