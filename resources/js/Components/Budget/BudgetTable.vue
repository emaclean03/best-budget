<template>
  <q-table
      :rows="categories"
      class="h-full"
      :columns="columns"
      row-key="name"
      :filter="filter"
      virtual-scroll
      hide-bottom
      :rows-per-page-options="[20]"
  >
    <template v-slot:top-left>
    <Toolbar/>
    </template>
    <template v-slot:top-right>
      <q-input dense debounce="150" v-model="filter" placeholder="Search Category">
        <template v-slot:append>
          <q-icon name="search" />
        </template>
      </q-input>
    </template>
    <template v-slot:body="props">
      <q-tr v-if="props.row.category_name !== 'Assign Income'" :props="props">
        <q-td key="category_name" :props="props">
          {{ props.row.category_name }}
          <q-popup-edit @save="(val) => handleSaveCategoryName(val, props.row.id)" title="Update Category"
                        v-model="props.row.category_name" buttons v-slot="scope">
            <q-input v-model="scope.value" dense autofocus/>
            <q-btn @click="handleDeleteCategory(props.row.id)" class="mt-2 ml-16">Delete</q-btn>
          </q-popup-edit>
        </q-td>
        <q-td key="category_assigned" :props="props">
          {{ props.row.category_assigned.formatted }}
          <q-popup-edit @save="(val) => handleSaveCategoryAssigned(val, props.row.id)" title="Update Assigned"
                        v-model="props.row.category_assigned.formatted" buttons v-slot="scope">
            <q-input mask="#.##"
                     fill-mask="0"
                     dense autofocus
                     input-class="text-right" reverse-fill-mask
                     v-model="scope.value"/>
          </q-popup-edit>
        </q-td>
        <q-td key="category_activity" :props="props">
          {{ props.row.category_activity.formatted }}
        </q-td>
        <q-td key="category_available" :props="props">
          <q-badge  :color="props.row.category_available.amount < 0.00 ? 'red' : 'green'" :text-color="'white'">
          {{ props.row.category_available.formatted }}
          </q-badge>
        </q-td>
      </q-tr>
    </template>
  </q-table>
</template>

<script lang="ts" setup>
import {ref} from "vue";
import { router } from '@inertiajs/vue3'
import Toolbar from "@/Layouts/Budget/Toolbar.vue";

interface Props{
  categories:[{
    id:number,
    category_name:string,
    category_assigned: {
      formatted: number,
      currency:string,
      amount: number,
    },
    category_activity:  {
      formatted: number,
      currency:string,
      amount: number,
    },
    category_available:  {
      formatted: number,
      currency:string,
      amount: number,
    },
  }]
}

const props = defineProps<Props>();
const filter = ref('');



const columns = [
  {
    name: 'category_name',
    required: true,
    label: 'Category',
    align: 'left',
    field: (row: { category_name: string; }) => row.category_name,
    sortable: true
  },
  {
    name: 'category_assigned',
    required: true,
    label: 'Assigned',
    align: 'left',
    field: (row: { category_assigned: string; }) => row.category_assigned,
    sortable: true
  },
  {
    name: 'category_activity',
    required: true,
    label: 'Activity',
    align: 'left',
    field: (row: { category_activity: string; }) => row.category_activity,
    sortable: true
  },
  {
    name: 'category_available',
    required: true,
    label: 'Available',
    align: 'left',
    field: (row: { category_available: string; }) => row.category_available,
    sortable: true
  },
];

const handleSaveCategoryName = (value: string, id: number) =>{
  console.log('saving...');
}

const handleDeleteCategory = (id: number) =>{
  router.post(`/category/${id}/destroy`, {}, {
    onSuccess: () => {

    }
  })
}



const handleSaveCategoryAssigned = (value: string, id: number) =>{
  router.post(`/category/${id}/updateAssigned`, {amount: value})
}
</script>
