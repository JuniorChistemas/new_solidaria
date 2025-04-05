import { Pagination } from '@/interface/paginacion';
import { ZoneRequest, ZoneResource, ZoneUpdateRequest } from '@/pages/panel/zone/interface/Zone';
import { ZoneServices } from '@/services/zoneServices';
import { showSuccessMessage } from '@/utils/message';
import { reactive } from 'vue';

export const useZone = () => {
    const principal = reactive<{
        zoneList: ZoneResource[];
        paginacion: Pagination;
        loading: boolean;
        filter: string;
        idZone: number;
        statusModal: {
            update: boolean;
            delete: boolean;
        };
        zoneData: ZoneResource;
    }>({
        zoneList: [],
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
        idZone: 0,
        statusModal: {
            update: false,
            delete: false,
        },
        zoneData: {
            id: 0,
            name: '',
            status: true,
            created_at: '',
            updated_at: '',
        },
    });
        //reset zone data
        const resetzoneData = () => {
            principal.zoneData = {
                id: 0,
                name: '',
                status: true,
                created_at: '',
                updated_at: '',
            };
        };

    // loading zones
    const loadingZones = async (page: number = 1, name: string = '', status: boolean = true) => {
        if (status) {
            principal.loading = true;
            try {
                const response = await ZoneServices.index(page, name);
                principal.zoneList = response.zones;
                principal.paginacion = response.pagination;
                console.log(response);
            } catch (error) {
                console.error(error);
            } finally {
                principal.loading = false;
            }
        }
    };
            // creating zones
            const createZone = async (data: ZoneRequest) => {
                try {
                    await ZoneServices.store(data);
                } catch (error) {
                    console.error(error);
                }
            };
        // get Zone by id
        const getZoneById = async (id: number) => {
            try {
                if (id === 0) {
                    principal.zoneData = {
                        id: 0,
                        name: '',
                        status: true,
                        created_at: '',
                        updated_at: '',
                    };
                    return;
                }
            const response = await ZoneServices.show(id);
            if (response.status) {
                principal.zoneData = response.zone;
                console.log(principal.zoneData.name);
                principal.idZone = response.zone.id;
                principal.statusModal.update = true;
            }
        } catch (error) {
            console.error(error);
        }
    };
    // update zone
    const updateZone = async (id: number, data: ZoneUpdateRequest) => {
        try {
            const response = await ZoneServices.update(id, data);
            if (response.status) {
                showSuccessMessage('Zona actualizada', 'La zona se actualizó correctamente');
                principal.statusModal.update = false;
                loadingZones(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        }
    };
    // delete zone
    const deleteZone = async (id: number) => {
        try {
            const response = await ZoneServices.destroy(id);
            console.log(response.status);
            if (response.status) {
                showSuccessMessage('Zona eliminada', 'La zona se eliminó correctamente');
                principal.statusModal.delete = false;
                loadingZones(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        } finally {
            principal.statusModal.delete = false;
        }
    };
    return {
        principal,
        loadingZones,
        createZone,
        getZoneById,
        resetzoneData,
        updateZone,
        deleteZone,
    };
};