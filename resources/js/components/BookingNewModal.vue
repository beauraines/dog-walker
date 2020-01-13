<template>


<!-- template for the modal component -->
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
            <h3>Add a booking</h3>
          </div>

        <div class="modal-body">
            <div class="form-group row" v-if="user.type == 'App\\Staff'">
                <label for="client_select" class="col-md-4 col-form-label text-md-right">Select a client</label>
                <div class="col-md-6">
                    <select name="client_select" id="client" class="form-control" @change="onSelectClient" v-model="selectedClientId">
                        <option disabled value="" selected="selected">Please select a client</option>
                        <option v-for="(client, index) in clients"
                                :key="index"
                                :value="client.id">{{ client.name }}
                        </option>
                    </select>
                </div>
            </div>

            <form v-if="selectedClientId">
                <div class="form-group row">
                    <label for="date" class="col-md-4 col-form-label text-md-right">Date</label>

                    <div class="col-md-6">
                        <input id="date" type="date" class="form-control" name="date" required autocomplete="date" autofocus v-model="bookingDate">
                    </div>
                </div>

                    <div class="form-group row">
                        <label for="service_id" class="col-md-4 col-form-label text-md-right">Service</label>

                        <div class="col-md-6">
                            <select id="service_id" class="form-control" name="service_id" required autofocus v-model="selectedService">
                                <option disabled value="" selected="selected">Please select a service</option>
                                <option v-for="(service, index) in services"
                                        :key="index"
                                        :value="service.id">{{ service.description }}
                                </option>
                            </select>
                        </div>
                </div>
            </form>
        </div>

          <div class="modal-footer">
              <button class="modal-default-button btn btn-danger" @click="$emit('close')">Cancel </button>
              <button class="modal-default-button btn btn-primary" @click="postNewBooking()" :disabled="selectedService == null || bookingDate == null">
                Save
              </button>
          </div>
        </div>
      </div>
    </div>
  </transition>

</template>

<script>
export default {
     props: ['user','bookings'],
    mounted(){
        document.addEventListener("keydown", (e) => {
        if (e.keyCode == 27) {
            this.$emit('close');
        }
        });
        axios
            .get('api/client',{
        headers: {
            Authorization: 'Bearer ' + this.user.api_token
        }
            })
            .then(response => {
                this.clients = response.data.data
            })
            .catch(error => {
                console.log(error.response.data);
                this.errored = error.response.data
            })

        axios
            .get('api/service',{
        headers: {
            Authorization: 'Bearer ' + this.user.api_token
        }
            })
            .then(response => {
                this.services = response.data.data
            })
            .catch(error => {
                console.log(error.response.data);
                this.errored = error.response.data
            })

        this.isClientUser(this.user);
    },
    data(){
        return{
            clients: this.clients,
            services: this.services,
            selectedClientId: null,
            bookingDate: null,
            selectedService: null,
        }
    },
    methods: {
        isClientUser(user) {
            this.selectedClientId = (user.type == 'App\\Client') ? user.id : null;
        },
        onSelectClient(){
            console.log("Selected a client",this.selectedClientId);
        },
        postNewBooking() {
            axios
            .post('api/booking',{
                service_id: this.selectedService,
                date: this.bookingDate,
                user_id: this.selectedClientId
            },{
        headers: {
            Authorization: 'Bearer ' + this.user.api_token,
        }
            })
            .then(response => {
                this.$emit('newBooking',response.data.data)
                this.$emit('close');
            })
            .catch(error => {
                console.error(error.response.data);
            })
            .finally(() => {
                // this.loading = false
                // this.$emit('close');
            })
        }
    }
}
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 600px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>