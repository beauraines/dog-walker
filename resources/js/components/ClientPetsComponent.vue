<template>
    <div class="card" style="margin-bottom: 12px;">
        <div class="card-header">{{title}}</div>
        <div class="card-body">
            <pet-display v-for="pet in pets" :key="pet.id" :pet="pet"></pet-display>
        </div>
    </div>
</template>

<script>
export default {
    props: ['title'],
     mounted() {
        axios
            .get('api/pet?' + 'with=petType')
            .then(response => {
                this.pets = response.data.data;
            })
            .catch(error => {
                console.log(error.response.data);
                this.errored = error.response.data
            })
            .finally(() => this.loading = false)
    },
    data() {
        return{
            pets: this.pets,
        }
    }

}
</script>

<style>

</style>
