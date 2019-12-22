<template>
    <div class="card" style="margin-bottom: 12px;">
        <div class="card-header" style="text-transform: capitalize;">{{title}}</div>

        <div class="card-body">
            <span v-if="errored" class="text-danger">There was an error. {{errored.message}}</span>
            <span v-if="loading" class="text-info">Data is loading <i class="fas fa-spin  fa-circle-notch"></i></span>

            <!-- TODO only display this if grouped.length > 0 -->
            <!-- Probably not, because in the long run, we'll display "canceled" bookings differently -->
            <p v-for="(grouped, date) in info">{{date}}
                <ol>
                    <li v-for="booking in grouped" v-bind:class="{'text-muted': booking.deleted_at}">
                        <span v-if="user.type == 'App\\Staff' ">{{ booking.client.name}}  -</span> {{ listPets(booking.client.pets)}} - <span v-if="booking.deleted_at">cancelled</span> {{ booking.service.name}}
                        <i v-if="scope == 'future' && !booking.deleted_at" class="far fa-trash-alt float-right" @click="cancelBooking(grouped,booking)"></i>
                        <i v-if="scope == 'future' && !booking.deleted_at" class="far fa-edit float-right" @click="editBooking(booking)"></i>
                    </li>

                </ol>
            </p>

            <a v-if='scope == "future" && user.type == "App\\Client"' href="/booking/create" class='float-right'>New Booking</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user','scope'],
        mounted() {
            console.log('Component mounted.')
            var requestScope = ''
            switch (this.scope) {
                case 'future':
                    this.title = "Future Bookings" ;
                    requestScope = 'scope[' + this.scope + ']&scope[includeCancelled]&'
                    break;
                case 'today':
                    this.title = "Today's Bookings - " + moment().format("MMM Do, YYYY");
                    requestScope = 'scope[' + this.scope + ']&'
                    break;
                case 'history':
                    this.title = "Previous Bookings"
                    requestScope = 'scope[' + this.scope + ']&scope[includeCancelled]&'
                    break;
                default:
                    requestScope = 'scope[includeCancelled]&'
                    this.title = "Bookings"
                    break;
            }
            axios
                .get('api/booking?' + requestScope  + 'with=service,client.pets',{
          headers: {
             Authorization: 'Bearer ' + this.user.api_token
           }
                })
                .then(response => {
                    this.info = _.groupBy(response.data.data,'date')
                })
                .catch(error => {
                    console.log(error.response.data);
                    this.errored = error.response.data
                })
                .finally(() => this.loading = false)


        },
    data() {
        return{
            title: this.title,
            errored: false,
            loading: true,
            info: null,
        }
    },
    methods: {
        editBooking(booking) {
            window.open("/booking/"+booking.id+"/edit", "_blank");
        },
        cancelBooking(grouped,booking) {
            if(confirm('Do you really want to cancel this booking?')){
                console.info("Deleting booking");
                // TODO add confirmation
                this.loading = true;
                axios
                    .delete('api/booking/' + booking.id,{
                headers: {
                Authorization: 'Bearer ' + this.user.api_token
            }
                    })
                    .then(response => {
                        console.log(response.data);
                        // // TODO make a convenience function for this
                        // let index = grouped.indexOf(booking)
                        // grouped.splice(index, 1);
                        let index = grouped.indexOf(booking)
                        Vue.set(grouped[index],'deleted_at',response.data.data.deleted_at)
                    })
                    .catch(error => {
                        this.errored = error.response.data
                    })
                    .finally(() => this.loading = false
            )}
        },
        listPets(petsArray) {
            console.log(petsArray)
            return petsArray.map(pet => pet.name).join(",");
        }
    }
    }
</script>
