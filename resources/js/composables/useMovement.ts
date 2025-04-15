// useMovement.ts
import { MovementResource, MovementRequest, MovementUpdateRequest } from '@/pages/panel/movement/interface/Movement';
import { MovementServices } from '@/services/movementService';
import { reactive } from 'vue';

export function useMovement() {
    const principal = reactive({
        movementList: [] as MovementResource[],
        movementData: {} as MovementResource,
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
        idMovement: 0,
        loading: true,
        statusModal: {
            update: false,
            delete: false,
        },
    });

    // Load movements with pagination and search
    const loadingMovements = async (page = 1, codigo = '') => {
        principal.loading = true;
        try {
            const response = await MovementServices.index(page, codigo);
            principal.movementList = response.movements;
            principal.paginacion = response.pagination;
        } catch (error) {
            console.error('Error loading movements:', error);
        } finally {
            principal.loading = false;
        }
    };

    // Create a movement
    const createMovement = async (data: MovementRequest) => {
        try {
            await MovementServices.store(data);
        } catch (error) {
            console.error('Error creating movement:', error);
        }
    };

    // Get movement by ID for editing
    const getMovementById = async (id: number) => {
        try {
            const response = await MovementServices.show(id);
            principal.movementData = response.movement;
            principal.statusModal.update = true;
        } catch (error) {
            console.error('Error getting movement:', error);
        }
    };

    // Update movement
    const updateMovement = async (id: number, data: MovementUpdateRequest) => {
        try {
            await MovementServices.update(id, data);
            loadingMovements();
        } catch (error) {
            console.error('Error updating movement:', error);
        }
    };

    // Delete movement
    const deleteMovement = async (id: number) => {
        try {
            await MovementServices.destroy(id);
            loadingMovements();
            principal.statusModal.delete = false;
        } catch (error) {
            console.error('Error deleting movement:', error);
        }
    };

    return {
        principal,
        loadingMovements,
        createMovement,
        getMovementById,
        updateMovement,
        deleteMovement,
    };
}