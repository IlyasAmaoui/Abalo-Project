<template>
  <footer class="site-footer">
    <p>&copy; 2025 Abalo. Alle Rechte vorbehalten.</p>
    <nav>
      <a href="#" @click.prevent="$emit('show', 'home')">Home</a> |
      <a href="#" @click.prevent="$emit('show', 'impressum')">Impressum</a>
    </nav>
  </footer>
</template>

<script>
export default {
  name: 'SiteFooter'
}
</script>

<style scoped>
.site-footer {
  background-color: #f0f0f0;
  padding: 1rem;
  text-align: center;
  font-size: 0.9rem;
  color: #333;
  border-top: 1px solid #ddd;
}

.site-footer nav a {
  margin: 0 0.5rem;
  color: #007bff;
  text-decoration: none;
}

.site-footer nav a:hover {
  text-decoration: underline;
}
</style>
