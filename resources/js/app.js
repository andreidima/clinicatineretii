/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';

import '../sass/app.scss'
import '../css/andrei.css'

import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

// import ExampleComponent from './components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);

import VueDatepickerNext from './components/DatePicker.vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

if (document.getElementById('app') != null) {
    app.mount('#app');
}

const clickOutside = {
    beforeMount: (el, binding) => {
        el.clickOutsideEvent = event => {
            if (!(el == event.target || el.contains(event.target))) {
                binding.value();
            }
        };
        document.addEventListener("click", el.clickOutsideEvent);
    },
    unmounted: el => {
        document.removeEventListener("click", el.clickOutsideEvent);
    },
};

// App for DatePicker
const datePicker = createApp({});
datePicker.component('vue-datepicker-next', VueDatepickerNext);
if (document.getElementById('datePicker') != null) {
    datePicker.mount('#datePicker');
}

const pacientForm = createApp({
    el: '#pacientForm',
    data() {
        return {
            judete: judete,
            localitati: localitati,

            judetNastere_id: judetNastereIdVechi,
            judetNastere_nume: '',
            judeteNastereListaAutocomplete: [],

            judet_id: judetIdVechi,
            judet_nume: '',
            judeteListaAutocomplete: [],

            localitate_id: localitateIdVechi,
            localitate_nume: '',
            localitatiListaAutocomplete: [],
        }
    },
    watch: {
        judet_id: {
            handler: function (newVal, oldVal) {
                if (!newVal){
                    this.localitate_id = '';
                    this.localitate_nume = '';
                }
            }
        }
    },
    created: function () {
        if (this.judetNastere_id) {
            for (var i = 0; i < this.judete.length; i++) {
                if (this.judete[i].id == this.judetNastere_id) {
                    this.judetNastere_nume = this.judete[i].nume;
                    break;
                }
            }
        }
        if (this.judet_id) {
            for (var i = 0; i < this.judete.length; i++) {
                if (this.judete[i].id == this.judet_id) {
                    this.judet_nume = this.judete[i].nume;
                    break;
                }
            }
        }
        if (this.localitate_id) {
            for (var i = 0; i < this.localitati.length; i++) {
                if (this.localitati[i].id == this.localitate_id) {
                    this.localitate_nume = this.localitati[i].nume;
                    break;
                }
            }
        }
    },
    methods: {
        autocompleteJudeteNastere() {
            this.judeteNastereListaAutocomplete = [];

            for (var i = 0; i < this.judete.length; i++) {
                if (this.judete[i].nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(this.judetNastere_nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""))) {
                    this.judeteNastereListaAutocomplete.push(this.judete[i]);
                }
            }
        },
        autocompleteJudete() {
            this.judeteListaAutocomplete = [];

            for (var i = 0; i < this.judete.length; i++) {
                if (this.judete[i].nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(this.judet_nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""))) {
                    this.judeteListaAutocomplete.push(this.judete[i]);
                }
            }
        },
        autocompleteLocalitati() {
            if (this.judet_id) { // „localitati„ will not autocomplete if is not first selected „judet”
                this.localitatiListaAutocomplete = [];

                for (var i = 0; i < this.localitati.length; i++) {
                    if ((this.localitati[i].judet_id == this.judet_id)
                        && this.localitati[i].nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(this.localitate_nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "")))
                    {
                        this.localitatiListaAutocomplete.push(this.localitati[i]);
                    }
                }
            }
        },
    }
});
pacientForm.directive("clickOut", clickOutside);
pacientForm.component('vue-datepicker-next', VueDatepickerNext);
if (document.getElementById('pacientForm') != null) {
    pacientForm.mount('#pacientForm');
}

