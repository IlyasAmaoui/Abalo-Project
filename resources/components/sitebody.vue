<template>

  <div>
    <!-- Impressum anzeigen -->
    <Impressum v-if="view === 'impressum'" />

    <!-- Hauptinhalt -->
    <template v-else>

      <!-- Artikelsuche -->
      <div class="article-search">
        <input
            type="text"
            v-model="searchQuery"
            @input="onSearchInput"
            placeholder="Suche Artikel..."
            class="article-search__input"
        >
      </div>




      <!-- Warenkorb-Button -->
      <button class="btn btn-primary position-fixed end-0 top-50 translate-middle-y me-3"
              type="button"
              data-bs-toggle="offcanvas"
              data-bs-target="#cartOffcanvas"
              style="z-index: 1000">
        🏍 Warenkorb
        <span id="cartBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
          0
        </span>
      </button>

      <!-- Offcanvas Warenkorb -->
      <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas">
        <div class="offcanvas-header">
          <h2 class="offcanvas-title">Warenkorb</h2>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
          <div id="warenkorb" class="list-group">
            <p class="text-muted">Keine Artikel im Warenkorb.</p>
          </div>
          <div class="d-grid gap-2 mt-3">
            <button class="btn btn-success">Zur Kasse gehen</button>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-between mt-4 w-100">
        <button class="btn btn-secondary" @click="prevPage" :disabled="page === 1">Zurück</button>
        <button class="btn btn-secondary" @click="nextPage" :disabled="page * 5 >= total">Weiter</button>
      </div>

      <!-- Artikelliste -->
      <h2>Artikelliste</h2>
      <!-- Artikelliste -->
      <div class="article-list">
        <div
            :id="`article-${article.id}`"
            v-for="article in articles"
            :key="article.id"
            class="article-card"
            :class="{ 'article-card--featured': article.featured }"
        >
          <img
              class="article-card__image"
              :src="`/articelimages/${article.id}.jpg`"
              @error="event => event.target.src = `/articelimages/${article.id}.png`"
              alt="Bild"
          />


          <div class="article-card__body">
            <h5 class="article-card__title">{{ article.ab_name }}</h5>
            <p class="article-card__desc">{{ article.ab_description }}</p>
            <h6 class="article-card__price">{{ article.ab_price }} €</h6>
            <button class="article-card__btn" @click="cartload(article.id)">add 🛒</button>
            <button v-if="currentUserId==article.ab_creator_id" class="article-card__btn article-card__btn--spaced" @click="offerArticle(article.id)">Artikel jetzt als Angebot anbieten</button>

            <star-rating
                class="article-card__rating"
                :rating="ratings[article.id] || 0"
                :max-rating="5"
                :star-size="25"
                :inactive-color="'#ccc'"
                :active-color="'#ffd055'"
                @rating-selected="val => saveRating(article.id, val)"
            />
          </div>
        </div>
      </div>


      <!-- Testnachricht -->
      <div>{{ msg }}</div>
    </template>
  </div>
</template>

<script>
import Impressum from './impressum.vue';
import axios from "axios";
import 'bootstrap';
import StarRating from "vue-star-rating";

