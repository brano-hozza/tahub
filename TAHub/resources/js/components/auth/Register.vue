<template>
  <div @click="hideError" class="register">
    <div class="register-kontainer">
      <transition
        mode="out-in"
        name="fade"
        enter-active-class="animate__animated animate__fadeIn"
        leave-active-class="animate__animated animate__fadeOut"
      >
        <p v-if="reg_status==='ok'" key="default">Registrácia</p>
        <p
          v-else-if="reg_status==='user_exists'"
          class="reg-alert"
          key="default"
        >Používateľ už existuje</p>
        <p v-else-if="reg_status==='wrong_format'" class="reg-alert" key="default">Neplatný mail</p>
        <p
          v-else-if="reg_status==='password_match'"
          class="reg-alert"
          key="error"
        >Heslá sa nerovnajú</p>
        <p
          v-else-if="reg_status==='password_short'"
          class="reg-alert"
          key="error"
        >Heslo musí mať minimálne 6 znakov</p>
        <p v-else-if="reg_status==='invalid_token'" class="reg-alert" key="error">Neplatný token</p>
      </transition>
      <div class="register-name">
        <input
          v-on:keydown.enter="enter"
          v-model="first_name"
          id="name"
          type="text"
          name="name"
          required
          autocomplete="name"
          autofocus
          placeholder="Meno..."
        />
        <input
          v-on:keydown.enter="enter"
          v-model="last_name"
          id="last_name"
          type="text"
          name="name"
          autocomplete="name"
          autofocus
          placeholder="Priezvisko..."
        />
      </div>
      <div class="register-mail">
        <input
          v-bind:class="emailStyl"
          v-on:keydown.enter="enter"
          v-model="email"
          id="email"
          type="email"
          name="email"
          required
          autocomplete="email"
          placeholder="E-mail..."
        />
      </div>
      <div class="token">
        <transition
          mode="out-in"
          name="fade"
          enter-active-class="animate__animated animate__fadeIn"
          leave-active-class="animate__animated animate__fadeOut"
        >
          <div v-if="isOut === true" class="token-popup">
            <div @click="tokenPopup">
              <span class="material-icons close">clear</span>
              <h2>Registračný token ?</h2>
              <p>Registračný token je spešl vec, ktorú dostaneš od admina.</p>
            </div>
          </div>
        </transition>
        <div class="token-input">
          <input
            v-bind:class="tokenStyl"
            v-on:keydown.enter="enter"
            v-model="reg_token"
            id="reg_token"
            type="text"
            required
            placeholder="Registračný token..."
          />
          <span class="info-button" v-on:click="tokenPopup">
            <span class="material-icons">info_outlined</span>
          </span>
        </div>
      </div>
      <div class="register-password">
        <input
          v-bind:class="zmenStyl"
          v-on:keydown.enter="enter"
          v-model="password"
          id="password"
          type="password"
          name="password"
          required
          autocomplete="new-password"
          placeholder="Heslo..."
        />
        <input
          v-bind:class="zmenStyl"
          class="reg-pass"
          v-on:keydown.enter="enter"
          v-model="password_confirm"
          id="password-confirm"
          type="password"
          name="password_confirmation"
          required
          placeholder="Zopakuj heslo..."
        />
      </div>
      <div>
        <div v-if="passwordMatch"></div>
        <div>
          <a v-on:click="back" class="register-info">Už mám účet</a>
        </div>
        <div>
          <button
            v-bind:class="buttonStyl"
            v-on:keyup.enter="enter"
            id="enter-button"
            v-on:click="register"
            class="register-button"
          >
            <transition
              mode="out-in"
              name="fade"
              enter-active-class="animate__animated animate__bounceIn"
              leave-active-class="animate__animated animate__fadeOut"
            >
              <p
                v-if="reg_complete === false"
                style="color:var(--font-secondary)"
                key="reg"
              >REGISTROVAŤ</p>
              <div v-else>
                <span class="material-icons">check</span>
              </div>
            </transition>
          </button>
        </div>
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
      first_name: "",
      last_name: "",
      email: "",
      password: "",
      password_confirm: "",
      reg_token: "",
      reg_status: "ok",
      isOut: false,
      reg_complete: false,
      zmenStyl: {
        "reg-pass": true,
        "reg-pass-err": false,
        "reg-pass-corr": false
      },

      emailStyl: {
        "reg-pass": true,
        "reg-pass-err": false,
        "reg-pass-corr": false
      },

      tokenStyl: {
        "reg-pass": true,
        "reg-pass-err": false
      },

      buttonStyl: {
        "reg-default": true,
        "reg-complete": false
      }
    };
  },
  watch: {
    email: function(mail) {
      const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

      if (re.test(String(mail).toLowerCase())) {
        this.reg_status = "ok";
        this.emailStyl["reg-pass-err"] = false;
        this.emailStyl["reg-pass"] = true;
      } else {
        this.reg_status = "wrong_format";
        this.emailStyl["reg-pass-err"] = true;
        this.emailStyl["reg-pass"] = false;
      }
    }
  },

  computed: {
    passwordMatch: function() {
      if (
        this.password !== "" &&
        this.password_confirm !== "" &&
        this.password.length > 7
      ) {
        if (this.password === this.password_confirm) {
          this.zmenStyl["reg-pass-err"] = false;
          this.zmenStyl["reg-pass"] = false;
          this.zmenStyl["reg-pass-corr"] = true;
          this.reg_status = "ok";
          return true;
        } else {
          this.zmenStyl["reg-pass-corr"] = false;
          this.zmenStyl["reg-pass"] = false;
          this.zmenStyl["reg-pass-err"] = true;
          this.reg_status = "password_match";
          return false;
        }
      } else if (
        this.password !== "" &&
        this.password_confirm !== "" &&
        this.password.length < 7
      ) {
        this.zmenStyl["reg-pass-err"] = false;
        this.zmenStyl["reg-pass-corr"] = false;
        this.zmenStyl["reg-pass"] = true;
        this.reg_status = "password_short";
      }
    }
  },

  methods: {
    back() {
      this.$router.replace("/auth/login");
    },

    delayedReroute() {
      var that = this;
      setTimeout(function() {
        that.$router.replace("/");
      }, 1500);
    },

    register() {
      if (
        this.password === this.password_confirm &&
        this.password.length >= 6
      ) {
        let data = {
          first_name: this.first_name,
          last_name: this.last_name,
          email: this.email,
          password: this.password,
          token: this.reg_token
        };

        console.log(data);
        axios
          .post("api/register", data, {
            headers: {
              "X-CSRF-TOKEN": this.csrf
            }
          })
          .then(response => {
            if (response.data["status_code"] === 200) {
              var str = window.localStorage;
              var str2 = window.localStorage;
              str.setItem("logged_in", "true");
              str2.removeItem("name");
              str2.setItem(
                "name",
                response.data.user["first_name"] +
                  " " +
                  response.data.user["last_name"]
              );
              str2.setItem("token", response.data.user["api_token"]);
              this.reg_status = "ok";
              this.reg_complete = true;
              this.buttonStyl["reg-default"] = false;
              this.buttonStyl["reg-complete"] = true;
              this.delayedReroute();
              console.log(response);
            } else {
              if (response.data["status_code"] === 421) {
                this.reg_status = "invalid_token";
                this.tokenStyl["reg-pass-err"] = true;
                this.tokenStyl["reg-pass"] = false;
              } else if (response.data["status_code"] === 420) {
                this.reg_status = "user_exists";
                this.emailStyl["reg-pass-err"] = true;
                this.emailStyl["reg-pass"] = false;
              }
              console.log("Chybička se vloudila");
              console.log(response);
            }
          })
          .catch(e => {
            console.log(e);
          });
      } else {
        if (this.password !== this.password_confirm) {
          this.zmenStyl["reg-pass-err"] = true;
          this.zmenStyl["reg-pass"] = false;
          this.reg_status = "password_match";
        } else {
          this.reg_status = "ok";
        }

        if (this.password.length < 6) {
          this.zmenStyl["reg-pass-corr"] = false;
          this.zmenStyl["reg-pass-err"] = true;
          this.zmenStyl["reg-pass"] = false;
          this.reg_status = "password_short";
        }
      }
    },
    enter() {
      let button = document.getElementById("enter-button");
      button.click();
    },

    hideError() {
      this.tokenStyl["reg-pass"] = true;
      this.tokenStyl["reg-pass-err"] = false;
      this.emailStyl["reg-pass"] = true;
      this.emailStyl["reg-pass-err"] = false;
    },

    tokenPopup() {
      if (this.isOut === false) {
        this.isOut = true;
        console.log(this.isOut);
        return true;
      } else {
        this.isOut = false;
        console.log(this.isOut);
        return false;
      }
    }
  },

  name: "Register"
};
</script>

