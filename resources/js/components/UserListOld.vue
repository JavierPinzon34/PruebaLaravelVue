<template>
  <div class="container-fluid users-content">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header"><h4 class="mb-0">Users</h4></div>
          <div class="card-body">
            <div class="buttons-container">
              <button
                type="button"
                class="btn btn-success"
                data-toggle="modal"
                data-target="#userModal"
                @click="showModal()"
              >
                New User
              </button>
            </div>
            <!-- Tabla INICIO -->
            <div class="table-container">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in users.data" :key="index">
                    <th scope="row">{{ item.id }}</th>
                    <td>{{ item.name }}</td>
                    <td>{{ item.email }}</td>
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
                    :data="users"
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
            <!-- Formulario INICIO -->
            <form @submit.prevent="save()">
              <!-- Nombre INICIO -->
              <div class="form-group">
                <label for="name">Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="name"
                  v-model="form.name"
                  required
                />
              </div>
              <!-- Nombre FIN -->
              <!-- E-mail INICIO -->
              <div class="form-group">
                <label for="email">Email address</label>
                <input
                  type="email"
                  class="form-control"
                  :class="{
                    'is-invalid': errors.email,
                  }"
                  id="email"
                  v-model="form.email"
                  required
                />
                <div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
              </div>
              <!-- E-mail FIN -->
              <!-- Password INICIO -->
              <div class="form-group">
                <label for="password">Password</label>
                <input
                  type="password"
                  class="form-control"
                  id="password"
                  v-model="form.password"
                  :required="event"
                />
              </div>
              <!-- Password FIN -->
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
      users: {},
      currentPage: 1,
      title: "",
      event: true,
      form: {
        id: null,
        name: null,
        email: null,
        password: null,
      },
      errors: {},
    };
  },
  created() {
    this.getUsers();
  },
  methods: {
    showModal(item) {
      //Recibo la información si es nuevo o editar
      if (item) {
        this.title = "Editar " + item.name;
        this.event = false;
        this.form.id = item.id;
        this.form.name = item.name;
        this.form.email = item.email;
      } else {
        this.title = "Nuevo Usuario";
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
        .get(`users?page=${changePage}`)
        .then((res) => {
          this.users = res.data;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    save() {
      let me = this;
      if (this.event) {
        console.log("guardar");
        axios
          .post("users", me.form)
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
            this.getUsers();
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
          .put(`users/${me.form.id}`, me.form)
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
            this.getUsers();
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
              .delete(`users/${id}`)
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
                this.getUsers();
              })
              .catch((err) => {
                console.error(err);
              });
          }
        }
      })
    },
    getUsers() {
      axios
        .get("users")
        .then((res) => {
          this.users = res.data;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    clearData() {
      this.form.id = null;
      this.form.name = null;
      this.form.email = null;
      this.form.password = null;
      this.errors = {};
    },
  },
};
</script>
<style lang="scss">
.users-content {
  .buttons-container {
    border-bottom: 1px solid #e8dfdf;
    margin-bottom: 2px;
    padding-bottom: 10px;
  }
  .table-container {
    margin-top: 10px;
  }
}
</style>
