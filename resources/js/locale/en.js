import { en } from 'vuetify/lib/locale'

export default {
    ...en,

    //GENERAL LINES
    common: {
        actions: {
            close: "Close",
            validate: "Validate",
            update: "Update",
            next: "Next",
            back: "Back",
            previous: "Previous"
        },
        snackbar: {
            created: "Created {0}",
            updated: "Updated {0}",
            deleted: "Deleted {0}",
            nothing: "Nothing to change"
        }
    },
    //COMPONENTS
    associations: {
        create: {
            nameRequired: 'Name is required',
            nameLength: 'Name must be between 2 and 255 characters',
            name: "Association's name",
            descLength: "Description must be between 2 and 255 characters",
            desc: "Description",
            president: "President",
            presidentRequired: "You must choose a president"
        },
        dashboard: {
            name: "Association's name",
            desc: "Description",
            president: "President",
        },
    },
    events: {
        create: {
            title: "Title",
            desc: "Description",
            room: "Location",
            link: "Event link",
            materials: "Equipment necessary",
            location: 'Other',
            linkHint: "Remember to add the http:// or https:// in front of the link",
            titleRequired: "Title is required",
            titleLength: "Title must be between 2 and 255 characters",
            descLength: "Description must be between 2 and 255 characters",
            linkLength: "Link must be between 2 and 255 characters",
            locationLength: 'Location must be between 2 and 255 characters',
            beginDate: "Select begin date",
            beginTime: "Select begin time",
            endDate: "Select end date",
            endTime: "Select end time",
            done: "Done!",
            dateOrder: "Beginning date should be before end date!"
        },
        card: {
            pending: "Pending",
            approved: "Approved",
            notApproved: "Not approved",
            to: "to"
        },
        update: {
            title: "Title",
            desc: "Description",
            room: "Location",
            link: "Event link",
            materials: "Equipment necessary",
            location: 'Other',
            linkHint: "Remember to add the http:// or https:// in front of the link",
            titleRequired: "Title is required",
            titleLength: "Title must be between 2 and 255 characters",
            descLength: "Description must be between 2 and 255 characters",
            linkLength: "Link must be between 2 and 255 characters",
            locationLength: 'Location must be between 2 and 255 characters',
            beginDate: "Select begin date",
            beginTime: "Select begin time",
            endDate: "Select end date",
            endTime: "Select end time",
            done: "Done!",
            dateOrder: "Beginning date should be before end date!"
        },
    },
    materials: {
        create: {
            nameRequired: 'Name is required',
            nameLength: 'Name must be between 2 and 255 characters',
            name: "Equipment's name",
            descLength: "Description must be between 2 and 255 characters",
            desc: "Description",
            price: "Price",
            priceLength: "Price must be between 2 and 255 characters"
        },
        update: {
            nameRequired: 'Name is required',
            nameLength: 'Name must be between 2 and 255 characters',
            name: "Equipment's name",
            descLength: "Description must be between 2 and 255 characters",
            desc: "Description",
            price: "Price",
            priceLength: "Price must be between 2 and 255 characters"
        }
    },
    occupations: {
        admin: {
            requested: "requested",
            approveQ: "Approve request?",
            to: "to",
            approve: "Approve",
            notApprove: "Do not approve"
        }
    },
    rents: {
        admin: {
            requested: "requested",
            approveQ: "Approve request?",
            to: "to",
            approve: "Approve",
            notApprove: "Do not approve"
        }
    },
    rooms: {
        create: {
            nameRequired: 'Name is required',
            nameLength: 'Name must be between 2 and 255 characters',
            name: "Room name",
            locLength: "Location must be between 2 and 255 characters",
            location: "Description",
            locHint: "Be specific we want people to find it right?",
        }
    },
    users: {
        update: {
            title: "Update user role",
            itemRequired: "Item is required",
            role: "Role",
            user: "User",
            admin: "Admin"
        }
    },
    general: {
        home: {
            today: "Today",
            day: "Day",
            week: "Week",
            month: "Month",
            fday: "4 Days",
        },
        roomMaterial: {
            title: "Manage your equipments and rooms",
            nMate: "New Equipment",
            nRoom: "New Room"
        }
    }
}
