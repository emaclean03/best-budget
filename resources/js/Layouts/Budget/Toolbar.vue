<template>
<div class="w-96 p-1 rounded-md bg-gray-100">
  <q-btn size="sm" @click="handleAddCategory" color="blue">Add Category</q-btn>
</div>
</template>

<script lang="ts" setup>
import {computed} from "vue";
import { usePage } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
//Coming from HandleInertiaRequests.phpa
const budget = computed(() => usePage().props.budget);

const handleAddCategory = () => {
  let categoryPrompt = prompt('Category Name');
  if(!categoryPrompt) return false;

  router.post(`/category/${budget.value.id}/store`, {categoryName:categoryPrompt})
}

</script>

