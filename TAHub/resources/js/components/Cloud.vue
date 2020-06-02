<template>
    <div>

        <button v-on:click="back" class="dashboard-button">Dashboard</button>
        <router-view>
        </router-view>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Cloud",



        methods: {
            back() {
                this.$router.replace("/")
            },
        }
    }
</script>

<style scoped>
.dashboard-button{
    position: absolute;
    top: .8rem;
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

.dashboard-button:hover{
    background-color: var(--btn-hover);
    transition-duration: 0.2s;
}


</style>
