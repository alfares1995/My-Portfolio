<script setup>
import { Rocket, Heart, Code2, Coffee } from 'lucide-vue-next';

defineProps({ profile: Object });

const iconMap = { rocket: Rocket, heart: Heart, code: Code2, coffee: Coffee };
</script>

<template>
  <section class="mx-auto grid max-w-7xl gap-12 px-6 py-20 md:grid-cols-2 md:items-center">
    <img
      :src="profile.banner"
      alt="John Doe working"
      class="rounded-2xl object-cover shadow-2xl"
    />

    <div>
      <span class="text-sm font-semibold uppercase tracking-wider text-violet-400">About Me</span>
      <h2 class="mt-3 text-3xl font-bold text-white md:text-4xl">
        Crafting Digital Experiences That Make Impact
      </h2>
      <p class="mt-4 text-slate-400">
        {{ profile.longBio }}
      </p>

      <div class="mt-10 grid grid-cols-2 gap-8 sm:grid-cols-4">
        <div v-for="stat in profile.stats" :key="stat.label">
          <component :is="iconMap[stat.icon]" class="h-5 w-5 text-violet-400" />
          <p class="mt-2 text-2xl font-bold text-white">{{ stat.value }}</p>
          <p class="text-xs text-slate-500">{{ stat.label }}</p>
        </div>
      </div>

      <a href="#about" class="mt-8 inline-flex items-center gap-1 text-sm font-medium text-violet-400 hover:text-violet-300">
        Read More About Me →
      </a>
    </div>
  </section>
</template>
