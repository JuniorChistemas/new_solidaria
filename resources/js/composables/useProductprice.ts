import { InputProduct } from '@/interface/Inputs';
import { Pagination } from '@/interface/paginacion';
import { ProductpriceRequest, ProductpriceRequestUpdate, ProductpriceResource } from '@/pages/panel/product_price/interface/Product_price';
import { ProductpriceServices } from '@/services/productpriceService';
import { showSuccessMessage } from '@/utils/message';
import { reactive } from 'vue';

export const useProductprice = () => {
    const principal = reactive<{
        productpriceList: ProductpriceResource[];
        paginacion: Pagination;
        loading: boolean;
        filter: string;
        idProductprice: number;
        statusModal: {
            update: boolean;
            delete: boolean;
        };
        productData: ProductpriceResource;
        productList: InputProduct[];
    }>({
        productpriceList: [],
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
        idProductprice: 0,
        statusModal: {
            update: false,
            delete: false,
        },
        productData: {
            id: 0,
            product_id: 0,
            product: '',
            box_price: 0,
            fraction_price: 0,
        },
        productList: [],
    });

    // reset product_prices data
    const resetProductData = () => {
        principal.productData = {
            id: 0,
            product_id: 0,
            product: '',
            box_price: 0,
            fraction_price: 0,
        };
    };

    // loading Product_prices
    const loadingProductsprice = async (page: number = 1, name: string = '') => {
        principal.loading = true;
        try {
            const response = await ProductpriceServices.index(page, name);
            principal.productpriceList = response.productsprice;
            principal.paginacion = response.pagination;
            console.log(response);
            if (principal.productList.length === 0 && principal.paginacion.current_page === 1) {
                const productpriceResponse = await ProductpriceServices.getProduct();
                principal.productList = productpriceResponse.data;
                console.log('envie la peticion');
            }

        } catch (error) {
            console.error(error);
        } finally {
            principal.loading = false;
        }
    };

    // creating Product_price
    const createProduct = async (data: ProductpriceRequest) => {
        try {
            await ProductpriceServices.store(data);
        } catch (error) {
            console.error(error);
        }
    };

    // get product_price by id
    const getProductpriceById = async (id: number) => {
        try {
            if (id === 0) {
                resetProductData();
                return;
            }
            const response = await ProductpriceServices.show(id);
            if (response) {
                principal.productData = response.productprice;
                console.log(principal.productData.product);
                principal.idProductprice = response.productprice.id;
                if (principal.productList.length === 0) {
                    const productpriceResponse = await ProductpriceServices.getProduct();
                    principal.productList = productpriceResponse.data;
                    console.log('envie la peticion');
                }
                principal.statusModal.update = true;
            }
        } catch (error) {
            console.error(error);
        }
    };

    // update product_price
    const updateProduct = async (id: number, data: ProductpriceRequestUpdate) => {
        try {
            const response = await ProductpriceServices.update(id, data);
            if (response) {
                showSuccessMessage('Producto actualizado', 'El producto se actualizó correctamente');
                principal.statusModal.update = false;
                loadingProductsprice(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        } finally {
            principal.productList = [];
        }
    };

    // delete product_price
    const deleteProduct = async (id: number) => {
        try {
            const response = await ProductpriceServices.destroy(id);
            if (response) {
                showSuccessMessage('Producto eliminado', 'El producto se eliminó correctamente');
                principal.statusModal.delete = false;
                loadingProductsprice(principal.paginacion.current_page, principal.filter);
            }
        } catch (error) {
            console.error(error);
        } finally {
            principal.statusModal.delete = false;
        }
    };

    return {
        principal,
        loadingProductsprice,
        createProduct,
        getProductpriceById,
        resetProductData,
        updateProduct,
        deleteProduct,
    };
};
