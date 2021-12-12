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
    data() {
        return {
            copyAndPayScript: null
        }
    },
    mounted() {
        this.copyAndPayScript = document.createElement('script')
        this.copyAndPayScript.setAttribute('src', `https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId=${this.checkoutId}`)
        document.head.appendChild(this.copyAndPayScript)
    },
    beforeUnmount() {
        this.copyAndPayScript.parentNode.removeChild(this.copyAndPayScript)
        if (window.wpwl !== undefined && window.wpwl.unload !== undefined) {
            window.wpwl.unload()
            let scripts = document.querySelectorAll('script')
            scripts.forEach((script) => {
                
                if(script.src.indexOf('static.min.js') !== -1) {
                    document.head.removeChild(script)
                }
            
            })
        }
    }
}
</script>