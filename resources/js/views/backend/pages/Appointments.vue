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
                                    <h1 class="h2 mb-0 ls-tight">Patient Appointments</h1>
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
                                <h5 class="mb-0">All Appointments</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-nowrap">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">No..</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Reason</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-for="(appointment, index) in appointments"
                                        :key="appointment.id"
                                    >
                                        <td>{{ index + 1 }} </td>
                                        <td>  {{ appointment.title }} </td>
                                        <td> {{ appointment.title }}</td>
                                        <td>  {{ appointment.appointment_reason }} </td>
                                        <td>  {{ appointment.status }} </td>
                                        <td> {{ formatDate(appointment.appointment_date)}}</td>
                                        <td class="text-end">
                                            <button  class="btn btn-sm btn-neutral" @click="editMode(appointment.id)" data-toggle="modal" data-target="#form">Approve</button>
                                            <button  class="btn btn-sm btn-danger" @click="editMode(appointment.id)" data-toggle="modal" data-target="#form">Decline</button>
                                            <button  @click="deleteAppointments(appointment.id)" type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
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
                                            <a class="page-link"  @click="getAllAppointments(pagination.prev_page_url)" href="#" tabindex="-1">Previous</a>
                                        </li>
                                        <li class="page-item disabled"><a class="page-link" href="#">Page {{ pagination.current_page}} of {{ pagination.last_page}} </a></li>
                                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                                            <a class="page-link" @click="getAllAppointments(pagination.next_page_url)" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!--Modal display-->
        <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title">Approve appointment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Date</label>
                                <input type="date" v-model="appointment.approved_date" class="form-control form-control-lg" id="name" aria-describedby="emailHelp" placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label for="description">Comment</label>
                                <textarea
                                    id="description"
                                    v-model="appointment.approval_comment"
                                    placeholder="Enter approval comment"
                                    rows="6"
                                    class="form-control form-control-md"
                                    aria-label="With textarea"
                                ></textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0">
                            <button type="submit" @click="approveAppointments(appointment.id)" class="btn btn-sm btn-dark">Approve</button>
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
    name: "Appointments",
    components: {
        Header: () => import("../../../components/Header"),
        Nav: () => import("../../../components/Nav.vue"),
    },
    data() {
        return {
            appointment: {
                approved_date: "",
                approval_comment: ""
            },
            appointments: [],
            pagination: {},
            edit: false,
        }
    },
    created() {
        this.getAllAppointments();
    },
    computed: {
        ...mapGetters(["user"]),
    },
    methods : {

        async editMode(id){
            this.edit = true;
            let api_url = process.env.MIX_API_BASE_URL + 'appointments/'
            const response = await axios.get(api_url + id, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                },
            });
            this.category = response.data.data;
        },

        async approveAppointments(id) {
            let api_url = process.env.MIX_API_BASE_URL + 'appointments/'
            try {
                const response = await axios.patch(
                    api_url + id,
                    {
                        title: this.category.title,
                        description: this.category.description
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("token")}`,
                        },
                    }
                );
                await this.getAllAppointments();
                this.$toasted.success(response.data.message)
                this.edit = false;
            } catch (e) {
                this.$toasted.error(e.response.data.message)
            }
        },

        async getAllAppointments(page_url) {
            let vm = this;
            page_url = page_url || 'appointments'
            const response = await axios.get(process.env.MIX_API_BASE_URL + page_url, {
                headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
            });
            this.appointments = response.data.data;
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

        async deleteAppointments(id) {
            let api_url = process.env.MIX_API_BASE_URL + 'appointments/'
            if (confirm("Do you really want to delete this record?")) {
                try {
                    const response = await axios.delete( api_url + id, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("token")}`,
                        },
                    });
                    this.$toasted.success(response.data.message)
                    await this.getAllAppointments();
                } catch (e) {
                    this.$toasted.error(e.response.data.message)
                }
            }
        },

        formatDate(dateString) {
            const options = { year: "numeric", month: "long", day: "numeric" };
            return new Date(dateString).toLocaleDateString(undefined, options);
        }

    },
}
</script>

<style scoped>
@import '../../../css/index.css';
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");
</style>


