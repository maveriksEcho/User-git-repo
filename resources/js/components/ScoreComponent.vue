<template>
    <div class="container">
        <button v-if="score !== 1" @click="setScore(1)">
            <i class="fa fa-thumbs-up"></i>
        </button>
        <button v-if="score !== 0" @click="setScore(0)">
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
            score: {
                required: true
            }
        },
        methods: {
            setScore(s) {
                    axios.post('score', {
                        repo_id: this.repo_id,
                        score: s
                    }).then(response => {
                        console.log(response.data);
                        this.score = s;
                    }).catch(error => {
                        console.log(error.response);
                    })
            },
        }
    }
</script>
