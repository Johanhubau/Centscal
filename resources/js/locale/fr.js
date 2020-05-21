import { fr } from 'vuetify/lib/locale'

export default {
    ...fr,

    //GENERAL LINES
    common: {
        actions: {
            close: "Fermer",
            validate: "Valider",
            update: "Mettre à jour",
            next: "Suivant",
            back: "Retour",
            previous: "Précédent"
        },
        snackbar: {
            created: "{0} créé",
            updated: "{0} mis à jour",
            deleted: "{0} supprimé",
            nothing: "Rien à changer"
        }
    },
    //COMPONENTS
    associations: {
        create: {
            nameRequired: 'Le nom est nécéssaire',
            nameLength: "Le nom doit être entre 2 et 255 caractères",
            name: "Nom de l'association",
            desc: "Description",
            descLength: "La description doit être entre 2 et 255 caractères",
            president: "Président.e",
            presidentRequired: "Ce champs est requis"
        },
        dashboard: {
            name: "Nom de l'association",
            desc: "Description",
            president: "Président.e",
        },
    },
    events: {
        create: {
            title: "Titre",
            desc: "Description",
            room: "Localisation",
            link: "Lien de l'évènement",
            materials: "Equipement nécessaire",
            location: 'Autre',
            linkHint: "Rappelez-vous de ajouter le http:// ou https:// au début du lien",
            titleRequired: "Le titre est nécéssaire",
            titleLength: "Le titre doit être entre 2 et 255 caractères",
            descLength: "La description doit être entre 2 et 255 caractères",
            linkLength: "Le lien doit être entre 2 et 255 caractères",
            locationLength: 'La localisation doit être entre 2 et 255 caractères',
            beginDate: "Sélectionner la date de début",
            beginTime: "Sélectionner la date de fin",
            endDate: "Sélectionner l'heure de début",
            endTime: "Sélectionner l'heure de fin",
            done: "C'est bon!",
            dateOrder: "Le début de l'évènement doit être après la fin!"
        },
        card: {
            pending: "En attente",
            approved: "Approuvé",
            notApproved: "Non approuvé",
            to: "à"
        },
        update: {
            title: "Titre",
            desc: "Description",
            room: "Localisation",
            link: "Lien de l'évènement",
            materials: "Equipement nécessaire",
            location: 'Autre',
            linkHint: "Rappelez-vous de ajouter le http:// ou https:// au début du lien",
            titleRequired: "Le titre est nécéssaire",
            titleLength: "Le titre doit être entre 2 et 255 caractères",
            descLength: "La description doit être entre 2 et 255 caractères",
            linkLength: "Le lien doit être entre 2 et 255 caractères",
            locationLength: 'La localisation doit être entre 2 et 255 caractères',
            beginDate: "Sélectionner la date de début",
            beginTime: "Sélectionner la date de fin",
            endDate: "Sélectionner l'heure de début",
            endTime: "Sélectionner l'heure de fin",
            done: "C'est bon!",
            dateOrder: "Le début de l'évènement doit être après la fin!"
        },
    },
    materials: {
        create: {
            nameRequired: 'Le nom est nécéssaire',
            nameLength: "Le nom doit être entre 2 et 255 caractères",
            name: "Nom de l'équipement",
            desc: "Description",
            descLength: "La description doit être entre 2 et 255 caractères",
            price: "Prix",
            priceLength: "Le prix doit être entre 2 et 255 caractères"
        },
        update: {
            nameRequired: 'Le nom est nécéssaire',
            nameLength: "Le nom doit être entre 2 et 255 caractères",
            name: "NNom de l'équipement",
            desc: "Description",
            descLength: "La description doit être entre 2 et 255 caractères",
            price: "Prix",
            priceLength: "Le prix doit être entre 2 et 255 caractères"
        }
    },
    occupations: {
        admin: {
            requested: "Demandé",
            approveQ: "Approuver la demande?",
            to: "à",
            approve: "Approuver",
            notApprove: "Ne pas approuver"
        }
    },
    rents: {
        admin: {
            requested: "Demandé",
            approveQ: "Approuver la demande?",
            to: "à",
            approve: "Approuver",
            notApprove: "Ne pas approuver"
        }
    },
    rooms: {
        create: {
            nameRequired: 'Le nom est nécéssaire',
            nameLength: "Le nom doit être entre 2 et 255 caractères",
            name: "Nom de la salle",
            locLength: "La localisation doit être entre 2 et 255 caractères",
            location: "Description",
            locHint: "Soyez spécifique",
        }
    },
    users: {
        update: {
            title: "Mettre à jour le rôle de l'utilisateur",
            itemRequired: "Ce champs est nécéssaire",
            role: "Rôle",
            user: "Utilisateur",
            admin: "Administrateur"
        }
    },
    general: {
        home: {
            today: "Aujourd'hui",
            day: "Jour",
            week: "Semaine",
            month: "Mois",
            fday: "4 Jours",
        },
        roomMaterial: {
            title: "Managez vos équipements et salles",
            nMate: "Nouvel équipement",
            nRoom: "Nouvelle salle",
        }
    }
}
