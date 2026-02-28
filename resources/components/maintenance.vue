<script >

export default {
  data() {
    return {
      message: null
    }
  },
  mounted() {
    const socket = new WebSocket("ws://localhost:4010/hinweis ");

    socket.onmessage =  (event) => {
      this.message=event.data;
    }
  }
};

</script>

<template>
  <div v-if="message">
    <h1 > ⚠ Wartungshinweis</h1>
    <p> Nachricht empfangen: {{ message }}</p>
  </div>
</template>

<style scoped>

</style>