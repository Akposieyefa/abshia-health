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
                  <h1 class="h2 mb-0 ls-tight">Referred Patients</h1>
                </div>
                <!-- Actions -->
                <div class="col-sm-6 col-12 text-sm-end">
                  <div class="mx-n1">
                    <button
                      v-if="user.role === 'hospital'"
                      data-toggle="modal"
                      data-target="#form"
                      class="btn d-inline-flex btn-sm btn-dark mx-1"
                    >
                      <span class="pe-2">
                        <i class="bi bi-plus"></i>
                      </span>
                      <span>Refer a patient</span>
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
                <h5 class="mb-0">All Referrals</h5>
              </div>
              <div class="table-responsive">
                <table class="table table-hover table-nowrap">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">No..</th>
                      <th scope="col" v-if="user.role === 'superadmin'">
                        Refred From
                      </th>
                      <th scope="col">Enrolle Id</th>
                      <th scope="col">Name</th>
                      <th scope="col">Case</th>
                      <th scope="col">Hospital Reffed To</th>
                      <th scope="col">Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(refer, index) in refers.data" :key="refer.id">
                      <td>{{ index + 1 }}</td>
                      <td v-if="user.role === 'superadmin'">
                        {{ refer.relationships.hospital.name }}
                      </td>
                      <td>{{ refer.relationships.enrolle.emp_id }}</td>
                      <td>
                        {{
                          refer.relationships.enrolle.surname +
                          " " +
                          refer.relationships.enrolle.first_name
                        }}
                      </td>
                      <td>{{ refer.case }}</td>
                      <td>{{ refer.hospital_name }}</td>
                      <td>{{ formatDate(refer.created_at) }}</td>
                      <td>
                        <router-link
                          to="/"
                          class="btn btn-sm btn-square btn-info text-info-hover"
                          data-toggle="modal"
                          data-target="#form"
                        >
                          <i class="bi bi-eye"></i>
                        </router-link>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer border-0 py-5">
                <PaginationComponet
                  :pagination="refers"
                  @paginate="getAllRefers()"
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
            <h5 class="modal-title">Refer patient</h5>
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
                <label for="name">Patient Id</label>
                <input
                  type="text"
                  v-model="refer.emp_code"
                  class="form-control form-control-lg"
                  aria-describedby="emailHelp"
                />
              </div>
              <div class="form-group">
                <label for="name">Case/Reason for Refer</label>
                <input
                  type="text"
                  v-model="refer.case"
                  class="form-control form-control-lg"
                  aria-describedby="emailHelp"
                />
              </div>
              <div class="form-group">
                <label for="name">Hospital Name</label>
                <input
                  type="text"
                  v-model="refer.hospital_name"
                  class="form-control form-control-lg"
                  aria-describedby="emailHelp"
                />
              </div>
              <div class="form-group">
                <label for="description">Summary/Remark</label>
                <textarea
                  id="description"
                  v-model="refer.remark"
                  rows="3"
                  class="form-control form-control-md"
                  aria-label="With textarea"
                ></textarea>
              </div>
            </div>
            <div class="modal-footer border-top-0">
              <button
                type="submit"
                @click="createRefer()"
                class="btn btn-sm btn-dark"
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
  name: "Refers",
  components: {
    Nav: () => import("../../../components/Nav.vue"),
    PaginationComponet: () => import("../../../components/Pagination.vue"),
  },
  data() {
    return {
      refer: {
        emp_code: "",
        case: "",
        hospital_name: "",
        remark: "",
      },
      refers: {
        meta: {
          current_page: 1,
        },
      },
      edit: false,
    };
  },
  created() {
    this.getAllRefers();
  },
  computed: {
    ...mapGetters(["user"]),
  },
  methods: {
    //create refers
    async createRefer() {
      let api_url = process.env.MIX_API_BASE_URL + "refers";
      try {
        const response = await axios.post(
          api_url,
          {
            emp_code: this.refer.emp_code,
            case: this.refer.case,
            hospital_name: this.refer.hospital_name,
            remark: this.refer.remark,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        );
        $('.modal').modal('hide');
        this.$toasted.success(response.data.message);
        await this.getAllRefers();
      } catch (e) {
        this.$toasted.error(e.response.data.message);
      }
    },

    //get all refers
    async getAllRefers() {
      let vm = this;
      let api_url =
        process.env.MIX_API_BASE_URL +
        `refers?page=${vm.refers.meta.current_page}`;
      await axios
        .get(api_url, {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        })
        .then((response) => {
          vm.refers = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
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


