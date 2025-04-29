<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import Collapsible from './ui/collapsible/Collapsible.vue';
import CollapsibleContent from './ui/collapsible/CollapsibleContent.vue';
import CollapsibleTrigger from './ui/collapsible/CollapsibleTrigger.vue';
import SidebarMenuSub from './ui/sidebar/SidebarMenuSub.vue';
import SidebarMenuSubItem from './ui/sidebar/SidebarMenuSubItem.vue';
import SidebarMenuSubButton from './ui/sidebar/SidebarMenuSubButton.vue';
import { ChevronRight } from 'lucide-vue-next';

defineProps<{
    items: NavItem[];
    items2: NavItem[];
    items3: NavItem[];
    items4: NavItem[];
}>();

const page = usePage<SharedData>();
    const isMenuActivo = (item: NavItem) => {
    return item.items?.some(subItem => subItem.href === page.url);
};
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Plataforma</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton 
                    as-child :is-active="item.href === page.url"
                    :tooltip="item.title"
                >
                    <Link :href="item.href">
                        <component :is="item.icon" />
                        <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
    <SidebarGroupLabel>Gestión de Personas</SidebarGroupLabel>
         <SidebarMenu>
            <SidebarMenuItem v-for="item in items2" :key="item.title">
                <SidebarMenuButton as-child :is-active="item.href === page.url" :tooltip="item.title">
                    <Link :href="item.href">
                        <component :is="item.icon" />
                        <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
        <SidebarGroupLabel>Gestión Comercial</SidebarGroupLabel>
        <SidebarMenu>
            <Collapsible v-for="item in items3" :key="item.title" as-child :default-open="isMenuActivo(item) || item.isActive"  class="group/collapsible" >
                <SidebarMenuItem>
                    <CollapsibleTrigger as-child>
                        <SidebarMenuButton :tooltip="item.title">
                            <component :is="item.icon" v-if="item.icon" />
                            <span>{{ item.title }}</span>
                            <ChevronRight class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                        </SidebarMenuButton>
                    </CollapsibleTrigger>
                    <CollapsibleContent>
                        <SidebarMenuSub>
                            <SidebarMenuSubItem v-for="subItem in item.items" :key="subItem.title" >
                                <SidebarMenuSubButton as-child :is-active="subItem.href === page.url">
                                    <Link :href="subItem.href">
                                        <span>{{ subItem.title }}</span>
                                    </Link>
                                </SidebarMenuSubButton>
                            </SidebarMenuSubItem>
                        </SidebarMenuSub>
                    </CollapsibleContent>
                </SidebarMenuItem>
            </Collapsible>
        </SidebarMenu>
        <SidebarGroupLabel>Adminsitración y Puntos</SidebarGroupLabel>
         <SidebarMenu>
            <SidebarMenuItem v-for="item in items4" :key="item.title">
                <SidebarMenuButton as-child :is-active="item.href === page.url" :tooltip="item.title">
                    <Link :href="item.href">
                        <component :is="item.icon" />
                        <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu> 
</template>
