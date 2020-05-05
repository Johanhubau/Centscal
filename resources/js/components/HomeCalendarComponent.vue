<template>
    <div class="fill-height" ref="calendarDiv">
        <v-sheet height="64">
            <v-toolbar flat color="white">
                <v-btn outlined class="mr-4" color="grey darken-2" @click="setToday">
                    Today
                </v-btn>
                <v-btn fab text small color="grey darken-2" @click="prev">
                    <v-icon small>mdi-chevron-left</v-icon>
                </v-btn>
                <v-btn fab text small color="grey darken-2" @click="next">
                    <v-icon small>mdi-chevron-right</v-icon>
                </v-btn>
                <v-toolbar-title>{{ title }}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-menu bottom right>
                    <template v-slot:activator="{ on }">
                        <v-btn
                            outlined
                            color="grey darken-2"
                            v-on="on"
                        >
                            <span>{{ typeToLabel[type] }}</span>
                            <v-icon right>mdi-menu-down</v-icon>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item @click="type = 'day'">
                            <v-list-item-title>Day</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="type = 'week'">
                            <v-list-item-title>Week</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="type = 'month'">
                            <v-list-item-title>Month</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="type = '4day'">
                            <v-list-item-title>4 days</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-toolbar>
        </v-sheet>
        <v-sheet :height="calendarHeight">
            <v-calendar
                ref="calendar"
                v-model="focus"
                color="primary"
                :events="computed_events"
                :event-color="getEventColor"
                :now="today"
                :type="type"
                @click:event="showEvent"
                @click:more="viewDay"
                @click:date="viewDay"
            ></v-calendar>
            <v-menu
                v-model="selectedOpen"
                :close-on-content-click="false"
                :activator="selectedElement"
                offset-x
            >
                <v-card
                    color="grey lighten-4"
                    min-width="350px"
                    flat
                >
                    <v-toolbar
                        :color="selectedEvent.color"
                        dark
                    >
                        <v-toolbar-title v-html="selectedEvent.association + ': ' + selectedEvent.name"></v-toolbar-title>
                        <v-spacer></v-spacer>
<!--                        <v-btn icon>-->
<!--                            <v-icon>mdi-dots-vertical</v-icon>-->
<!--                        </v-btn>-->
                    </v-toolbar>
                    <v-card-text>
                        <span v-html="selectedEvent.details"></span>
                    </v-card-text>
                    <v-card-subtitle>
                        <span v-if="selectedEvent.location !== 'Location: null'" v-html="selectedEvent.location"></span>
                        <v-spacer></v-spacer>
                        <a :href="selectedEvent.link"><span v-if="selectedEvent.link !== 'null'" v-html="selectedEvent.link"></span></a>
                    </v-card-subtitle>
<!--                    <v-card-actions>-->
<!--                        <v-btn-->
<!--                            text-->
<!--                            color="secondary"-->
<!--                            @click="selectedOpen = false"-->
<!--                        >-->
<!--                            Cancel-->
<!--                        </v-btn>-->
<!--                    </v-card-actions>-->
                </v-card>
            </v-menu>
        </v-sheet>
    </div>
</template>

<script>
    export default {
        props: ['events', 'associations'],
        data: () => ({
            focus: '',
            type: 'month',
            typeToLabel: {
                month: 'Month',
                week: 'Week',
                day: 'Day',
                '4day': '4 Days',
            },
            start: null,
            end: null,
            selectedEvent: {},
            selectedElement: null,
            selectedOpen: false,
            calendarHeight: 600,
            colors_by_id: {},
            names_by_id: {},
            computed_events: [],
        }),
        computed: {
            title() {
                const {start, end} = this
                if (!start || !end) {
                    return ''
                }

                const startMonth = this.monthFormatter(start)
                const endMonth = this.monthFormatter(end)
                const suffixMonth = startMonth === endMonth ? '' : endMonth

                const startYear = start.year
                const endYear = end.year
                const suffixYear = startYear === endYear ? '' : endYear

                const startDay = start.day + this.nth(start.day)
                const endDay = end.day + this.nth(end.day)

                switch (this.type) {
                    case 'month':
                        return `${startMonth} ${startYear}`
                    case 'week':
                    case '4day':
                        return `${startMonth} ${startDay} ${startYear} - ${suffixMonth} ${endDay} ${suffixYear}`
                    case 'day':
                        return `${startMonth} ${startDay} ${startYear}`
                }
                return ''
            },
            monthFormatter() {
                return this.$refs.calendar.getFormatter({month: 'long',
                })
            },
        },
        mounted() {
            this.$refs.calendar.checkChange()
            this.calendarHeight = this.$refs.calendarDiv.clientHeight - 75
            this.makeVars()
        },
        methods: {
            makeVars() {
                this.associations.forEach(association =>
                    this.colors_by_id[association.id] = association.color
                )
                this.associations.forEach(association =>
                    this.names_by_id[association.id] = association.name
                )
                this.events.forEach(event =>
                    this.computed_events.push({
                        name: event.title,
                        start: this.formatDate(event.begin),
                        end: this.formatDate(event.end),
                        color: this.colors_by_id[event.association_id],
                        details:  event.desc,
                        association: this.names_by_id[event.association_id],
                        location: 'Location: ' + event.location,
                        link: event.link
                    })
                )
            },
            viewDay({date}) {
                this.focus = date
                this.type = 'day'
            },
            getEventColor(event) {
                return event.color
            },
            setToday() {
                this.focus = this.today
            },
            prev() {
                this.$refs.calendar.prev()
            },
            next() {
                this.$refs.calendar.next()
            },
            showEvent({nativeEvent, event}) {
                const open = () => {
                    this.selectedEvent = event
                    this.selectedElement = nativeEvent.target
                    setTimeout(() => this.selectedOpen = true, 10)
                }

                if (this.selectedOpen) {
                    this.selectedOpen = false
                    setTimeout(open, 10)
                } else {
                    open()
                }

                nativeEvent.stopPropagation()
            },
            nth(d) {
                return d > 3 && d < 21
                    ? 'th'
                    : ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'][d % 10]
            },
            rnd(a, b) {
                return Math.floor((b - a + 1) * Math.random()) + a
            },
            formatDate(date) {
                let d = new Date(date)
                let hours = d.getHours()
                let min = d.getMinutes()
                if(hours < 10){
                    hours = "0" + d.getHours()
                }
                if(min < 10){
                    min = "0" + d.getMinutes()
                }
                return d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() + "T" + hours + ":" + min
            },
        },
    }
</script>

<style scoped>

</style>
