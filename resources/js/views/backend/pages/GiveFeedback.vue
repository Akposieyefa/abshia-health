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
                  <h1 class="h2 mb-0 ls-tight">Feedbacks</h1>
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
            <div>
              <div class="row jumbotron">
                <br />
                <div class="d-flex justify-content-center" v-if="loading">
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>

                <div class="col-sm-12 form-group">
                  <label>Name</label>
                  <input
                    type="text"
                    v-model="feedback.name"
                    class="form-control form-control-lg"
                    id="surname"
                    required
                  />
                </div>

                <div class="col-sm-12 form-group">
                  <label>Market Reality</label>
                  <input
                    type="text"
                    v-model="feedback.market_reality"
                    class="form-control form-control-lg"
                    required
                  />
                </div>

                <div class="col-sm-12 form-group">
                  <label>Importance </label>
                  <input
                    type="text"
                    v-model="feedback.importance"
                    class="form-control form-control-lg"
                    required
                  />
                </div>

                <div class="col-sm-12 form-group">
                  <label for="email">Solution</label>
                  <input
                    type="text"
                    v-model="feedback.solution_platform"
                    class="form-control form-control-lg"
                    id="email"
                    required
                  />
                </div>

                <div class="col-sm-12 form-group">
                  <label for="address-1">Key Things</label>
                  <input
                    type="text"
                    v-model="feedback.key_things"
                    class="form-control form-control-lg"
                    id="address-1"
                    required
                  />
                </div>

                <div class="col-sm-12 form-group">
                  <label for="address-2">Ideal Relationship</label>
                  <input
                    type="text"
                    v-model="feedback.ideal_relationship"
                    class="form-control form-control-lg"
                    id="address-2"
                    required
                  />
                </div>

                <div class="col-sm-12 form-group">
                  <label>Facilities</label>
                  <input
                    type="text"
                    v-model="feedback.facility_band"
                    class="form-control form-control-lg"
                    id="Date"
                    required
                  />
                </div>

                <div class="col-sm-12 form-group">
                  <label>Patients Percentage</label>
                  <input
                    type="text"
                    v-model="feedback.patient_percentage"
                    class="form-control form-control-lg"
                    required
                  />
                </div>

                <div class="col-sm-12 form-group">
                  <label>Second Investigation</label>
                  <input
                    type="text"
                    v-model="feedback.second_third_investigation"
                    class="form-control form-control-lg"
                    required
                  />
                </div>

                <div class="col-sm-12 form-group">
                  <label>Perceived HMO</label>
                  <input
                    type="text"
                    v-model="feedback.perceive_hmo"
                    class="form-control form-control-lg"
                    required
                  />
                </div>

                <div class="col-sm-12 form-group mb-0">
                  <button
                    class="btn btn-dark float-right"
                    @click="submitFeedBack()"
                  >
                    Submit Feedback
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
  name: "GiveFeedbacks",
  components: {
    Nav: () => import("../../../components/Nav.vue"),
  },
  data() {
    return {
      loading: false,
      feedback: {
        market_reality: "",
        importance: "",
        solution_platform: "",
        key_things: "",
        ideal_relationship: "",
        facility_band: "",
        patient_percentage: "",
        second_third_investigation: "",
        perceive_hmo: "",
        name: "",
      },
      pagination: {},
    };
  },
  computed: {
    ...mapGetters(["user"]),
  },
  methods: {
    //submit feedback
    async submitFeedBack() {
      let api_url = process.env.MIX_API_BASE_URL + "feedbacks";
      try {
        const response = await axios.post(
          api_url,
          {
            market_reality: this.feedback.market_reality,
            importance: this.feedback.importance,
            solution_platform: this.feedback.solution_platform,
            key_things: this.feedback.key_things,
            ideal_relationship: this.feedback.ideal_relationship,
            facility_band: this.feedback.facility_band,
            patient_percentage: this.feedback.patient_percentage,
            second_third_investigation:
              this.feedback.second_third_investigation,
            perceive_hmo: this.feedback.perceive_hmo,
            name: this.feedback.name,
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
};
</script>

<style scoped>
@import "../../../css/index.css";
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");
</style>
