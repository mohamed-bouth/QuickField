import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar')

    if (!calendarEl) return

    const fieldId = calendarEl.dataset.fieldId

    const calendar = new Calendar(calendarEl, {
        plugins: [
            dayGridPlugin,
            timeGridPlugin,
            interactionPlugin,
        ],

        slotDuration: '01:00:00',
        snapDuration: '01:00:00',

        initialView: 'timeGridWeek',

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },

        allDaySlot: false,

        slotMinTime: '08:00:00',
        slotMaxTime: '23:59:00',

        selectable: true,

        events: {   
                    url: `/fields/${fieldId}/reservations/events`,
                    success: function(response) {
                        console.log('Response JSON:', response)
                    }
                },

        select: function (info) {
            const params = new URLSearchParams({
                    start: info.startStr,
                    end: info.endStr,
                })

                window.location.href = `/manager/fields/${fieldId}/blocks/create?${params.toString()}`
        },

        eventClick: function (info) {
            alert(info.event.title)
        },
    })

    console.log(calendar)

    calendar.render()
})