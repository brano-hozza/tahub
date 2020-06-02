<template>
  <div class="header">
    <h1 class="header-text">404</h1>
    <h2 class="description">Asi si sa stratil</h2>
    <button class="back-button" v-on:click="back">Back home</button>
  </div>
</template>

<script>
export default {
  name: "ForOFor",
  methods: {
    back() {
      this.$router.replace("/");
    }
  }
};
</script>

<style scoped>
.header-text {
  text-align: center;
  font-size: 3rem;
}
.header {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: var(--bg-secondary);
  height: 1000px;
  width: 100%;
}
.description {
  font-size: 2.5rem;
  text-align: center;
}
.back-button {
  background-color: var(--btn);
  width: 18rem;
  padding-top: 0.8rem;
  padding-bottom: 0.8rem;
  border-radius: 2rem;
  border: none;
  background-color: var(--btn);
  color: var(--fnt-btn);
  font-size: 1rem;
  transition-duration: 0.2s;
  margin-top: 0.8rem;
}
.back-button:hover {
  background-color: var(--btn-hover);
}
</style>
