<template>
    <div v-if = 'workingHours.length > 0'> 
        <div v-for = '(hour, index) in workingHours' :key = 'index' class = 'mb-4'>
            <div class = 'flex flex-wrap gap-2'>
                <button type = 'button' v-for = 'timeSlot in generateTimeSlots(hour.start_time, hour.end_time)' :key = 'timeSlot' @click = 'selectTime(timeSlot)'
                    class = 'px-4 py-2 bg-blue-100 rounded text-sm cursor-pointer'
                    :class = "[ 
                        isTimeSlotDisabled(timeSlot) ? 'bg-gray-300 text-gray-500 cursor-not-allowed' :
                        (selectedTime === timeSlot ? 'bg-blue-500 text-white' : 'bg-blue-100')
                    ]"
                    :disabled = 'isTimeSlotDisabled(timeSlot)'>
                    {{ timeSlot }}
                </button>
            </div>
        </div>
    </div>
    <div class = 'text-sm mb-4 bg-red-400 rounded-xl px-4 py-2 text-white font-bold' v-else> Šią dieną laisvų darbo valandų nėra </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import axios from 'axios';
    import { useDateFormat } from '@vueuse/core'

    const workingHours = ref([]);
    const appointments = ref([]);

    const selectedTime = defineModel();

    const props = defineProps({
        serviceProviderID: {
            type: Number,
            required: true,
            default: null
        },
        date: {
            type: [ String, Date ],
            required: true
        }
    });

    onMounted(() => {
        if (props.serviceProviderID) {
            fetchAppointmentHours(props.serviceProviderID)
        }
    })

    const fetchAppointmentHours = async (serviceProviderID) => {
        try {
            const response = await axios.get(`working_hours/${serviceProviderID}`, {
                params: {
                    weekday: props.date.getDay(),
                    appointment_date: useDateFormat(props.date, 'YYYY-MM-DD').value
                }
            });

            workingHours.value = response.data.data.working_hours ?? [];
            appointments.value = response.data.data.working_hours[0].appointments ?? [];
            appointments.value = appointments.value.map(app => app.appointment_time);
        } catch (error) {
            workingHours.value = [];
            appointments.value = [];
        }
    };

    const generateTimeSlots = (start, end) => {
        const timeSlots = [];
        let [startHour, startMinute] = start.split(':').map(Number);
        let [endHour, endMinute] = end.split(':').map(Number);

        for (let hour = startHour; hour < endHour; hour++) {
            const timeSlot = `${hour.toString().padStart(2, '0')}:00`;
            timeSlots.push(timeSlot);
        }

        return timeSlots;
    }

    const selectTime = (timeSlot) => {
        selectedTime.value = timeSlot;
    }

    const isTimeSlotDisabled = (timeSlot) => {
        if (appointments.value.includes(timeSlot)) {
            return true;
        }

        const today = new Date();
        const selected = new Date(props.date);

        const isToday = today.toDateString() === selected.toDateString();
        if (isToday) {
            const [hour, minute] = timeSlot.split(':').map(Number);
            const slotTime = new Date();
            slotTime.setHours(hour, minute, 0, 0);

            return slotTime < new Date();
        }

        return false;
    };
</script>
