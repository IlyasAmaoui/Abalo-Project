<template>
  <div class="container my-5">
    <div id="search-app" class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <!-- Search Input -->
        <div class="input-group mb-3 shadow-sm">
          <input
              type="text"
              v-model="searchQuery"
              @input="onSearchInput"
              placeholder="Suche Artikel..."
              class="form-control form-control-lg border-primary"
          >
          <span class="input-group-text bg-primary text-white">
            <i class="bi bi-search"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  emits: ['search-results'],
  data() {
    return {
      searchQuery: '',
      xhr: null,
      page: 1
    }
  },
  methods: {
    onSearchInput() {
      this.page = 1;
      this.searchArticles();
    },
    searchArticles() {
      if (this.searchQuery.length < 3) {
        this.$emit('search-results', { results: [], total: 0 });
        return;
      }

      const url = `/api/articles?search=${encodeURIComponent(this.searchQuery)}&page=${this.page}`;

      this.xhr = new XMLHttpRequest();
      this.xhr.open('GET', url);
      this.xhr.setRequestHeader('Accept', 'application/json');
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      this.xhr.setRequestHeader('X-CSRF-TOKEN', token);

      this.xhr.onload = () => {
        if (this.xhr.status === 200) {
          const data = JSON.parse(this.xhr.responseText);
          this.$emit('search-results', {
            results: data.articles.map(article => ({
              ...article,
              imgSrc: this.getImagePath(article.id)
            })),
            total: data.total
          });
        } else {
          this.$emit('search-results', { results: [], total: 0 });
        }
      };

      this.xhr.onerror = () => {
        console.error('Request failed');
        this.$emit('search-results', { results: [], total: 0 });
      };

      this.xhr.send();
    },
    getImagePath(id) {
      return `/articelimages/${id}.jpg`;
    }
  }
}
</script>