<style scoped>
.animate__fadeIn {
  animation-duration: 0.2s;
}

.animate__fadeOut {
  animation-duration: 0.2s;
}
input {
  border-radius: 2rem;
  transition-duration: 0.2s;
}
input:focus {
  border: 0.1rem solid var(--brdr-el);
  transition-duration: 0.2s;
}
.reg-complete {
  background-color: #6ac174;
  transition-duration: 0.2s;
  padding-top: 0.2rem;
  padding-bottom: 0;
}

.reg-complete:hover {
  background-color: #62b26b !important;
  transition-duration: 0.2s;
}

.reg-default {
  background-color: var(--btn);
  color: var(--fnt-btn);
  padding-top: 0.8rem;
  padding-bottom: 0.8rem;
}

.reg-pass {
  transition-duration: 0.2s;
}

.reg-pass-err {
  border: solid 0.1rem var(--fnt-err);
  transition-duration: 0.2s;
}

.reg-pass-corr {
  border: solid 0.1rem #9ae49f !important;
  transition-duration: 0.2s;
}

.register-info {
  text-decoration: underline;
  font-size: 0.8rem;
}

.register-info:hover {
  cursor: pointer;
}

.register-button {
  width: 18rem;
  border-radius: 2rem;
  border: none;
  font-size: 1rem;
  transition-duration: 0.2s;
  margin-top: 0.8rem;
  cursor: pointer;
  height: 3rem;
  color: var(--fnt-btn);
  background-color: var(--btn);
}

