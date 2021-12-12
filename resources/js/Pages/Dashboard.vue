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
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="md:grid md:grid-cols-2 md:gap-3 px-4">
                            <form @submit.prevent="submit" class="md:col-span-1">
                                <div class="mt-4">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Payment Details</h3>
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
                                <div class="flex items-center justify-start my-4">
                                    <BreezeButton :disabled="form.processing">
                                        Submit
                                    </BreezeButton>
                                </div>
                            </form>

                            <div class="md:col-span-1">
                                <div class="mt-4">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Card Details</h3>
                                </div>
                                <CopyAndPayForm v-if="copyAndPayForm.show" :checkoutId="copyAndPayForm.checkoutId"/>
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

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        BreezeInput,
        BreezeLabel,
        BreezeButton,
        BreezeValidationErrors,
        CurrencyInput,
        CopyAndPayForm
    },
    data() {
        return {
            form: this.$inertia.form({
                reference: '',
                amount: '',
                currency: 'GBP'
            }),
            copyAndPayForm: {
                show: false,
                checkoutId: ''
            }
        }
    },
    mounted() {
        console.log(this.$page.props.flash.transaction)
    },
    methods: {
        submit() {
            this.form.post(this.route('transaction.create'), {
                preserveScroll: true,
                onSuccess: (data) => {
                    this.copyAndPayForm.checkoutId = this.$page.props.flash.checkoutId
                    this.copyAndPayForm.show = true
                    // this.form.reset()
                },
            })
        }
    }
}
</script>
