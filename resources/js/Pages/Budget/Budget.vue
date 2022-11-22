<template>
  <AppLayout>
    {{budget.budget_name}}
  </AppLayout>
</template>

<script lang="ts" setup>
import AppLayout from "@/Layouts/AppLayout.vue";

interface Props{
  budget:{
    budget_name: string,
  }
}

const props = defineProps<Props>()
</script>
