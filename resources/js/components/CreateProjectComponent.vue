<template>
    <button type="button" class="btn btn-create btn-warning" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-bs-whatever="@fat">+ Проект</button>
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Создать проект</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="mb-3">
                            <input type="text" class="form-control" v-model="nameProject" id="nameProject" placeholder="Введите название проекта (от 2 до 25 символов)">
                        <template v-if="message">
                            <p class="text-danger">{{message}}</p>
                        </template>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-success"  @click.prevent="addProject">Создать</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

 export default {
    name: "CreateProjectComponent",

     data(){
        return{
            nameProject:'',
            message:false
        }

     },
     mounted() {
        this.$parent;
     },
     components: {

    },
     methods: {
        addProject() {
           axios.post('/api/projects', {name: this.nameProject})
               .then( res =>{
                  this.nameProject=null;
                  this.$parent.getProject();
               })
               .catch((error)=>{
                   this.message = (error.response.data.message);
               });
        },

     }


}
</script>

