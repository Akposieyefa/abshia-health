
<template>
    <div class="row g-6 mb-6">
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Patients</span>
                            <span class="h3 font-bold mb-0">{{ patients }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-tertiary text-white text-lg rounded-circle">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2"> Appointments</span>
                            <span class="h3 font-bold mb-0">{{appointments }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-info text-white text-lg rounded-circle">
                                <i class="bi bi-credit-card"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 col-12">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Treatments </span>
                            <span class="h3 font-bold mb-0">{{ treatments }}</span>
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
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "DashboardComponentHospital",
    created() {
        this.getDashboardHelperHospital();
    },
    data() {
        return {
            patients: 0,
            appointments: 0,
            treatments: 0
        }
    },
    methods : {
        async getDashboardHelperHospital() {
            let api_url = process.env.MIX_API_BASE_URL + 'get-dashboard-hospital'
            const response = await axios.get(api_url,  {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                },
            })
            this.patients = response.data.data.patients
            this.appointments = response.data.data.appointments
            this.treatments = response.data.data.treatments
        },
    }
}
</script>
