<script setup lang = 'ts'>
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import WorkingHoursForm from '@/components/WorkingHoursForm.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Darbo valandų taisyklės',
        href: '/dashboard',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs = 'breadcrumbs'>
        <div class = 'flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto'>
            <WorkingHoursForm />
        </div>
    </AppLayout>
</template>
