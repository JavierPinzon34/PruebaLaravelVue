<template>
  <div class="container-fluid people-content">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="mb-3">
          <button
            type="button"
            class="btn btn-info"
            @click="changeType(true)"
            > Medics
          </button>
          <button
            type="button"
            class="btn btn-secondary"
            @click="changeType(false)"
            > Patients
          </button>
        </div>
        <div v-if="type" class="card">
          <div class="card-header"><h4 class="mb-0">Medics</h4></div>
          <div class="card-body">
            <div class="row buttons-container">
              <button
                type="button"
                class="col-2 btn btn-success mr-5"
                data-toggle="modal"
                data-target="#userModal"
                @click="showModal()"
              >
                New Medic
              </button>
              <input
                type="search"
                class="col-3 form-control ml-5"
                v-model="docuemntSearch"
              />
              <button
                type="button"
                class="text-left col-2 btn btn-primary ml-2"
                @click="getPeople"
              >
                Search
              </button>
            </div>
            <!-- Tabla INICIO -->
            <div class="table-container">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Document</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Second Name</th>
                    <th scope="col">First Surname</th>
                    <th scope="col">Second Surname</th>
                    <th scope="col">Type Document</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in people.data" :key="index">
                    <th scope="row">{{ item.id }}</th>
                    <td>{{ item.document }}</td>
                    <td>{{ item.first_name }}</td>
                    <td>{{ item.second_name }}</td>
                    <td>{{ item.first_surname }}</td>
                    <td>{{ item.second_surname }}</td>
                    <td>{{ item.type_document == 1 ? 'REGISTRO CIVIL' : item.type_document == 2 ? 'TARJETA DE IDENTIDAD' : 'CÉDULA DE CIUDADANÍA' }}</td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-warning"
                        data-toggle="modal"
                        data-target="#userModal"
                        @click="showModal(item)"
                      >
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                      </button>
                      <button
                        type="button"
                        class="btn btn-danger"
                        @click="destroy(item.id)"
                      >
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="float-right">
                <ul class="pagination pagination-rounded mb-0">
                  <!-- Implementa el vue pagination para poder cambiar pagina -->
                  <pagination
                    :data="people"
                    @pagination-change-page="changePaginate"
                    :limit="2"
                  ></pagination>
                </ul>
              </div>
            </div>
            <!-- Tabla FIN -->
          </div>
        </div>
        <div v-else class="card">
          <div class="card-header"><h4 class="mb-0">Patients</h4></div>
          <div class="card-body">
            <div class="row buttons-container">
              <button
                type="button"
                class="col-2 btn btn-success mr-5"
                data-toggle="modal"
                data-target="#userModal"
                @click="showModal()"
              >
                New Patient
              </button>
              <input
                type="text"
                class="col-3 form-control ml-5"
                v-model="docuemntSearch"
              />
              <button
                type="button"
                class="text-left col-2 btn btn-primary ml-2"
                @click="getPeople"
              >
                Search
              </button>
            </div>
            <!-- Tabla INICIO -->
            <div class="table-container">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Document</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Second Name</th>
                    <th scope="col">First Surname</th>
                    <th scope="col">Second Surname</th>
                    <th scope="col">Type Document</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in people.data" :key="index">
                    <th scope="row">{{ item.id }}</th>
                    <td>{{ item.document }}</td>
                    <td>{{ item.first_name }}</td>
                    <td>{{ item.second_name }}</td>
                    <td>{{ item.first_surname }}</td>
                    <td>{{ item.second_surname }}</td>
                    <td>{{ item.type_document == 1 ? 'REGISTRO CIVIL' : item.type_document == 2 ? 'TARJETA DE IDENTIDAD' : 'CÉDULA DE CIUDADANÍA' }}</td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-warning"
                        data-toggle="modal"
                        data-target="#userModal"
                        @click="showModal(item)"
                      >
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                      </button>
                      <button
                        type="button"
                        class="btn btn-danger"
                        @click="destroy(item.id)"
                      >
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="float-right">
                <ul class="pagination pagination-rounded mb-0">
                  <!-- Implementa el vue pagination para poder cambiar pagina -->
                  <pagination
                    :data="people"
                    @pagination-change-page="changePaginate"
                    :limit="2"
                  ></pagination>
                </ul>
              </div>
            </div>
            <!-- Tabla FIN -->
          </div>
        </div>
      </div>
    </div>
    <!-- Modal INICIO -->
    <div
      class="modal fade"
      id="userModal"
      tabindex="-1"
      aria-labelledby="userModalLabel"
      aria-hidden="true"
      data-backdrop="static"
      data-keyboard="false"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="userModalLabel">{{ title }}</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Nombre INICIO -->
              <div class="form-group">
                <label for="name">Type document</label>
                <select
                  class="form-control"
                  aria-label="Default select example"
                  id="type_document"
                  v-model="form.type_document"
                  required
                >
                  <option :value="null">Selected</option>
                  <option :value="1">REGISTRO CIVIL</option>
                  <option :value="2">TARJETA DE IDENTIDAD</option>
                  <option :value="3">CÉDULA DE CIUDADANÍA</option>
                </select>
              </div>
              <!-- Nombre FIN -->
            <!-- Formulario INICIO -->
            <form @submit.prevent="save()">
              <!-- Nombre INICIO -->
              <div class="form-group">
                <label for="name">Document</label>
                <input
                  type="text"
                  class="form-control"
                  :class="{
                    'is-invalid': errors.document,
                  }"
                  id="document"
                  v-model="form.document"
                  required
                />
                <div v-if="errors.document" class="invalid-feedback">{{ errors.document[0] }}</div>
              </div>
              <!-- Nombre FIN -->
              <!-- Nombre INICIO -->
              <div class="form-group">
                <label for="name">First name</label>
                <input
                  type="text"
                  class="form-control"
                  id="first_name"
                  v-model="form.first_name"
                  required
                />
              </div>
              <!-- Nombre FIN -->
              <!-- Nombre INICIO -->
              <div class="form-group">
                <label for="name">Second name</label>
                <input
                  type="text"
                  class="form-control"
                  id="second_name"
                  v-model="form.second_name"
                  required
                />
              </div>
              <!-- Nombre FIN -->
              <!-- Nombre INICIO -->
              <div class="form-group">
                <label for="name">First surname</label>
                <input
                  type="text"
                  class="form-control"
                  id="first_surname"
                  v-model="form.first_surname"
                  required
                />
              </div>
              <!-- Nombre FIN -->
              <!-- Nombre INICIO -->
              <div class="form-group">
                <label for="name">Second surname</label>
                <input
                  type="text"
                  class="form-control"
                  id="second_surname"
                  v-model="form.second_surname"
                  required
                />
              </div>
              <!-- Nombre FIN -->
              <!-- Nombre INICIO -->
              <div class="form-group">
                <label for="name">Expedition date</label>
                <input
                  type="date"
                  class="form-control"
                  id="expedition_date"
                  v-model="form.expedition_date"
                  required
                />
              </div>
              <!-- Nombre FIN -->
              <!-- Botones INICIO -->
              <div class="text-center">
                <button v-if="event" type="submit" class="btn btn-primary">
                  Save
                </button>
                <button v-if="!event" type="submit" class="btn btn-primary">
                  Update
                </button>
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-dismiss="modal"
                  @click="hideModal()"
                >
                  Close
                </button>
              </div>
              <!-- Botones INICIO -->
            </form>
            <!-- Formulario FIN -->
          </div>
        </div>
      </div>
    </div>
    <!-- Modal FIN -->
  </div>
