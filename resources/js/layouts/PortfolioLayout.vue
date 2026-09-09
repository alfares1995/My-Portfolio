<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import NavBar from '@/components/portfolio/NavBar.vue';
import Footer from '@/components/portfolio/Footer.vue';

const page = usePage();

defineProps({
  title: { type: String, default: 'DevFolio' },
});
</script>

<template>
  <Head :title="title" />

  <div class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
    <NavBar />

    <!-- each page's own content goes here -->
    <slot />

    <Footer :profile="page.props.profile" :current-year="page.props.currentYear" />
  </div>
</template>
