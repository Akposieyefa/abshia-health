<template>
    <header class="bg-surface-primary border-bottom pt-6 pb-10">
        <div class="container-fluid">
            <div class="mb-npx">
                <div class="row align-items-center">
                    <div class="col-sm-6 col-12 mb-4 mb-sm-0">
                        <h3 class="h2 mb-0 ls-tight">Dashboard</h3>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
import {mapGetters} from "vuex";
export default {
    name: "Header",
    computed: {
        ...mapGetters(["user"]),
    }
}
</script>

<style scoped>

</style>
