<template>
  <div>
    <div style="text-align: right; padding-left: 1rem; padding-top: 1rem;">
      <div v-on:click="posun" style="width: 3.8rem; right: 2rem; position: absolute">
        <span class="material-icons gear">settings</span>
      </div>
    </div>
    <div v-bind:style="{right: margin}" id="settings" class="settings-tab">
      <h2>Nastavenia</h2>
      <div class="settings-item">
        <p>Dark mode</p>
        <label class="toggle">
          <input type="checkbox" v-model="dark" id="dark-mode" v-on:click="darkmode" />
          <span class="slider"></span>
        </label>
      </div>
      <div class="settings-item">
        <p>Odhlásiť</p>
        <span v-on:click="logout" class="material-icons logout">exit_to_app</span>
      </div>
    </div>

    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: "MainComponent",

  data() {
    return {
      dark: false,
      isOut: false,
      margin: "-15rem"
    };
  },
  created() {
    let str = window.localStorage;
    let tok = str.getItem("token");
    axios
      .post("api/token", {
        api_token: tok
      })
      .then(resp => {
        if (resp.data["status_code"] == 420) {
          str.removeItem("token");
          str.setItem("logged_in", "false");
          this.$router.replace("/auth/login")
        }else{
          tok = resp.data["token"];
          str.setItem("token",tok);
        }
      });
  },

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
  },

  methods: {
    posun() {
      if (this.isOut === false) {
        this.isOut = true;
        this.margin = "-0.4rem";
      } else if (this.isOut === true) {
        this.isOut = false;
        this.margin = "-15rem";
      }
    },
    logout() {
      var str = window.localStorage;
      str.removeItem("logged_in");
      this.$router.replace("/auth/login");
    },

    darkmode() {
      var style_storage = window.localStorage;
      console.log(this.dark);
      if (!this.dark) {
        document.getElementById("style").href = "css/dark.css";
        style_storage.setItem("darkapp", "1");
      } else {
        document.getElementById("style").href = "css/light.css";
        style_storage.setItem("darkapp", "0");
      }
    }
  }
};
</script>

<style>
.gear {
  color: var(--btn);
}
.gear:hover {
  cursor: pointer;
}
.toggle {
  position: relative;
  display: inline-block;
  width: 3rem;
  height: 1.5rem;
}

.toggle input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: white;
  -webkit-transition: 0.4s;
  transition: 0.4s;
  border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 1.5rem;
  width: 1.5rem;
  background-color: var(--btn);
  -webkit-transition: 0.2s;
  transition: 0.2s;
  border-radius: 50%;
}

.toggle input:focus + .slider {
  box-shadow: 0 0 1px var(--btn-hover);
}

.toggle input:checked + .slider:before {
  background-color: var(--btn-active);
  -webkit-transform: translateX(1.4rem);
  -ms-transform: translateX(1.4rem);
  transform: translateX(1.5rem);
}
.settings-tab {
  width: 12rem;
  background-color: var(--bg-secondary);
  border-radius: 1rem;
  position: absolute;
  padding: 1.2rem 1rem;
  top: 10%;
  transition-duration: 0.5s;
  -webkit-box-shadow: 1px -1px 20px -16px rgba(0, 0, 0, 0.75);
  -moz-box-shadow: 1px -1px 20px -16px rgba(0, 0, 0, 0.75);
  box-shadow: 1px -1px 20px -16px rgba(0, 0, 0, 0.75);
  z-index: 1;
  border: var(--border-secondary) 0.1rem solid;
}

.settings-tab h2 {
  font-size: 1.2rem;
  margin-bottom: 0.5rem;
}

.settings-item {
  display: flex;
  flex-flow: row;
  justify-content: space-between;
  width: 100%;
  padding: 0.5rem 0;
}

.settings-item p {
  margin-top: 0.3rem;
  font-size: 1rem;
}

.logout {
  border: none;
  cursor: pointer;
  border-radius: 0.5rem;
  padding-top: 0.3rem;
  padding-left: 0.3rem;
  padding-right: 0.3rem;
  transition-duration: 0.2s;
  color: var(--btn);
}
.logout:hover {
  color: var(--btn-hover);
  transition-duration: 0.2s;
}
.settings {
  width: 1.3rem;
  height: auto;
  margin-top: 1rem;
  margin-right: 4%;
  background-color: var(--bg-secondary);
  padding: 0.4rem 0.4rem;
  border-radius: 50%;
  transition-duration: 0.2s;
}

.settings:hover {
  cursor: pointer;
  transition-duration: 0.2s;
}
/*Phone*/
@media (min-width: 320px) and (max-width: 480px) {
  .settings-tab {
    display: none;
  }
}
</style>
