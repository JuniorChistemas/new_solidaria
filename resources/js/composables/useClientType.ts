import { ClientTypeRequest, ClientTypeResource, ClientTypeUpdateRequest } from '@/pages/panel/clientType/interface/ClientType';
import { ClientTypeServices } from '@/services/clientTypeService';
import { showSuccessMessage } from '@/utils/message';
import { reactive } from 'vue';

export function useClientType() {
    const principal = reactive({
        clientTypeList: [] as ClientTypeResource[],
        clientTypeData: {} as ClientTypeResource,
        paginacion: {
            total: 0,
            current_page: 0,
            per_page: 0,
            last_page: 0,
            from: 0,
            to: 0,
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
            const response = await ClientTypeServices.update(id, data);
            showSuccessMessage(response.message);
            loadingClientTypes();
        } catch (error) {
            console.error('Error updating client type:', error);
        }
    };

    // Delete client type
    const deleteClientType = async (id: number) => {
        try {
            const response = await ClientTypeServices.destroy(id);
            loadingClientTypes();
            showSuccessMessage(response.message);
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
