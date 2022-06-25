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
                        <div class="card shadow border-0 mb-7">
                            <div class="card-header">
                                <h5 class="mb-0">All Feedbacks</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-nowrap">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">No..</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Market Reality</th>
                                        <th scope="col">Importance</th>
                                        <th scope="col">Date</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-for="(feedback, index) in feedbacks"
                                        :key="feedback.id"
                                    >
                                        <td>{{ index + 1 }} </td>
                                        <td> {{ feedback.name }}</td>
                                        <td>  {{ feedback.market_reality }} </td>
                                        <td>  {{ feedback.importance }} </td>
                                        <td> {{ formatDate(feedback.created_at)}}</td>
                                        <td class="text-end">
                                            <button  class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#form">More</button>
                                            <button  @click="deleteFeedback(feedback.id)" type="button" class="btn btn-sm btn-square btn-neutral text-danger-hover">
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
                                            <a class="page-link"  @click="getAllFeedbacks(pagination.prev_page_url)" href="#" tabindex="-1">Previous</a>
                                        </li>
                                        <li class="page-item disabled"><a class="page-link" href="#">Page {{ pagination.current_page}} of {{ pagination.last_page}} </a></li>
                                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                                            <a class="page-link" @click="getAllFeedbacks(pagination.next_page_url)" href="#">Next</a>
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
export default {
    name: "Feedbacks",
    components: {
        Nav: () => import("../../../components/Nav.vue"),
    },
    data() {
        return {
            feedbacks: [],
            pagination: {}
        }
    },
    created() {
        this.getAllFeedbacks();
    },
    computed: {
        ...mapGetters(["user"]),
    },
    methods : {

        async getAllFeedbacks(page_url) {
            let vm = this;
            page_url = page_url || 'feedbacks'
            const response = await axios.get(process.env.MIX_API_BASE_URL + page_url, {
                headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
            });
            this.feedbacks = response.data.data;
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

        async deleteFeedback(id) {
            let api_url = process.env.MIX_API_BASE_URL + 'feedbacks/'
            if (confirm("Do you really want to delete this record?")) {
                try {
                    const response = await axios.delete( api_url + id, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("token")}`,
                        },
                    });
                    this.$toasted.success(response.data.message)
                    await this.getAllFeedbacks();
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



