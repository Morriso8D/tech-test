<template>
    <div>
        <Head title="History" />

        <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    History
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="container" style="height: calc(100vh - 234px)">
                        <DataTable 
                            :value="transactions" 
                            :paginator="true" 
                            class="p-datatable-customers" 
                            :rows="20"
                            dataKey="id" 
                            v-model:filters="filters" 
                            responsiveLayout="scroll"
                            scrollHeight="flex"
                            :scrollable="true"
                        >
                            <template #header>
                                <div class="flex justify-between">
                                    <Button type="button" icon="pi pi-filter-slash" label="Clear" class="p-button-outlined" @click="initFilters()"/>
                                    <span class="p-input-icon-left">
                                        <i class="pi pi-search"/>
                                        <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                                    </span>
                                </div>
                            </template>
                            <Column field="amount" header="Amount">
                                <template #body="slotProps">
                                    {{ parseFloat(slotProps.data.amount).toFixed(2) }}
                                </template>
                            </Column>
                            <Column field="currency" header="Currency"/>
                            <Column field="reference" header="Reference"/>
                            <Column field="created_at" header="Created at">
                                <template #body="slotProps">
                                    {{ printTime(slotProps.data.created_at) }}
                                </template>
                            </Column>
                        </DataTable>
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
import DataTable from 'primevue/datatable'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import Column from 'primevue/column'
import { FilterMatchMode } from 'primevue/api';

export default {
    props: {
        transactions: {
            type: Array,
        }
    },
    name: 'History',
    components: {
        BreezeAuthenticatedLayout,
        Head,
        DataTable,
        Button,
        InputText,
        Column,
    },
    data() {
        return {
            filters: {},
        }
    },
    mounted() {
        console.log(this.transactions)
    },
    methods: {
        initFilters() {
            this.filters = {
                'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
            }
        },
        printTime(date) {
            const dateJs = new Date(date)
            return `${dateJs.toLocaleDateString()} ${dateJs.toLocaleTimeString()}`
        }
    },
    created() {
        this.initFilters()
    }
}
</script>