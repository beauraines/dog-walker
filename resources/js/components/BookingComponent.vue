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
        mounted() {
            console.log('Component mounted.');
            axios
                .get('api/booking',{
          headers: {
             Authorization: 'Bearer ' + '6ynCXouWnkY7h3mySl4D9OuCmya3Fu9tMkQekIJ5E6YnMtM005CSDyAlOo5Hm72jPJjuco7Z8CVaFksq'
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
            title: "Bookings",
            errored: false,
            loading: true,
            info: null,
        }
    }
    }
</script>
