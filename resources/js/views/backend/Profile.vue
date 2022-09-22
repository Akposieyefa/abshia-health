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
                  <h1 class="h2 mb-0 ls-tight">Profile</h1>
                </div>
                <!-- Actions -->
              </div>
              <!-- Nav -->
            </div>
          </div>
        </header>

        <!-- Main -->
        <main class="py-6 bg-surface-secondary">
          <div class="container">
            <div class="row profile">
              <div class="col-md-3">
                <div class="profile-sidebar">
                  <!-- SIDEBAR USERPIC -->
                  <div class="profile-userpic">
                    <img
                      :src="asset('avater.jpg')"
                      class="img-responsive center"
                      alt=""
                    />
                  </div>
                  <!-- END SIDEBAR USERPIC -->
                  <!-- SIDEBAR USER TITLE -->
                  <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                      {{ userDetails.details.name }}
                    </div>
                    <div class="profile-usertitle-job">
                      {{ userDetails.role }}
                    </div>
                  </div>
                  <!-- END SIDEBAR USER TITLE -->
                  <!-- SIDEBAR BUTTONS -->
                  <div class="profile-userbuttons">
                    <button type="button" class="btn btn-success btn-sm">
                      Follow
                    </button>
                    <button type="button" class="btn btn-danger btn-sm">
                      Message
                    </button>
                  </div>
                  <!-- END SIDEBAR BUTTONS -->
                  <!-- SIDEBAR MENU -->
                  <div class="profile-usermenu">
                    <ul class="nav">
                      <li class="active">
                        <a href="#">
                          <i class="glyphicon glyphicon-home"></i>
                          Overview
                        </a>
                      </li>
                    </ul>
                  </div>
                  <!-- END MENU -->

                  <div class="portlet light bordered">
                    <div>
                      <h4 class="profile-desc-title">Address</h4>
                      <span class="profile-desc-text">
                        {{ userDetails.details.address }}
                      </span>
                      <div class="margin-top-20 profile-desc-link">
                        Email :
                        <a href="https://www.apollowebstudio.com">{{
                          userDetails.email
                        }}</a>
                      </div>
                      <div class="margin-top-20 profile-desc-link">
                        Phone :
                        <a href="https://www.twitter.com/jasondavisfl/">{{
                          userDetails.details.phone_number
                        }}</a>
                      </div>
                      <span v-if="userDetails.role == 'user'">
                        <div class="margin-top-20 profile-desc-link">
                          Genotype :
                          <a href="https://www.twitter.com/jasondavisfl/">{{
                            userDetails.details.genotype
                          }}</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          Blood Group :
                          <a href="https://www.twitter.com/jasondavisfl/">{{
                            userDetails.details.blood_group
                          }}</a>
                        </div>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-9">
                <div class="profile-content">
                  <span v-if="userDetails.role == 'user'">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="margin-top-20 profile-desc-link">
                          NOK Name :
                          <a href="https://www.apollowebstudio.com">
                            {{ userDetails.details.nok_name }}</a
                          >
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          DOB :
                          <a href="https://www.apollowebstudio.com">{{
                            userDetails.details.dob
                          }}</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          Town :
                          <a href="https://www.twitter.com/jasondavisfl/">{{
                            userDetails.details.town
                          }}</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          PHC :
                          <a href="https://www.twitter.com/jasondavisfl/">{{
                            userDetails.details.relationships.primary_healthcare
                          }}</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          State :
                          <a href="https://www.twitter.com/jasondavisfl/">{{
                            userDetails.details.relationships.state
                          }}</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          Lga :
                          <a href="https://www.twitter.com/jasondavisfl/">{{
                            userDetails.details.relationships.lga
                          }}</a>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="margin-top-20 profile-desc-link">
                          NOK Address :
                          <a href="https://www.apollowebstudio.com">
                            {{ userDetails.details.nok_address }}</a
                          >
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          NOK Phone :
                          <a href="https://www.apollowebstudio.com">{{
                            userDetails.details.nok_phone
                          }}</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          NOK Relationship :
                          <a href="https://www.twitter.com/jasondavisfl/">{{
                            userDetails.details.nok_relationship
                          }}</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          NOK Address :
                          <a href="https://www.twitter.com/jasondavisfl/">{{
                            userDetails.details.nok_address
                          }}</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          Marital Status :
                          <a href="https://www.twitter.com/jasondavisfl/">{{
                            userDetails.details.marital_status
                          }}</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          Number of Dependants :
                          <a href="https://www.twitter.com/jasondavisfl/">{{
                            userDetails.details.no_of_dependants
                          }}</a>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="margin-top-20 profile-desc-link">
                          Active Status :
                          <a href="https://www.apollowebstudio.com">
                            {{ userDetails.details.is_subscribed }}</a
                          >
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          Cancer :
                          <a href="https://www.apollowebstudio.com">{{
                            userDetails.details.cancer
                          }}</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          Sickle Cell :
                          <a href="https://www.twitter.com/jasondavisfl/">{{
                            userDetails.details.sickle_cell
                          }}</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          Hypertension :
                          <a href="https://www.twitter.com/jasondavisfl/">{{
                            userDetails.details.hypertension
                          }}</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          Kidney Issue :
                          <a href="https://www.twitter.com/jasondavisfl/">{{
                            userDetails.details.kidney_issue
                          }}</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                          Registration Agent :
                          <a href="https://www.twitter.com/jasondavisfl/">{{
                            userDetails.details.relationships.agents
                          }}</a>
                        </div>
                      </div>
                    </div>
                  </span>

                  <div v-if="userDetails.role == 'user'">
                    <!-- Card stats -->
                    <div class="card shadow border-0 mb-7">
                      <div class="card-header">
                        <h5 class="mb-0">All Appointments</h5>
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
                              <td>
                                {{ treatment.relationships.enrolle.emp_id }}
                              </td>
                              <td>
                                {{ treatment.relationships.enrolle.first_name }}
                              </td>
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
                          @paginate="getAllAppointments()"
                          :offset="10"
                        ></PaginationComponet>
                      </div>
                    </div>
                  </div>
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
  name: "Profile",
  components: {
    Nav: () => import("../../components/Nav.vue"),
    PaginationComponet: () => import("../../components/Pagination.vue"),
  },
  data() {
    return {
      userDetails: {},
      treatments: {
        meta: {
          current_page: 1,
        },
      },
    };
  },
  computed: {
    ...mapGetters(["user"]),
  },
  created() {
    this.getMyProfile(this.$route.params.id);
    this.getAllAppointments();
  },
  methods: {
    //get my profile
    async getMyProfile(id) {
      let api_url = process.env.MIX_API_BASE_URL + "account-details/";
      const response = await axios.get(api_url + id, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      });
      this.userDetails = response.data.data;
    },

    //get all treatments
    async getAllTreatmentes() {
      let vm = this;
      let api_url =
        process.env.MIX_API_BASE_URL +
        `my-treatments?page=${vm.treatments.meta.current_page}`;
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

    //format date
    formatDate(dateString) {
      const options = { year: "numeric", month: "long", day: "numeric" };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },
  },
};
</script>

