<template>
  <div class="article-form">
    <h1 class="article-form__title">Neuen Artikel erstellen</h1>

    <!-- Fehlermeldungen -->
    <div v-if="errors.length > 0" class="article-form__error-box">
      <ul class="article-form__error-list">
        <li v-for="error in errors" :key="error" class="article-form__error-item">{{ error }}</li>
      </ul>
    </div>

    <!-- Formular -->
    <form @submit.prevent="submitForm" class="article-form__form">
      <!-- Name -->
      <div class="article-form__field">
        <label for="name" class="article-form__label">Name:</label>
        <input type="text" id="name" v-model="article.name" class="article-form__input" required>
      </div>

      <!-- Preis -->
      <div class="article-form__field">
        <label for="price" class="article-form__label">Preis:</label>
        <input type="number" id="price" v-model.number="article.price" class="article-form__input" min="0.01" step="0.01" required>
      </div>

      <!-- Beschreibung -->
      <div class="article-form__field">
        <label for="description" class="article-form__label">Beschreibung:</label>
        <textarea id="description" v-model="article.description" class="article-form__textarea"></textarea>
      </div>

      <!-- Submit Button -->
      <button
          type="submit"
          class="article-form__button"
          :disabled="isSubmitting"
          :class="{ 'article-form__button--loading': isSubmitting }"
      >
        <span v-if="!isSubmitting">Speichern</span>
        <span v-else>Wird gespeichert...</span>
      </button>
    </form>

    <!-- Erfolgsmeldung -->
    <div v-if="successMessage" class="article-form__success-msg">
      {{ successMessage }}
    </div>
  </div>
</template>

<script >
export default {
    data() {
        return {
            article: {
                name: '',
                price: null,
                description: ''
            },
            errors: [],
            isSubmitting: false,
            successMessage: '',
            xhr: null // Für XMLHttpRequest Instanz
        }
    },
    methods: {
        submitForm() {
            this.isSubmitting = true;
            this.successMessage = '';
            this.errors = [];
            this.xhr = new XMLHttpRequest();
            const url = '/api/articles';
            const token = document.querySelector('meta[name="csrf-token"]').content;

            this.xhr.open('POST', url, true);
            this.xhr.setRequestHeader('Content-Type', 'application/json');
            this.xhr.setRequestHeader('X-CSRF-TOKEN', token);
            this.xhr.setRequestHeader('Accept', 'application/json');

            this.xhr.onload = () => {
                if (this.xhr.status >= 200 && this.xhr.status < 300) {
                    try {
                        const data = JSON.parse(this.xhr.responseText);//objekt
                        console.log(data);
                        this.successMessage = 'Artikel erfolgreich gespeichert! id des Artikels: ' + data.id;
                        this.resetForm();
                    } catch (e) {
                        this.errors.push('Fehler beim Verarbeiten der Antwort');
                    }
                } else {
                    try {
                        const errorData = JSON.parse(this.xhr.responseText);
                        this.errors.push(errorData.message || 'Fehler beim Speichern');
                    } catch (e) {
                        this.errors.push(`Serverfehler: ${this.xhr.status}`);
                    }
                }
                this.isSubmitting = false;
                this.xhr = null;
            };

            this.xhr.onerror = () => {
                this.errors.push('Netzwerkfehler aufgetreten');
                this.isSubmitting = false;
                this.xhr = null;
            };

            this.xhr.ontimeout = () => {
                this.errors.push('Zeitüberschreitung bei der Anfrage');
                this.isSubmitting = false;
                this.xhr = null;
            };

            this.xhr.send(JSON.stringify(this.article));
        },
        resetForm() {
            this.article = {
                name: '',
                price: null,
                description: ''
            };
        },
        beforeUnmount() {
            // Aufräumen: Anfrage abbrechen wenn Komponente zerstört wird
            if (this.xhr) {
                this.xhr.abort();
            }
        }
    }
};
</script>




<style lang="scss" scoped>

                   $primary: #198754;
$error: #dc3545;
$success: #198754;
$border: #ced4da;
$font-size: 16px;

// ✅ Sass Feature 2: Mixin
@mixin input-style {
  padding: 0.5rem;
  font-size: $font-size;
  border: 1px solid $border;
  border-radius: 4px;
  width: 100%;
}

// ✅ Sass Feature 3: Platzhalter
%flex-column {
   display: flex;
   flex-direction: column;
 }

.article-form {
  max-width: 600px;
  margin: 2rem auto;
  padding: 2rem;
  border: 1px solid $border;
  border-radius: 8px;
  background: #fff;

  &__title {
    font-size: 1.8rem;
    margin-bottom: 1rem;
    text-align: center;
  }

  &__error-box {
    color: $error;
    background: lighten($error, 45%);
    padding: 0.75rem;
    margin-bottom: 1rem;
    border-radius: 5px;
  }

  &__error-list {
    margin: 0;
    padding-left: 1.2rem;
  }

  &__error-item {
    font-size: 0.95rem;
  }

  &__form {
    @extend %flex-column;
    gap: 1rem;
  }

  &__field {
    @extend %flex-column;
    gap: 0.25rem;
  }

  &__label {
    font-weight: 500;
  }

  &__input,
  &__textarea {
    @include input-style;
  }

  &__textarea {
    resize: vertical;
    min-height: 100px;
  }

  &__button {
    padding: 0.75rem;
    font-size: $font-size;
    background: $primary;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;

    &--loading {
      opacity: 0.7;
      pointer-events: none;
    }
  }

  &__success-msg {
    margin-top: 1rem;
    color: $success;
    font-weight: 500;
    text-align: center;
  }
}
</style>

