<template>
    <label for = 'service' class = 'block text-sm font-bold mb-2'> Pasirinkite paslaugą: </label>
    <select id = 'service' v-model = 'selectedService' class = 'text-sm border rounded px-2 py-2 w-full mb-4'>
        <option disabled value = ''> Pasirinkite paslaugą </option>
        <option v-for = 'service in services' :key = 'service.id' :value = 'service.id'> {{ service.service_title }} </option>
    </select>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import axios from 'axios';

    const selectedService = defineModel()
    const services = ref([]);

    onMounted(() => {
        fetchServices()
    })

    const fetchServices = async () => {
        try {
            const response = await axios.get('services');
            services.value = response.data.data.services ?? [];
        } catch (error) {
            services.value = [];
        }
    }
</script>
