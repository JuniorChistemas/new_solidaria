import {
    ZoneDeleteResponse,
    ZoneRequest,
    ZoneResponse,
    ZoneUpdateRequest,
    showZoneResponse,
} from '@/pages/panel/zone/interface/Zone';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

export const ZoneServices = {
    //list zones
    async index(page: number, name: string): Promise<ZoneResponse> {
        const response = await axios.get(`/panel/listar-zones?page=${page}&name=${encodeURIComponent(name)}`);
        return response.data;
    },
    //inertia
    async store(data: ZoneRequest) {
        router.post(route('panel.zones.store'), data);
    },
    // show zones
    async show(id: number): Promise<showZoneResponse> {
        const response = await axios.get(`zones/${id}`);
        return response.data;
    },
    // update zones
    async update(id: number, data: ZoneUpdateRequest): Promise<showZoneResponse> {
        const response = await axios.put(`zones/${id}`, data);
        return response.data;
    },
    // detele zones
    async destroy(id: number): Promise<ZoneDeleteResponse> {
        const response = await axios.delete(`zones/${id}`);
        return response.data;
    },
};
