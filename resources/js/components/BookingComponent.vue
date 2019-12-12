<template>
    <div class="card">
        <div class="card-header" style="text-transform: capitalize;">{{title}}</div>

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
        props: ['user','scope'],
        mounted() {
            console.log('Component mounted.')
            var requestScope = ''
            switch (this.scope) {
                case 'future':
                    this.title = "Future Bookings" ;
                    requestScope = 'scope[' + this.scope + ']&'
                    break;
                case 'today':
                    this.title = "Today's Bookings - " + moment().format("MMM Do, YYYY");
                    requestScope = 'scope[' + this.scope + ']&'
                    break;
                case 'history':
                    this.title = "Previous Bookings"
                    requestScope = 'scope[' + this.scope + ']&'
                    break;
                default:
                    this.title = "Bookings"
                    break;
            }
            axios
                .get('api/booking?' + requestScope + 'with=service,client',{
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
            title: this.title,
            errored: false,
            loading: true,
            info: null,
        }
    }
    }
</script>
