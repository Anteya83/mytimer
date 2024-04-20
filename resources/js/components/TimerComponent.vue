<template>

    <CreateTaskComponent></CreateTaskComponent>

<h1>Мои проекты</h1>
    <div class="col-md-12 col-md-offset-2">
        <div class="col-2"> <CreateProjectComponent ref="creat"></CreateProjectComponent></div>
            <hr>
        <div class="no-projects" v-if="projects">

            <div v-if="projects.length > 0">
                <div class="panel panel-default" v-for="project in projects" :key="project.id">

                    <div class="panel-heading clearfix row mb-lg-3" :class="(isEdit(project.id)) ? 'd-none' :''">
                       <div class="col-8"> <h4 class="pull-right ">{{ project.name }}</h4></div>
                        <span class="col-4 ">На проект затрачено : {{getTotalTime(project.tasks, false)}}</span>
                        <template v-if="project.tasks.length !== 0">
                            <button class="btn btn-success btn-sm  col-4"   data-bs-toggle="collapse"  :data-bs-target="getStrForId(project.id, true)" :aria-controls="getStrForId(project.id)" :id="getStrForId(project.id, true)" @click="clickBtn(getStrForId(project.id, true))" aria-expanded="false">Показать задачи</button>
                        </template>

                        <template v-else> <span class="btn btn-success btn-sm  col-4">У проекта пока нет задач</span></template>
                        <button type="button" class="btn btn-sm btn-warning col-4" data-bs-toggle="modal" data-bs-target="#exampleModal" @click.prevent="getId(project.id)"  data-bs-whatever="@mdo">+ Задача</button>
                        <a href="#"  @click.prevent="changeEditProjectId(project.id, project.name)" class="btn btn-success btn-sm col-4">Редактировать</a>

                    </div>


                    <div :class="isEdit(project.id) ? '' :'d-none'" class="row" >
                        <span class="pull-right col-5"><input type="text" v-model="projectName" class="form-control " placeholder="Введите от 2 до 25 символов">
                         </span>

                         <a href="#" @click.prevent="updateProject(project.id)" class="btn btn-success btn-sm col-3 mb-lg-5">Обновить</a>
                        <a href="#" @click.prevent="changeEditProjectId(null)" class="btn btn-warning btn-sm col-4 mb-lg-5" >Закрыть</a>
                    </div>

                    <div class="panel-body collapse multi-collapse mb-lg-5" :id="getStrForId(project.id)">
                        <ul class="list-group mb-lg-5" v-if="project.tasks.length > 0">
                            <li v-for="task in project.tasks" :key="task.id" class="list-group-item clearfix row">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="col-sm-4"></th>
                                        <th class="col-sm-7"></th>
                                        <th class="col-sm-1"></th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="">
                                        <th scope="row">{{ task.name }}</th>
                                        <td class="">На задачу затрачено : {{ getTotalTime(false,task) }}</td>

                                        <td>
                                            <template v-if="task.start == null">
                                                <button  @click.prevent="updateRunTask(task.id)" @click="" class="btn btn-success btn-sm btn-start"><i class="glyphicon glyphicon-stop">Старт</i></button>
                                            </template>
                                            <template v-else>
                                                <button  @click.prevent="updateStopTask(task.id)" @click='' class="btn btn-danger btn-sm btn-start"><i class="glyphicon glyphicon-stop">Стоп</i></button>
                                            </template>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </li>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="" v-else>
                У вас пока нет проектов
            </div>
        </div>
    </div>

</template>
<script>

import CreateProjectComponent from "./CreateProjectComponent.vue";
import CreateTaskComponent from "./CreateTaskComponent.vue";
import axios from "axios";
 export default {
    data() {
        return {
            projects: null,
            newTimerName: '',
            newProjectName: null,
            editProjectId:null,//id проекта который открыт для редакт
            projectName: '',
            idProject:null,
            timer: 0,
            message:false,
        }
    },

     mounted() {
        this.getProject();
     },
     methods: {

      getProject(){
          axios.get('/api/projects')
              .then(res=>{
                 // console.log(res.data);
                  this.projects = res.data;

              })
      },

         updateProject(id){
              this.editProjectId = null;
              axios.patch(`/api/project/${id}`, {name: this.projectName})
                  .then(res=>{
                      this.getProject();
                  })
                  .catch((error)=>{
                      this.message = (error.response.data.message);
                  })
      },
//запуск времени у таска с переданным id
         updateRunTask(id){

             axios.patch(`/api/projects/tasks/${id}/start`)
                 .then(res=>{
                     this.getProject();

                 })
         },
         //stop времени у таска с переданным id
         updateStopTask(id){
             axios.patch(`/api/projects/tasks/${id}/stop`)
                 .then(res=>{
                     this.getProject();
                 })
         },
         //метод для занесения в editProjectId данных
      changeEditProjectId(id,name){
          this.editProjectId = id;
          this.projectName = name;
      },
         //нужно ли отобразить поле редактирования для проекта с переданным id
      isEdit(id){
              return this.editProjectId === id;
      },


      getId(id){
       this.idProject = id;
      },
         //для вывода времени по всему проекту передаем tasks, для времени задачи соответственно передаем task
         getTotalTime(tasks=false, task=false){
             let count = 0;
             if (tasks){
                 for (let task of tasks) {
                     count += task['totalTimer'];
                 }
             }
             else{
                 count = task.totalTimer;
             }

             let hour = 0, minutes = 0;

             if (count >= 60){
                 minutes = count % 60;
                 hour = Math.floor(count/ 60);
                 return `${hour} ч ${minutes} м`;
             }
             else {
                 if(count === null){
                     count = 0;
                 }

                 return `${hour} ч ${count} м`;
             }

         },

//метод для формирования атрибутов строк в соответствии с id
         getStrForId(id, is=false){
          if(is){
              return "#multiCollapseExample".concat(id);
          }
          else{
              return "multiCollapseExample".concat(id);
          }

         },
         //тоггл кнопки Показать задачи/скрыть задачи
         clickBtn(idDomElement) {
           let element = document.getElementById(idDomElement);
          let text = element.innerHTML;
          text === "Показать задачи" ?   element.innerHTML = 'Скрыть задачи': element.innerHTML = 'Показать задачи';

         }

    },

     computed:{


     },
     components:{
         CreateTaskComponent,
       CreateProjectComponent
     }
}
</script>

<style>
.panel-body, .panel-default {
    margin-bottom: 40px;
}
.panel-heading > h4 {
    margin: 5px;

    top: 5px;
}
.btn-start {
    width: 100px;
}
.btn-create {
    width: max-content;
}
.form-control:focus{
    border-color: darkgreen;
    box-shadow: inset 0 0 15px rgba(0,0,0,0.07), 0 0 12px rgba(2,70,56,0.9);
}
</style>
