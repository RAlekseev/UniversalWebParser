<template>
    <div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{parser.name}}
                <button class="btn btn-success btn-round" @click="start()">
                    <i class="fa fa-play-circle"></i> Старт
                </button>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="data_table" class="display table-bordered" style="width:100%;">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Img</th>
                        <th v-for="target in parser.targets">{{target.name}}</th>
                        <th>Url</th>
                        <th class="text-right">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="result in parser.results.slice(0, 3)">
                        <td class="text-center">{{result.id}}</td>
                        <td>
                            <img width="50px" :src="result.images[0]" v-if="result.images.length">
                        </td>
                        <td v-for="(target, target_id) in parser.targets">
                            <span v-if="result.targets_result[target_id]">
                                {{limitStr(result.targets_result[target_id].value, 200)}}
                            </span>
                            <span v-else class="text-danger">Not found</span>
                        </td>
                        <td>
                            <a :href="result.url">
                                {{result.url}}
                            </a>
                        </td>

                        <td class="text-right">
                            <div class="row m-0">
                                <router-link :to="{ name: 'parserResultShow', params: { id: result.id } }">
                                    <button class="btn btn-success btn-round">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </router-link>

                                <button @click="deleteResult(result.id)"
                                        class="btn btn-danger btn-round">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-center">
                            <router-link :to="{name: 'parserShow', params: {id: parser.id}}">
                                . . .
                            </router-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['parser'],
        methods: {
            start() {
                this.$store.dispatch('startParser', this.parser.id);
            },
            limitStr(str, n) {
                return str.substr(0, n) + (str.length > n ? "..." : "");
            },
        }
    }
</script>
