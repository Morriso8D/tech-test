<template>
    <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <span class="text-gray-500 sm:text-sm">
            {{ getCurrencySymbol }}
        </span>
        </div>
        <input :id="id" :value="currencyValue" @input="$emit('update:currencyValue', $event.target.value)" type="number" step="any" class="focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00" required>
        <div class="absolute inset-y-0 right-0 flex items-center">
        <label for="currency" class="sr-only">Currency</label>
        <select :value="currencyType" @input="$emit('update:currencyType', $event.target.value)" id="currency" name="currency" class="focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-md">
            <option value="GBP">GBP</option>
            <option value="EUR">EUR</option>
            <option value="USD">USD</option>
        </select>
        </div>
    </div>
</template>
<script>
export default {
    name: 'CurrencyInput',
    props: {
        currencyValue: {
            type: String,
            required: true,
        },
        currencyType: {
            type: String,
            required: true,
            default: 'GBP'
        },
        id: {
            type: String,
            required: true
        }
    },
    computed: {
        getCurrencySymbol(){

            let symbol

            switch(this.currencyType){
                case 'USD' :
                    symbol = '$'
                    break
                case 'EUR' :
                    symbol = '€'
                    break
                default :
                    symbol = '£'
            }

            return symbol
        }
    }
}
</script>
<style lang="css" scoped>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
-webkit-appearance: none;
margin: 0;
}

/* Firefox */
input[type=number] {
-moz-appearance: textfield;
}
</style>