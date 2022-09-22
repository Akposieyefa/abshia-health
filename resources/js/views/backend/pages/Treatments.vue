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
                  <h1 class="h2 mb-0 ls-tight">Treatments</h1>
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
                <h5 class="mb-0">All Treatments</h5>
              </div>
              <div class="table-responsive">
                <table class="table table-hover table-nowrap">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">No..</th>
                      <th v-if="user.role === 'superadmin'" scope="col">
                        Hospital Name
                      </th>
                      <th scope="col">ENROLLEE ID</th>
                      <th scope="col">Patient Name</th>
                      <th scope="col">Doctor Name</th>
                      <th scope="col">Cost of Treatment</th>
                      <th scope="col">Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(treatment, index) in treatments.data"
                      :key="treatment.id"
                    >
                      <td>{{ index + 1 }}</td>
                      <td v-if="user.role === 'superadmin'">
                        {{ treatment.relationships.hospital.name }}
                      </td>
                      <td>{{ treatment.relationships.enrolle.emp_id }}</td>
                      <td>{{ treatment.relationships.enrolle.name }}</td>
                      <td>{{ treatment.verified_by }}</td>
                      <td>{{ treatment.cost_of_treatment }}</td>
                      <td>{{ formatDate(treatment.date_and_time) }}</td>
                      <td class="text-end">
                        <router-link
                          to="/"
                          type="button"
                          class="
                            btn btn-sm btn-square btn-info
                            text-danger-hover
                          "
                        >
                          <i class="bi bi-eye"></i>
                        </router-link>
                        <button
                          v-if="user.role === 'superadmin'"
                          @click="deleteTreatments(treatment.id)"
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
                  :pagination="treatments"
                  @paginate="getAllTreatments()"
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
export default {
  name: "Treatments",
  components: {
    Nav: () => import("../../../components/Nav.vue"),
    PaginationComponet: () => import("../../../components/Pagination.vue"),
  },
  data() {
    return {
      treatments: {
        meta: {
          current_page: 1,
        },
      },
    };
  },
  created() {
    this.getAllTreatments();
  },
  computed: {
    ...mapGetters(["user"]),
  },
  methods: {
    //get all treatments
    async getAllTreatments() {
      let vm = this;
      let api_url =
        process.env.MIX_API_BASE_URL +
        `treatments?page=${vm.treatments.meta.current_page}`;
      await axios
        .get(api_url, {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        })
        .then((response) => {
          vm.treatments = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    //delete treatments
    async deleteTreatments(id) {
      let api_url = process.env.MIX_API_BASE_URL + "treatments/";
      if (confirm("Do you really want to delete this record?")) {
        try {
          const response = await axios.delete(api_url + id, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          });
          this.$toasted.success(response.data.message);
          await this.getAllTreatments();
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