</template>
<script>
export default {
  data() {
    return {
      people: {},
      currentPage: 1,
      title: 'New Medic',
      event: true,
      form: {
        id: null,
        first_name: null,
        second_name: null,
        first_surname: null,
        second_surname: null,
        expedition_date: null,
        type_document: null,
        document: null,
        type: null,
      },
      errors: {},
      type: true,
      docuemntSearch: null,
    };
  },
  created() {
    this.getPeople();
  },
  methods: {
    showModal(item) {
      //Recibo la información si es nuevo o editar
      if (item) {
        this.title = "Editar " + item.name;
        this.event = false;
        this.form.id = item.id;
        this.form.first_name = item.first_name;
        this.form.second_name = item.second_name;
        this.form.first_surname = item.first_surname;
        this.form.second_surname = item.second_surname;
        this.form.expedition_date = item.expedition_date;
        this.form.type_document = item.type_document;
        this.form.document = item.document;
      } else {
        this.event = true;
      }
    },
    hideModal() {
      $("#myModal").modal("hide");
      this.clearData();
    },
    changePaginate(changePage) {
      this.currentPage = changePage;
      axios
        .get(`people?page=${changePage}`)
        .then((res) => {
          this.people = res.data;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    save() {
      let me = this;
      me.form.type = me.type ? 1 : 0
      if (this.event) {
        console.log("guardar");
        axios
          .post("people", me.form)
          .then((res) => {
            console.log(res);
            this.$swal({
              position: 'top',
              icon: 'success',
              title: res.data.message,
              showConfirmButton: true,
              confirmButtonText: 'Aceptar',
              timer: 1500
            })
            $("#userModal").modal("hide");
            this.clearData();
            this.getPeople();
          })
          .catch((err) => {
            if (err.response.status == 422) {
              this.errors = err.response.data.errors;
            }
            console.error(err);
          });
      } else {
        console.log("actualizar");
        axios
          .put(`people/${me.form.id}`, me.form)
          .then((res) => {
            console.log(res);
            this.$swal({
              position: 'top',
              icon: 'success',
              title: res.data.message,
              showConfirmButton: true,
              confirmButtonText: 'Aceptar',
              timer: 1500
            })
            $("#userModal").modal("hide");
            this.clearData();
            this.getPeople();
          })
          .catch((err) => {
            if (err.response.status == 422) {
              this.errors = err.response.data.errors;
            }
            console.error(err);
          });
      }
    },
    destroy(id) {
      this.$swal({
        title: '¿Estás seguro?',
        text: '¡No podrás revertir esto!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
      }).then(result => {
        if (result.value) {
          //Inactivar
          if (id) {
            axios
              .delete(`people/${id}`)
              .then((res) => {
                console.log(res);
                this.$swal({
                  position: 'top',
                  icon: 'success',
                  title: res.data.message,
                  showConfirmButton: true,
                  confirmButtonText: 'Aceptar',
                  timer: 1500
                })
                this.getPeople();
              })
              .catch((err) => {
                console.error(err);
              });
          }
        }
      })
    },
    getPeople() {
      let t = this.type ? 1 : 0
      if (this.docuemntSearch) {
        axios
        .get(`people?type=${t}&document=${this.docuemntSearch}`)
        .then((res) => {
          this.people = res.data;
        })
        .catch((err) => {
          console.error(err);
        });
      } else {
        axios
          .get(`people?type=${t}`)
          .then((res) => {
            this.people = res.data;
          })
          .catch((err) => {
            console.error(err);
          });
      }
    },
    clearData() {
      this.form.id = null;
      this.form.id = null;
      this.form.first_name = null;
      this.form.second_name = null;
      this.form.first_surname = null;
      this.form.second_surname = null;
      this.form.expedition_date = null;
      this.form.type_document = null;
      this.form.document = null;
      this.form.type = null;
      this.errors = {};
    },
    changeType(type) {
      this.type = type
      this.title = type ? 'New Medic' : 'New Patient'
      this.getPeople()
    },
    searchPeople(document) {
      console.log(document)
    }
  },
  watch: {
    docuemntSearch() {
      if (this.docuemntSearch == "") {
        this.getPeople()
      }
    }
  }
};
</script>
<style lang="scss">
.people-content {
  .buttons-container {
    border-bottom: 1px solid #e8dfdf;
    margin-bottom: 2px;
    padding-bottom: 10px;
    margin-left: 20px;
    margin-right: 20px;
    width: 90%;
  }
  .table-container {
    margin-top: 10px;
  }
}
</style>
