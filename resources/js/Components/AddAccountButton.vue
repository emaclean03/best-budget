<template>
  <q-btn color="blue" @click="showAccountModal = !showAccountModal"
         class="flex items-center p-2 text-base  font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
    <svg aria-hidden="true"
         class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white dark:text-gray-400"
         focusable="false" data-prefix="fas" data-icon="gem" role="img" xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 512 512">
      <path fill="currentColor"
            d="M378.7 32H133.3L256 182.7L378.7 32zM512 192l-107.4-141.3L289.6 192H512zM107.4 50.67L0 192h222.4L107.4 50.67zM244.3 474.9C247.3 478.2 251.6 480 256 480s8.653-1.828 11.67-5.062L510.6 224H1.365L244.3 474.9z"></path>
    </svg>
    <span class="ml-4 text-sm">Add Account</span>
  </q-btn>


  <!--Modal-->
  <DialogModal :show="showAccountModal" :max-width='sm'>
    <template #title>
      Add new Account
      <div class="q-gutter-sm">
        <q-radio v-model="account_type" val="Checking" label="Checking Account"/>
        <q-radio v-model="account_type" val="Saving" label="Saving Account"/>
      </div>
    </template>

    <template #content>
      <q-input label="Account Name" v-model="account_name"/>
      <q-input mask="#.##"
               fill-mask="0"
               input-class="text-right" reverse-fill-mask label="Transaction Amount ($)"
               v-model="account_starting_balance"/>
    </template>

    <template #footer>
      <q-btn color="blue" @click="handleAddAccount">Add</q-btn>
      <q-btn @click="showAccountModal = !showAccountModal" color="red">Cancel</q-btn>
    </template>
  </DialogModal>
</template>

<script lang="ts" setup>
import {ref} from "vue";
import {Inertia} from "@inertiajs/inertia";
import DialogModal from "@/Components/DialogModal.vue";


const showAccountModal = ref(false);
const account_type = ref(null);
const account_name = ref(null);
const account_starting_balance = ref(0);

const handleAddAccount = () => {
  Inertia.post('/account/store', {
    accountName: account_name.value,
    accountType: account_type.value,
    startingBalance: account_starting_balance.value
  }, {
    onSuccess: () => {
      account_type.value = null;
      account_name.value = null;
      account_starting_balance.value = 0;
      showAccountModal.value = !showAccountModal
    }
  });
}

</script>

