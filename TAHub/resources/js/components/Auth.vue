<template>
    <div class="home-container">
      <img src="/images/tahub.png" />
      <h1>TAHub</h1>
      <p>Cloud to je pecka jak fortnite</p>
      <transition
        mode="out-in"
        name="fade"
        enter-active-class="animate__animated animate__fadeIn"
        leave-active-class="animate__animated animate__fadeOut"
      >
        <router-view></router-view>
      </transition>
    </div>
</template>

<script>
export default {
  name: "Auth",

  mounted() {
    var storage = window.localStorage;
    var darkmode = storage.getItem("darkapp");
    if (darkmode === "1") {
      this.dark = true;
      document.getElementById("style").href = "css/dark.css";
    } else {
      this.dark = false;
      document.getElementById("style").href = "css/light.css";
    }
  }
};
</script>

<style>
.animate__fadeIn {
  animation-duration: 0.2s;
}
.animate__fadeOut {
  animation-duration: 0.2s;
}
.home-container {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
  justify-content: center;
  text-align: center;
}

.home-container img {
  width: 6rem;
  height: auto;
}

.home-container h1 {
  margin-top: -1.5rem;
  font-size: 3rem;
}

.home-container p {
  font-size: 1rem;
}

.home-container h3 {
  margin-top: 2rem;
  font-size: 1rem;
  font-weight: normal;
}
</style>
