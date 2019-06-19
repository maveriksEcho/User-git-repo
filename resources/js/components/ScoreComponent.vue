<template>
    <div class="container">
        <button class="btn bg-success" v-if="score !== 1" @click="setScore(1)">
            <i class="fa fa-thumbs-up"></i>
        </button>
        <button class="btn bg-danger" v-if="score !== 0" @click="setScore(0)">
            <i class="fa fa-thumbs-down"></i>
        </button>
    </div>
</template>

<script>
    export default {
        props: {
            repo_id: {
                type: Number,
                required: true
            },
            user_score: {
                required: true
            }
        },
        data() {
            return {
                score: this.user_score,
            }
        },
        methods: {
            setScore(s) {
                    axios.post('/score', {
                        repo_id: this.repo_id,
                        score: s
                    }).then(response => {
                        this.score = s;
                    }).catch(error => {
                        console.log(error.response);
                    })
            },
        }
    }
</script>

<style scoped>
    .btn i {
        color: white;
    }
</style>
