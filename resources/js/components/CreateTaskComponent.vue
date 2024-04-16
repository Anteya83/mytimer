<script >
export default {
    name: "CreateTaskComponent",
    data(){
        return {
            name:null,
            message: false,
        }
    },
    methods: {
      addTask(id)  {
         axios.post(`/api/projects/${id}/tasks`, {name: this.name,id: this.id })
          .then( res =>{
              this.name = null;
              this.$parent.getProject();

    })
             .catch((error)=>{
                 this.message = (error.response.data.message);
             });
      }
    },
    mounted() {
        this.$parent;
    }
}
</script>

<template>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Создать задачу</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control" v-model="name" id="name" placeholder="Наименование задачи(от 2 до 25 символов)">
                            <template v-if="message">
                                <p class="text-danger">{{message}}</p>
                            </template>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-warning" @click.prevent="addTask(this.$parent.idProject)">Создать</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
