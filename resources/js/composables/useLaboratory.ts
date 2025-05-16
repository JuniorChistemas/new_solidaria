import { useToast } from '@/components/ui/toast'; // ✅ Agregado
import { Pagination } from '@/interface/paginacion';
import { LaboratoryRequest, LaboratoryResource, LaboratoryUpdateRequest } from '@/pages/panel/laboratory/interface/Laboratory';
import { showErrorMessage, showSuccessMessage } from '@/utils/message';
import axios from 'axios';
import { reactive } from 'vue';
import { LaboratoryServices } from '../services/laboratoryServices';

export const useLaboratory = () => {
    const { toast } = useToast(); // ✅ Inicializamos toast

    const principal = reactive<{
        laboratoryList: LaboratoryResource[];
        paginacion: Pagination;
        loading: boolean;
        filter: string;
        idLaboratory: number;
        stateModal: {
            update: boolean;
            delete: boolean;
        };
        laboratoryData: LaboratoryResource;
    }>({
        laboratoryList: [],
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
        idLaboratory: 0,
        stateModal: {
            update: false,
            delete: false,
        },
        laboratoryData: {
            id: 0,
            name: '',
            state: true,
        },
    });

    const resetLaboratoryData = () => {
        principal.laboratoryData = {
            id: 0,
            name: '',
            state: true,
        };
    };

    const loadingLaboratories = async (page: number = 1, name: string = '', status: boolean = true) => {
        if (status) {
            principal.loading = true;
            try {
                const response = await LaboratoryServices.index(page, name);
                principal.laboratoryList = response.laboratories;
                principal.paginacion = response.pagination;
                console.log(response);
            } catch (error) {
                console.error(error);
            } finally {
                principal.loading = false;
            }
        }
    };

    const createLaboratory = async (data: LaboratoryRequest) => {
        try {
            await LaboratoryServices.store(data);
        } catch (error) {
            console.error(error);
        }
    };

    const getLaboratoryById = async (id: number) => {
        try {
            if (id === 0) {
                resetLaboratoryData();
                return;
            }
            const response = await LaboratoryServices.show(id);
            if (response.state) {
                principal.laboratoryData = response.laboratory;
                principal.idLaboratory = response.laboratory.id;
                principal.stateModal.update = true;
            }
        } catch (error) {
            console.error(error);
        }
    };

    const updateLaboratory = async (id: number, data: LaboratoryUpdateRequest) => {
        try {
            const response = await LaboratoryServices.update(id, data);
            if (response.state) {
                toast({
                    title: 'Laboratorio actualizado',
                    description: 'El laboratorio se actualizó correctamente',
                });
                principal.stateModal.update = false;
                loadingLaboratories(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        }
    };

    const deleteLaboratory = async (id: number) => {
        try {
            const response = await LaboratoryServices.destroy(id);
            if (response.state) {
                showSuccessMessage('Laboratorio eliminado', 'El laboratorio se eliminó correctamente');
                principal.stateModal.delete = false;
                loadingLaboratories(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            showErrorMessage('Laboratorio no eliminado', 'El laboratorio no se eliminó correctamente');
            console.error(error);
        } finally {
            principal.stateModal.delete = false;
        }
    };
    const validateLaboratoryName = async (name: string): Promise<boolean> => {
        try {
            const response = await axios.get(`/panel/laboratories/validate-name?name=${encodeURIComponent(name)}`);
            return response.data.exists;
        } catch (error) {
            console.error('Error validando nombre:', error);
            return false;
        }
    };

    return {
        principal,
        loadingLaboratories,
        createLaboratory,
        getLaboratoryById,
        resetLaboratoryData,
        updateLaboratory,
        deleteLaboratory,
        validateLaboratoryName,
    };
};
