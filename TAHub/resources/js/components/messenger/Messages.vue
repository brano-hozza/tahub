<template>
  <div>
    <div class="send-menu">
      <div class="send-wrapper">
        <input v-model="sprava" v-on:keydown.enter="odosli" placeholder="sprava" />
        <span class="poslat" v-on:click="odosli">
          <span class="material-icons">send</span>
        </span>
      </div>
    </div>
    <h2 class="friends-header">Recent friends</h2>
    <div class="friends">
      <span
        class="avatar-wrapper"
        v-on:click="changeFriend(friend)"
        v-for="friend in friends"
        :key="friend.id"
      >
        <span class="avatar" v-html="jdenticon.toSvg(friend.id,50)"></span>
        <p class="avatar-name">{{friend.first_name[0]}}.{{friend.last_name[0]}}.</p>
      </span>
    </div>
    <h2 class="username">{{priatel.first_name}} {{priatel.last_name}}</h2>
    <span v-on:click="scrollDown" class="notify" v-if="newMess">New message</span>
    <div class="messages">
      <div v-for="sprava in spravy" class="message" :key="sprava.id">
        <div v-if="sprava.sender_id==priatel.id" class="friend-message">
          <p>{{sprava.message}}</p>
        </div>
        <div v-else class="my-message">
          <p>{{sprava.message}}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import jdenticon from "jdenticon";

export default {
  name: "Messages",
  data() {
    return {
      priatel: {
        id: -1
      },
      sprava: "",
      spravy: [],
      friends: [],
      callback: null,
      jdenticon: jdenticon,
      bottom: true,
      newMess: true
    };
  },

  created() {
    var a = { bottom: this.bottom };
    window.addEventListener("scroll", this.handleScroll);
    let str = window.localStorage;
    let token = str.getItem("token");
    axios
      .post("api/mess/friends", {
        api_token: token
      })
      .then(response => {
        console.log(response);
        this.friends = response.data.friends;
        this.priatel = this.friends[0];
        this.ziskaj();
      })
      .catch(e => console.log(e));
    let that = this;
    this.callback = setInterval(function() {
      console.log("Idzem");
      that.ziskaj();
    }, 5000);
  },
  beforeDestroy() {
    clearInterval(this.callback);
  },

  methods: {
    scrollDown() {
      window.scrollTo(0, document.body.scrollHeight);
      this.bottom = true;
      this.newMess = false;
    },
    handleScroll(ev) {
      if (
        window.innerHeight + window.pageYOffset >=
        document.body.offsetHeight
      ) {
        this.bottom = true;
        this.newMess = false;
      } else {
        this.bottom = false;
      }
    },
    changeFriend(priatel) {
      this.priatel = priatel;
      this.spravy = [];
      this.ziskaj();
    },
    odosli() {
      if (this.priatel.id === -1) {
        console.log("Nezadal si id");
      } else if (this.sprava === "") {
        console.log("Nezadal si spravu");
      } else {
        var str = window.localStorage;
        var token = str.getItem("token");
        let sprava = this.sprava;
        this.sprava = "";
        axios
          .post("api/mess/send", {
            api_token: token,
            id: this.priatel.id,
            message: sprava
          })
          .then(response => {
            console.log(response);
            this.spravy.push(response.data.message);
            setTimeout(function() {
              window.scrollTo(0, document.body.scrollHeight);
            }, 600);
          })
          .catch(error => {
            console.log(error);
          });
      }
    },

    ziskaj() {
      if (this.priatel.id === -1) {
        console.log("Nezadal si id");
      } else {
        var str = window.localStorage;
        var token = str.getItem("token");
        axios
          .post("api/mess", {
            api_token: token,
            id: this.priatel.id,
            amount: 15
          })
          .then(response => {
            console.log(response);
            if (!this.loaded) {
              this.spravy = response.data.messenger.reverse();
              this.loaded = true;
              setTimeout(function() {
                window.scrollTo(0, document.body.scrollHeight);
              }, 600);
            } else {
              response.data.messenger.map((v, i) => {
                let is_in = this.spravy.filter(va => va.id == v.id);
                if (is_in[0] == null) {
                  this.spravy.push(v);
                  console.log("Tu som");
                  console.log("Hodnota:" + this.bottom);
                  if (this.bottom == false) {
                    this.newMess = true;
                    console.log(this.newMess);
                  }
                }
              });
            }
          })
          .catch(error => {
            console.log(error);
          });
      }
    }
  }
};
</script>

<style scoped>
h1 {
  font-size: 3rem;
}
h2 {
  font-size: 2rem;
}

input {
  padding-left: 2rem;
  border: 0.1rem solid var(--brdr-el);
  transition-duration: 0.2s;
  border-radius: 2rem 0 0 2rem;
  height: 3.2rem;
  width: 100%;
}
.notify {
  text-align: center;
  vertical-align: center;
  position: absolute;
  bottom: 3.8rem;
  left: 50%;
  width: 3rem;
  height: 3rem;
  border-radius: 1rem;
  background-color: var(--btn);
}
.username {
  text-align: center;
  width: 100%;
}
.friends-header {
  text-align: center;
  width: 100%;
}
.friends {
  position: sticky;
  top: 0;
  width: 100%;
  display: flex;
  justify-content: flex-start;
  align-items: center;
  background-color: var(--bg-secondary);
  border-top: 2px solid var(--bg-third);
  border-bottom: 2px solid var(--bg-third);
}

.avatar-wrapper {
  display: flex;
  border-radius: 50%;
  width: 80px;
  height: 80px;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: var(--bg);
  transition-duration: 0.5s;
  margin-right: 0.3rem;
  margin-left: 0.3rem;
}

.avatar-wrapper:hover {
  background-color: var(--btn-hover);
  cursor: pointer;
  transition-duration: 0.5s;
}
.avatar {
  width: 50px;
}
.avatar-name {
  font-size: 1rem;
  color: var(--fnt);
}
.send-menu {
  position: fixed;
  display: flex;
  align-items: center;
  justify-content: center;
  bottom: 0;
  left: 0;
  width: 100%;
  background-color: var(--bg-secondary);
}
.send-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;

  width: 70%;
}
.poslat {
  padding-left: 0.2rem;
  width: 2rem;
  border: 0.1rem solid transparent;
  transition-duration: 0.2s;
  border-radius: 0 2rem 2rem 0;
  background-color: var(--btn);
  height: 3.2rem;
  display: flex;
  justify-content: center;
  align-items: center;
}
.poslat:hover {
  color: var(--fnt);
  cursor: pointer;
}
.messages {
  margin-bottom: 3.2rem;
}
.message {
  width: 80%;
  max-height: 100%;
  overflow: auto;
  margin: 0 auto;
}

.message div p {
  font-size: 1rem;
  padding: 0.7rem;
  margin-top: 0.5rem;
  max-width: 40%;
}

.my-message {
  width: 100%;
}

.my-message p {
  background-color: var(--btn);
  color: var(--fnt-btn);
  float: right;
  border-radius: 1.5rem 1.5rem 0rem 1.5rem;
}

.friend-message {
  width: 100%;
}

.friend-message p {
  background-color: var(--fnt);
  color: var(--fnt-btn);
  float: left;
  border-radius: 1.5rem 1.5rem 1.5rem 0;
}

/*Phone*/
@media (min-width: 320px) and (max-width: 480px) {
  .message {
    width: 98%;
  }

  .message div p {
    max-width: 50%;
  }
}
</style>
