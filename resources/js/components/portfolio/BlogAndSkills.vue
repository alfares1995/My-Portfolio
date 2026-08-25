<script setup>
defineProps({
  posts: { type: Array, default: () => [] },
  skills: { type: Array, default: () => [] },
});
</script>

<template>
  <section class="mx-auto grid max-w-7xl gap-10 px-6 py-16 lg:grid-cols-3">
    <!-- Blog posts: takes 2/3 width -->
    <div class="lg:col-span-2">
      <div class="mb-6 flex items-end justify-between">
        <div>
          <span class="text-sm font-semibold uppercase tracking-wider text-violet-400">Latest Blog Posts</span>
        </div>
        <a href="/blog" class="text-sm font-medium text-violet-400 hover:text-violet-300">
          View All Posts →
        </a>
      </div>

      <div class="grid gap-6 sm:grid-cols-3">
        <article v-for="post in posts" :key="post.title">
          <img :src="post.image" :alt="post.title" class="h-32 w-full rounded-xl object-cover" />
          <p class="mt-3 text-xs text-slate-500">{{ post.date }}</p>
          <h3 class="mt-1 font-semibold leading-snug text-white">{{ post.title }}</h3>
          <p class="mt-2 line-clamp-2 text-sm text-slate-400">{{ post.excerpt }}</p>
          <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
            <span>{{ post.readTime }}</span>
            <a :href="post.url" class="text-violet-400 hover:text-violet-300">→</a>
          </div>
        </article>
      </div>
    </div>

    <!-- Skills: takes 1/3 width -->
    <div>
      <span class="text-sm font-semibold uppercase tracking-wider text-violet-400">My Skills</span>

      <div class="mt-6 space-y-5">
        <div v-for="skill in skills" :key="skill.name">
          <div class="mb-1.5 flex justify-between text-sm">
            <span class="text-slate-200">{{ skill.name }}</span>
            <span class="text-slate-400">{{ skill.level }}%</span>
          </div>
          <div class="h-1.5 w-full overflow-hidden rounded-full bg-white/5">
            <div
              class="h-full rounded-full bg-gradient-to-r from-violet-600 to-indigo-400"
              :style="{ width: skill.level + '%' }"
            ></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
