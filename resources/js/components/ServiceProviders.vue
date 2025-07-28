<template>
    <div v-if = 'serviceProviders.length > 0'> 
        <label class = 'block text-sm font-bold mb-2'> Pasirinkite paslaugų teikėją: </label>
        <div class = 'mb-4' v-for = '(serviceProvider, index) in serviceProviders' :key = 'serviceProvider.id'>
            <div @click = 'toggleServiceProvider(serviceProvider)'
                class = 'cursor-pointer px-4 py-2 rounded-md border transition-colors mb-4'
                :class = "[serviceProvider.is_active ? 'bg-black text-white border-black' : 'bg-white text-black border-gray-300']">
                <span class = 'font-bold text-sm'> {{ serviceProvider.name }} </span>
            </div>
        </div>

        <div v-if = 'selectedServiceProvider'>
            <AppointmentForm :serviceProviderID = 'selectedServiceProvider.id' />
        </div>
    </div>
    <div v-else class = 'block text-sm font-bold mb-2'> Dar nėra užsiregistravusių paslaugų tiekėjų! </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue'
    import axios from 'axios'
    import AppointmentForm from './AppointmentForm.vue';

    const serviceProviders = ref([]);
    const selectedServiceProvider = ref(null);

    onMounted(() => {
        fetchServiceProviders()
    })

    const fetchServiceProviders = async () => {
        try {
            const response = await axios.get('service_providers');
            serviceProviders.value = response.data.data.service_providers ?? [];
        } catch (error) {
            serviceProviders.value = [];
        }
    }

    const toggleServiceProvider = (serviceProvider) => {
        serviceProviders.value.forEach(serviceProvider => { serviceProvider.is_active = false });
        selectedServiceProvider.value = selectedServiceProvider.value?.id === serviceProvider.id ? null : serviceProvider;
        serviceProvider.is_active = selectedServiceProvider.value?.id !== serviceProvider.id ? false : true;
    }
</script>
