<template>
  <router-view></router-view>
</template>

<script>
import axios from "axios";
export default {
  name: "App",
  async updated() {
    let api_url = process.env.MIX_API_BASE_URL + "user-profile";
    const response = await axios.get(api_url, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
    });
    await this.$store.dispatch("user", response.data.data);
  },
};
</script>

<style scoped>
</style>
