<template>
    <div class="relative ml-auto max-w-sm items-center p-2">
        <Input v-model="searchText" id="search" type="text" placeholder="Buscar..." class="pl-10" @input="debounceSearch" />
        <span class="absolute inset-y-2 flex items-center justify-center px-2">
            <Search class="size-6 text-muted-foreground" />
        </span>
    </div>
</template>

<script setup lang="ts">
import { Input } from '@/components/ui/input';
import debounce from 'debounce';
import { Search } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const emit = defineEmits<{
    (e: 'search', text: string): void;
}>();

const searchText = ref('');

const debounceSearch = debounce(() => {
    emit('search', searchText.value);
}, 400);

watch(searchText, () => {
    debounceSearch();
});
</script>

<style scoped></style>
