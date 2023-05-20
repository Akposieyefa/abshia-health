<template>
  <div>
    <!-- Dashboard -->
    <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
      <!-- Vertical Navbar -->
      <Nav />
      <!-- Main content -->
      <div class="h-screen flex-grow-1 overflow-y-lg-auto">
        <!-- Header -->
        <header class="bg-surface-primary border-bottom pt-6 pb-5">
          <div class="container-fluid">
            <div class="mb-npx">
              <div class="row align-items-center">
                <div class="col-sm-6 col-12 mb-4 mb-sm-0">
                  <!-- Title -->
                  <h1 class="h2 mb-0 ls-tight">Categories</h1>
                </div>
                <!-- Actions -->
                <div class="col-sm-6 col-12 text-sm-end">
                  <div class="mx-n1">
                    <button
                      data-toggle="modal"
                      data-target="#form"
                      class="btn d-inline-flex btn-sm btn-dark mx-1"
                    >
                      <span class="pe-2">
                        <i class="bi bi-plus"></i>
                      </span>
                      <span>Create</span>
                    </button>
                  </div>
                </div>
              </div>
              <!-- Nav -->
            </div>
          </div>
        </header>

        <!-- Main -->
        <main class="py-6 bg-surface-secondary">
          <div class="container-fluid">
            <!-- Card stats -->
            <div class="card shadow border-0 mb-7">
              <div class="card-header">
                <h5 class="mb-0">All Categories</h5>
              </div>
              <div class="table-responsive">
                <table class="table table-hover table-nowrap">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">No..</th>
                      <th scope="col">Title</th>
                      <th scope="col">Description</th>
                      <th scope="col">Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(category, index) in categories.data"
                      :key="category.id"
                    >
                      <td>{{ index + 1 }}</td>
                      <td>{{ category.title }}</td>
                      <td>{{ category.description }}</td>
                      <td>{{ formatDate(category.created_at) }}</td>
                      <td class="text-end">
                        <button
                          title="Edit category"
                          class="btn btn-sm btn-square btn-dark text-dark-hover"
                          @click="editMode(category.id)"
                          data-toggle="modal"
                          data-target="#form"
                        >
                          <i class="bi bi-pen-fill"></i>
                        </button>
                        <button
                          title="Delete category"
                          @click="deleteCategory(category.id)"
                          type="button"
                          class="
                            btn btn-sm btn-square btn-danger
                            text-danger-hover
                          "
                        >
                          <i class="bi bi-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer border-0 py-5">
                <PaginationComponet
                  :pagination="categories"
                  @paginate="getAllCategories()"
                  :offset="10"
                ></PaginationComponet>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

    <!--Modal display-->
    <div
      class="modal fade"
      id="form"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" v-if="edit">Edit Category</h5>
            <h5 class="modal-title" v-else>Add New</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div>
            <div class="modal-body">
              <div class="form-group">
                <label for="name">Title</label>
                <input
                  type="text"
                  v-model="category.title"
                  class="form-control form-control-lg"
                  id="name"
                  aria-describedby="emailHelp"
                  placeholder="Enter title"
                />
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <textarea
                  id="description"
                  v-model="category.description"
                  placeholder="Enter description"
                  rows="6"
                  class="form-control form-control-md"
                  aria-label="With textarea"
                ></textarea>
              </div>
            </div>
            <div class="modal-footer border-top-0">
              <button
                type="submit"
                @click="updateCategory(category.id)"
                class="btn btn-sm btn-dark"
                v-if="edit"
              >
                Update
              </button>
              <button
                type="submit"
                @click="createCategory()"
                class="btn btn-sm btn-dark"
                v-else
              >
                Create
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--end of modal -->
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "Categories",
  components: {
    Nav: () => import("../../../components/Nav.vue"),
    PaginationComponet: () => import("../../../components/Pagination.vue"),
  },
  data() {
    return {
      category: {
        title: "",
        description: "",
      },
      categories: {
        meta: {
          current_page: 1,
        },
      },
      edit: false,
    };
  },
  created() {
    this.getAllCategories();
  },
  computed: {
    ...mapGetters(["user"]),
  },
  methods: {
    //set edit mode
    async editMode(id) {
      this.edit = true;
      let api_url = process.env.MIX_API_BASE_URL + "categories/";
      const response = await axios.get(api_url + id, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });
      this.category = response.data.data;
    },

    //udpate category
    async updateCategory(id) {
      let api_url = process.env.MIX_API_BASE_URL + "categories/";
      try {
        const response = await axios.patch(
          api_url + id,
          {
            title: this.category.title,
            description: this.category.description,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        );
        await this.getAllCategories();
        this.$toasted.success(response.data.message);
        this.edit = false;
      } catch (e) {
        this.$toasted.error(e.response.data.message);
      }
    },

    //create category
    async createCategory() {
      let api_url = process.env.MIX_API_BASE_URL + "categories";
      try {
        const response = await axios.post(
          api_url,
          {
            title: this.category.title,
            description: this.category.description,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        );
        this.$toasted.success(response.data.message);
        this.category.title = "";
        this.category.description = "";
        $('.modal').modal('hide');
        await this.getAllCategories();
      } catch (e) {
        this.$toasted.error(e.response.data.message);
      }
    },

    //get all category
    async getAllCategories() {
      let vm = this;
      let api_url =
        process.env.MIX_API_BASE_URL +
        `categories?page=${vm.categories.meta.current_page}`;
      await axios
        .get(api_url, {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        })
        .then((response) => {
          vm.categories = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    //delete category
    async deleteCategory(id) {
      let api_url = process.env.MIX_API_BASE_URL + "categories/";
      if (confirm("Do you really want to delete this record?")) {
        try {
          const response = await axios.delete(api_url + id, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          });
          this.$toasted.success(response.data.message);
          await this.getAllCategories();
        } catch (e) {
          this.$toasted.error(e.response.data.message);
        }
      }
    },

    //format date
    formatDate(dateString) {
      const options = { year: "numeric", month: "long", day: "numeric" };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },
  },
};
</script>

<style scoped>
@import "../../../css/index.css";
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");
</style>