const programareForm = createApp({
    el: '#programareForm',
    data() {
        return {
            specializariSiMedici: specializariSiMedici,
            specializari: [],
            medici: [],

            specializare_id: specializareIdVechi,
            specializare_denumire: '',
            specializariListaAutocomplete: [],

            medic_id: medicIdVechi,
            medic_nume: '',
            mediciListaAutocomplete: [],

            cabinete: (typeof cabinete !== 'undefined') ? cabinete : '',
            cabinet_id: (typeof cabinetIdVechi !== 'undefined') ? cabinetIdVechi : '',
            cabinet_nume: '',
            cabineteListaAutocomplete: [],

            pacient_id: (typeof pacientIdVechi !== 'undefined') ? pacientIdVechi : '',
            pacient_nume: '',
            pacient_telefon: '',
            pacient_localitate: '',
            pacienti: (typeof pacienti !== 'undefined') ? pacienti : '',
            pacientiListaAutocomplete: [],

            // dataProgramare: '',

            // orare: [],
        }
    },
    watch: {
        specializare_id: {
            handler: function (newVal, oldVal) {
                this.medic_id = '';
                this.medic_nume = '';
                this.createMediciList();
            }
        },
        // medic_id: {
        //     handler: function (newVal, oldVal) {
        //         this.createOrareList();
        //     }
        // },
        // dataProgramare: {
        //     handler: function (newVal, oldVal) {
        //         this.createOrareList();
        //     }
        // }
    },
    created: function () {
        this.createSpecializariList();
        this.createMediciList();

        if (this.specializare_id) {
            for (var i = 0; i < this.specializari.length; i++) {
                if (this.specializari[i].id == this.specializare_id) {
                    this.specializare_denumire = this.specializari[i].denumire;
                    break;
                }
            }
        }
        if (this.medic_id) {
            for (var i = 0; i < this.medici.length; i++) {
                if (this.medici[i].id == this.medic_id) {
                    this.medic_nume = this.medici[i].nume;
                    break;
                }
            }
        }
        if (this.cabinet_id) {
            for (var i = 0; i < this.cabinete.length; i++) {
                if (this.cabinete[i].id == this.cabinet_id) {
                    this.cabinet_nume = this.cabinete[i].nume;
                    break;
                }
            }
        }
        if (this.pacient_id) {
            for (var i = 0; i < this.pacienti.length; i++) {
                if (this.pacienti[i].id == this.pacient_id) {
                    this.pacient_nume = this.pacienti[i].nume + ' ' + this.pacienti[i].prenume;
                    // this.pacient_data_nastere = new Date(this.pacienti[i].data_nastere); this.pacient_data_nastere = this.pacient_data_nastere.toLocaleString('ro-RO', { dateStyle: 'short' });
                    this.pacient_telefon = this.pacienti[i].telefon;
                    this.pacient_localitate = this.pacienti[i].localitate ? this.pacienti[i].localitate.nume : '';
                    break;
                }
            }
        }
    },
    methods: {
        createSpecializariList() {
            for (var i = 0; i < this.specializariSiMedici.length; i++) {
                this.specializari.push(this.specializariSiMedici[i]);
            }
        },
        createMediciList() {
            if (this.specializare_id) {
                for (var i = 0; i < this.specializariSiMedici.length; i++) {
                    if (this.specializariSiMedici[i]['id'] == this.specializare_id) {
                        this.medici = this.specializariSiMedici[i]['medici'];
                        break;
                    }
                }
            }
        },
        // createOrareList() {
        //     if (this.specializare_id && this.medic_id && this.dataProgramare) {
        //         axios
        //             .get('/axios/get-available-orare',
        //                 {
        //                     params: {
        //                         specializare_id: this.specializare_id,
        //                         medic_id: this.medic_id,
        //                         data: this.dataProgramare,
        //                     }
        //                 })
        //             .then(response => {
        //                 this.orare = response.data.orare;
        //             });
        //     }
        // },
        autocompleteSpecializari() {
            this.specializariListaAutocomplete = [];

            for (var i = 0; i < this.specializari.length; i++) {
                if (this.specializari[i].denumire.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(this.specializare_denumire.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""))) {
                    this.specializariListaAutocomplete.push(this.specializari[i]);
                }
            }
        },
        autocompleteMedici() {
            this.mediciListaAutocomplete = [];
            if (this.specializare_id){
                for (var i = 0; i < this.medici.length; i++) {
                    if (this.medici[i].nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(this.medic_nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""))) {
                        this.mediciListaAutocomplete.push(this.medici[i]);
                    }
                }
            }
        },
        // dataProgramareTrimisa(data_programare) {
        //     this.dataProgramare = data_programare;
        // },
        autocompleteCabinete() {
            this.cabineteListaAutocomplete = [];

            for (var i = 0; i < this.cabinete.length; i++) {
                if (this.cabinete[i].nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(this.cabinet_nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""))) {
                    this.cabineteListaAutocomplete.push(this.cabinete[i]);
                }
            }
        },
        autocompletePacienti() {
            this.pacientiListaAutocomplete = [];

            for (var i = 0; i < this.pacienti.length; i++) {
                if (this.pacienti[i].nume || this.pacienti[i].prenume) {
                    var nume = this.pacienti[i].nume + ' ' + this.pacienti[i].prenume;
                    if (nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(this.pacient_nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""))) {
                        this.pacientiListaAutocomplete.push(this.pacienti[i]);
                    }
                }
            }
        },
    },
});
programareForm.directive("clickOut", clickOutside);
programareForm.component('vue-datepicker-next', VueDatepickerNext);
if (document.getElementById('programareForm') != null) {
    programareForm.mount('#programareForm');
}

