<script setup>
import {computed} from 'vue';

const emit = defineEmits(['pageEvent']);

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
});

const corrigeLabel = (label) => {
    if (label === '&laquo; Previous' || label === 'pagination.previous') {
        return '<';
    }

    if (label === 'Next &raquo;' || label === 'pagination.next') {
        return '>';
    }
    return label;
};

const gotoPage = (page) => {

    if (page == props.data.current_page) {
        return;
    }

    if (page === '&laquo; Previous'|| page === 'pagination.previous') {
        if (props.data.current_page == 1) {
            return;
        }
        page = props.data.current_page - 1;
    }

    if (page === 'Next &raquo;'|| page === 'pagination.next') {
        if (props.data.current_page == props.data.last_page) {
            return;
        }
        page = props.data.current_page + 1;
    }
    emit('pageEvent', page);
};
</script>

<template>
    <div class="p-6">
        <button @click="gotoPage(page.label)" v-for="page in data.links" :class="page.label == data.current_page ? 'bg-gray-200 text-new-t': 'bg-transparent border-none'" class="px-4 py-3 border-none rounded-md font-semibold text-sm text-new-p hover:bg-gray-200 focus:outline-none focus:ring-none focus:ring-offset-2">{{ corrigeLabel(page.label) }}</button>
    </div>
</template>
