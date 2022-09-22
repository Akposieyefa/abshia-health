<template>
  <div class="container">
    <div>
      <h2 class="text-center">Create Account</h2>
      <div class="row jumbotron">
        <br />
        <div class="d-flex justify-content-center" v-if="loading">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>

        <div class="col-sm-4 form-group">
          <label>Sur Name</label>
          <input
            type="text"
            v-model="user.surname"
            class="form-control"
            id="surname"
            placeholder="Enter your first name."
            required
          />
        </div>

        <div class="col-sm-4 form-group">
          <label>First Name</label>
          <input
            type="text"
            v-model="user.first_name"
            class="form-control"
            placeholder="Enter your first name."
            required
          />
        </div>

        <div class="col-sm-4 form-group">
          <label>Middle Name</label>
          <input
            type="text"
            v-model="user.middle_name"
            class="form-control"
            placeholder="Enter your last name."
            required
          />
        </div>

        <div class="col-sm-6 form-group">
          <label for="email">Email</label>
          <input
            type="email"
            v-model="user.email"
            class="form-control"
            name="email"
            id="email"
            placeholder="Enter your email."
            required
          />
        </div>

        <div class="col-sm-6 form-group">
          <label for="address-1">Address</label>
          <input
            type="text"
            v-model="user.address"
            class="form-control"
            name="Locality"
            id="address-1"
            placeholder="Locality/House/Street no."
            required
          />
        </div>

        <div class="col-sm-5 form-group">
          <label for="address-2">Phone Number</label>
          <input
            type="text"
            v-model="user.phone_number"
            class="form-control"
            id="address-2"
            placeholder="08100788859"
            required
          />
        </div>

        <div class="col-sm-4 form-group">
          <label>State</label>
          <select
            class="form-control custom-select browser-default"
            v-model="user.state"
            @change="getStateLga(user.state)"
          >
            <option value="0">Select State</option>
            <option
              v-for="(state, index) in states"
              v-bind:value="state.id"
              :key="index"
            >
              {{ state.state_name }}
            </option>
          </select>
        </div>

        <div class="col-sm-3 form-group">
          <label>Lga</label>
          <select
            class="form-control custom-select browser-default"
            v-model="user.lga"
          >
            <option value="0">Select local government area</option>
            <option
              v-for="(lga, index) in lgas"
              v-bind:value="lga.id"
              :key="index"
            >
              {{ lga.lga_name }}
            </option>
          </select>
        </div>

        <div class="col-sm-6 form-group">
          <label>Date Of Birth</label>
          <input
            type="date"
            v-model="user.date_of_birth"
            class="form-control"
            id="Date"
            required
          />
        </div>

        <div class="col-sm-6 form-group">
          <label>Blood Group</label>
          <select
            v-model="user.blood_group"
            class="form-control browser-default custom-select"
          >
            <option value="0">Select Blood Group</option>
            <option value="O+">O+</option>
            <option value="B+">B+</option>
            <option value="O-">O-</option>
            <option value="B-">B-</option>
          </select>
        </div>

        <div class="col-sm-4 form-group">
          <label>NOK Name</label>
          <input
            type="text"
            v-model="user.nok_name"
            class="form-control"
            required
          />
        </div>

        <div class="col-sm-4 form-group">
          <label>NOK Phone Number</label>
          <input
            type="text"
            v-model="user.nok_phone_number"
            class="form-control"
            required
          />
        </div>

        <div class="col-sm-4 form-group">
          <label>NOK Relationship</label>
          <input
            type="text"
            v-model="user.nok_relationship"
            class="form-control"
            required
          />
        </div>

        <div class="col-sm-3 form-group">
          <label>NOK Address</label>
          <input
            type="text"
            v-model="user.nok_address"
            class="form-control"
            required
          />
        </div>

        <div class="col-sm-3 form-group">
          <label>Number of dependants</label>
          <input
            type="text"
            v-model="user.no_of_dependants"
            class="form-control"
            required
          />
        </div>

        <div class="col-sm-3 form-group">
          <label>Town</label>
          <input
            type="text"
            v-model="user.town"
            class="form-control"
            required
          />
        </div>

        <div class="col-sm-3 form-group">
          <label>Marital status</label>
          <select
            v-model="user.marital_status"
            class="form-control browser-default custom-select"
          >
            <option value="0">Select marital status</option>
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Unspesified">Unspecified</option>
          </select>
        </div>

        <div class="col-sm-4 form-group">
          <label>Gender</label>
          <select
            v-model="user.gender"
            class="form-control browser-default custom-select"
          >
            <option value="0">Select gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>

        <div class="col-sm-2 form-group">
          <label>Hypertensive</label>
          <select
            v-model="user.hypertensive"
            class="form-control browser-default custom-select"
          >
            <option value="0">Are you hypertensive</option>
            <option value="false">NO</option>
            <option value="true">Yes</option>
          </select>
        </div>

        <div class="col-sm-2 form-group">
          <label>Sickle cell</label>
          <select
            v-model="user.sickle_cell"
            class="form-control browser-default custom-select"
          >
            <option value="0">Are you sickle cell</option>
            <option value="false">NO</option>
            <option value="true">Yes</option>
          </select>
        </div>

        <div class="col-sm-2 form-group">
          <label>Cancer</label>
          <select
            v-model="user.cancer"
            class="form-control browser-default custom-select"
          >
            <option value="0">Do you have cancer</option>
            <option value="false">NO</option>
            <option value="true">True</option>
          </select>
        </div>

        <div class="col-sm-2 form-group">
          <label>Kidney Issue</label>
          <select
            v-model="user.kidney_issue"
            class="form-control browser-default custom-select"
          >
            <option value="0">Do you have kidney issue</option>
            <option value="false">No</option>
            <option value="true">Yes</option>
          </select>
        </div>

        <div class="col-sm-4 form-group">
          <label>Category</label>
          <select
            v-model="user.category"
            class="form-control browser-default custom-select"
          >
            <option value="0">Select a category plan</option>
            <option
              v-for="(category, index) in categories"
              v-bind:value="category.id"
              :key="index"
            >
              {{ category.title }}
            </option>
          </select>
        </div>

        <div class="col-sm-4 form-group">
          <label>Health Care</label>
          <select
            v-model="user.health_care"
            class="form-control browser-default custom-select"
          >
            <option value="0">Select your primary health care center</option>
            <option
              v-for="(health, index) in hospitals"
              v-bind:value="health.id"
              :key="index"
            >
              {{ health.name }}
            </option>
          </select>
        </div>

        <div class="col-sm-4 form-group">
          <label>Title</label>
          <select
            v-model="user.title"
            class="form-control browser-default custom-select"
          >
            <option value="0">Select Title</option>
            <option value="Mr">Mr</option>
            <option value="Mrs">Mrs</option>
          </select>
        </div>

        <div class="col-sm-4 form-group">
          <label>Agent Code <small>(Not required)</small></label>
          <input
            type="text"
            v-model="user.agent_code"
            class="form-control"
            required
          />
        </div>

        <div class="col-sm-4 form-group">
          <label>Genotype</label>
          <select
            v-model="user.genotype"
            class="form-control browser-default custom-select"
          >
            <option value="0">Select Genotype</option>
            <option value="AA">AA</option>
            <option value="AS">AS</option>
            <option value="SS">SS</option>
          </select>
        </div>

        <div class="col-sm-4 form-group">
          <label>Existing Medical Condition</label>
          <select
            v-model="user.existing_medical_condition"
            class="form-control browser-default custom-select"
          >
            <option value="0">Do you have existing medical condition</option>
            <option value="false">No</option>
            <option value="true">Yes</option>
          </select>
        </div>

        <div class="col-sm-6 form-group">
          <label>Password</label>
          <input
            type="Password"
            v-model="user.password"
            class="form-control"
            placeholder="Enter your password."
            required
          />
        </div>

        <div class="col-sm-6 form-group">
          <label>Confirm Password</label>
          <input
            type="Password"
            v-model="user.password_confirmation"
            class="form-control"
            placeholder="Re-enter your password."
            required
          />
        </div>

        <div class="col-sm-12">
          <input
            type="checkbox"
            class="form-check d-inline"
            id="chb"
            required
          /><label for="chb" class="form-check-label"
            >&nbsp;I accept all terms and conditions.
          </label>
        </div>

        <div class="col-sm-12 form-group mb-0">
          <button class="btn btn-primary float-right" @click="createUser()">
            Submit
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Register",
  data() {
    return {
      loading: false,
      user: {
        email: "",
        title: 0,
        surname: "",
        first_name: "",
        middle_name: "",
        phone_number: "",
        address: "",
        nok_name: "",
        nok_address: "",
        nok_phone_number: "",
        nok_relationship: "",
        blood_group: 0,
        date_of_birth: "",
        state: 0,
        lga: 0,
        marital_status: 0,
        no_of_dependants: 0,
        category: 0,
        kidney_issue: 0,
        health_care: 0,
        sickle_cell: 0,
        hypertensive: 0,
        cancer: 0,
        genotype: 0,
        existing_medical_condition: 0,
        password: "",
        password_confirmation: "",
        gender: 0,
        town: "",
        agent_code: "",
      },
      hospitals: [],
      states: [],
      categories: [],
      lgas: [],
    };
  },
  created() {
    this.getHelpers();
  },
  methods: {
    //get helpers endpoints
    async getHelpers() {
      let api_url = process.env.MIX_API_BASE_URL + "create-helpers";
      const response = await axios.get(api_url);
      this.states = response.data.data.states;
      this.categories = response.data.data.categories;
      this.hospitals = response.data.data.hospitals;
    },

    //create users
    async createUser() {
      this.loading = true;
      let api_url = process.env.MIX_API_BASE_URL + "onboard-new-users";
      try {
        const response = await axios.post(
          api_url,
          {
            title: this.user.title,
            email: this.user.email,
            surname: this.user.surname,
            first_name: this.user.first_name,
            middle_name: this.user.middle_name,
            gender: this.user.gender,
            phone_number: this.user.phone_number,
            dob: this.user.date_of_birth,
            address: this.user.address,
            blood_group: this.user.blood_group,
            state_id: this.user.state,
            lga_id: this.user.lga,
            town: this.user.town,
            nok_name: this.user.nok_name,
            nok_address: this.user.nok_address,
            nok_phone: this.user.nok_phone_number,
            nok_relationship: this.user.nok_relationship,
            category_id: this.user.category,
            agent_code: this.user.agent_code,
            genotype: this.user.genotype,
            marital_status: this.user.marital_status,
            no_of_dependants: this.user.no_of_dependants,
            health_care_id: this.user.health_care,
            existing_medical_condition: this.user.existing_medical_condition,
            hypertension: this.user.hypertensive,
            sickle_cell: this.user.sickle_cell,
            cancer: this.user.cancer,
            kidney_issue: this.user.kidney_issue,
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
        this.loading = false;
      }
    },

    //get all state by id
    async getStateLga(state_id) {
      let api_url = process.env.MIX_API_BASE_URL + "lga-helper/";
      const response = await axios.get(api_url + state_id);
      this.lgas = response.data.data.lgas;
    },
  },
};
</script>

<style scoped>
label {
  font-weight: 600;
  color: #555;
}
</style>
