<template>
  <AppLayout>
    <TransactionTable :transactions="transactions" :categories="categories"/>
  </AppLayout>
</template>

<script lang="ts" setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TransactionTable from "@/Components/Account/TransactionTable.vue";

interface Props{
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
