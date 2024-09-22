<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ModalCreate from './_partials/ModalCreate.vue';
import Detailing from './_partials/Detailing.vue';
import Paginator from '@/Components/Paginator.vue';
import axios from 'axios';
import { ref, onBeforeMount, defineProps, watch } from 'vue';

const requests = ref<RequestsResponse | null>(null);
const showModal = ref(false);
const images = ref<File[]>([]);
const interlivedItems = ref<{ data: RequestItem | null; type: 'data' | 'details' }[]>([]);
const selected = ref<number>(-1);
const perPage = ref<number>(1);
const selectedPage = ref<number>(0);
const isLoading = ref<boolean>(false);
const isLoadingCreate = ref<boolean>(false);

interface RequestItem {
  id_request: number;
  requesting_user: {
    name: string;
  };
  status: number;
  create_date: string;
  files: any[];
}

interface RequestsResponse {
  data: RequestItem[];
  meta: { [key: string]: any }[];
}

interface Auth {
  user: {
    id: number;
    permission: number;
    name: string;
  };
}

const props = defineProps<{
  auth: Auth;
  isLoadingCreate: boolean;
}>();

onBeforeMount(() => {
  getRequests()
})

watch(selectedPage, (newValue) => {
  getRequests()
})

const validateApproval = (item: any): boolean => {

  if (props.auth.user.permission === 0) {
    return false;
  }

  if (item.status === 2 || item.status === 1) {
    return false;
  }

  return true;
};

const formattedDate = (dateString: string): string => {

  if(dateString){

    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();

    return `${day}/${month}/${year}`;

  }

  return '-'

};

const changePage = (page: number) => {

  selectedPage.value = page;

};

const decodeStatus = (status: number | any): string => {

  const data: Record<number, string> = {
    0: 'Pendente',
    1: 'Aprovado',
    2: 'Recusado'
  };

  return data[status] || 'Desconhecido';

};

const filesSelected = (file: File[]) => {

  images.value = file;

};

const getRequests = () => {

  isLoading.value = true;

  const url = window.location.origin;

  axios.get<RequestsResponse>(url + `/api?page=${perPage.value}&status=${selectedPage.value}`)
  .then(response => {
      requests.value = response.data
      interlive();
  })
  .finally(() => {
    isLoading.value = false;
  });
}

const selectItem = (index: number) => {
  selected.value = selected.value === index ? -1 : index;
};

const interlive = () => {

  interlivedItems.value = [];

  if (requests.value) {
    requests.value.data.forEach((item, index) => {
      interlivedItems.value.push({ data: item, type: 'data' });
      interlivedItems.value.push({ data: null, type: 'details' });
    });
  }
};

const createRequests = () => {

  isLoadingCreate.value = true;

  const url = window.location.origin;

  const data = {
    user : props.auth.user.id,
    images : images.value
  }

  axios.post(url + '/api/create', data)
  .then(response => {
    getRequests()
  })
  .finally(() => {
    isLoadingCreate.value = false;
    showModal.value = false
  });
}

const approveOrRejected = (item: any, status: number) => {

  const url = window.location.origin;

  const data = {
    status: status,
    id_request: item.id_request
  };

  axios.post(`${url}/api/approve-or-rejected`, data)
    .then(() => {
      location.reload();
    });
};

</script>