const programareIndexSaptamanalSearch = createApp({
    el: '#programareIndexSaptamanalSearch',
    data() {
        return {
            specializariSiMedici: specializariSiMedici,
            specializari: [],
            medici: [],

            specializare_id: specializareIdVechi,
            specializare_denumire: '',
            specializariListaAutocomplete: [],

            medic_id: medicIdVechi,
            medic_nume: '',
            mediciListaAutocomplete: [],
        }
    },
    watch: {
        specializare_id: {
            handler: function (newVal, oldVal) {
                this.medic_id = '';
                this.medic_nume = '';
                this.createMediciList();
            }
        },
    },
    created: function () {
        this.createSpecializariList();
        this.createMediciList();

        if (this.specializare_id) {
            for (var i = 0; i < this.specializari.length; i++) {
                if (this.specializari[i].id == this.specializare_id) {
                    this.specializare_denumire = this.specializari[i].denumire;
                    break;
                }
            }
        }
        if (this.medic_id) {
            for (var i = 0; i < this.medici.length; i++) {
                if (this.medici[i].id == this.medic_id) {
                    this.medic_nume = this.medici[i].nume;
                    break;
                }
            }
        }
    },
    methods: {
        createSpecializariList() {
            for (var i = 0; i < this.specializariSiMedici.length; i++) {
                this.specializari.push(this.specializariSiMedici[i]);
            }
        },
        createMediciList() {
            if (this.specializare_id) {
                for (var i = 0; i < this.specializariSiMedici.length; i++) {
                    if (this.specializariSiMedici[i]['id'] == this.specializare_id) {
                        this.medici = this.specializariSiMedici[i]['medici'];
                        break;
                    }
                }
            }
        },
        autocompleteSpecializari() {
            this.specializariListaAutocomplete = [];

            for (var i = 0; i < this.specializari.length; i++) {
                if (this.specializari[i].denumire.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(this.specializare_denumire.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""))) {
                    this.specializariListaAutocomplete.push(this.specializari[i]);
                }
            }
        },
        autocompleteMedici() {
            this.mediciListaAutocomplete = [];
            if (this.specializare_id) {
                for (var i = 0; i < this.medici.length; i++) {
                    if (this.medici[i].nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(this.medic_nume.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""))) {
                        this.mediciListaAutocomplete.push(this.medici[i]);
                    }
                }
            }
        },
    },
});
programareIndexSaptamanalSearch.directive("clickOut", clickOutside);
programareIndexSaptamanalSearch.component('vue-datepicker-next', VueDatepickerNext);
if (document.getElementById('programareIndexSaptamanalSearch') != null) {
    programareIndexSaptamanalSearch.mount('#programareIndexSaptamanalSearch');
}
