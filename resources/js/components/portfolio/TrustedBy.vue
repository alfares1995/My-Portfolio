<script setup>
defineProps({ logos: { type: Array, default: () => [] } });
</script>

<template>
  <section class="border-y border-white/5 bg-white/[0.02] py-8">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-6 px-6">
      <span class="text-xs font-medium uppercase tracking-wider text-slate-500">Trusted by</span>
      <div class="flex flex-wrap items-center gap-10 text-slate-400">
        <span v-for="logo in logos" :key="logo" class="text-lg font-medium">
          {{ logo }}
        </span>
      </div>
    </div>
  </section>
</template>
