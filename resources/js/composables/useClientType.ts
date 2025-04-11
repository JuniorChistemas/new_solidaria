import { ClientTypeResource, ClientTypeRequest, ClientTypeUpdateRequest } from '@/pages/panel/clientType/interface/ClientType';
import { ClientTypeServices } from '@/services/clientTypeService';
import { reactive } from 'vue';

export function useClientType() {
    const principal = reactive({
        clientTypeList: [] as ClientTypeResource[],
        clientTypeData: {} as ClientTypeResource,
        paginacion: {
            current_page: 1,
            from: 0,
            last_page: 0,
            links: [],
            path: '',
            per_page: 10,
            to: 0,
            total: 0,
        },
        idClientType: 0,
        loading: true,
        statusModal: {
            update: false,
            delete: false,
        },
    });

    // Load client types with pagination and search
    const loadingClientTypes = async (page = 1, name = '') => {
        principal.loading = true;
        try {
            const response = await ClientTypeServices.index(page, name);
            principal.clientTypeList = response.clientTypes;
            principal.paginacion = response.pagination;
        } catch (error) {
            console.error('Error loading client types:', error);
        } finally {
            principal.loading = false;
        }
    };

    // Create a client type
    const createClientType = async (data: ClientTypeRequest) => {
        try {
            await ClientTypeServices.store(data);
        } catch (error) {
            console.error('Error creating client type:', error);
        }
    };

    // Get client type by ID for editing
    const getClientTypeById = async (id: number) => {
        try {
            const response = await ClientTypeServices.show(id);
            principal.clientTypeData = response.clientType;
            principal.statusModal.update = true;
        } catch (error) {
            console.error('Error getting client type:', error);
        }
    };

    // Update client type
    const updateClientType = async (id: number, data: ClientTypeUpdateRequest) => {
        try {
            await ClientTypeServices.update(id, data);
            loadingClientTypes();
        } catch (error) {
            console.error('Error updating client type:', error);
        }
    };

    // Delete client type
    const deleteClientType = async (id: number) => {
        try {
            await ClientTypeServices.destroy(id);
            loadingClientTypes();
            principal.statusModal.delete = false;
        } catch (error) {
            console.error('Error deleting client type:', error);
        }
    };

    return {
        principal,
        loadingClientTypes,
        createClientType,
        getClientTypeById,
        updateClientType,
        deleteClientType,
    };
}