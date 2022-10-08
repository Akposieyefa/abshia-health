<template>
    <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg" id="navbarVertical">
        <div class="container-fluid">
            <!-- Toggle -->
            <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Brand -->
            <router-link to="/dashboard" class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0" href="#">
                <img :src="asset('logo.jpg')" id="logo" alt="Website Logo" />
            </router-link>
            <!-- User menu (mobile) -->
            <div class="navbar-user d-lg-none">
                <!-- Dropdown -->
                <div class="dropdown">
                    <!-- Toggle -->
                    <a href="#" id="sidebarAvatar" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar-parent-child">
                            <img alt="Image Placeholder" src="https://images.unsplash.com/photo-1548142813-c348350df52b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" class="avatar avatar- rounded-circle">
                            <span class="avatar-child avatar-badge bg-success"></span>
                        </div>
                    </a>
                    <!-- Menu -->
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarAvatar">
                        <a href="#" class="dropdown-item">Profile</a>
                        <a href="#" class="dropdown-item">Settings</a>
                        <a href="#" class="dropdown-item">Billing</a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidebarCollapse">
                <!-- Navigation -->
                <ul class="navbar-nav" v-if="user.role === 'superadmin'">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/dashboard">
                            <i class="bi bi-house"></i> Dashboard
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/services">
                            <i class="bi bi-bar-chart"></i> Service
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/categories">
                            <i class="bi bi-eye"></i> Categories
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/plans">
                            <i class="i bi-arrow-return-right"></i> Plans
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/agents">
                            <i class="bi bi-people"></i> Agents
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/hospitals">
                            <i class="bi bi-file-medical-fill"></i> Health Care Provider
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/appointments">
                            <i class="bi bi-book"></i> Appointment
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/feedbacks">
                            <i class="bi bi-arrow-clockwise"></i> Feedback
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/get-refers">
                            <i class="bi bi-arrow-right-circle"></i> Referral
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/claims">
                            <i class="bi bi-arrows-move"></i>Payment Claims
                        </router-link>
                    </li>
                </ul>

                <ul class="navbar-nav" v-if="user.role === 'hospital'">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/dashboard">
                            <i class="bi bi-house"></i> Dashboard
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/appointments">
                            <i class="bi bi-book"></i> Appointment
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/administer-treatment">
                            <i class="bi bi-chat"></i> Treatments
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/give-feedbacks">
                            <i class="bi bi-arrow-clockwise"></i> Feedback
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/get-refers">
                            <i class="bi bi-people"></i> Referral
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/claims">
                            <i class="bi bi-arrows-move"></i>Payment Claims
                        </router-link>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item" v-if="user.role != 'superadmin'">
                        <router-link class="nav-link" v-bind:to="'/profile/' + user.id">
                            <i class="bi bi-person-square"></i>  Profile
                        </router-link>
                    </li><li class="nav-item">
                        <router-link class="nav-link" v-bind:to="'/settings'">
                            <i class="bi bi-gear-fill"></i>  Settings
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" @click="onLogout()">
                            <i class="bi bi-box-arrow-left"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    name: "Nav",
    computed: {
        ...mapGetters(["user"]),
    },
    methods: {
        onLogout() {
            let api_url = process.env.MIX_API_BASE_URL + 'logout'
            axios.post(
                api_url, { token: localStorage.getItem("token") },
                {
                    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
                }
            );
            localStorage.removeItem("token");
            this.$router.push("/");
        },
    }
}
</script>

<style scoped>
@import '../css/index.css';
@import url("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css");
#logo {
    width: 100px;
    height: 90px;
    margin-left: 3rem;
    margin-top: -1rem;
}
</style>
