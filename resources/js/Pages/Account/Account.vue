<template>
  <AppLayout>
    <TransactionTable :transactions="transactions" :categories="categories" :account="account"/>
  </AppLayout>
</template>

<script lang="ts" setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TransactionTable from "@/Components/Account/TransactionTable.vue";

interface Props{
  account:{
    id: number,
    account_name: string,
  }
  transactions:[{
    payee: string,
    memo:string,
    outflow:number,
    inflow:number,
    category:[{
      category_name: string,
    }]
  }],
  categories:[{
    category_name:string,
    id:number,
  }]
}

defineProps<Props>()
</script>
