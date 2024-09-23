<script setup lang="ts">

import { ref, defineEmits, watch, defineProps } from 'vue';
import Modal from '@/Components/Modal.vue';
import Loading from '@/Components/Loading.vue';

const emit = defineEmits(['confirmObservation']);

const props = defineProps<{
    isLoadingCreate : boolean
}>();

const observation = ref<string>('');

const confirmObservation = () => {
    emit('confirmObservation', observation.value)
}

</script>

<template>
    <Modal>
        <div id="header">
            <div class="p-5">
                <h1>Adicione uma observação</h1>
            </div>
        </div>
        <div id="content">
            <div class="bg-[#ffff] m-auto p-4">
                <textarea name="" id="" rows="5" v-model="observation" class="resize-none w-full rounded-md border-b border-[#d0d7e7]"></textarea>
            </div>
            <div class="flex px-4 py-2 justify-end">
                <button @click="confirmObservation()" :disabled="props.isLoadingCreate" class="bg-blue-500 text-white p-2 flex justify-center items-center rounded-md text-center">
                    <span v-if="!props.isLoadingCreate">Confirmar</span>
                    <Loading :color="'#fff'" :size="22" v-else />
                </button>
            </div>
        </div>
    </Modal>
</template>