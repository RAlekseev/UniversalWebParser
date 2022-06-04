<template>
    <span>
        <button class="btn btn-success btn-round" data-toggle="modal" data-target="#createModal">
            <i class="fa fa-plus"></i> Создать парсер
        </button>

        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Создание парсера</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="addParser()" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Название<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" v-model="parser.name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">URL<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="email" v-model="parser.url" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Селктор элемента(ов)<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" v-model="parser.selector" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Селектор для ссылки на дочерние объекты<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" v-model="parser.search_link_selector">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Селектор для внутренних изображений(опционально)</label>
                                        <input type="text" class="form-control" v-model="parser.img_selector">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Селектор для внутренних ссылок(опционально)</label>
                                        <input type="text" class="form-control" v-model="parser.internal_link_selector">
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-for="target in parser.targets">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Название таргета</label>
                                        <input type="text" class="form-control" v-model="target.name" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Селктор таргета</label>
                                        <input type="text" class="form-control" v-model="target.selector" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="m-auto">
                                     <i class="fa fa-minus text-danger" v-if="parser.targets.length > 1" @click="delTarget()"></i>
                                <i class="fa fa-plus text-success" @click="addTarget()"></i>
                                </div>
                            </div>



                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Создать</button>
                                <button id="close" type="button" class="btn btn-danger" data-dismiss="modal">Закрыть
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
    export default {
        data() {
            return {
                parser: {
                    targets: [
                        {
                            name: '',
                            selector: ''
                        },
                    ]
                }
            }
        },
        methods: {
            addParser() {
                document.getElementById('close').click();
                this.$store.dispatch('createParser', this.parser)
            },
            addTarget() {
                this.parser.targets.push({
                    name: '',
                    selector:''
                })
            },
            delTarget() {
                this.parser.targets.pop()
            },
        }
    }
</script>
