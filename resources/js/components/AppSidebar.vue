<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen,  
    Folder, 
    GitPullRequest, 
    LayoutGrid, 
    UserCog,   
    Map,
    Users,
    Box,
    PackageCheck,
    Truck,
    Building } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Principal',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    ];
    const mainNavItems2: NavItem[] = [
    {
        title: 'Proveedores',
        href: '/panel/suppliers',
        icon: PackageCheck,
    },

    {
        title: 'Doctores',
        href: '/panel/doctors',
        icon: GitPullRequest,
    },    
    {
        title: 'Tipos de cliente',
        href: '/panel/clientTypes',
        icon: Users,
    },
    ];
    const mainNavItems3: NavItem[] = [  
    {
        title: 'Productos',
        href: '#',
        icon: Box,
        items: [
    {
        title: 'Productos Disponibles',
        href: '/panel/products',
    },
    {
        title: 'Categorías',
        href: '/panel/categories',
    },
    {
        title: 'Laboratorios',
        href: '/panel/laboratories',
    },
        ],
    }, 
    {
        title: 'Movimientos',
        href: '#',
        icon: Truck,
        items: [
        {
        title: 'Movimientos',
        href: '/panel/movements',
    },
    ],
    },
];
  
const mainNavItems4: NavItem[] = [     
    {   
        title: 'Roles',
        href: '/panel/roles',
        icon: UserCog, 
    },  
    {
        title: 'Zonas',
        href: '/panel/zones',
         icon: Map,
    },
    {
        title: 'Locales',
        href: '/panel/locals',
         icon: Building,
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
            <NavMain 
            :items="mainNavItems" 
            :items2="mainNavItems2" 
            :items3="mainNavItems3" 
            :items4="mainNavItems4" 
            />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
