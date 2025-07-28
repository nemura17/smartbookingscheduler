<template>
    <h4 class = 'font-bold text-sm ml-2'> Pasirinkite darbo dienas ir jų darbo laikus </h4>
    <div v-for = '(day, index) in weekdays' :key = 'index'>
        <div @click = 'toggleDay(day)' class = 'cursor-pointer px-4 py-2 rounded-md border transition-colors' 
            :class = "[day.is_active ? 'bg-black text-white border-black' : 'bg-white text-black border-gray-300']">
            <span class = 'font-bold text-sm'> {{ day.label }} </span>
        </div>

        <div class = 'ml-4 my-4' v-if = 'day.is_active'>
            <label class = 'block text-sm font-bold mb-2'> Darbo laiko pradžia </label>
            <input class = 'text-sm border rounded px-2 py-2 mb-4' type = 'time' v-model = 'day.start_time' />

            <label class = 'block text-sm font-bold mb-2'> Darbo laiko pabaiga </label>
            <input class = 'text-sm border rounded px-2 py-2' type = 'time' v-model = 'day.end_time' />
        </div>
    </div>

    <div v-if = 'errorMessage' class = 'bg-red-400 py-2 px-8 text-white font-bold text-sm rounded-xl'> {{ errorMessage }} </div>
    <p v-if = 'successMessage' class = 'bg-green-400 text-white text-sm font-bold px-4 py-2 rounded-xl'> {{ successMessage }} </p>
    <button @click = 'onSubmit' class='bg-black hover:bg-gray-900 text-white font-bold text-sm rounded-xl px-8 py-2 cursor-pointer'> Saugoti </button>
</template>

<script setup>
    import { ref, onMounted } from 'vue'
    import axios from 'axios'

    const weekdays = ref([
        { value: 0, label: 'Sekmadienis', is_active: false, start_time: '', end_time: '' },
        { value: 1, label: 'Pirmadienis', is_active: false, start_time: '', end_time: '' },
        { value: 2, label: 'Antradienis', is_active: false, start_time: '', end_time: '' },
        { value: 3, label: 'Trečiadienis', is_active: false, start_time: '', end_time: '' },
        { value: 4, label: 'Ketvirtadienis', is_active: false, start_time: '', end_time: '' },
        { value: 5, label: 'Penktadienis', is_active: false, start_time: '', end_time: '' },
        { value: 6, label: 'Šeštadienis', is_active: false, start_time: '', end_time: '' }
    ]);

    const errorMessage = ref('');
    const successMessage = ref('');

    onMounted(async () => {
        fetchWorkingHours();
    });

    const toggleDay = (day) => {
        day.is_active = !day.is_active;
        if (!day.is_active) {
            day.start_time = '';
            day.end_time = '';
        }
    }

    const fetchWorkingHours = async () => {
        try {
            const response = await axios.get('working_hours', { withCredentials: true });
            const workingHours = response?.data?.data?.working_hours ?? [];

            weekdays.value.forEach(day => {
                const activeWorkingHour = workingHours.find(workingHour => workingHour.weekday === day.value);
                if (activeWorkingHour) {
                    day.is_active = true;
                    day.start_time = activeWorkingHour.start_time;
                    day.end_time = activeWorkingHour.end_time;
                } else {
                    day.is_active = false;
                    day.start_time = '';
                    day.end_time = '';
                }
            });
        } catch (error) {
            errorMessage.value = 'Įvyko klaida nustatant darbo valandas!';
        }
    };

    const onSubmit = async () => {
        errorMessage.value = '';

        const payload = weekdays.value.filter(day => day.is_active).map(day => ({ weekday: day.value, start_time: day.start_time, end_time: day.end_time }));
        if (payload.length === 0) {
            errorMessage.value = 'Prašome užpildyti bent vienos darbo dienos taisykles';

            return;
        }

        try {
            const response = await axios.post('working_hours', payload, { withCredentials: true });
            successMessage.value = 'Darbo valandos išsaugotos sėkmingai!';
            setTimeout(() => {
                successMessage.value = '';
            }, 3000);
        } catch (error) {
            errorMessage.value = 'Įvyko klaida! Peržiūrėkite užpildytus duomenis ir bandykite dar kartą.';
        }
    }
</script>
