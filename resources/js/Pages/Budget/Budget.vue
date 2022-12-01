<template>
  <AppLayout>
    <div>
    <BudgetTable
      :categories="budget.categories"/>
    </div>
  </AppLayout>
</template>

<script lang="ts" setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import BudgetTable from "@/Components/Budget/BudgetTable.vue";

interface Props{
  budget:{
    budget_name: string,
    categories:[{
      category_name: string,
    }],
    account:[{
      account_name: string,
      cleared_balance: number,
      uncleared_balance: number,
      working_balance: number,
    }],
    transaction:[{
      payee:string,
      memo: string,
      outflow:number,
      inflow:number,
    }]
  }
}

const props = defineProps<Props>();

</script>
