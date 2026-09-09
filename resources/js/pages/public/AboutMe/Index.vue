<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';
import { BriefcaseBusiness, Coffee, Download, Github, Globe, Heart, Linkedin, Mail, MapPin, Phone, Rocket, Twitter } from 'lucide-vue-next';
import PortfolioLayout from '@/layouts/PortfolioLayout.vue';

defineOptions({ layout: PortfolioLayout });

defineProps({
  profile: {
    type: Object,
    required: true,
  },
});

const statIcons = [Rocket, BriefcaseBusiness, Heart, Coffee];


</script>

<template>
  <Head title="About Me" />
  
    
  <main class="mx-auto max-w-7xl px-6 py-14 md:py-20">
    <section class="grid gap-12 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)] lg:items-center">
      <div class="relative mx-auto w-full max-w-md">
        <div class="aspect-[4/5] overflow-hidden rounded-2xl bg-slate-200 dark:bg-slate-800">
          <img
            v-if="profile.profileImage || profile.bannerImage"
            :src="profile.profileImage || profile.bannerImage"
            :alt="profile.fullName"
            class="h-full w-full object-cover"
          />
        </div>
        <div
          v-if="profile.availability"
          class="absolute -bottom-5 -right-3 flex items-center gap-2 rounded-lg border border-emerald-200 bg-white px-4 py-3 text-sm font-medium text-emerald-700 shadow-lg dark:border-emerald-400/20 dark:bg-slate-900 dark:text-emerald-400"
        >
          <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
          {{ profile.availability }}
        </div>
      </div>

      <div>
        <p class="text-sm font-semibold uppercase tracking-wider text-violet-500">About Me</p>
        <h1 class="mt-3 text-4xl font-bold text-slate-950 dark:text-white md:text-5xl">{{ profile.fullName }}</h1>
        <p v-if="profile.headline" class="mt-3 text-xl font-medium text-violet-600 dark:text-violet-400">{{ profile.headline }}</p>
        <p v-if="profile.shortBio" class="mt-6 text-lg leading-8 text-slate-700 dark:text-slate-300">{{ profile.shortBio }}</p>
        <p v-if="profile.longBio" class="mt-5 whitespace-pre-line leading-7 text-slate-600 dark:text-slate-400">{{ profile.longBio }}</p>

        <div v-if="profile.location || profile.email || profile.phone" class="mt-8 grid gap-3 text-sm text-slate-600 dark:text-slate-400 sm:grid-cols-2">
          <p v-if="profile.location" class="flex items-center gap-2"><MapPin class="h-4 w-4 shrink-0 text-violet-500" />{{ profile.location }}</p>
          <a v-if="profile.email" :href="`mailto:${profile.email}`" class="flex items-center gap-2 transition hover:text-violet-600 dark:hover:text-violet-400"><Mail class="h-4 w-4 shrink-0 text-violet-500" />{{ profile.email }}</a>
          <a v-if="profile.phone" :href="`tel:${profile.phone}`" class="flex items-center gap-2 transition hover:text-violet-600 dark:hover:text-violet-400"><Phone class="h-4 w-4 shrink-0 text-violet-500" />{{ profile.phone }}</a>
        </div>

        <div class="mt-8 flex flex-wrap items-center gap-3">
          <a v-if="profile.resumeUrl" :href="profile.resumeUrl" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-violet-600 to-indigo-500 px-5 py-3 text-sm font-medium text-white shadow-lg shadow-violet-600/20 transition hover:opacity-90">
            <Download class="h-4 w-4" />
            Download Resume
          </a>
          <div class="flex items-center gap-2">
            <a v-if="profile.githubUrl" :href="profile.githubUrl" aria-label="GitHub profile" class="grid h-10 w-10 place-items-center rounded-full bg-slate-200 text-slate-700 transition hover:bg-slate-300 dark:bg-white/5 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"><Github class="h-4 w-4" /></a>
            <a v-if="profile.linkedinUrl" :href="profile.linkedinUrl" aria-label="LinkedIn profile" class="grid h-10 w-10 place-items-center rounded-full bg-slate-200 text-slate-700 transition hover:bg-slate-300 dark:bg-white/5 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"><Linkedin class="h-4 w-4" /></a>
            <a v-if="profile.twitterUrl" :href="profile.twitterUrl" aria-label="Twitter profile" class="grid h-10 w-10 place-items-center rounded-full bg-slate-200 text-slate-700 transition hover:bg-slate-300 dark:bg-white/5 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"><Twitter class="h-4 w-4" /></a>
            <a v-if="profile.websiteUrl" :href="profile.websiteUrl" aria-label="Personal website" class="grid h-10 w-10 place-items-center rounded-full bg-slate-200 text-slate-700 transition hover:bg-slate-300 dark:bg-white/5 dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-white"><Globe class="h-4 w-4" /></a>
          </div>
        </div>
      </div>
    </section>

    <section class="mt-20 grid grid-cols-2 gap-px overflow-hidden rounded-xl border border-slate-200 bg-slate-200 dark:border-white/10 dark:bg-white/10 sm:grid-cols-4">
      <div v-for="(stat, index) in profile.stats" :key="stat.label" class="bg-white p-6 dark:bg-slate-950">
        <component :is="statIcons[Number(index)]" class="h-5 w-5 text-violet-500" />
        <p class="mt-5 text-3xl font-bold text-slate-950 dark:text-white">{{ stat.value }}</p>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ stat.label }}</p>
      </div>
    </section>
  </main>
</template>