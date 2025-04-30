<template>
    <!-- Estado de carga inicial -->
    <div v-if="isLoading" class="flex items-center space-x-2 py-2">
        <div class="h-4 w-4 animate-spin rounded-full border-b-2 border-t-2 border-primary"></div>
        <span class="text-sm text-muted-foreground">Cargando usuarios...</span>
    </div>

    <!-- Mensaje de error -->
    <div v-else-if="error" class="py-2 text-sm text-red-500">Error al cargar usuarios. Intente nuevamente.</div>

    <!-- Combobox con altura controlada -->
    <Combobox v-else by="id" v-model="selectedUser">
        <ComboboxAnchor>
            <div class="relative w-full items-center">
                <ComboboxInput
                    class="pl-9 pr-7"
                    :display-value="(val) => val?.name ?? ''"
                    :model-value="searchText"
                    placeholder="Seleccionar usuario..."
                    @update:model-value="handleSearchInput"
                />
                <span class="absolute inset-y-0 start-0 flex items-center justify-center px-3">
                    <Search class="size-4 text-muted-foreground" />
                </span>
                <!-- Indicador de búsqueda -->
                <span v-if="isSearching" class="absolute inset-y-0 end-0 flex items-center justify-center px-2">
                    <div class="h-4 w-4 animate-spin rounded-full border-b-2 border-t-2 border-primary"></div>
                </span>
            </div>
        </ComboboxAnchor>

        <!-- Lista con scroll controlado -->
        <ComboboxList class="max-h-[280px] overflow-y-auto">
            <ComboboxEmpty class="px-4 py-2 text-sm text-muted-foreground"> No se encontraron usuarios </ComboboxEmpty>
            <ComboboxGroup>
                <ComboboxItem
                    v-for="user in filteredUsers"
                    :key="user.id"
                    :value="user"
                    @select="onSelect(user)"
                    class="px-4 py-2 text-sm hover:bg-accent hover:text-accent-foreground"
                >
                    <div class="flex items-center">
                        <span class="truncate">{{ user.name }}</span>
                        <span class="ml-2 truncate text-xs text-muted-foreground">{{ user.email }}</span>
                    </div>
                    <ComboboxItemIndicator class="ml-auto">
                        <Check class="h-4 w-4" />
                    </ComboboxItemIndicator>
                </ComboboxItem>
            </ComboboxGroup>
        </ComboboxList>
    </Combobox>
</template>

<script setup lang="ts">
import {
    Combobox,
    ComboboxAnchor,
    ComboboxEmpty,
    ComboboxGroup,
    ComboboxInput,
    ComboboxItem,
    ComboboxItemIndicator,
    ComboboxList,
} from '@/components/ui/combobox';
import { getUserResponse } from '@/pages/panel/user/interface/User';
import { userServices } from '@/services/userServices';
import debounce from 'debounce';
import { Check, Search } from 'lucide-vue-next';
import { computed, onMounted, ref } from 'vue';

const emit = defineEmits<{
    (e: 'select', user_id: number): void;
}>();

// Estado
const users = ref<getUserResponse[]>([]);
const searchText = ref<string>('');
const error = ref<boolean>(false);
const isLoading = ref<boolean>(true);
const isSearching = ref<boolean>(false);
const selectedUser = ref<getUserResponse | null>(null);
const initialLoadDone = ref<boolean>(false);

const filteredUsers = computed(() => {
    if (!searchText.value) return users.value;

    return users.value.filter(
        (user) =>
            user.name.toLowerCase().includes(searchText.value.toLowerCase()) ||
            (user.email && user.email.toLowerCase().includes(searchText.value.toLowerCase())),
    );
});

const initialLoadUsers = async () => {
    if (initialLoadDone.value) return;

    try {
        isLoading.value = true;
        const response = await userServices.getUsers('');
        users.value = response || [];
        error.value = false;
        initialLoadDone.value = true;
    } catch (e) {
        console.error('Error al cargar usuarios:', e);
        error.value = true;
    } finally {
        isLoading.value = false;
    }
};

const searchUsers = async (query: string) => {
    if (!initialLoadDone.value) return;

    try {
        isSearching.value = true;
        const response = await userServices.getUsers(query);
        users.value = response || [];
        error.value = false;
    } catch (e) {
        console.error('Error al buscar usuarios:', e);
    } finally {
        isSearching.value = false;
    }
};

const handleSearchInput = (value: string) => {
    searchText.value = value;
    if (initialLoadDone.value) {
        debouncedSearch(value);
    }
};

const debouncedSearch = debounce((value: string) => {
    if (value.length >= 3 || value === '') {
        searchUsers(value);
    }
}, 400);

const onSelect = (user: getUserResponse) => {
    selectedUser.value = user;
    emit('select', user.id);
};

onMounted(() => {
    initialLoadUsers();
});
</script>
