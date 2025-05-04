import { InputLaboratory } from '@/interface/Inputs';
import { InputCategory } from '@/interface/Inputs';
import { Pagination } from '@/interface/paginacion';
import { ProductRequest, ProductRequestUpdate, ProductResource } from '@/pages/panel/product/interface/Product';
import { ProductServices } from '@/services/productService';
import { showSuccessMessage } from '@/utils/message';
import { reactive } from 'vue';

export const useProduct = () => {
    const principal = reactive<{
        productList: ProductResource[];
        paginacion: Pagination;
        loading: boolean;
        filter: string;
        idProduct: number;
        statusModal: {
            update: boolean;
            delete: boolean;
        };
        productData: ProductResource;
        laboratoryList: InputLaboratory[];
        categoryList: InputCategory[];
    }>({
        productList: [],
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
        idProduct: 0,
        statusModal: {
            update: false,
            delete: false,
        },
        productData: {
            id: 0,
            name: '',
            composition: '',
            presentation: '',
            form_farm: '',
            barcode: '',
            laboratory_id: 0,
            laboratory: '',
            category_id: 0,
            category: '',
            fraction: 0,
            state_fraction: true,
            state_igv: true,
            state: true,
        },
        laboratoryList: [],
        categoryList: [],
    });

    // reset product data
    const resetProductData = () => {
        principal.productData = {
            id: 0,
            name: '',
            composition: '',
            presentation: '',
            form_farm: '',
            barcode: '',
            laboratory_id: 0,
            laboratory: '',
            category_id: 0,
            category: '',
            fraction: 0,
            state_fraction: true,
            state_igv: true,
            state: true,
        };
    };

    // loading Products
    const loadingProducts = async (page: number = 1, name: string = '') => {
        principal.loading = true;
        try {
            const response = await ProductServices.index(page, name);
            principal.productList = response.products;
            principal.paginacion = response.pagination;
            console.log(response);
            if (principal.laboratoryList.length === 0 && principal.paginacion.current_page === 1) {
                const laboratoryResponse = await ProductServices.getLaboratory();
                principal.laboratoryList = laboratoryResponse.data;
                console.log('envie la peticion');
            }

            if (principal.categoryList.length === 0 && principal.paginacion.current_page === 1) {
                const categoryResponse = await ProductServices.getCategory();
                principal.categoryList = categoryResponse.data;
                console.log('envie la peticion');
            }
        } catch (error) {
            console.error(error);
        } finally {
            principal.loading = false;
        }
    };

    // creating Product
    const createProduct = async (data: ProductRequest) => {
        try {
            await ProductServices.store(data);
        } catch (error) {
            console.error(error);
        }
    };

    // get product by id
    const getProductById = async (id: number) => {
        try {
            if (id === 0) {
                resetProductData();
                return;
            }
            const response = await ProductServices.show(id);
            if (response.status) {
                principal.productData = response.product;
                console.log(principal.productData.name);
                principal.idProduct = response.product.id;
                if (principal.laboratoryList.length === 0) {
                    const laboratoryResponse = await ProductServices.getLaboratory();
                    principal.laboratoryList = laboratoryResponse.data;
                    console.log('envie la peticion');
                }
                if (principal.categoryList.length === 0) {
                    const categoryResponse = await ProductServices.getCategory();
                    principal.categoryList = categoryResponse.data;
                    console.log('envie la peticion');
                }
                principal.statusModal.update = true;
            }
        } catch (error) {
            console.error(error);
        }
    };

    // update product
    const updateProduct = async (id: number, data: ProductRequestUpdate) => {
        try {
            const response = await ProductServices.update(id, data);
            if (response.status) {
                showSuccessMessage('Producto actualizado', 'El producto se actualizó correctamente');
                principal.statusModal.update = false;
                loadingProducts(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        } finally {
            principal.laboratoryList = [];
            principal.categoryList = [];
        }
    };

    // delete product
    const deleteProduct = async (id: number) => {
        try {
            const response = await ProductServices.destroy(id);
            if (response.status) {
                showSuccessMessage('Producto eliminado', 'El producto se eliminó correctamente');
                principal.statusModal.delete = false;
                loadingProducts(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        } finally {
            principal.statusModal.delete = false;
        }
    };

    return {
        principal,
        loadingProducts,
        createProduct,
        getProductById,
        resetProductData,
        updateProduct,
        deleteProduct,
    };
};