<style scoped>
/* Profile container */
.profile {
  margin: 20px 0;
}

/* Profile sidebar */
.profile-sidebar {
  padding: 20px 0 10px 0;
  background: #fff;
}

.profile-userpic img {
  float: none;
  margin: 0 auto;
  width: 50%;
  height: 50%;
  -webkit-border-radius: 50% !important;
  -moz-border-radius: 50% !important;
  border-radius: 50% !important;
}

.profile-usertitle {
  text-align: center;
  margin-top: 20px;
}

.profile-usertitle-name {
  color: #5a7391;
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 7px;
}

.profile-usertitle-job {
  text-transform: uppercase;
  color: #5b9bd1;
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 15px;
}

.profile-userbuttons {
  text-align: center;
  margin-top: 10px;
}

.profile-userbuttons .btn {
  text-transform: uppercase;
  font-size: 11px;
  font-weight: 600;
  padding: 6px 15px;
  margin-right: 5px;
}

.profile-userbuttons .btn:last-child {
  margin-right: 0px;
}

.profile-usermenu {
  margin-top: 30px;
}

.profile-usermenu ul li {
  border-bottom: 1px solid #f0f4f7;
}

.profile-usermenu ul li:last-child {
  border-bottom: none;
}

.profile-usermenu ul li a {
  color: #93a3b5;
  font-size: 14px;
  font-weight: 400;
}

.profile-usermenu ul li a i {
  margin-right: 8px;
  font-size: 14px;
}

.profile-usermenu ul li a:hover {
  background-color: #fafcfd;
  color: #5b9bd1;
}

.profile-usermenu ul li.active {
  border-bottom: none;
}

.profile-usermenu ul li.active a {
  color: #5b9bd1;
  background-color: #f6f9fb;
  border-left: 2px solid #5b9bd1;
  margin-left: -2px;
}

/* Profile Content */
.profile-content {
  padding: 20px;
  background: #fff;
  min-height: 460px;
}
a,
button,
code,
div,
img,
input,
label,
li,
p,
pre,
select,
span,
svg,
table,
td,
textarea,
th,
ul {
  -webkit-border-radius: 0 !important;
  -moz-border-radius: 0 !important;
  border-radius: 0 !important;
}
.dashboard-stat,
.portlet {
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  -ms-border-radius: 4px;
  -o-border-radius: 4px;
}
.portlet {
  margin-top: 0;
  margin-bottom: 25px;
  padding: 0;
  border-radius: 4px;
}
.portlet.bordered {
  border-left: 2px solid #e6e9ec !important;
}
.portlet.light {
  padding: 12px 20px 15px;
  background-color: #fff;
}
.portlet.light.bordered {
  border: 1px solid #e7ecf1 !important;
}
.list-separated {
  margin-top: 10px;
  margin-bottom: 15px;
}
.profile-stat {
  padding-bottom: 20px;
  border-bottom: 1px solid #f0f4f7;
}
.profile-stat-title {
  color: #7f90a4;
  font-size: 25px;
  text-align: center;
}
.uppercase {
  text-transform: uppercase !important;
}

.profile-stat-text {
  color: #5b9bd1;
  font-size: 10px;
  font-weight: 600;
  text-align: center;
}
.profile-desc-title {
  color: #7f90a4;
  font-size: 17px;
  font-weight: 600;
}
.profile-desc-text {
  color: #7e8c9e;
  font-size: 14px;
}
.margin-top-20 {
  margin-top: 20px !important;
}
[class*=" fa-"]:not(.fa-stack),
[class*=" glyphicon-"],
[class*=" icon-"],
[class^="fa-"]:not(.fa-stack),
[class^="glyphicon-"],
[class^="icon-"] {
  display: inline-block;
  line-height: 14px;
  -webkit-font-smoothing: antialiased;
}
.profile-desc-link i {
  width: 22px;
  font-size: 19px;
  color: #abb6c4;
  margin-right: 5px;
}
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
</style>



