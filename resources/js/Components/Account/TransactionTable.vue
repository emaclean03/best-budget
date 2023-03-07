<template>
  <q-table
      :rows="transactions"
      class="h-full"
      :columns="columns"
      :filter="filter"
      virtual-scroll
      dense
      :rows-per-page-options="[17]"
  >
    <template v-slot:top-left>
     <toolbar :account="account"/>
    </template>
    <template v-slot:top-right>
      <q-input dense debounce="150" v-model="filter" placeholder="Search name or email">
        <template v-slot:append>
          <q-icon name="search"/>
        </template>
      </q-input>
    </template>
    <template v-slot:body="props">
      <q-tr :props="props">
        <q-td key="created_at" :props="props">
          {{ props.row.created_at }}
        </q-td>
        <q-td key="payee" :props="props">
          {{ props.row.payee }}
          <q-popup-edit @save="(val) => handleSavePayee(val, props.row.id)" title="Update Payee"
                        v-model="props.row.payee" buttons v-slot="scope">
            <q-input v-model="scope.value" dense autofocus/>
          </q-popup-edit>
        </q-td>
        <q-td key="Category"  class="w-1/6" :props="props">
          <q-select
              option-label="category_name"
              option-value="id"
              filled
              dense
              @update:model-value="val => handleUpdate(val, props.row.id)"
              :key="categories"
              :options="categories"
              v-model="selectedCategory"
              :display-value="`${props.row.category.category_name ? props.row.category.category_name : ''}`"
              label="Category"/>
        </q-td>

        <q-td key="memo" :props="props">
          {{ props.row.memo }}
          <q-popup-edit @save="(val) => handleSaveMemo(val, props.row.id)" title="Update Memo"
                        v-model="props.row.memo" buttons v-slot="scope">
            <q-input v-model="scope.value" dense autofocus/>
          </q-popup-edit>
        </q-td>
        <q-td key="outflow" :props="props">
          {{ props.row.outflow.formatted }}
          <q-popup-edit @save="(val) => handleSaveOutflow(val, props.row.id)" title="Update Outflow"
                        v-model="props.row.outflow.formatted" buttons v-slot="scope">
            <q-input v-model="scope.value" dense autofocus/>
          </q-popup-edit>
        </q-td>
        <q-td key="inflow" :props="props">
          {{ props.row.inflow.formatted }}
          <q-popup-edit @save="(val) => handleSaveInflow(val, props.row.id)" title="Update Inflow"
                        v-model="props.row.inflow.formatted" buttons v-slot="scope">
            <q-input v-model="scope.value" dense autofocus/>
          </q-popup-edit>
        </q-td>
      </q-tr>
    </template>
  </q-table>
</template>

<script lang="ts" setup>
import {ref, watch} from "vue";
import { router } from '@inertiajs/vue3'
import Toolbar from "@/Layouts/Account/Toolbar.vue";

interface Props {
  account:{
    id: number,
    account_name:string,
  }
  transactions: [{
    payee: string,
    memo: string,
    outflow: number,
    inflow: number,
    created_at: string,
    category: [{
      category_name: string,
    }]
  }],
  categories:[{
    id:number,
    category_name:string,
  }]
}

const props = defineProps<Props>();
const filter = ref(null);

const selectedCategory = ref(null);


const columns = [
  {
    name: 'created_at',
    required: true,
    label: 'Date',
    align: 'left',
    field: (row: { created_at: string; }) => row.created_at,
    sortable: true
  },
  {
    name: 'payee',
    required: true,
    label: 'Payee',
    align: 'left',
    field: (row: { payee: string; }) => row.payee,
    sortable: true
  },
  {
    name: 'Category',
    required: true,
    label: 'Category',
    align: 'left',
    field: (row: { category: { category_name: string }; }) => row.category.category_name,
    sortable: true
  },
  {
    name: 'memo',
    required: true,
    label: 'Memo',
    align: 'left',
    field: (row: { memo: string; }) => row.memo,
    sortable: true
  },
  {
    name: 'outflow',
    required: true,
    label: 'Outflow',
    align: 'left',
    field: (row: { outflow: number; }) => row.outflow,
    sortable: true
  },
  {
    name: 'inflow',
    required: true,
    label: 'Inflow',
    align: 'left',
    field: (row: { inflow: number; }) => row.inflow,
    sortable: true
  },
];

const handleSavePayee = (value: string, id: number) =>{
  router.patch(`/transaction/${id}/update`, {payee: value})
}

const handleUpdate = (value: { id: number }, transaction: {id:number,}) => {
  router.patch(`/transaction/${transaction}/update`, {category: value.id})
}


const handleSaveMemo = (value: string, id: number) =>{
  router.patch(`/transaction/${id}/update`, {memo: value})
}

const handleSaveInflow = (value: number, id:number) => {
  router.patch(`/transaction/${id}/update`, {inflow: value})
}
const handleSaveOutflow = (value: number, id:number) => {
  console.log(value);
  router.patch(`/transaction/${id}/update`, {outflow: value})
}


</script>
