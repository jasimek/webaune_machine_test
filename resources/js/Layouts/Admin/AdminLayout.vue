<script setup>
import { onMounted, watch } from 'vue'
import Sidemenu from '@/Layouts/Admin/Menu.vue'
import Header from '@/Layouts/Admin/Header.vue'
import Toast from 'primevue/toast';
import { usePage } from '@inertiajs/vue3'
import { useToast } from 'primevue/usetoast';
import { initFlowbite } from 'flowbite';

const page = usePage()
const toast = useToast()
// initialize components based on data attribute selectors
onMounted(() => {
    if(page.props.toast) toastMessage(page.props.toast)
	initFlowbite();

})

watch(() => page.props.toast, toastData => {
    if(toastData) toastMessage(toastData)
}, {deep: true})

function toastMessage(toastData){
    toast.add({severity: toastData?.type, summary: toastData?.title, detail: toastData?.message, life: 3000 });
}
</script>
<template>
    <Header />
    <div class="flex pt-14 bg-gray-100 dark:bg-gray-900">
        <Sidemenu />
        <div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>
        <div id="main-content" class="relative w-full h-full lg:ml-64">
            <slot />
            
        </div>

</div>
<Toast position="bottom-right" :pt="{
        // root:{ class:'!w-96'},
        // content: { class: '!px-2 !py-2' }
    }" />
</template>