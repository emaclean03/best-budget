<template>
  <div class="w-96 p-1 rounded-md bg-gray-100">
    <q-btn size="sm" @click="() => showNewTransaction = !showNewTransaction" color="blue">Add Transaction</q-btn>
  </div>

  <DialogModal :show="showNewTransaction" :max-width='sm'>
    <template #title>
      Add new transaction
      <div class="q-gutter-sm">
        <q-radio v-model="transaction_type" val="inflow" label="Inflow"/>
        <q-radio v-model="transaction_type" val="outflow" label="Outflow"/>
      </div>
    </template>

    <template #content>
      <q-input label="Payee" v-model="transaction_payee"/>
      <q-input label="Memo" v-model="transaction_memo"/>
      <q-select
          option-label="category_name"
          option-value="id"
          v-model="transaction_category"
          :options="categories" label="Category"/>
      <q-input mask="#.##"
               fill-mask="0"
               input-class="text-right" reverse-fill-mask label="Transaction Amount ($)"
               v-model="transaction_amount"/>
    </template>

    <template #footer>
      <q-btn color="blue" @click="handleAddTransaction">Add</q-btn>
      <q-btn @click="showNewTransaction = !showNewTransaction" color="red">Cancel</q-btn>
    </template>
  </DialogModal>
</template>

<script lang="ts" setup>
import DialogModal from "@/Components/DialogModal.vue";
import {computed, ref} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";

interface Props {
  account: {
    id: number,
    account_name: string,
  }
}

const props = defineProps<Props>();

const categories = computed(() => usePage().props.value.categories);
const showNewTransaction = ref(false);

const transaction_payee = ref(null);
const transaction_category = ref(null);
const transaction_memo = ref(null);
const transaction_amount = ref(null);
const transaction_type = ref('inflow');

const handleAddTransaction = () => {
  console.log(props.account);
  Inertia.post('/transaction/store', {
    transaction_type: transaction_type.value,
    transaction_payee: transaction_payee.value,
    transaction_category: transaction_category.value,
    transaction_memo: transaction_memo.value,
    transaction_amount: transaction_amount.value,
    account_id: props.account.id
  }, {
    onSuccess: () => {
      transaction_type: transaction_type.value;
      transaction_payee.value = null;
      transaction_category.value = null;
      transaction_memo.value = null;
      transaction_amount.value = null;
      showNewTransaction.value = !showNewTransaction
    }
  })
}


</script>