.register-button:hover {
  background-color: var(--btn-hover);
  transition-duration: 0.2s;
}

.register-kontainer {
  margin-top: 1rem;
}

.register input {
  padding-left: 1.5rem;
  height: 3.2rem;
  margin-top: 1rem;
}

.register-mail {
  width: 100%;
}

.register-mail input {
  width: calc(100% - 1.5rem);
}

.token {
  width: 100%;
}
.token input {
  width: calc(100% - 1.5rem);
}

.register-password {
  margin-bottom: 2rem;
}

.token-popup {
  width: 100%;
  text-align: left;
  -webkit-box-shadow: 0px 3px 22px -13px rgba(0, 0, 0, 0.75);
  -moz-box-shadow: 0px 3px 22px -13px rgba(0, 0, 0, 0.75);
  box-shadow: 0px 3px 22px -13px rgba(0, 0, 0, 0.75);
  border: 0.05rem solid var(--brdr-el);
  border-radius: 0.5rem;
  position: absolute;
  background-color: var(--bg-secondary);
  bottom: 5rem;
}

.token-popup div {
  padding: 0.8rem;
  position: relative;
}

.token-popup h2 {
  font-size: 1rem;
}

.token-popup p {
  width: 18rem;
  margin-top: 0.3rem;
}

.token-input {
  display: flex;
  transition-duration: 0.2s;
  border-right: 0;
}

.token-input input {
  border-radius: 3rem 0 0 3rem;
  border-right: 0;
}
.info-button {
  background-color: var(--btn);
  margin-top: 1rem;
  border-radius: 0 3rem 3rem 0;
  border: 0.1rem solid var(--brdr-input);
  border-left: 0;
  width: 3rem;
  display: flex;
  color: var(--fnt-btn);
  justify-content: center;
  align-items: center;
}

.info-button span {
  text-align: center;
  width: 2rem;
}

.info-button span:hover {
  cursor: pointer;
}

.close {
  color: var(--fnt-err);
  position: absolute;
  top: 0.5rem;
  right: 1rem;
  width: 1rem;
  height: auto;
  border-radius: 2rem;
  cursor: pointer;
}
.reg-alert {
  color: var(--fnt-err);
}
/*Phone*/
@media (min-width: 320px) and (max-width: 480px) {
  .register input {
    width: 80% !important;
  }
  .register-mail input {
    width: 80% !important;
  }
}
</style>
