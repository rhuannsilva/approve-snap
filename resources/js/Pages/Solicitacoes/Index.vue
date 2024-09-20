<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ModalCreate from './_partials/ModalCreate.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, useTemplateRef, onBeforeMount} from 'vue';

const requests = ref([]);
const showModal = ref(false);
let images = ref<Array<{ name: string; url: string }>>([]);

onBeforeMount(() => {
    getRequests()
})

const selectedPage = ref('Pendente');

const changePage = (page: string) => {
  selectedPage.value = page;
};

const decodeStatus = (status: number) : string | undefined => {

  const data : { [key: number]: string } = {
    0 : 'Pendente',
    1 : 'Aprovado',
    2 : 'Recusado'
  }

  return data[status];
}

const filesSelected = (file: Array<{ name: string; url: string }>) => {
  images.value = file;
}

const getRequests = () => {

  const url = window.location.origin;

  axios.get(url + '/api/')
  .then(response => {
      requests.value = response.data.data
  })
}

</script>

<template>
    <AuthenticatedLayout>
        <div class="w-full container m-auto">
            <div class="px-40 flex flex-1 justify-center py-5">
          <div class="flex flex-col flex-1">
            <div class="flex flex-wrap justify-between p-4">
                <p class="text-[#0e121b] text-[32px] font-bold leading-tight">Lista de Solicitações</p>
                <button @click="() => {showModal = true}" class="p-3 bg-[#E8EBF2] rounded-md">
                    Upload
                </button>
            </div>
            <div class="pb-3">
              <div class="flex border-b border-[#d0d7e7] px-4 gap-8">
                <a @click="changePage('Pendente')" :class="(selectedPage == 'Pendente') ? 'border-b-[2px] border-b-[#195de6] text-[#0e121b]' : 'text-[#4e6797] border-b-transparent'" class="flex flex-col items-center justify-center pb-[13px] pt-4" href="#">
                  <p class="text-sm font-bold leading-normal tracking-[0.015em]">Pendente</p>
                </a>
                <a @click="changePage('Aprovados')" :class="(selectedPage == 'Aprovados') ? 'border-b-[3px] border-b-[#195de6] text-[#0e121b]' : 'text-[#4e6797] border-b-transparent'" class="flex flex-col items-center justify-center border-b-[3px] pb-[13px] pt-4" href="#">
                  <p class="text-sm font-bold leading-normal tracking-[0.015em]">Aprovados</p>
                </a>
                <a @click="changePage('Recusados')" :class="(selectedPage == 'Recusados') ? 'border-b-[3px] border-b-[#195de6] text-[#0e121b]' : 'text-[#4e6797] border-b-transparent'" class="flex flex-col items-center justify-center border-b-[3px] pb-[13px] pt-4" href="#">
                  <p class=" text-sm font-bold leading-normal tracking-[0.015em]">Recusados</p>
                </a>
                <a @click="changePage('Todos')" :class="(selectedPage == 'Todos') ? 'border-b-[3px] border-b-[#195de6] text-[#0e121b]' : 'text-[#4e6797] border-b-transparent'" class="flex flex-col items-center justify-center pb-[13px] pt-4" href="#">
                  <p class="text-sm font-bold leading-normal tracking-[0.015em]">Todos</p>
                </a>
              </div>
            </div>
            <div class="px-4 py-3">
              <div class="flex overflow-hidden rounded-xl border border-[#d0d7e7] bg-[#f8f9fc]">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-[#f8f9fc]">
                      <th class="px-4 py-3 text-left text-[#0e121b] text-sm font-medium leading-normal">Id</th>
                      <th class=" px-4 py-3 text-left text-[#0e121b] w-[400px] text-sm font-medium leading-normal">Nome</th>
                      <th class="px-4 py-3 text-left text-[#0e121b] w-60 text-sm font-medium leading-normal">Status</th>
                      <th class="px-4 py-3 text-left text-[#0e121b] w-[400px] text-sm font-medium leading-normal"> Descrição </th>
                      <th class="px-4 py-3 text-left text-[#0e121b] w-[400px] text-sm font-medium leading-normal"> Data Criação </th>
                      <th class="px-4 py-3 text-left text-[#0e121b] w-60 text-sm font-medium leading-normal"
                      ></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in requests" class="border-t border-t-[#d0d7e7]">
                        <td class="h-[72px] px-4 py-2 w-[400px] text-[#4e6797] text-sm font-normal leading-normal">#{{ item.id_request }}</td>
                        <td class="h-[72px] px-4 py-2 w-[400px] text-[#0e121b] text-sm font-normal leading-normal"> {{ item.requesting_user.name }} </td>
                        <td class="table-a589e3d2-3512-4ac2-81b6-837810765f5f-column-360 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                        <button class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#e7ebf3] text-[#0e121b] text-sm font-medium leading-normal w-full">
                          <span class="truncate">{{ decodeStatus(item.status) || '-' }}</span>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        </div>
    </AuthenticatedLayout>

    <ModalCreate :show="showModal" @files="filesSelected" @close="showModal = false" />

</template>