<template>
    <AuthenticatedLayout>
        <div class="w-full container m-auto">
            <div class="flex flex-1 justify-center py-5">
          <div class="flex flex-col flex-1">
            <div class="flex flex-wrap justify-between p-4">
                <p class="text-[#0e121b] text-[32px] font-bold leading-tight">Lista de Solicitações</p>
                <button @click="() => {showModal = true}" class="p-3 bg-[#E8EBF2] rounded-md">
                    Upload
                </button>
            </div>
            <div class="pb-3">
              <div class="flex border-b border-[#d0d7e7] px-4 gap-8">
                <a @click="changePage(0)" :class="(selectedPage == 0) ? 'border-b-[2px] border-b-[#195de6] text-[#0e121b]' : 'text-[#4e6797] border-b-transparent'" class="flex flex-col items-center justify-center pb-[13px] pt-4" href="#">
                  <p class="text-sm font-bold leading-normal tracking-[0.015em]">Pendente</p>
                </a>
                <a @click="changePage(1)" :class="(selectedPage == 1) ? 'border-b-[3px] border-b-[#195de6] text-[#0e121b]' : 'text-[#4e6797] border-b-transparent'" class="flex flex-col items-center justify-center border-b-[3px] pb-[13px] pt-4" href="#">
                  <p class="text-sm font-bold leading-normal tracking-[0.015em]">Aprovados</p>
                </a>
                <a @click="changePage(2)" :class="(selectedPage == 2) ? 'border-b-[3px] border-b-[#195de6] text-[#0e121b]' : 'text-[#4e6797] border-b-transparent'" class="flex flex-col items-center justify-center border-b-[3px] pb-[13px] pt-4" href="#">
                  <p class=" text-sm font-bold leading-normal tracking-[0.015em]">Recusados</p>
                </a>
                <a @click="changePage(3)" :class="(selectedPage == 3) ? 'border-b-[3px] border-b-[#195de6] text-[#0e121b]' : 'text-[#4e6797] border-b-transparent'" class="flex flex-col items-center justify-center pb-[13px] pt-4" href="#">
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
                      <th class="px-4 py-3 text-left text-[#0e121b] w-[400px] text-sm font-medium leading-normal">Nome</th>
                      <th class="px-4 py-3 text-left text-[#0e121b] w-60 text-sm font-medium leading-normal">Status</th>
                      <th class="px-4 py-3 text-left text-[#0e121b] w-[400px] text-sm font-medium leading-normal"> Data Criação </th>
                      <th class="px-4 py-3 text-left text-[#0e121b] w-60 text-sm font-medium leading-normal">Ação</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="isLoading" class="text-center border-t border-t-[#d0d7e7]">
                      <td colspan="6">Carregando...</td>
                    </tr>
                    <tr v-else :id="'itemList-' + index" v-for="(item, index) in interlivedItems" @dblclick="selectItem(index)" class="border-t cursor-pointer border-t-[#d0d7e7]">
                      <td v-if="item.type == 'data'" class="h-[60px] px-4 py-2 text-[#4e6797] text-sm font-normal leading-normal">#{{ item.data?.id_request }}</td>
                      <td v-if="item.type == 'data'" class="h-[60px] px-4 py-2 text-[#0e121b] text-sm font-normal leading-normal"> {{ item.data?.requesting_user.name }} </td>
                      <td v-if="item.type == 'data'" class="h-[60px] px-4 py-2 text-sm font-normal leading-normal">
                        <button class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#e7ebf3] text-[#0e121b] text-sm font-medium leading-normal w-full">
                          <span class="truncate">{{ decodeStatus(item.data?.status) || '-' }}</span>
                        </button>
                      </td>
                      <td v-if="item.type == 'data'" class="h-[60px] px-4 py-2 text-[#0e121b] text-sm font-normal leading-normal"> {{ item.data ? formattedDate(item.data.create_date) : '-' }}</td>
                      <td v-if="item.type == 'data'" class="h-[60px] flex flex-row gap-3 px-4 py-2 text-[#0e121b] text-sm font-normal leading-normal">
                        <div v-if="validateApproval(item.data)">
                          <button @click="approveOrRejected(item.data, 2)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">
                              Reprovar
                          </button>
                          <button @click="approveOrRejected(item.data, 1)" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
                              Aprovar
                          </button>
                        </div>
                      </td>
                      <td colspan="9" v-if="item.type == 'details' && selected == index - 1" class="">
                        <Detailing :autoupdate="false" :closeable="true" :files="interlivedItems[index - 1]?.data?.files ?? []"></Detailing>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="flex justify-end">
                <Paginator v-if="requests?.data" :data="requests.meta[0]" @pageEvent="(page) => { perPage = page, console.log(page),getRequests() }"/>
              </div>
            </div>
          </div>
        </div>
        </div>
    </AuthenticatedLayout>

    <ModalCreate :show="showModal" :isLoadingCreate="isLoadingCreate" @files="filesSelected" @save="createRequests" @close="showModal = false" />

</template>



