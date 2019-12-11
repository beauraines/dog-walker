<template>
    <div class="card">
        <div class="card-header">{{title}}</div>

        <div class="card-body">
            <span v-if="errored">There was an error.</span>
            <span v-if="loading">Data is loading</span>

            <p v-for="(grouped, date) in info">{{date}}
                <ol>
                    <li v-for="booking in grouped" >
                        {{ booking.client.name}} - {{ booking.service.name}}
                    </li>

                </ol>
            </p>

        </div>
    </div>
</template>

<script>
    export default {
         props: ['user'],
        mounted() {
            console.log('Component mounted.')
            axios
                .get('api/booking',{
          headers: {
             Authorization: 'Bearer ' + this.user.api_token
           }
                })
                .then(response => {
                    this.info = _.groupBy(response.data,'date')
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                    this.info=error
                })
                .finally(() => this.loading = false)
        },
    data() {
        return{
            title: "Future Bookings (vue)",
            errored: false,
            loading: true,
            info: null,
        }
    }
    }
</script>
