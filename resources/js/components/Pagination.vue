<template>
 <div class="card-footer border-0 py-10">
  <nav aria-label="...">
    <ul class="pagination">
      <li class="page-item" >
        <a
          class="page-link"
          @click.prevent="changePage(pagination.meta.current_page - 1)"
          href="#"
          >Previous</a
        >
      </li>
      <li class="page-item"  v-for="page in pagesNumber"
          :aria-current="page === pagination.meta.current_page"
          :class="{
            'border-indigo-500 text-indigo-600':
              page === pagination.meta.current_page,
          }"
          :key="page">
        <a
          class="page-link"
          href="javascript:void(0)"
          @click.prevent="changePage(page)"
          >{{ page }}</a
        >
      </li>
      <li
        class="page-item"
      >
        <a
          href="javascript:void(0)"
          class="page-link"
          @click.prevent="changePage(pagination.meta.current_page + 1)"
          >Next</a
        >
      </li>
    </ul>
  </nav></div>
</template>

<script>
export default {
  props: {
    pagination: {
      type: Object,
      required: true,
    },
    offset: {
      type: Number,
      default: 4,
    },
  },
  computed: {
    pagesNumber() {
      if (!this.pagination.meta.to) {
        return [];
      }
      let from = this.pagination.meta.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }
      let to = from + this.offset * 2;
      if (to >= this.pagination.meta.last_page) {
        to = this.pagination.meta.last_page;
      }
      let pagesArray = [];
      for (let page = from; page <= to; page++) {
        pagesArray.push(page);
      }
      return pagesArray;
    },
  },
  mounted() {
    console.log(this.pagination);
  },
  methods: {
    changePage(page) {
      this.pagination.meta.current_page = page;
      this.$emit("paginate");
    },
  },
};
</script>