<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

type AboutMeRecord = {
    id: number;
    full_name: string | null;
    headline: string | null;
    short_bio: string | null;
    email: string | null;
};

const props = defineProps<{
    aboutMe: AboutMeRecord;
}>();
</script>

<template>
    <Head :title="`About Me #${props.aboutMe.id}`" />

    <AppLayout>
        <div>
            <h1>About Me Details</h1>
            <p><strong>Name:</strong> {{ props.aboutMe.full_name ?? '—' }}</p>
            <p><strong>Headline:</strong> {{ props.aboutMe.headline ?? '—' }}</p>
            <p><strong>Short Bio:</strong> {{ props.aboutMe.short_bio ?? '—' }}</p>
            <p><strong>Email:</strong> {{ props.aboutMe.email ?? '—' }}</p>
        </div>
    </AppLayout>
</template>