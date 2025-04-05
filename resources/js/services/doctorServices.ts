import {
    DoctorDeleteResponse,
    DoctorResponse,
    showDoctorResponse,
    storeDoctorRequest,
    updateDoctorRequest,
} from '@/pages/panel/doctor/interface/Doctor';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

export const DoctorServices = {
    //list doctors
    async index(page: number, name: string): Promise<DoctorResponse> {
        const response = await axios.get(`/panel/listar-doctors?page=${page}&name=${encodeURIComponent(name)}`);
        return response.data;
    },
    //inertia
    async store(data: storeDoctorRequest) {
        router.post(route('panel.doctors.store'), data);
    },
    // show doctors
    async show(id: number): Promise<showDoctorResponse> {
        const response = await axios.get(`doctors/${id}`);
        // const doctorData = {
        //     ...response.data.doctor,
        //     start_date: backendDateToHtmlDate(response.data.doctor.start_date),
        // };
        // return {
        //     ...response.data,
        //     doctor: doctorData,
        // };
        // console.log('hol23332' + response.data.doctor.start_date);
        return response.data;
    },
    // update doctors
    async update(id: number, data: updateDoctorRequest): Promise<showDoctorResponse> {
        const response = await axios.put(`doctors/${id}`, data);
        return response.data;
    },
    // delete doctors
    async destroy(id: number): Promise<DoctorDeleteResponse> {
        const response = await axios.delete(`doctors/${id}`);
        return response.data;
    },
};
