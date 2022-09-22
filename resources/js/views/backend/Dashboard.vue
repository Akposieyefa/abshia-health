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
                  <h1 class="h2 mb-0 ls-tight">Dashboard</h1>
                </div>

                <div
                  v-if="user.role === 'superadmin'"
                  class="col-sm-6 col-12 text-sm-end"
                >
                  <div class="mx-n1">
                    <router-link
                      to="/treatments"
                      data-toggle="modal"
                      data-target="#form"
                      class="btn d-inline-flex btn-sm btn-dark mx-1"
                    >
                      <span class="pe-2">
                        <i class="bi bi-eye"></i>
                      </span>
                      <span>All Treatments</span>
                    </router-link>
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
            <DashboardComponent v-if="user.role === 'superadmin'" />
            <DashboardComponentHospital v-if="user.role === 'hospital'" />
            <!-- End of card state -->
            <div
              class="card shadow border-0 mb-7"
              v-if="user.role === 'superadmin' || user.role === 'hospital'"
            >
              <div class="card-header">
                <h5 class="mb-0" v-if="user.role === 'superadmin'">
                  Enrollees
                </h5>
                <h5 class="mb-0" v-if="user.role === 'hospital'">Enrollees</h5>
              </div>
              <div class="table-responsive">
                <table class="table table-hover table-nowrap">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">No..</th>
                      <th scope="col">Enrollee ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Phone</th>
                      <th scope="col">Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user, index) in users.data" :key="user.id">
                      <td>{{ index + 1 }}</td>
                      <td>{{ user.details.emp_id }}</td>
                      <td>{{ user.details.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.details.phone_number }}</td>
                      <td>{{ formatDate(user.created_at) }}</td>
                      <td class="text-end">
                        <router-link
                          v-bind:to="'/profile/' + user.id"
                          class="btn btn-sm btn-info"
                        >
                          <i class="bi bi-eye"></i>
                        </router-link>
                        <button
                          @click="deleteUser(user.id)"
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
                  :pagination="users"
                  @paginate="getAllUser()"
                  :offset="10"
                ></PaginationComponet>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios";

export default {
  name: "Dashboard",
  components: {
    DashboardComponent: () => import("../../components/DashboardComponent"),
    DashboardComponentHospital: () =>
      import("../../components/DashboardComponentHospital"),
    Nav: () => import("../../components/Nav.vue"),
    PaginationComponet: () => import("../../components/Pagination.vue"),
  },
  created() {
    this.getAllUser();
  },
  data() {
    return {
      users: {
        meta: {
          current_page: 1,
        },
      },
    };
  },
  methods: {
    //get all users
    async getAllUser() {
      let vm = this;
      let api_url =
        process.env.MIX_API_BASE_URL +
        `get-onboard-users?page=${vm.users.meta.current_page}`;
      await axios
        .get(api_url, {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        })
        .then((response) => {
          vm.users = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    //delete users
    async deleteUser(id) {
      let api_url = process.env.MIX_API_BASE_URL + "delete-account/";
      if (confirm("Do you really want to delete this record?")) {
        try {
          const response = await axios.delete(api_url + id, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          });
          this.$toasted.success(response.data.message);
          await this.getAllUser();
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
  computed: {
    ...mapGetters(["user"]),
  },
};
</script>

