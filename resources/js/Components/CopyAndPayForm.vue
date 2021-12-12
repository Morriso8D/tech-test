<template>
    <form :action="route('transaction.results')" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>
</template>
<script>
export default {
    name: 'CopyAndPayForm',
    props: {
        checkoutId: {
            required: true,
            type: String
        }
    },
    mounted() {
        let copyAndPayScript = document.createElement('script')
        copyAndPayScript.setAttribute('src', `https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId=${this.checkoutId}`)
        document.head.appendChild(copyAndPayScript)
    },
    unmounted() {

    }
}
</script>