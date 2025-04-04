import { Pagination } from '@/interface/paginacion';
import { CategoryRequest, CategoryResource, CategoryUpdateRequest } from '@/pages/panel/category/interface/Category';
import { CategoryServices } from '@/services/categoryServices';
import { showSuccessMessage } from '@/utils/message';
import { reactive } from 'vue';

export const useCategory = () => {
    const principal = reactive<{
        categoryList: CategoryResource[];
        paginacion: Pagination;
        loading: boolean;
        filter: string;
        idCategory: number;
        statusModal: {
            update: boolean;
            delete: boolean;
        };
        categoryData: CategoryResource;
    }>({
        categoryList: [],
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
        idCategory: 0,
        statusModal: {
            update: false,
            delete: false,
        },
        categoryData: {
            id: 0,
            name: '',
            status: true,
            created_at: '',
            updated_at: '',
        },
    });
        //reset category data
        const resetcategoryData = () => {
            principal.categoryData = {
                id: 0,
                name: '',
                status: true,
                created_at: '',
                updated_at: '',
            };
        };

    // loading categories
    const loadingCategories = async (page: number = 1, name: string = '', status: boolean = true) => {
        if (status) {
            principal.loading = true;
            try {
                const response = await CategoryServices.index(page, name);
                principal.categoryList = response.categories;
                principal.paginacion = response.pagination;
                console.log(response);
            } catch (error) {
                console.error(error);
            } finally {
                principal.loading = false;
            }
        }
    };
            // creating categories
            const createCategory = async (data: CategoryRequest) => {
                try {
                    await CategoryServices.store(data);
                } catch (error) {
                    console.error(error);
                }
            };
        // get Category by id
        const getCategoryById = async (id: number) => {
            try {
                if (id === 0) {
                    principal.categoryData = {
                        id: 0,
                        name: '',
                        status: true,
                        created_at: '',
                        updated_at: '',
                    };
                    return;
                }
            const response = await CategoryServices.show(id);
            if (response.status) {
                principal.categoryData = response.category;
                console.log(principal.categoryData.name);
                principal.idCategory = response.category.id;
                principal.statusModal.update = true;
            }
        } catch (error) {
            console.error(error);
        }
    };
    // update category
    const updateCategory = async (id: number, data: CategoryUpdateRequest) => {
        try {
            const response = await CategoryServices.update(id, data);
            if (response.status) {
                showSuccessMessage('Categoría actualizada', 'La categoría se actualizó correctamente');
                principal.statusModal.update = false;
                loadingCategories(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        }
    };
    // delete category
    const deleteCategory = async (id: number) => {
        try {
            const response = await CategoryServices.destroy(id);
            console.log(response.status);
            if (response.status) {
                showSuccessMessage('Categoría eliminada', 'La categoría se eliminó correctamente');
                principal.statusModal.delete = false;
                loadingCategories(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        } finally {
            principal.statusModal.delete = false;
        }
    };
    return {
        principal,
        loadingCategories,
        createCategory,
        getCategoryById,
        resetcategoryData,
        updateCategory,
        deleteCategory,
    };
};