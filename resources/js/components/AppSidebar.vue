<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Car, FlaskConical, Folder, LayoutGrid, DoorClosed , BookText , ArrowLeftRight , Package, List , User2 , Syringe} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Principal',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Proveedores',
        href: '/panel/suppliers',
        icon: Car,
    },
    {
        title: 'Categorías',
        href: '/panel/categories',
        icon: List,
    },
    {
        title: 'Doctores',
        href: '/panel/doctors',
        icon: Syringe,
    },
    {
        title: 'Laboratorios',
        href: '/panel/laboratories',
        icon: FlaskConical,
    },
    {
        title: 'Zonas',
        href: '/panel/zones',
         icon: DoorClosed,
    },
    {
        title: 'Tipos de cliente',
        href: '/panel/clientTypes',
        icon: User2,
    },
    {
        title: 'Productos',
        href: '/panel/products',
        icon: Package,
    }, 
    {
        title: 'Movimientos',
        href: '/panel/movements',
        icon: ArrowLeftRight,
    },
    {
        title: 'Inventario',
        href: '/panel/inventory',
        icon: BookText,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
