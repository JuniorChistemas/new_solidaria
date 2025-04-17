import { Pagination } from '@/interface/paginacion';

// interface for list and show doctor
export type DoctorResource = {
    id: number;
    name: string;
    code: string;
    start_date: string;
    state: boolean;
    created_at: string;
};

// interface for adding doctor
export type storeDoctorRequest = {
    name: string;
    code: string;
    start_date: string;
};

// interface for update doctor
export type updateDoctorRequest = {
    name: string;
    code: string;
    start_date: string;
    state: boolean;
};

// interface response for add and update doctor
export type showDoctorResponse = {
    status: boolean;
    message: string;
    doctor: DoctorResource;
};

// interface response of delete doctor
export type DoctorDeleteResponse = {
    status: boolean;
    message: string;
};

// interface json response of list doctor in cotroller
export type DoctorResponse = {
    doctors: DoctorResource[];
    pagination: Pagination;
};
