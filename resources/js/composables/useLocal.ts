import { Pagination } from '@/interface/paginacion';
import { LocalRequest, LocalResource, LocalUpdateRequest } from '@/pages/panel/local/interface/Local';
import { localServices } from '@/services/localServices';
import { showSuccessMessage } from '@/utils/message';
import { reactive } from 'vue';

export const useLocal = () => {
    const principal = reactive<{
        localList: LocalResource[];
        paginacion: Pagination;
        loading: boolean;
        filter: string;
        idLocal: number;
        statusModal: {
            update: boolean;
            delete: boolean;
        };
        localData: LocalResource;
    }>({
        localList: [],
        paginacion: {
            total: 0,
            current_page: 0,
            per_page: 0,
            last_page: 0,
            from: 0,
            to: 0,
        },
        loading: false,
        filter: '',
        idLocal: 0,
        statusModal: {
            update: false,
            delete: false,
        },
        localData: {
            id: 0,
            name: '',
            address: '',
            series: '',
            series_note: '',
            status: true,
            created_at: '',
            updated_at: '',
        },
    });
        //reset local data
        const resetlocalData = () => {
            principal.localData = {
                id: 0,
                name: '',
                address: '',
                series: '',
                series_note: '',
                status: true,
                created_at: '',
                updated_at: '',
            };
        };

    // loading Locals
    const loadingLocals = async (page: number = 1, name: string = '', address: string = '',series: string = '',series_note: string = '', status: boolean = true) => {
        if (status) {
            principal.loading = true;
            try {
                const response = await localServices.index(page, name);
                principal.localList = response.locals;
                principal.paginacion = response.pagination;
                console.log(response);
            } catch (error) {
                console.error(error);
            } finally {
                principal.loading = false;
            }
        }
    };
            // creating locals
            const createLocal = async (data: LocalRequest) => {
                try {
                    await localServices.store(data);
                } catch (error) {
                    console.error(error);
                }
            };
        // get Local by id
        const getLocalById = async (id: number) => {
            try {
                if (id === 0) {
                    principal.localData = {
                        id: 0,
                        name: '',
                        address: '',
                        series: '',
                        series_note: '',
                        status: true,
                        created_at: '',
                        updated_at: '',
                    };
                    return;
                }
            const response = await localServices.show(id);
            if (response.status) {
                principal.localData = response.local;
                console.log(principal.localData.name);
                principal.idLocal = response.local.id;
                principal.statusModal.update = true;
            }
        } catch (error) {
            console.error(error);
        }
    };
    // update local
    const updateLocal = async (id: number, data: LocalUpdateRequest) => {
        try {
            const response = await localServices.update(id, data);
            if (response.status) {
                showSuccessMessage('Local actualizada', 'El local se actualizó correctamente');
                principal.statusModal.update = false;
                loadingLocals(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        }
    };
    // delete local
    const deleteLocal = async (id: number) => {
        try {
            const response = await localServices.destroy(id);
            console.log(response.status);
            if (response.status) {
                showSuccessMessage('Local eliminado', 'El local se eliminó correctamente');
                principal.statusModal.delete = false;
                loadingLocals(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        } finally {
            principal.statusModal.delete = false;
        }
    };
    return {
        principal,
        loadingLocals,
        createLocal,
        getLocalById,
        resetlocalData,
        updateLocal,
        deleteLocal,
    };
};