@props(['events' => []])

<div
    x-data="calendarComponent()"
    x-init='init(@json($events))'
    class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md mx-auto"
    x-cloak
>
    <!-- nav -->
    <div class="flex justify-between items-center mb-4">
        <button @click="prevMonth"
                class="px-3 py-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded">
            Prethodni
        </button>

        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100" x-text="monthYear"></h2>

        <button @click="nextMonth"
                class="px-3 py-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded">
            Sledeći
        </button>
    </div>

    <!-- weekdays -->
    <div class="grid grid-cols-7 gap-1 text-center text-gray-600 dark:text-gray-400 mb-2">
        <template x-for="day in ['Pon','Uto','Sre','Čet','Pet','Sub','Ned']" :key="day">
            <div class="font-semibold text-xs" x-text="day"></div>
        </template>
    </div>

    <!-- calendar days -->
    <div class="grid grid-cols-7 gap-1">
        <template x-for="blank in blanks" :key="'b'+blank"><div></div></template>

        <template x-for="d in dates" :key="d.date">
            <div>
                <button
                    @click="showDetails(d)"
                    class="w-full h-10 text-sm flex flex-col items-center justify-center rounded
                           hover:bg-blue-300 dark:hover:bg-blue-700 transition-colors duration-100 ease-in"
                    :class="d.isToday
                        ? 'bg-blue-500 dark:bg-blue-600 text-white'
                        : 'text-gray-900 dark:text-gray-100'">
                    <span x-text="d.date.getDate()"></span>

                    <div class="flex space-x-0.5 mt-0.5">
                        <template x-if="d.hasService">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-600 dark:bg-red-400"></span>
                        </template>
                        <template x-if="d.hasInspection">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-600 dark:bg-green-400"></span>
                        </template>
                        <template x-if="d.hasTest">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 dark:bg-amber-400"></span>
                        </template>
                    </div>
                </button>
            </div>
        </template>
    </div>

    <!-- modal -->
    <div x-show="detailsVisible"
         class="mt-4 p-4 border border-gray-300 dark:border-gray-700 rounded bg-gray-50 dark:bg-gray-900"
         style="display:none;">
        <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100" x-text="detailDate"></h3>

        <template x-if="detailEvents.length">
            <ul class="space-y-1 text-sm">
                <template x-for="ev in detailEvents" :key="ev.id">
                    <li class="flex items-start gap-2">
                        <span class="w-2 h-2 rounded-full mt-1"
                              :class="{
                                  'bg-red-600  dark:bg-red-400'   : ev.type.toLowerCase()==='servis',
                                  'bg-green-600 dark:bg-green-400': ev.type.toLowerCase()==='inspekcija',
                                  'bg-amber-500 dark:bg-amber-400': ev.type.toLowerCase()==='test'
                              }"></span>

                        <a :href="ev.url"
                           class="underline hover:text-blue-700 dark:hover:text-blue-400 font-semibold dark:text-gray-300"
                           x-text="ev.label">
                        </a>

                        <span class="text-gray-700 dark:text-gray-300" x-text="ev.description"></span>
                    </li>
                </template>
            </ul>
        </template>

        <template x-if="!detailEvents.length">
            <p class="italic text-sm text-gray-500 dark:text-gray-400">
                Nema događaja za ovaj datum.
            </p>
        </template>

        <button @click="detailsVisible=false"
                class="mt-4 px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded">
            Zatvori
        </button>
    </div>
</div>

@once
    <script>
        function calendarComponent() {
            return {
                now: new Date(),
                currentMonth: 0,
                currentYear: 0,
                monthYear: '',
                blanks: [],
                dates: [],
                detailsVisible: false,
                detailDate: '',
                detailEvents: [],
                events: [],

                init(events = []) {
                    this.events = events ?? [];
                    this.currentMonth = this.now.getMonth();
                    this.currentYear  = this.now.getFullYear();
                    this.generateCalendar();
                },

                generateCalendar() {
                    this.monthYear = new Date(this.currentYear, this.currentMonth)
                        .toLocaleString('sr-RS', { month: 'long', year: 'numeric' });

                    const firstDay = new Date(this.currentYear, this.currentMonth, 1);
                    let offset = firstDay.getDay();
                    offset = offset === 0 ? 6 : offset - 1;
                    this.blanks = [...Array(offset).keys()];

                    const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
                    this.dates = [];

                    for (let d = 1; d <= lastDay; d++) {
                        const dateObj = new Date(this.currentYear, this.currentMonth, d);
                        const iso = dateObj.toLocaleDateString('en-CA');
                        const dayEvents = this.events.filter(e => e.date === iso);
                        this.dates.push({
                            date:          dateObj,
                            isToday:       dateObj.toDateString() === this.now.toDateString(),
                            events:        dayEvents,
                            hasService:    dayEvents.some(e => e.type.toLowerCase() === 'servis'),
                            hasInspection: dayEvents.some(e => e.type.toLowerCase() === 'inspekcija'),
                            hasTest:       dayEvents.some(e => e.type.toLowerCase() === 'test'),
                        });
                    }
                },

                prevMonth(){ this.shift(-1); },
                nextMonth(){ this.shift(1); },

                shift(step) {
                    this.currentMonth += step;
                    if (this.currentMonth > 11) { this.currentMonth = 0;  this.currentYear++; }
                    if (this.currentMonth < 0)  { this.currentMonth = 11; this.currentYear--; }
                    this.detailsVisible = false;
                    this.generateCalendar();
                },

                showDetails(day) {
                    this.detailDate   = day.date.toLocaleDateString('sr-RS',
                        { weekday:'long', year:'numeric', month:'long', day:'numeric' });
                    this.detailEvents = day.events;
                    this.detailsVisible = true;
                }
            }
        }
    </script>
@endonce
