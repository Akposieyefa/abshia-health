<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="card form-holder">
                    <div class="card-body">
                        <h1 class="text-center">Login</h1>
                        <br />
                        <div class="d-flex justify-content-center" v-if="loading">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input
                                    type="text"
                                    v-model="user.email"
                                    class="form-control"
                                    placeholder="info@gmail.com"
                                />
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input
                                    type="password"
                                    v-model="user.password"
                                    class="form-control"
                                    placeholder="Enter Password"
                                />
                            </div>
                            <div class="row">
                                <div class="col-8 text-left">
                                    <router-link to="/forget-password" class="btn btn-link"
                                    >Forgot Password</router-link
                                    >
                                </div>
                                <div class="col-4 text-right">
                                    <button
                                        type="submit"
                                        :disabled="loading"
                                        @click="loginUser()"
                                        class="btn btn-primary"
                                    >
                                        Login
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            loading: false,
            user: {
                email: "",
                password: "",
            },
        };
    },
    methods: {
        //login user
        async loginUser() {
            if (this.loading) {
                return;
            }
            let api_url = process.env.MIX_API_BASE_URL + "login";
            try {
                this.loading = true;
                const response = await axios.post(api_url, {
                    email: this.user.email,
                    password: this.user.password,
                });
                localStorage.setItem("token", response.data.token);
                await this.$store.dispatch("user", response.data.data);
                await this.$router.push("/dashboard");
            } catch (e) {
                this.$toasted.error(e.response.data.message);
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
body {
    background-color: #f1f1f1 !important;
}
.form-holder {
    margin-top: 20%;
    margin-bottom: 20%;
}
</style>