export default {
  name: 'SiteBody',
  props: ['view'],
  components: {
    Impressum,
    StarRating
  },
  data() {
    return {
      isLoading: false,
      articles: [],
      ratings: {},
      page: 1,
      total: 0,
      searchQuery: '',
      isSearching: false,
      currentUserId:null
    }
  },
  methods: {

    onSearchInput() {
      this.page = 1;
      this.fetchArticles(); // lädt entweder gefiltert oder alle
    },

    cartload(articleId) {
      axios.post('/api/shoppingcart', { article_id: articleId }, {
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      }).then(() => {
        const offcanvas = new bootstrap.Offcanvas(document.getElementById('cartOffcanvas'));
        offcanvas.show();
        this.loadCart();
      }).catch(err => {
        alert('Fehler beim Hinzufügen: ' + err.message);
      });
    },

    loadArticles() {
      axios.get('/api/articles', {
        params: {
          search: this.searchQuery,
          page: this.page
        }
      }).then(response => {
        this.articles = response.data.articles;
        this.total = response.data.total;
      });
    },


    fetchArticles() {
      axios.get('/api/articles', {
        params: {
          page: this.page,
          search: this.searchQuery
        }
      }).then(res => {
        this.articles = res.data.articles.map(article => ({
          ...article,
          imgSrc: this.getImagePath(article.id)
        }));
        this.total = res.data.total;
      });
    },

    nextPage() {
      if (this.page * 5 < this.total) {
        this.page++;
        this.fetchArticles();
      }
    },
    prevPage() {
      if (this.page > 1) {
        this.page--;
        this.fetchArticles();
      }
    },
    getImagePath (id) {
      const jpg = `/articelimages/${id}.jpg`;
      const png = `/articelimages/${id}.png`;
      const img = new Image();
      img.src = jpg;
      img.onerror = () => {
        return png;
      };
      return jpg;
    },

    removeFromCart(cartId, articleId) {
      axios.delete(`/api/shoppingcart/${cartId}/articles/${articleId}`, {
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
    .then(() => {
        this.loadCart(); // Aktualisiere Warenkorb
      })
          .catch(err => {
            alert('Fehler beim Entfernen: ' + err.message);
            console.error(err);
          });
    },


    loadCart() {
      const self = this; // Vue-Instanz sichern

      const xhr = new XMLHttpRequest();
      xhr.open("GET", "/api/shoppingcarte", true);

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          const cartItems = JSON.parse(xhr.responseText);
          const cartContainer = document.getElementById("warenkorb");
          const cartBadge = document.getElementById("cartBadge");
          cartContainer.innerHTML = "";

          if (cartItems.length === 0) {
            cartContainer.innerHTML = '<p class="text-muted">Keine Artikel im Warenkorb.</p>';
            cartBadge.textContent = '0';
            cartBadge.classList.add('d-none');
            return;
          }

          cartBadge.textContent = cartItems.length;
          cartBadge.classList.remove('d-none');

          cartItems.forEach(item => {
            const cartItem = document.createElement("div");
            cartItem.className = "list-group-item d-flex justify-content-between align-items-center";

            const infoDiv = document.createElement("div");
            infoDiv.innerHTML = `
                                  <h6 class="my-0">${item.ab_name}</h6>
                                  <small class="text-muted">${item.ab_price} €</small>
                                `;

            const removeBtn = document.createElement("button");
            removeBtn.className = "btn btn-outline-danger btn-sm";
            removeBtn.innerText = "🗑";
            removeBtn.addEventListener("click", function () {
              self.removeFromCart(item.ab_shoppingcart_id, item.id);
            });

            cartItem.appendChild(infoDiv);
            cartItem.appendChild(removeBtn);
            cartContainer.appendChild(cartItem);
          });
        }
      };

      xhr.send();
    },

    saveRating(articleId, rating) {
      console.log(`Artikel ${articleId} bewertet mit ${rating}`);
    },


    // Aufgabe 13: M5
    highlightingArticle(){
      const socket = new WebSocket("ws://localhost:4010/chat");
      socket.onmessage = (event) => {
        const msg = JSON.parse(event.data);

        if (msg.type === 'offer'&& msg.user_id != this.currentUserId) {
              alert(msg.message)
          const card = document.getElementById(`article-${msg.article_id}`);
          if (card) {
            card.classList.add('highlighted');
            alert(msg.message);
          }
        }
      };
    },
    offerArticle (articleId){
      axios.post(`/api/articles/${articleId}/offer`)
          .then(response => {
            console.log("Angebot gesendet:", response.data);
          })
          .catch(err => console.error(err));
    }

  },
  mounted() {
    this.currentUserId=document.querySelector('meta[name="session_id"]')?.content || null;
    console.log("currentUserId aus <meta>: ", this.currentUserId);
    this.loadArticles();
    this.loadCart();
    this.highlightingArticle()
  }

}
</script>



<style lang="scss" scoped>
//  Sass Feature 1: Variablen
$primary: #0d6efd;
$gray: #e9ecef;
$dark: #343a40;
$font-base: 16px;

//  Sass Feature 2: Mixin
@mixin card-hover {
  transition: box-shadow 0.3s ease;
  &:hover {
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
  }
}

//  Sass Feature 3: Placeholder
%flex-center {
  display: flex;
  justify-content: center;
  align-items: center;
}

// ARTIKELSUCHE
.article-search {
  margin: 2rem auto;
  max-width: 600px;

  &__input {
    padding: 0.75rem 1rem;
    border: 2px solid $primary;
    border-radius: 0.25rem;
    font-size: $font-base;
    width: 100%;
  }
}

// ARTIKELLISTE
.article-list {
  display: flex;
  flex-wrap: wrap;
  gap: 1.5rem;
  padding: 1rem;
}

.article-card {
  width: 16rem;
  background: white;
  border: 1px solid $gray;
  border-radius: 8px;
  overflow: hidden;
  @include card-hover;

  &--featured {
    border: 2px solid $primary;
  }

  &__image {
    height: 180px;
    object-fit: cover;
    width: 100%;
    background: $gray;

    &--empty {
      @extend %flex-center;
      color: $dark;
    }
  }

  &__body {
    padding: 0.75rem;
  }

  &__title {
    font-weight: bold;
    font-size: $font-base * 1.1; // ✅ Sass Feature 4: Rechenoperation
    margin-bottom: 0.25rem;
  }

  &__desc {
    font-size: $font-base;
    color: gray;
    margin-bottom: 0.5rem;
  }

  &__price {
    font-weight: bold;
    margin-bottom: 0.5rem;
  }

  &__btn {
    width: 100%;
    background: $primary;
    color: white;
    padding: 0.5rem;
    border: none;
    border-radius: 4px;
    font-size: $font-base;
    cursor: pointer;
  }

  &__rating {
    margin-top: 0.5rem;
  }
  .article-card__btn--spaced {
    margin-top: 0.5rem;
  }

}
</style>
