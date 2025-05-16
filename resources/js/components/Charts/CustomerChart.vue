<template>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4">
        <VueApexCharts :type="props.chartType" :options="options" :series="series" />
    </div>
</template>

<script setup lang="ts">
import { useAppearance } from '@/composables/useAppearance';
import { computed, onMounted, ref, watch } from 'vue';
import VueApexCharts from 'vue3-apexcharts';

const props = defineProps<{
    columnsY: number[];
    columnsX: string[];
    title: string;
    subtitle: string;
    chartType: 'bar' | 'line' | 'area' | 'radar' | 'scatter' | 'heatmap' | 'polarArea';
    height?: number;
    width?: number;
}>();

const { appearance } = useAppearance();
const isDarkMode = computed(
    () => appearance.value === 'dark' || (appearance.value === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches),
);

const chartColors = ref<string[]>([]);

// Función para obtener un color CSS de una variable CSS personalizada
const getCssVariable = (variableName: string): string => {
    const color = getComputedStyle(document.documentElement).getPropertyValue(variableName).trim();

    // Las variables en app.css están en formato HSL
    if (color.includes(' ')) {
        return `hsl(${color})`;
    }
    return color;
};
const updateChartColors = () => {
    chartColors.value = [getCssVariable('--chart-1')];
};

onMounted(() => {
    updateChartColors();
});

// Actualizar colores cuando cambie el tema
watch(isDarkMode, updateChartColors);

const series = computed(() => [
    {
        name: props.title,
        data: props.columnsY,
    },
]);

const options = computed(() => ({
    chart: {
        height: props.height ?? '100%',
        width: props.width ?? '100%',
        background: 'transparent',
        toolbar: { show: true },
        animations: { enabled: true },
    },
    title: {
        text: props.title,
        align: 'left',
    },
    subtitle: {
        text: props.subtitle,
        align: 'left',
    },
    xaxis: {
        categories: props.columnsX,
    },
    dataLabels: {
        enabled: false,
    },
    plotOptions: {
        bar: {
            distributed: false,
        },
    },
    colors: [chartColors.value[0]],
    theme: {
        mode: isDarkMode.value ? 'dark' : 'light',
    },
    tooltip: {
        theme: isDarkMode.value ? 'dark' : 'light',
    },
    grid: {
        borderColor: isDarkMode.value ? getCssVariable('--border') : getCssVariable('--border'),
    },
}));
</script>

<style scoped></style>
