<template></template>

<script>
export default {
  name: "VerifyPayment",
  async created() {
    const url = window.location.href;
    const token_id = url.slice(url.indexOf("=") + 1, url.length);
    const config = {
      method: "GET",
      headers: { "Content-Type": "application/json" }
    };
    const response = await fetch("verify-payment-paystack/"+token_id , config);
    await this.$router.push("/");
  },
};
</script>

<style scoped>
</style>
