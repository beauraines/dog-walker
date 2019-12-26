<template>
    <div class="card" style="margin-bottom: 12px;">
        <div class="card-header">Payments</div>
        <div class="card-body">
            <a v-bind:href="'https://www.paypal.me/'+payee" target="_blank" referrerpolicy="no-referrer">Make a payment with Paypal <i class="fab fa-paypal"></i></a>
            <span style="font-size: small">opens in a new tab</span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['payee'],
}
</script>

<style>

</style>
