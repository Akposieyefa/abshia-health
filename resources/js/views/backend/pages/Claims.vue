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
                  <h1 class="h2 mb-0 ls-tight">Payment Claims</h1>
                </div>
                <!-- Actions -->
                <div
                  v-if="user.role === 'hospital'"
                  class="col-sm-6 col-12 text-sm-end"
                >
                  <div class="mx-n1">
                    <button
                      data-toggle="modal"
                      data-target="#form"
                      class="btn d-inline-flex btn-sm btn-dark mx-1"
                    >
                      <span class="pe-2">
                        <i class="bi bi-plus"></i>
                      </span>
                      <span>Request Payment</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </header>

        <!-- Main -->
        <main class="py-6 bg-surface-secondary">
          <div class="container-fluid">
            <!-- Card stats -->
            <div class="card shadow border-0 mb-7">
              <div class="card-header">
                <h5 class="mb-0">All Claims</h5>
              </div>
              <div class="table-responsive">
                <table class="table table-hover table-nowrap">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">No..</th>
                      <th v-if="user.role === 'superadmin'" scope="col">
                        Hospital Name
                      </th>
                      <th scope="col">Patient ID</th>
                      <th v-if="user.role === 'hospital'" scope="col">
                        Patient Name
                      </th>
                      <th scope="col">Diagnosis</th>
                      <th scope="col">Cost of Treatment</th>
                      <th scope="col">Payment Status</th>
                      <th scope="col">Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(claimData, index) in claims.data" :key="claimData.id">
                      <td>{{ index + 1 }}</td>
                      <td v-if="user.role === 'superadmin'">
                        {{ claimData.relationships.hospital.name }}
                      </td>
                      <td>{{ claimData.relationships.enrolle.emp_id }}</td>
                      <td v-if="user.role === 'hospital'">
                        {{ claimData.relationships.enrolle.first_name }}
                      </td>
                      <td>{{ claimData.diagnosis }}</td>
                      <td>{{ claimData.cost }}</td>
                      <td>{{ claimData.payment_status }}</td>
                      <td>{{ formatDate(claimData.created_at) }}</td>
                      <td class="text-end">
                        <button
                          title="Edit claim"
                          v-if="user.role === 'hospital'"
                          @click="editMode(claimData.id)"
                          type="button"
                          class="btn btn-sm btn-square btn-dark text-dark-hover"
                          data-toggle="modal"
                          data-target="#form"
                        >
                          <i class="bi bi-pen-fill"></i>
                        </button>
                        <router-link
                          title="View claim details"
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
                          title="Delete claim"
                          v-if="user.role === 'hospital'"
                          @click="deleteTreatments(claimData.id)"
                          type="button"
                          class="
                            btn btn-sm btn-square btn-danger
                            text-danger-hover
                          "
                        >
                          <i class="bi bi-trash"></i>
                        </button>
                        <button
                          title="Cancle claim request"
                          v-if="user.role === 'superadmin'"
                          @click="declineClaim(claimData.id)"
                          type="button"
                          class="
                            btn btn-sm btn-square btn-danger
                            text-danger-hover
                          "
                        >
                          <i class="bi bi-x"></i>
                        </button>
                        <button
                          title="Approve claim request"
                          v-if="user.role === 'superadmin'"
                          @click="approveClaim(claimData.id)"
                          type="button"
                          class="
                            btn btn-sm btn-square btn-success
                            text-danger-hover
                          "
                        >
                          <i class="bi bi-check2-all"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody> 
                </table>
              </div>
              <div class="card-footer border-0 py-5">
                <PaginationComponet
                  :pagination="claims"
                  @paginate="getAllClaims()"
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
            <h5 class="modal-title" v-if="edit">Edit Claim</h5>
            <h5 class="modal-title" v-else>Request New Claim</h5>
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
              <div class="form-group" v-if="!edit">
                <label for="name">Patient Id</label>
                <input
                  type="text"
                  v-model="claim.enrolle_id"
                  class="form-control form-control-lg"
                  id="name"
                  aria-describedby="emailHelp"
                  placeholder="Enter patient id"
                />
              </div>
              <div class="form-group">
                <label for="name">Admission Date</label>
                <input
                  type="date"
                  v-model="claim.date_of_admission"
                  class="form-control form-control-lg"
                  id="name"
                  aria-describedby="emailHelp"
                />
              </div>
              <div class="form-group">
                <label for="name">Discharge Date</label>
                <input
                  type="date"
                  v-model="claim.date_of_discharge"
                  class="form-control form-control-lg"
                  id="name"
                  aria-describedby="emailHelp"
                />
              </div>
              <div class="form-group">
                <label for="name">Diagnosis</label>
                <input
                  type="text"
                  v-model="claim.diagnosis"
                  class="form-control form-control-lg"
                  id="name"
                  aria-describedby="emailHelp"
                  placeholder="Enter diagnosis"
                />
              </div>
              <div class="form-group">
                <label for="name">Investigations</label>
                <input
                  type="text"
                  v-model="claim.investigations"
                  class="form-control form-control-lg"
                  id="name"
                  aria-describedby="emailHelp"
                  placeholder="Enter treatment investigations"
                />
              </div>
              <div class="form-group">
                <label for="name">Cost</label>
                <input
                  type="number"
                  v-model="claim.cost"
                  class="form-control form-control-lg"
                  id="name"
                  aria-describedby="emailHelp"
                  placeholder="Enter treatment cost"
                />
              </div>
              <div class="form-group">
                <label for="description">Treatment Details</label>
                <textarea
                  id="description"
                  v-model="claim.treatment_details"
                  placeholder="Enter treatment details"
                  rows="3"
                  class="form-control form-control-md"
                  aria-label="With textarea"
                ></textarea>
              </div>
            </div>
            <div class="modal-footer border-top-0">
              <button
                type="submit"
                @click="updateClaim(category.id)"
                class="btn btn-sm btn-dark"
                v-if="edit"
              >
                Update
              </button>
              <button
                type="submit"
                @click="createClaim()"
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
  name: "Claims",
  components: {
    Nav: () => import("../../../components/Nav.vue"),
    PaginationComponet: () => import("../../../components/Pagination.vue"),
  },
  data() {
    return {
      claim: {
        enrolle_id: "",
        date_of_admission: "",
        date_of_discharge: "",
        treatment_details: "",
        diagnosis: "",
        investigations: "",
        cost: "",
      },
      claims: {
        meta: {
          current_page: 1,
        },
      },
      edit: false,
    };
  },
  created() {
    this.getAllClaims();
  },
  computed: {
    ...mapGetters(["user"]),
  },
  methods: {
    //set edit mode
    async editMode(id) {
      this.edit = true;
      let api_url = process.env.MIX_API_BASE_URL + "claims/";
      const response = await axios.get(api_url + id, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });
      this.claim = response.data.data;
    },

    //approve claims
    async approveClaim(id) {
      let api_url = process.env.MIX_API_BASE_URL + "approve-claims/";
      const response = await axios.get(api_url + id, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });
      this.getAllClaims();
    },

    //decline claims
    async declineClaim(id) {
      let api_url = process.env.MIX_API_BASE_URL + "decline-claims/";
      const response = await axios.get(api_url + id, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });
      this.getAllClaims();
    },

    //get all claims
    async getAllClaims() {
      let vm = this;
      let api_url =
        process.env.MIX_API_BASE_URL +
        `claims?page=${vm.claims.meta.current_page}`;
      await axios
        .get(api_url, {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        })
        .then((response) => {
          vm.claims = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    //udpate claims
    async updateClaim(id) {
      let api_url = process.env.MIX_API_BASE_URL + "claims/";
      try {
        const response = await axios.patch(
          api_url + id,
          {
            date_of_admission: this.claim.date_of_admission,
            date_of_discharge: this.claim.date_of_discharge,
            treatment_details: this.claim.treatment_details,
            diagnosis: this.claim.diagnosis,
            investigations: this.claim.investigations,
            cost: this.claim.cost,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        );
        await this.getAllClaims();
        this.$toasted.success(response.data.message);
        this.edit = false;
      } catch (e) {
        this.$toasted.error(e.response.data.message);
      }
    },

    //create claims
    async createClaim() {
      let api_url = process.env.MIX_API_BASE_URL + "claims";
      try {
        const response = await axios.post(
          api_url,
          {
            emp_code: this.claim.enrolle_id,
            date_of_admission: this.claim.date_of_admission,
            date_of_discharge: this.claim.date_of_discharge,
            treatment_details: this.claim.treatment_details,
            diagnosis: this.claim.diagnosis,
            investigations: this.claim.investigations,
            cost: this.claim.cost,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        );
        this.$toasted.success(response.data.message);
        await this.getAllClaims();
      } catch (e) {
        this.$toasted.error(e.response.data.message);
        console.log(e.response.data);
      }
    },

    //delete claims
    async deleteClaim(id) {
      let api_url = process.env.MIX_API_BASE_URL + "claims/";
      if (confirm("Do you really want to delete this record?")) {
        try {
          const response = await axios.delete(api_url + id, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          });
          this.$toasted.success(response.data.message);
          await this.getAllClaims();
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


>
