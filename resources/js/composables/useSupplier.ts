import { Pagination } from '@/interface/paginacion';
import { SupplierResource, SupplierRequest, SupplierUpdateRequest } from '@/pages/panel/supplier/interface/Supplier';
import { SupplierServices } from '@/services/supplierServices';
import { showSuccessMessage } from '@/utils/message';
import { reactive } from 'vue';

export const useSupplier = () => {
    const principal = reactive<{
        supplierList: SupplierResource[];
        paginacion: Pagination;
        loading: boolean;
        filter: string;
        idSupplier: number;
        stateModal: {
            update: boolean;
            delete: boolean;
        };
        supplierData: SupplierResource;
    }>({
        supplierList: [],
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
        idSupplier: 0,
        stateModal: {
            update: false,
            delete: false,
        },
        supplierData: {
            id: 0,
            name: '',
            ruc: '',
            phone: '',
            address: '',
            state: true,
        },
    });
        //reset supplier data
        const resetSupplierData = () => {
            principal.supplierData = {
                id: 0,
                name: '',
                ruc: '',
                phone: '',
                address: '',
                state: true,
            };
        };

    // loading suppliers
    const loadingSuppliers = async (page: number = 1, name: string = '', state: boolean = true) => {
        if (state) {
            principal.loading = true;
            try {
                const response = await SupplierServices.index(page, name);
                principal.supplierList = response.suppliers;
                principal.paginacion = response.pagination;
                console.log(response);
            } catch (error) {
                console.error(error);
            } finally {
                principal.loading = false;
            }
        }
    };
            // creating suppliers
            const createSupplier = async (data: SupplierRequest) => {
                try {
                    await SupplierServices.store(data);
                } catch (error) {
                    console.error(error);
                }
            };
        // get Supplier by id
        const getSupplierById = async (id: number) => {
            try {
                if (id === 0) {
                    principal.supplierData = {
                        id: 0,
                        name: '',
                        ruc: '',
                        phone: '',
                        address: '',
                        state: true,
                    };
                    return;
                }
            const response = await SupplierServices.show(id);
            if (response.state) {
                principal.supplierData = response.supplier;
                console.log(principal.supplierData.name);
                principal.idSupplier = response.supplier.id;
                principal.stateModal.update = true;
            }
        } catch (error) {
            console.error(error);
        }
    };
    // update supplier
    const updateSupplier = async (id: number, data: SupplierUpdateRequest) => {
        try {
            const response = await SupplierServices.update(id, data);
            if (response.state) {
                showSuccessMessage('Proveedor actualizado', 'El proveedor se actualizo correctamente');
                principal.stateModal.update = false;
                loadingSuppliers(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        }
    };
    // delete supplier
    const deleteSupplier = async (id: number) => {
        try {
            const response = await SupplierServices.destroy(id);
            console.log(response.state);
            if (response.state) {
                showSuccessMessage('Proveedor eliminado', 'El Proveedor se elimino correctamente');
                principal.stateModal.delete = false;
                loadingSuppliers(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        } finally {
            principal.stateModal.delete = false;
        }
    };

    return {
        principal,
        loadingSuppliers,
        createSupplier,
        getSupplierById,
        resetSupplierData,
        updateSupplier,
        deleteSupplier,
    };
};
