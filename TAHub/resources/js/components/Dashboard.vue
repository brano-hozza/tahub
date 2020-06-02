<template>
    <div>
        <div class="dashboard">
            <h1>Ahoj {{name}}!</h1>
            <h2>Dashboard</h2>
        </div>
        <div class="dashboard-container">
            <div class="dashboard-card">
                <img src="images/tahub2.png">
                <h1>TAHub</h1>
                <h2>Cloud</h2>
                <p>Miesto, ktoré predstavuje bezpečné útočisko
                    pre všetky tvoje krásne súbory, ktoré nechceš
                    mať natrepané na svojom mobilnom
                    zariadení alebo počítači.</p>
                <button v-on:click="cloud">Prejsť na cloud</button>
            </div>
            <div class="dashboard-card">
                <img src="images/messages.png">
                <h1>TAHub</h1>
                <h2>Správy</h2>
                <p>Miesto, ktoré predstavuje bezpečné útočisko
                    pre všetky tvoje krásne súbory, ktoré nechceš
                    mať natrepané na svojom mobilnom
                    zariadení alebo počítači.</p>
                <button v-on:click="messenger">Prejsť na správy</button>
            </div>
            <div class="dashboard-card">
                <img src="images/shortener.png">
                <h1>TAHub</h1>
                <h2>Url shortener</h2>
                <p>Miesto, ktoré predstavuje bezpečné útočisko
                    pre všetky tvoje krásne súbory, ktoré nechceš
                    mať natrepané na svojom mobilnom
                    zariadení alebo počítači.</p>
                <button>Prejsť na shortener</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Dashboard",

        data() {
            return {
                name: "",
                isOut: false
            }
        },

        methods:{
            messenger(){
                this.$router.replace("/messenger")
            },
            cloud(){
                this.$router.replace('/cloud')
            }
        },

        mounted(){
            var storage=window.localStorage;
            this.name=storage.getItem("name");
        },

    }
</script>

<style scoped>

.dashboard{
    text-align: center;
    margin-top: 2rem;
}

.dashboard h1{
    font-size: 2rem;
}

.dashboard h2{
    font-size: 1.8rem;
    color: var(--fnt);
    font-weight: normal;
}

.dashboard-container{
    display: flex;
    flex-flow: wrap;
    justify-content: center;
}

.dashboard-card{
    background-color: var(--bg-secondary);
    width: 20rem;
    text-align: center;
    margin-left: 2rem;
    margin-right: 2rem;
    border-radius: 1rem;
    -webkit-box-shadow: 0px 1px 29px -15px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 1px 29px -15px rgba(0,0,0,0.75);
    box-shadow: 0px 1px 29px -15px rgba(0,0,0,0.75);
    margin-top: 3rem;
    transition-duration: 0.1s;
}

.dashboard-card:hover{
    -webkit-box-shadow: 0px 1px 5px 0px rgb(107, 183, 222);
    -moz-box-shadow: 0px 1px 5px 0px rgb(107, 183, 222);
    box-shadow: 0px 1px 5px 0px rgb(107, 183, 222);
    transition-duration: 0.1s;
}

.dashboard-card img{
    width: 50%;
    height: auto;
    margin-top: 2rem;
}

.dashboard-card h1{
    font-size: 1.8rem;
}

.dashboard-card h2{
    font-size: 1.8rem;
}

.dashboard-card p{
    font-size: 0.8rem;
    margin-top: 1.5rem;
    width: 80%;
    margin-left: 10%;
}

.dashboard-card button{
    background-color: var(--btn);
    color: var(--fnt-btn);
    border: none;
    padding: 1rem 3rem;
    margin-top: 1.5rem;
    border-radius: 3rem;
    transition-duration: 0.2s;
    font-weight: bold;
    margin-bottom: 4rem;
}

.dashboard-card button:hover{
    cursor: pointer;
    background-color: var(--btn-hover);
    transition-duration: 0.2s;
}





</style>
