<template>
    <div v-if="result">
        <loading v-if="loading"></loading>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Изображения
                </h6>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3" v-for="img in result.images">
                        <img :src="img" width="100%">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Параметры
                    <a :href="result.url" target="_blank">
                        <button class="btn btn-success btn-round">
                            <i class="fa fa-eye"></i> Оригинал
                        </button>
                    </a>
                </h6>
            </div>

            <div class="card-body">
                <div v-for="(target, i) in result.targets_result">
                    <h2>{{targetName(target, i)}}</h2>
                    <p>{{target}}</p>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4" v-if="result.internal_links.length">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Внутренние ссылки
                </h6>
            </div>

            <div class="card-body">
                <div v-for="link in result.internal_links">
                    <a :href="link.href">
                        <h2>{{link.text}}</h2>
                    </a>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                loading: true,
                result: null,
            };
        },
        mounted() {
            this.getResult();
        },
        methods: {
            getResult() {
                axios
                    .get(`/api/parser_results/${this.$route.params.id}`)
                    .then(response => {
                        this.result = response.data;
                    }).catch(error => {
                    this.$store.dispatch('pushError', error.response.data.message || error.message)
                }).finally(() => this.loading = false);
            },
            targetName(target, i) {
                return this.result.parser.targets[i].name;
            },
        }
    }
</script>
