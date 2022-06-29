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

                                <div  v-if="user.role === 'superadmin'" class="col-sm-6 col-12 text-sm-end">
                                    <div class="mx-n1">
                                        <router-link to="/treatments"   data-toggle="modal" data-target="#form" class="btn d-inline-flex btn-sm btn-dark mx-1">
                                            <span class=" pe-2">
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
                        <DashboardComponent v-if="user.role === 'superadmin'"/>
                        <DashboardComponentHospital   v-if="user.role === 'hospital'"/>
                        <!-- End of card state -->
                        <div class="card shadow border-0 mb-7" v-if="user.role === 'superadmin' || user.role === 'hospital'">
                            <div class="card-header">
                                <h5 class="mb-0" v-if="user.role === 'superadmin'">Enrolled Users</h5>
                                <h5 class="mb-0" v-if="user.role === 'hospital'">Patients</h5>
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
                                    <tr
                                        v-for="(user, index) in users"
                                        :key="user.id"
                                    >
                                        <td> {{ index + 1 }}</td>
                                        <td> {{ user.details.emp_id }}  </td>
                                        <td> {{ user.details.surname }}  </td>
                                        <td> {{ user.email }}  </td>
                                        <td> {{ user.details.phone_number }}  </td>
                                        <td>  {{ formatDate(user.created_at)}} </td>
                                        <td class="text-end">
                                            <router-link  v-bind:to="'/leave/' + user.id" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </router-link>
                                            <button  @click="deleteUser(user.id)" type="button" class="btn btn-sm btn-square btn-danger text-danger-hover">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer border-0 py-5">
                                <nav aria-label="...">
                                    <ul class="pagination">
                                        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                                            <a class="page-link"  @click="getAllUser(pagination.prev_page_url)" href="#" tabindex="-1">Previous</a>
                                        </li>
                                        <li class="page-item disabled"><a class="page-link" href="#">Page {{ pagination.current_page}} of {{ pagination.last_page}} </a></li>
                                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                                            <a class="page-link" @click="getAllUser(pagination.next_page_url)" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
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
        DashboardComponentHospital: () => import("../../components/DashboardComponentHospital"),
        Nav: () => import("../../components/Nav.vue"),
    },
    created() {
        this.getAllUser()
    },
    data() {
        return {
            users: [],
            pagination: {}
        }
    },
    methods : {

        async getAllUser(page_url) {
            let vm = this;
            page_url = page_url || 'get-onboard-users'
            const response = await axios.get(process.env.MIX_API_BASE_URL + page_url, {
                headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
            });
            this.users = response.data.data;
            console.log(this.users)
            vm.makePagination(response.data.meta, response.data.links)
        },

        makePagination(meta, links) {
            this.pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            };
        },

        async deleteUser(id) {
            let api_url = process.env.MIX_API_BASE_URL + 'delete-account/'
            if (confirm("Do you really want to delete this record?")) {
                try {
                    const response = await axios.delete( api_url + id, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("token")}`,
                        },
                    });
                    this.$toasted.success(response.data.message)
                    await this.getAllUser();
                } catch (e) {
                    this.$toasted.error(e.response.data.message)
                }
            }
        },

        formatDate(dateString) {
            const options = { year: "numeric", month: "long", day: "numeric" };
            return new Date(dateString).toLocaleDateString(undefined, options);
        },
    },
    computed: {
        ...mapGetters(["user"]),
    },
}
</script>

