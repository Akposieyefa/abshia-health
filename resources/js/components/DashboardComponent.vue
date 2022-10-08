<template>
    <div class="row g-6 mb-6">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Agents</span>
                            <span class="h3 font-bold mb-0">{{ agents }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-tertiary text-white text-lg rounded-circle">
                                <i class="bi bi-credit-card"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2"> Enrolled Users</span>
                            <span class="h3 font-bold mb-0">{{ enrolled_users }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-info text-white text-lg rounded-circle">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Health Care Provider </span>
                            <span class="h3 font-bold mb-0">{{ hospitals }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                                <i class="bi bi-file-medical-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Services</span>
                            <span class="h3 font-bold mb-0">{{ services }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-info text-white text-lg rounded-circle">
                                <i class="bi bi-clock-history"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "DashboardComponent",
    created() {
        this.getDashboardHelper();
    },
    data() {
        return {
            services: 0,
            enrolled_users: 0,
            agents : 0,
            hospitals : 0

        }
    },
    methods : {
        async getDashboardHelper() {
            let api_url = process.env.MIX_API_BASE_URL + 'get-dashboard'
            const response = await axios.get(api_url,  {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                },
            })
            this.services = response.data.data.services
            this.enrolled_users = response.data.data.enrolled_users
            this.agents = response.data.data.agents
            this.hospitals = response.data.data.hospitals
        },
    }
}
</script>

