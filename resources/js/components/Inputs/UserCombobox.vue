<!-- @/components/inputs/UserCombobox.vue -->
<template>
    <!-- Estado de carga inicial -->
    <div v-if="isLoading" class="flex items-center space-x-2 py-2">
        <div class="h-4 w-4 animate-spin rounded-full border-b-2 border-t-2 border-primary"></div>
        <span class="text-sm text-muted-foreground">Cargando usuarios...</span>
    </div>
    
    <!-- Mensaje de error -->
    <div v-else-if="error" class="py-2 text-sm text-red-500">Error al cargar usuarios. Intente nuevamente.</div>
    
    <!-- Combobox -->
    <Combobox v-else by="id" v-model="selectedUser">
        <ComboboxAnchor>
            <div class="relative w-full items-center">
                <ComboboxInput
                    class="pl-9"
                    :display-value="(val) => val?.name ?? ''"
                    :model-value="searchText"
                    placeholder="Seleccionar usuario..."
                    @update:model-value="handleSearchInput"
                />
                <span class="absolute inset-y-0 start-0 flex items-center justify-center px-3">
                    <Search class="size-4 text-muted-foreground" />
                </span>
                <!-- Indicador de búsqueda -->
                <span v-if="isSearching" class="absolute inset-y-0 end-0 flex items-center justify-center px-3">
                    <div class="h-4 w-4 animate-spin rounded-full border-b-2 border-t-2 border-primary"></div>
                </span>
            </div>
        </ComboboxAnchor>
        <ComboboxList>
            <ComboboxEmpty>No se encontró ningún usuario.</ComboboxEmpty>
            <ComboboxGroup>
                <ComboboxItem v-for="user in filteredUsers" :key="user.id" :value="user" @select="onSelect(user)">
                    {{ user.name }} <span class="text-sm text-muted-foreground ml-2">({{ user.email }})</span>
                    <ComboboxItemIndicator>
                        <Check class="ml-auto h-4 w-4" />
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
import { Check, Search } from 'lucide-vue-next';
import { onMounted, ref, computed } from 'vue';
import debounce from 'debounce';
import { UserServices } from '@/services/userServices';
import { UserResource } from '@/pages/panel/user/interface/User';

const emit = defineEmits<{
    (e: 'select', user_id: number): void;
}>();

// Estado
const users = ref<UserResource[]>([]);
const searchText = ref<string>('');
const error = ref<boolean>(false);
const isLoading = ref<boolean>(true);
const isSearching = ref<boolean>(false);
const selectedUser = ref<UserResource | null>(null);
const initialLoadDone = ref<boolean>(false);

// Filtrar usuarios en el cliente para respuesta inmediata
const filteredUsers = computed(() => {
    if (!searchText.value) return users.value;
    
    return users.value.filter(user => 
        user.name.toLowerCase().includes(searchText.value.toLowerCase()) ||
        (user.email && user.email.toLowerCase().includes(searchText.value.toLowerCase()))
    );
});

// Cargar usuarios desde la API - carga inicial
const initialLoadUsers = async () => {
    if (initialLoadDone.value) return;
    
    try {
        isLoading.value = true;
        const response = await UserServices.getUsers('');
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

// Búsqueda de usuarios - para actualizaciones posteriores
const searchUsers = async (query: string) => {
    if (!initialLoadDone.value) return;
    
    try {
        isSearching.value = true;
        const response = await UserServices.getUsers(query);
        users.value = response || [];
        error.value = false;
    } catch (e) {
        console.error('Error al buscar usuarios:', e);
        // No cambiamos error.value aquí para evitar un mensaje de error en búsquedas
    } finally {
        isSearching.value = false;
    }
};

// Manejar la búsqueda con debounce
const handleSearchInput = (value: string) => {
    searchText.value = value;
    
    // Solo iniciamos búsqueda si ya se completó la carga inicial
    if (initialLoadDone.value) {
        debouncedSearch(value);
    }
};

// Función de búsqueda con debounce
const debouncedSearch = debounce((value: string) => {
    // Solo realizamos búsqueda en servidor si hay al menos 3 caracteres o está vacío
    if (value.length >= 3 || value === '') {
        searchUsers(value);
    }
}, 400);

// Selección de usuario
const onSelect = (user: UserResource) => {
    selectedUser.value = user;
    emit('select', user.id);
};

// Cargar usuarios solo una vez al montar el componente
onMounted(() => {
    initialLoadUsers();
});
</script>

<style scoped></style>