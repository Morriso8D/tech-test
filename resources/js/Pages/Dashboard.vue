<template>
    <div>
        <Head title="Dashboard" />

        <BreezeAuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard
                </h2>
            </template>
            <div class="py-12">
                <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                    <Message v-if="message.show" icon="pi pi-check" severity="success">{{ message.content }}</Message>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="container px-4 justify-center items-center flex">
                            <form v-if="!copyAndPayForm.show" @submit.prevent="submit" class="w-full h-96">
                                <div class="mt-4 flex justify-between">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Payment Details</h3>
                                    <BreezeButton :disabled="form.processing">
                                        Submit
                                    </BreezeButton>
                                </div>
                                <BreezeValidationErrors class="mt-4"/>
                                <div class="w-full mt-4">
                                    <BreezeLabel for="amount" value="Amount"/>
                                    <CurrencyInput v-model:currencyValue="form.amount" v-model:currencyType="form.currency" id="amount"/>
                                </div>
                                <div class="w-full mt-4 ">
                                    <BreezeLabel for="reference" value="Reference"/>
                                    <BreezeInput id="reference" type="text" class="mt-1 block w-full" v-model="form.reference" required/>
                                </div>
                            </form>

                            <div v-if="copyAndPayForm.show" class="w-full h-96">
                                <div class="mt-4 flex justify-between">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Card Details</h3>
                                    <BreezeButton :disabled="form.processing" @click="initCopyAndPayForm">
                                    <i class="pi pi-angle-left"></i>
                                        Back
                                    </BreezeButton>
                                </div>
                                <CopyAndPayForm :checkoutId="copyAndPayForm.checkoutId"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </BreezeAuthenticatedLayout>
    </div>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeButton from '@/Components/Button.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import CurrencyInput from '@/Components/CurrencyInput.vue'
import CopyAndPayForm from '@/Components/CopyAndPayForm.vue'
import Message from 'primevue/message'

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        BreezeInput,
        BreezeLabel,
        BreezeButton,
        BreezeValidationErrors,
        CurrencyInput,
        CopyAndPayForm,
        Message
    },
    data() {
        return {
            form: this.$inertia.form({
                reference: '',
                amount: '',
                currency: 'GBP'
            }),
            copyAndPayForm: {},
            message: {
                show: false,
                content: ''
            }
        }
    },
    mounted() {
        this.initCopyAndPayForm()
       if(this.$page.props.flash.transaction) this.showMessage(this.$page.props.flash.transaction)
    },
    methods: {
        submit() {
            this.form.post(this.route('transaction.create'), {
                preserveScroll: true,
                onSuccess: (data) => {
                    this.copyAndPayForm.checkoutId = this.$page.props.flash.checkoutId
                    this.copyAndPayForm.show = true
                },
            })
        },
        showMessage(transaction) {
            const { result_code, result_description } = transaction
            this.message.content = `Payment Successful!   code: ${result_code} description: ${result_description}`
            this.message.show = true
        },
        initCopyAndPayForm() {
            this.copyAndPayForm = {
                show: false,
                checkoutId: ''
            }
        }
    }
}
</script>
