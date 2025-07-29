<template>
    <form @submit.prevent = 'onSubmit'>
        <label class = 'block text-sm font-bold mb-2'> Pasirinkite paslaugos datą: </label>
        <Datepicker class = 'mb-4' v-model = 'selectedDate' auto-position = 'top' :time-picker = 'false' :min-date = 'startOfToday' />
        <p v-if = 'validations.selectedDate' class = 'bg-red-400 text-white text-sm font-bold mb-4 px-4 py-2 rounded-xl'> {{ validations.selectedDate }} </p>

        <p class = 'bg-green-400 text-white text-sm font-bold mb-2 px-4 py-2 rounded-xl' v-if = 'successMessage'> {{ successMessage }} </p>

        <div v-if = 'selectedDate'>
            <WorkingHours v-model = 'selectedTime' :key = 'selectedDate' :serviceProviderID = 'props.serviceProviderID' :date = 'selectedDate' />
            <p v-if = 'validations.selectedTime' class = 'bg-red-400 text-white text-sm font-bold mb-4 px-4 py-2 rounded-xl'> {{ validations.selectedTime }} </p>

            <ServiceSelection class = 'mb-4' v-model = 'selectedService' />
            <p v-if = 'validations.selectedService' class = 'bg-red-400 text-white text-sm font-bold mb-4 px-4 py-2 rounded-xl'> {{ validations.selectedService }} </p>

            <div class = 'mb-4'>
                <label for = 'email' class = 'block text-sm font-bold mb-2'> Jūsų el. paštas </label>
                <input type = 'email' id = 'email' v-model = 'email' class = 'w-full px-4 py-2 border text-sm border-gray-300 rounded-md focus:outline-none mb-4' placeholder = 'Įveskite savo el. paštą' />
                <p v-if = 'validations.email' class = 'bg-red-400 text-white text-sm font-bold mb-4 px-4 py-2 rounded-xl'> {{ validations.email }} </p>
            </div>

            <p class = 'bg-red-400 text-white text-sm font-bold mb-2 px-4 py-2 rounded-xl' v-if = 'errorMessage'> {{ errorMessage }} </p>
            <button type = 'submit' class = 'bg-black hover:bg-gray-900 text-white font-bold text-sm rounded-xl px-8 py-2 cursor-pointer'> Užsakyti paslaugą </button>
        </div>
    </form>
</template>

<script setup>
    import { ref, reactive, watch } from 'vue'
    import Datepicker from '@vuepic/vue-datepicker';
    import axios from 'axios';
    import '@vuepic/vue-datepicker/dist/main.css';
    import { useDateFormat } from '@vueuse/core'
    import WorkingHours from './WorkingHours.vue';
    import ServiceSelection from './ServiceSelection.vue';

    const currentDate = new Date();
    const startOfToday = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate());
    const selectedDate = ref();
    const selectedTime = ref();
    const selectedService = ref('');
    const email = ref('');
    const successMessage = ref('');
    const errorMessage = ref('');
    const validations = reactive({
        selectedDate: '',
        selectedTime: '',
        selectedService: '',
        email: ''
    });

    const props = defineProps({
        serviceProviderID: {
                type: Number,
                default: null
            }
        }
    );

    watch(() => props.serviceProviderID, () => {
        clearValues();
    });

    const onSubmit = async () => {
        if (validateForm()) {
            const payload = { service_provider_id: props.serviceProviderID, appointment_date: useDateFormat(selectedDate.value, 'YYYY-MM-DD').value, appointment_time: selectedTime.value, service_id: selectedService.value, client_email: email.value };

            await axios.post('appointments', payload).then(response => {
                clearValues();
                successMessage.value = response.data.message;
                setTimeout(() => {
                    successMessage.value = '';
                }, 3000);
            }).catch(error => {
                errorMessage.value = error.response.data.message ?? 'Įvyko klaida! Peržiūrėkite įvestus duomenis ir bandykite dar kartą.';
            });
        }
    }

    const validateForm = () => {
        validations.selectedDate = selectedDate.value ? '' : 'Pasirinkite pageidaujamą paslaugos datą';
        validations.selectedTime = selectedTime.value ? '' : 'Pasirinkite pageidaujamą paslaugos laiką';
        validations.selectedService = selectedService.value ? '' : 'Pasirinkite pageidaujamą paslaugą';
        
        if (!email.value) {
            validations.email = 'El. paštas yra privalomas';
        } else if (!/\S+@\S+\.\S+/.test(email.value)) {
            validations.email = 'Neteisingas el. pašto formatas';
        } else {
            validations.email = '';
        }

        return Object.values(validations).every((validation) => validation === '');
    };

    const clearValues = () => {
        selectedDate.value = '';
        selectedTime.value = '';
        selectedService.value = '';
        email.value = '';
        successMessage.value = '';
        errorMessage.value = '';
        validations.selectedDate = '';
        validations.selectedTime = '';
        validations.selectedService = '';
        validations.email = '';
    }
</script>
