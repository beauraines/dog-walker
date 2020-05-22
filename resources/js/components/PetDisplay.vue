<template>
    <p>
    {{ pet.name}} <i :class="icon"></i>
    <br>
    <!-- Special Instructions: {{ pet.special_instructions}} -->
    </p>
</template>

<script>
export default {
    props: ['pet'],
    mounted() {
        this.icon = "fas fa-"+this.pet.pet_type.pet_type;
    },
    data() {
        return{
            icon: this.icon,
        }
    }
}
</script>

<style>

</style>
