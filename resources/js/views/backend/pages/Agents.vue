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
                  <h1 class="h2 mb-0 ls-tight">Agents</h1>
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
                <h5 class="mb-0">All Agents</h5>
              </div>
              <div class="table-responsive">
                <table class="table table-hover table-nowrap">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">No..</th>
                      <th scope="col">Agent Code</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Phone</th>
                      <th scope="col">Enrolled Users</th>
                      <th scope="col">Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(agent, index) in agents.data" :key="agent.id">
                      <td>{{ index + 1 }}</td>
                      <td>{{ agent.details.code }}</td>
                      <td>{{ agent.details.name }}</td>
                      <td>{{ agent.email }}</td>
                      <td>{{ agent.details.phone_number }}</td>
                      <td>
                        {{ agent.details.relationships.enrolled_users.length }}
                      </td>
                      <td>{{ formatDate(agent.details.created_at) }}</td>
                      <td class="text-end">
                        <button
                          title="Edit agent"
                          class="btn btn-sm btn-square btn-dark text-dark-hover"
                          @click="editMode(agent.id)"
                          data-toggle="modal"
                          data-target="#form"
                        >
                          <i class="bi bi-pen-fill"></i>
                        </button>
                        <button
                          title="Delete agent"
                          @click="deleteAgent(agent.id)"
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
                 <PaginationComponet :pagination="agents" @paginate="getAllAgents()" :offset="10"></PaginationComponet>
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
            <h5 class="modal-title" v-if="edit">Edit Agent</h5>
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
                <label for="name">Name</label>
                <input
                  type="text"
                  v-model="agent.details.name"
                  class="form-control form-control-lg"
                  id="name"
                  aria-describedby="emailHelp"
                  placeholder="Enter name"
                />
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input
                  type="text"
                  v-model="agent.email"
                  class="form-control form-control-lg"
                  id="email"
                  aria-describedby="emailHelp"
                  placeholder="Enter email"
                />
              </div>
              <div class="form-group">
                <label for="phone">Phone Number</label>
                <input
                  type="text"
                  v-model="agent.details.phone_number"
                  class="form-control form-control-lg"
                  id="phone"
                  aria-describedby="emailHelp"
                  placeholder="Enter phone number"
                />
              </div>
              <div class="form-group">
                <label for="phone">Lga</label>
                <select
                  id="lga"
                  v-model="agent.details.lga_id"
                  class="form-control form-control-lg"
                >
                  <option value="0">Select Lga</option>
                  <option
                    v-for="(lga, index) in lgas"
                    v-bind:value="lga.id"
                    :key="index"
                  >
                    {{ lga.lga_name }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label for="description">Address</label>
                <textarea
                  id="description"
                  v-model="agent.details.address"
                  placeholder="Enter address"
                  rows="3"
                  class="form-control form-control-md"
                  aria-label="With textarea"
                ></textarea>
              </div>
            </div>
            <div class="modal-footer border-top-0">
              <button
                type="submit"
                @click="updateAgent(agent.id)"
                class="btn btn-sm btn-dark"
                v-if="edit"
              >
                Update
              </button>
              <button
                type="submit"
                @click="createAgent()"
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
  name: "Agents",
  components: {
    Nav: () => import("../../../components/Nav.vue"),
    PaginationComponet: () => import("../../../components/Pagination.vue"),
  },
  data() {
    return {
      agent: {
        email: "",
        details: {
          name: "",
          phone_number: "",
          address: "",
          lga_id: 0,
        },
      },
      lgas: [],
      agents: {
        meta: {
          current_page : 1
        }
      },
      edit: false,
    };
  },
  created() {
    this.getAllAgents();
    this.getAllLocalArea();
  },
  computed: {
    ...mapGetters(["user"]),
  },
  methods: {
    //set edit mood
    async editMode(id) {
      this.edit = true;
      let api_url = process.env.MIX_API_BASE_URL + "account-details/";
      const response = await axios.get(api_url + id, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });
      this.agent = response.data.data;
    },

    //udate agent
    async updateAgent(id) {
      let api_url = process.env.MIX_API_BASE_URL + "account-update-agent/";
      try {
        const response = await axios.patch(
          api_url + id,
          {
            name: this.agent.details.name,
            phone_number: this.agent.details.phone_number,
            address: this.agent.details.address,
            lga_id: this.agent.details.lga_id,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        );
        $('.modal').modal('hide');
        await this.getAllAgents();
        this.$toasted.success(response.data.message);
        this.edit = false;
      } catch (e) {
        this.$toasted.error(e.response.data.message);
      }
    },

    //create agent
    async createAgent() {
      let api_url = process.env.MIX_API_BASE_URL + "create-agents";
      try {
        const response = await axios.post(
          api_url,
          {
            name: this.agent.details.name,
            email: this.agent.email,
            phone_number: this.agent.details.phone_number,
            address: this.agent.details.address,
            lga_id: this.agent.details.lga_id,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        );
        $('.modal').modal('hide');
        this.$toasted.success(response.data.message);
        await this.getAllAgents();
      } catch (e) {
        this.$toasted.error(e.response.data.message);
      }
    },

  //get all agent
    async getAllAgents() {
      let vm = this;
      let api_url = process.env.MIX_API_BASE_URL + `get-agents?page=${vm.agents.meta.current_page}`
      await axios.get(
        api_url,
        {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        }
      ).then((response) => {
         vm.agents = response.data;
      })
      .catch((error) => {
          console.log(error);
      });
    },

    //get all local government areas
    async getAllLocalArea() {
      let api_url = process.env.MIX_API_BASE_URL + "get-all-lga";
      const response = await axios.get(api_url, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });
      this.lgas = response.data.data.lgas;
    },

    //delete agent
    async deleteAgent(id) {
      let api_url = process.env.MIX_API_BASE_URL + "delete-account/";
      if (confirm("Do you really want to delete this record?")) {
        try {
          const response = await axios.delete(api_url + id, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          });
          this.$toasted.success(response.data.message);
          await this.getAllAgents();
        } catch (e) {
          this.$toasted.error(e.response.data.message);
        }
      }
    },

    //date time format
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


