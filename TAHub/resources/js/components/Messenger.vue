<template>
  <div>
    <div class="header">
      <h1>Messenger</h1>
      <button v-on:click="back" class="dashboard-btn">Dashboard</button>
      <button v-on:click="messages" v-bind:class="messActive">Messages</button>
      <button v-on:click="friends" v-bind:class="friendsActive">Friends</button>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: "Messenger",
  data() {
    return {
      messActive: {
        "mess-btn-active": true,
        "mess-btn": false
      },
      friendsActive: {
        "friends-btn-active": false,
        "friends-btn": true
      }
    };
  },
  methods: {
    back() {
      this.$router.replace("/");
    },
    messages() {
        this.messActive = {
        "mess-btn-active": true,
        "mess-btn": false
      };
      this.friendsActive = {
        "friends-btn-active": false,
        "friends-btn": true
      };
      this.$router.replace("/messenger");
    },
    friends() {
        this.messActive = {
        "mess-btn-active": false,
        "mess-btn": true
      };
      this.friendsActive = {
        "friends-btn-active": true,
        "friends-btn": false
      };
      this.$router.replace("/messenger/friends");
    }
  }
};
</script>

<style scoped>
h1 {
  position: absolute;
  font-size: 2rem;
  width: 100%;
  text-align: center;
  top: 0;
}
.header {
  height: 4rem;
}
.dashboard-btn {
  position: absolute;
  top: 0.8rem;
  right: 6rem;
  padding: 0.6rem 1rem;
  background-color: var(--btn);
  border: none;
  border-radius: 2rem;
  font-weight: bolder;
  color: var(--fnt-btn);
  cursor: pointer;
  transition-duration: 0.2s;
}

.dashboard-btn:hover {
  background-color: var(--btn-hover);
  transition-duration: 0.2s;
}

.mess-btn {
  position: absolute;
  top: 0.8rem;
  left: 2rem;
  padding: 0.6rem 1rem;
  background-color: var(--btn);
  border: none;
  border-radius: 2rem;
  font-weight: bolder;
  color: var(--fnt-btn);
  cursor: pointer;
  transition-duration: 0.2s;
}

.mess-btn:hover {
  background-color: var(--btn-hover);
  transition-duration: 0.2s;
}
.mess-btn-active {
  position: absolute;
  top: 0.8rem;
  left: 2rem;
  padding: 0.6rem 1rem;
  background-color: var(--btn-active);
  border: none;
  border-radius: 2rem;
  font-weight: bolder;
  color: var(--fnt-btn);
  cursor: pointer;
  transition-duration: 0.2s;
}

.friends-btn {
  position: absolute;
  top: 0.8rem;
  left: 8.5rem;
  padding: 0.6rem 1rem;
  background-color: var(--btn);
  border: none;
  border-radius: 2rem;
  font-weight: bolder;
  color: var(--fnt-btn);
  cursor: pointer;
  transition-duration: 0.2s;
}

.friends-btn:hover {
  background-color: var(--btn-hover);
  transition-duration: 0.2s;
}

.friends-btn-active {
  position: absolute;
  top: 0.8rem;
  left: 8.5rem;
  padding: 0.6rem 1rem;
  background-color: var(--btn-active);
  border: none;
  border-radius: 2rem;
  font-weight: bolder;
  color: var(--fnt-btn);
  cursor: pointer;
  transition-duration: 0.2s;
}
</style>
