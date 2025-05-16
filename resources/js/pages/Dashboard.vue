<script setup lang="ts">
import CustomerChart from '@/components/Charts/CustomerChart.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const props = defineProps<{
    locales: Array<{
        local: { id: number; name: string };
        total_users: number;
        total_guias_enviadas: number;
        total_guias_recibidas: number;
        total_ventas: number;
    }>;
}>();

const chartData = {
    users: {
        labels: props.locales.map((local) => local.local.name),
        values: props.locales.map((local) => local.total_users),
    },
    sentGuides: {
        labels: props.locales.map((local) => local.local.name),
        values: props.locales.map((local) => local.total_guias_enviadas),
    },
    receivedGuides: {
        labels: props.locales.map((local) => local.local.name),
        values: props.locales.map((local) => local.total_guias_recibidas),
    },
    sales: {
        labels: props.locales.map((local) => local.local.name),
        values: props.locales.map((local) => local.total_ventas),
    },
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-auto overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <CustomerChart
                        :columns-x="chartData.users.labels"
                        :columns-y="chartData.users.values"
                        title="Usuarios"
                        subtitle="Usuarios por local"
                        chart-type="area"
                    />
                </div>
                <div class="relative aspect-auto overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <CustomerChart
                        :columns-x="chartData.users.labels"
                        :columns-y="chartData.users.values"
                        title="Guias enviadas"
                        subtitle="Guias enviadas por local"
                        chart-type="scatter"
                    />
                </div>
                <div class="relative aspect-auto overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <CustomerChart
                        :columns-x="chartData.receivedGuides.labels"
                        :columns-y="chartData.receivedGuides.values"
                        title="Guias recibidas"
                        subtitle="guias recibidas por local"
                        chart-type="bar"
                    />
                </div>
            </div>
            <div class="relative h-[400px] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <CustomerChart
                    :columns-x="chartData.sales.labels"
                    :columns-y="chartData.sales.values"
                    title="VENTAS"
                    subtitle="Ventas por vendedor del local"
                    chart-type="radar"
                />
            </div>
        </div>
    </AppLayout>
</template>
