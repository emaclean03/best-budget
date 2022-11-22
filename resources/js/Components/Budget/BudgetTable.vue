<template>
  <q-table
      :rows="categories"
      class="h-full"
      :columns="columns"
      row-key="name"
      :filter="filter"
      virtual-scroll
      :rows-per-page-options="[20]"
  >
    <template v-slot:top-left>
      This will be the nav bar
    </template>
    <template v-slot:top-right>
      <q-input dense debounce="150" v-model="filter" placeholder="Search name or email">
        <template v-slot:append>
          <q-icon name="search" />
        </template>
      </q-input>
    </template>
    <template v-slot:body="props">
      <q-tr :props="props">
        <q-td key="category_name" :props="props">
          {{ props.row.category_name }}
          <q-popup-edit @save="(val) => handleSaveCategoryName(val, props.row.id)" title="Update Category"
                        v-model="props.row.category_name" buttons v-slot="scope">
            <q-input v-model="scope.value" dense autofocus/>
          </q-popup-edit>
        </q-td>
      </q-tr>
    </template>
  </q-table>
</template>

<script lang="ts" setup>
import {ref} from "vue";

interface Props{
  categories:[{
    id:number,
    category_name:string,
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
];

const handleSaveCategoryName = (value: string, id: number) =>{
  console.log('saving...');
}
</script>
