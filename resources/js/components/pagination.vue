<template>
    <Pagination
        v-slot="{ page }"
        :items-per-page="props.meta.per_page"
        :total="props.meta.total"
        :sibling-count="1"
        show-edges
        :default-page="props.meta.current_page"
        :key="props.meta.current_page"
        class="flex justify-center gap-2"
    >
        <PaginationList v-slot="{ items }" class="flex items-center gap-1">
            <PaginationFirst @click="handlePageChange(1)" />
            <PaginationPrev @click="handlePageChange(props.meta.current_page - 1)" />

            <template v-for="(item, index) in items" :key="index">
                <PaginationListItem v-if="item.type === 'page'" :value="item.value" as-child>
                    <Button class="h-9 w-9 p-0" :variant="item.value === page ? 'default' : 'outline'" @click="handlePageChange(item.value)">
                        {{ item.value }}
                    </Button>
                </PaginationListItem>
                <PaginationEllipsis v-else :index="index" />
            </template>

            <PaginationNext @click="handlePageChange(props.meta.current_page + 1)" />
            <PaginationLast @click="handlePageChange(props.meta.last_page)" />
        </PaginationList>
    </Pagination>
</template>
<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
} from '@/components/ui/pagination';

import type { Pagination as PaginationMeta } from '@/interface/paginacion';

interface Props {
    meta: PaginationMeta;
    onPageChange?: (page: number) => void;
}

const props = withDefaults(defineProps<Props>(), {
    onPageChange: () => {},
});

const emit = defineEmits<{
    (e: 'page-change', page: number): void;
}>();

const handlePageChange = (page: number) => {
    emit('page-change', page);
};
</script>
<style scoped></style>
