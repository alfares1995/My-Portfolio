<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { BookOpen, FolderGit2, LayoutGrid, ChevronRight, StickyNote, ArrowsUpFromLine, BookText, University, PencilRuler, SwatchBook } from 'lucide-vue-next';

import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { index as aboutMe } from '@/routes/admin/about-me';
import { index as blogPosts } from '@/routes/admin/blog-posts';
import { index as blogCategories } from '@/routes/admin/blog-categories';
import { index as projects } from '@/routes/admin/projects';
import { index as technologies } from '@/routes/admin/technologies';
import { index as skills } from '@/routes/admin/skills';
import { index as educations } from '@/routes/admin/educations';
import { index as experiences } from '@/routes/admin/experiences';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'About Me',
        href: aboutMe(),
        icon: ChevronRight,
    },
    {
        title: 'Blog Posts',
        href: blogPosts(),
        icon: StickyNote,
    },
    {
        title: 'Blog Categories',
        href: blogCategories(),
        icon: ArrowsUpFromLine,
    },
    {
        title: 'Projects',
        href: projects(),
        icon: FolderGit2,
    },
     {
        title: 'Technologies',
        href: technologies(),
        icon: BookText ,
    },
    {
        title: 'Skills',
        href: skills(),
        icon: SwatchBook,
    },
    {
        title: 'Education',
        href: educations(),
        icon: University ,
    },
    {
        title: 'Experiences',
        href: experiences(),
        icon: PencilRuler ,
    },

];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: FolderGit2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
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
                        <Link :href="dashboard()">
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
