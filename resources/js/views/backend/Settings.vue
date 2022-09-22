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
                  <h1 class="h2 mb-0 ls-tight">Settings</h1>
                </div>
              </div>
              <!-- Nav -->
            </div>
          </div>
        </header>

        <!-- Main -->
        <main class="py-6 bg-surface-secondary">
          <div class="container-fluid">
            <div class="row jumbotron">
              <br />
              <div class="d-flex justify-content-center" v-if="loading">
                <div class="spinner-border" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

              <div class="col-sm-12 form-group">
                <label>Old Password</label>
                <input
                  type="text"
                  v-model="password.old_password"
                  class="form-control form-control-lg"
                  id="surname"
                  required
                />
              </div>

              <div class="col-sm-12 form-group">
                <label>New Password</label>
                <input
                  type="password"
                  v-model="password.new_password"
                  class="form-control form-control-lg"
                  required
                />
              </div>

              <div class="col-sm-12 form-group">
                <label>Confirm Password </label>
                <input
                  type="password"
                  v-model="password.confirm_new_password"
                  class="form-control form-control-lg"
                  required
                />
                <br />
                <div class="col-sm-12 form-group mb-0">
                  <button
                    class="btn btn-dark float-right"
                    @click="submitChangePassword()"
                  >
                    Submit
                  </button>
                </div>
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
  name: "Settings",
  components: {
    Nav: () => import("../../components/Nav.vue"),
  },
  data() {
    return {
      password: {
        old_password: "",
        new_password: "",
        confirm_new_password: "",
      },
    };
  },
  methods: {
    //submit change password
    async submitChangePassword() {
      let api_url = process.env.MIX_API_BASE_URL + "change-password";
      try {
        const response = await axios.patch(
          api_url,
          {
            old_password: this.password.old_password,
            password: this.password.new_password,
            password_confirmation: this.password.confirm_new_password,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        );
        this.$toasted.success(response.data.message);
      } catch (e) {
        this.$toasted.error(e.response.data.message);
      }
    },
  },
  computed: {
    ...mapGetters(["user"]),
  },
};
</script>

<style scoped>
@import "../../css/index.css";
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");
</style>

