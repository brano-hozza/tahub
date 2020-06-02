<template>
  <div class="login">
    <div>
      <transition
        mode="out-in"
        name="fade"
        enter-active-class="animate__animated animate__fadeIn"
        leave-active-class="animate__animated animate__fadeOut"
      >
        <p
          v-if="login_error===false"
          key="default"
          class="login-text"
        >Prihlásenie</p>
        <p
          v-else
          class="login-error-alert"
          key="error"
        >Nesprávne meno alebo heslo</p>
      </transition>

      <div class="login-input">
        <div class="login-image">
          <span class="material-icons">email</span>
        </div>
        <input
          v-on:keyup.enter="enter"
          v-model="email"
          id="email"
          type="email"
          class
          name="email"
          required
          autocomplete="email"
          autofocus
          placeholder="E-mail..."
        />
      </div>
    </div>
    <div class>
      <div class="login-input">
        <div class="login-image">
          <span class="material-icons">vpn_key</span>
        </div>
        <input
          v-model="heslo"
          v-on:keyup.enter="enter"
          id="password"
          type="password"
          class
          name="password"
          required
          autocomplete="current-password"
          placeholder="Heslo..."
        />
      </div>
    </div>
    <div class="login-info">
      <a v-on:click="registrovat">Registrovať sa</a>
      <a href>Nepamätáš si heslo?</a>
    </div>
    <div>
      <div>
        <button
          v-on:keyup.enter="enter"
          id="enter-button"
          v-on:click="prihlas"
          class="login-button"
        >PRIHLÁSIŤ</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      email: "",
      heslo: "",
      login_error: false
    };
  },

  methods: {
    prihlas() {
      axios
        .post("api/login", {
          email: this.email,
          password: this.heslo
        })
        .then(response => {
          if (response.data["status_code"] === 200) {
            var str = window.localStorage;
            str.setItem("logged_in", "true");
            str.removeItem("name");
            str.setItem("name", response.data.user["first_name"]);
            str.setItem("token", response.data.user["api_token"]);
            this.$router.replace("/");
            console.log(response.data.user);
            this.login_error = false;
          } else {
            console.log("Nastala chyba");
            this.heslo = "";
            this.login_error = true;
          }
        })
        .catch(e => {
          console.log(e);
        });
    },

    registrovat() {
      this.$router.replace("/auth/register");
    },

    enter() {
      let button = document.getElementById("enter-button");
      button.click();
      button.style.backgroundColor = "var(--bg-third)";
      setTimeout(function() {
        button.style.backgroundColor = "var(--bg-secondary)";
      }, 100);
    }
  },
  name: "Login"
};
</script>

<style scoped>
.animate__fadeIn {
  animation-duration: 0.2s;
}
.animate__fadeOut {
  animation-duration: 0.2s;
}
.login {
    justify-content: center;
    text-align: center;
    margin-top: 1rem;
}

.login-input {
    display: flex;
}

.login-input input {
    padding-left: 0.8rem;
    width: 15rem;
    border: 0.1rem solid transparent;
    transition-duration: 0.2s;
    border-radius: 0 2rem 2rem 0;
    margin-bottom: 1.5rem;
    height: 3.2rem;
}

.login-input input:focus{
    border: 0.1rem solid var(--brdr-el);
    transition-duration: 0.2s;
}

.login-image {
    width: 3rem;
    height: 3.2rem;
    background-color: var(--btn);
    transition-duration: 0.2s;
    border-radius: 2rem 0 0 2rem;
    border: 0.1rem solid var(--brdr-el);   
    color: var(--fnt-btn);
    display: flex;
    justify-content: center;
    align-items: center;
}


.login-button {
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

.login-button:focus{
    background-color:var( --btn-hover);
}


.login-button:hover {
    cursor: pointer;
    background-color: var(--btn-hover);
    transition-duration: 0.2s;
}

.login-info {
    display: flex;
    justify-content: space-between;
}

.login-info a {
    text-decoration: underline;
    font-size: 0.8rem;
}
.login-info a:hover{
    cursor: pointer;
}

.login-error-alert{
    margin-bottom: 1rem;
    color: var(--fnt-err)
}
.login-text{
  
    margin-bottom: 1rem;
}


</style>
