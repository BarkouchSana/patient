import { Component, OnInit, ViewChild, AfterViewInit, ChangeDetectorRef } from '@angular/core';
import { CalendarOptions, EventClickArg, DateSelectArg, CalendarApi } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction'; // Pour la sélection de date, le clic sur événement
import { FullCalendarComponent } from '@fullcalendar/angular';
import { MyCalendarEvent } from '../../../../core/domain/models/calendar-event.model';
import { StaticCalendarDataService } from '../../../../core/services/static-calendar-data.service';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { DatePipe } from '@angular/common';

@Component({
  selector: 'app-shared-calendar',
  standalone: false,
  templateUrl: './shared-calendar.component.html',
  styleUrl: './shared-calendar.component.css',
  providers: [DatePipe]
})
// export class SharedCalendarComponent implements OnInit, AfterViewInit {
//   @ViewChild('calendar') calendarComponent!: FullCalendarComponent;
//   doctorName = 'Dr. Sarah Johnson'; // Nom du médecin, peut être dynamique
//   // Données statiques pour les événements et les légendes/ressources
//   calendarEvents: MyCalendarEvent[] = [];
//   resources = [
//     { id: 'doctorSarah', title: 'Dr. Sarah Johnson', eventColor: '#007bff' },
//     { id: 'doctorJohn', title: 'Dr. John Smith', eventColor: '#28a745' },
//     { id: 'nurseCarol', title: 'Nurse Carol White', eventColor: '#ffc107' }
//   ];
//   selectedResources: string[] = []; // IDs des ressources sélectionnées pour le filtrage

//   calendarOptions: CalendarOptions = {
//     plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
//     initialView: 'dayGridMonth', // Vue par défaut
//     headerToolbar: {
//       left: 'prev,next today',
//       center: 'title',
//       right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' // Boutons pour changer de vue
//     },
//     weekends: true,
//     editable: true,       // Permet le glisser-déposer/redimensionnement
//     selectable: true,     // Permet de sélectionner des dates/plages
//     selectMirror: true,
//     dayMaxEvents: true,   // Affiche un lien "+X more" si trop d'événements
//     events: [],           // Sera rempli avec this.calendarEvents filtrés
//     select: this.handleDateSelect.bind(this),
//     eventClick: this.handleEventClick.bind(this),
//     // eventDrop: this.handleEventDrop.bind(this), // Si vous gérez le glisser-déposer
//     // eventResize: this.handleEventResize.bind(this), // Si vous gérez le redimensionnement
//     height: 'auto', // ou une hauteur fixe comme '700px'
//     contentHeight: 600,
//     eventTimeFormat: { // Format de l'heure dans les événements
//       hour: 'numeric',
//       minute: '2-digit',
//       meridiem: 'short'
//     }
//   };

//   isEventModalOpen = false;
//   selectedEventDetails: MyCalendarEvent | null = null;
//   // Pour le formulaire de création/réservation (similaire à votre exemple précédent)
//   isBookingFormOpen = false;
//   bookingFormData: { date?: Date, time?: string, patientName?: string /* ... autres champs */ } = {};
//   constructor(private staticDataService: StaticCalendarDataService) {}

//   ngOnInit(): void {
//     this.calendarEvents = this.staticDataService.getStaticAppointments().map(app => ({
//       ...app,
//       // Assigner une couleur basée sur la ressource (médecin/infirmière)
//       backgroundColor: this.resources.find(r => r.id === app.extendedProps?.resourceId)?.eventColor,
//       borderColor: this.resources.find(r => r.id === app.extendedProps?.resourceId)?.eventColor
//     }));
//     this.selectedResources = this.resources.map(r => r.id); // Sélectionner toutes les ressources par défaut
//     this.filterCalendarEvents();
//   }
//   ngAfterViewInit() {
//     // Vous pouvez accéder à l'API de FullCalendar ici si nécessaire
//     // const calendarApi = this.calendarComponent.getApi();
//     // calendarApi.next();
//   }
  
//   filterCalendarEvents(): void {
//     const filtered = this.calendarEvents.filter(event =>
//       this.selectedResources.includes(event.extendedProps?.resourceId || '')
//     );
//     // Mettre à jour les événements dans FullCalendar
//     if (this.calendarComponent && this.calendarComponent.getApi()) {
//         this.calendarComponent.getApi().removeAllEvents();
//         this.calendarComponent.getApi().addEventSource(filtered);
//     } else {
//         // Si le composant n'est pas encore prêt, mettre à jour l'option
//         this.calendarOptions.events = filtered;
//     }
//   }
//   toggleResource(resourceId: string): void {
//     const index = this.selectedResources.indexOf(resourceId);
//     if (index > -1) {
//       this.selectedResources.splice(index, 1);
//     } else {
//       this.selectedResources.push(resourceId);
//     }
//     this.filterCalendarEvents();
//   }

//   handleDateSelect(selectInfo: DateSelectArg) {
//     // Ouvre un formulaire pour créer un nouvel événement
//     // selectInfo.startStr, selectInfo.endStr, selectInfo.allDay
//     console.log('Date selected:', selectInfo);
//     this.bookingFormData = { date: selectInfo.start }; // Pré-remplir la date
//     this.isBookingFormOpen = true;
//     // Ici, vous ouvririez votre formulaire de réservation comme dans l'exemple précédent
//     // et à la soumission, vous ajouteriez un nouvel événement à this.calendarEvents
//     // puis appelleriez this.filterCalendarEvents() ou this.calendarComponent.getApi().addEvent(...)

//     // Pour l'instant, on désélectionne
//     const calendarApi = selectInfo.view.calendar;
//     calendarApi.unselect(); // clear date selection
//   }
//   handleEventClick(clickInfo: EventClickArg) {
//     // Affiche les détails de l'événement dans un modal/popup
//     console.log('Event clicked:', clickInfo.event);
//     this.selectedEventDetails = {
//         id: clickInfo.event.id,
//         title: clickInfo.event.title,
//         start: clickInfo.event.start || new Date(),
//         end: clickInfo.event.end || undefined,
//         allDay: clickInfo.event.allDay,
//         extendedProps: clickInfo.event.extendedProps
//     };
//     this.isEventModalOpen = true;
//   }
//   closeEventModal(): void {
//     this.isEventModalOpen = false;
//     this.selectedEventDetails = null;
//   }

//   // Méthodes pour le formulaire de réservation (similaires à votre exemple précédent)
//   submitBookingForm(/* ...data... */): void {
//     // const newEvent: MyCalendarEvent = { ... };
//     // this.calendarEvents.push(newEvent);
//     // this.filterCalendarEvents(); // Pour rafraîchir le calendrier
//     // this.isBookingFormOpen = false;
//     alert('Fonctionnalité de réservation à implémenter');
//   }

//   printCalendar(): void {
//     // La fonctionnalité d'impression peut être délicate.
//     // FullCalendar n'a pas de bouton d'impression intégré simple.
//     // Vous pourriez utiliser window.print() et des CSS spécifiques pour l'impression.
//     // Ou chercher des plugins/solutions tierces pour une meilleure expérience d'impression.
//     alert('Fonctionnalité d\'impression à implémenter avec des CSS spécifiques ou une bibliothèque.');
//     // window.print(); // Tentative simple
//   }

// ... (imports existants) ...

export class SharedCalendarComponent implements OnInit, AfterViewInit {
  // ... (propriétés existantes : @ViewChild, doctorName, allCalendarEvents, etc.) ...
  @ViewChild('calendar') calendarComponent!: FullCalendarComponent;
  public calendarApi!: CalendarApi;

  doctorName = 'Dr. Sarah Johnson';
  allCalendarEvents: MyCalendarEvent[] = [];
  calendarEvents: MyCalendarEvent[] = [];
  resources = [
    { id: 'doctorSarah', title: 'Dr. Sarah Johnson', eventColor: '#3a87ad' },
    { id: 'doctorJohn', title: 'Doctor John', eventColor: '#468847' },
  ];
  selectedResources: string[] = [];
  searchTerm: string = '';

  miniCalendarViewDate: Date = new Date(2025, 4, 1);
  miniCalendarDays: { date: Date, dayOfMonth: number, isCurrentMonth: boolean, isSelected: boolean }[] = [];
  miniCalendarWeekDaysHeader = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
  customToolbarTitle: string = '';

  calendarOptions: CalendarOptions = {
    plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
    initialView: 'timeGridWeek',
    headerToolbar: false,
    weekends: true,
    editable: true, // Important pour la détection de chevauchement si vous permettez le drag & drop
    selectable: true,
    selectMirror: true,
    dayMaxEvents: true,
    events: [],
    select: this.handleDateSelect.bind(this),
    eventClick: this.handleEventClick.bind(this),
    height: 'auto',
    contentHeight: 650,
    slotMinTime: '07:00:00',
    slotMaxTime: '19:00:00',
    eventTimeFormat: { hour: 'numeric', minute: '2-digit', meridiem: 'short' },
    displayEventTime: true,
    allDaySlot: false,
    datesSet: (arg) => {
      if (this.calendarApi) {
        this.updateCustomToolbarTitle(arg.view);
      }
    },
    // Optionnel: pour une vérification visuelle plus poussée des contraintes
    // eventOverlap: false, // Empêche le chevauchement visuel par drag & drop
    // businessHours: { // Définir les heures ouvrables si pertinent
    //   daysOfWeek: [ 1, 2, 3, 4, 5 ], // Lundi - Vendredi
    //   startTime: '08:00',
    //   endTime: '18:00',
    // }
  };

  isEventModalOpen = false;
  selectedEventDetails: MyCalendarEvent | null = null;

  isBookingFormOpen = false;
  bookingForm: FormGroup;
  selectedDateForBooking: Date | null = null;
  selectedTimeForBooking: string | null = null;
  selectedEndTimeForBooking: string | null = null;
  slotDurationMinutes = 30; // Assurez-vous que cela correspond à la granularité de votre calendrier

  constructor(
    private staticDataService: StaticCalendarDataService,
    private fb: FormBuilder,
    private datePipe: DatePipe,
    private cdr: ChangeDetectorRef
  ) {
    this.bookingForm = this.fb.group({
      fullName: ['', Validators.required],
      email: ['', [Validators.email]],
      phoneNumber: [''],
      notes: [''],
    });
  }

  ngOnInit(): void {
    this.allCalendarEvents = this.staticDataService.getStaticAppointments().map(app => ({
      ...app,
      start: new Date(app.start), // S'assurer que les dates sont des objets Date
      end: app.end ? new Date(app.end) : undefined,
      backgroundColor: this.resources.find(r => r.id === app.extendedProps?.resourceId)?.eventColor || '#3788d8',
      borderColor: this.resources.find(r => r.id === app.extendedProps?.resourceId)?.eventColor || '#3788d8'
    }));
    this.selectedResources = this.resources.map(r => r.id);
    this.filterAndSearchEvents();
    this.generateMiniCalendar();
  }

  ngAfterViewInit() {
    if (this.calendarComponent) {
      this.calendarApi = this.calendarComponent.getApi();
      this.updateCustomToolbarTitle(this.calendarApi.view);
      this.calendarApi.removeAllEvents();
      this.calendarApi.addEventSource(this.calendarEvents);
    }
  }

  // ... (updateCustomToolbarTitle, filterAndSearchEvents, onSearchTermChange, toggleResource, miniCalendar logic, mainCalendar navigation) ...
  updateCustomToolbarTitle(view: any) {
    if (view.type === 'timeGridWeek' || view.type === 'dayGridWeek') {
      const start = this.datePipe.transform(view.activeStart, 'MMM d');
      const end = this.datePipe.transform(view.activeEnd, 'MMM d, yyyy');
      this.customToolbarTitle = `${start} - ${end}`;
    } else if (view.type === 'dayGridMonth') {
      this.customToolbarTitle = this.datePipe.transform(view.currentStart, 'MMMM yyyy') || '';
    } else if (view.type === 'timeGridDay') {
      this.customToolbarTitle = this.datePipe.transform(view.currentStart, 'MMMM d, yyyy') || '';
    } else {
      this.customToolbarTitle = view.title;
    }
    this.cdr.detectChanges();
  }

  filterAndSearchEvents(): void {
    let filtered = this.allCalendarEvents.filter(event =>
      this.selectedResources.includes(event.extendedProps?.resourceId || '')
    );
    if (this.searchTerm.trim() !== '') {
      const lowerSearchTerm = this.searchTerm.toLowerCase();
      filtered = filtered.filter(event =>
        event.title.toLowerCase().includes(lowerSearchTerm) ||
        (event.extendedProps?.description && event.extendedProps.description.toLowerCase().includes(lowerSearchTerm))
      );
    }
    this.calendarEvents = filtered;
    if (this.calendarApi) {
      this.calendarApi.removeAllEvents();
      this.calendarApi.addEventSource(this.calendarEvents);
    } else {
      this.calendarOptions.events = this.calendarEvents;
    }
  }

  onSearchTermChange(): void { this.filterAndSearchEvents(); }
  toggleResource(resourceId: string): void {
    const index = this.selectedResources.indexOf(resourceId);
    if (index > -1) this.selectedResources.splice(index, 1);
    else this.selectedResources.push(resourceId);
    this.filterAndSearchEvents();
  }
  generateMiniCalendar(): void {
    this.miniCalendarDays = [];
    const firstDayOfMonth = new Date(this.miniCalendarViewDate.getFullYear(), this.miniCalendarViewDate.getMonth(), 1);
    const firstDayToDisplay = new Date(firstDayOfMonth);
    firstDayToDisplay.setDate(firstDayOfMonth.getDate() - firstDayOfMonth.getDay());
    const mainCalendarCurrentDate = this.calendarApi ? this.calendarApi.getDate() : new Date();
    for (let i = 0; i < 42; i++) {
      const currentDay = new Date(firstDayToDisplay);
      currentDay.setDate(firstDayToDisplay.getDate() + i);
      this.miniCalendarDays.push({
        date: new Date(currentDay),
        dayOfMonth: currentDay.getDate(),
        isCurrentMonth: currentDay.getMonth() === this.miniCalendarViewDate.getMonth(),
        isSelected: this.isSameDate(currentDay, mainCalendarCurrentDate)
      });
    }
  }
  isSameDate(date1: Date, date2: Date): boolean {
    return date1.getFullYear() === date2.getFullYear() && date1.getMonth() === date2.getMonth() && date1.getDate() === date2.getDate();
  }
  previousMiniMonth(): void {
    this.miniCalendarViewDate.setMonth(this.miniCalendarViewDate.getMonth() - 1);
    this.miniCalendarViewDate = new Date(this.miniCalendarViewDate);
    this.generateMiniCalendar();
  }
  nextMiniMonth(): void {
    this.miniCalendarViewDate.setMonth(this.miniCalendarViewDate.getMonth() + 1);
    this.miniCalendarViewDate = new Date(this.miniCalendarViewDate);
    this.generateMiniCalendar();
  }
  selectMiniCalendarDate(date: Date): void {
    if (this.calendarApi) this.calendarApi.gotoDate(date);
    this.miniCalendarDays.forEach(day => day.isSelected = this.isSameDate(day.date, date));
  }
  goToToday(): void {
    if (this.calendarApi) this.calendarApi.today();
    this.miniCalendarViewDate = new Date();
    this.generateMiniCalendar();
  }
  mainCalendarNext(): void { if (this.calendarApi) this.calendarApi.next(); }
  mainCalendarPrev(): void { if (this.calendarApi) this.calendarApi.prev(); }
  changeMainCalendarView(view: 'dayGridMonth' | 'timeGridWeek' | 'timeGridDay'): void {
    if (this.calendarApi) this.calendarApi.changeView(view);
  }


  isSlotOccupied(startTime: Date, endTime: Date): boolean {
    return this.allCalendarEvents.some(event => {
      const eventStart = new Date(event.start);
      const eventEnd = event.end ? new Date(event.end) : new Date(eventStart.getTime() + (this.slotDurationMinutes * 60000)); // Estimer la fin si non définie

      // Vérifier le chevauchement:
      // (StartA < EndB) and (EndA > StartB)
      return startTime < eventEnd && endTime > eventStart;
    });
  }

  handleDateSelect(selectInfo: DateSelectArg) {
    const today = new Date();
    if (selectInfo.start < today) {
      alert("Vous ne pouvez pas sélectionner une date ou une heure passée.");
      if (this.calendarApi) this.calendarApi.unselect();
      return;
    }

    // Vérifier si le créneau est déjà occupé
    if (this.isSlotOccupied(selectInfo.start, selectInfo.end)) {
      alert("Ce créneau horaire est déjà réservé ou bloqué.");
      if (this.calendarApi) this.calendarApi.unselect();
      return;
    }

    this.selectedDateForBooking = selectInfo.start;
    if (!selectInfo.allDay) {
      this.selectedTimeForBooking = this.datePipe.transform(selectInfo.start, 'HH:mm');
      this.selectedEndTimeForBooking = this.datePipe.transform(selectInfo.end, 'HH:mm');
    } else {
      // Pour une sélection "allDay", définir une heure par défaut ou gérer différemment
      this.selectedTimeForBooking = "08:00"; // Heure de début par défaut
      const defaultEndDate = new Date(selectInfo.start);
      defaultEndDate.setHours(8, this.slotDurationMinutes, 0, 0); // Ex: 08:00 - 08:30
      this.selectedEndTimeForBooking = this.datePipe.transform(defaultEndDate, 'HH:mm');
    }

    this.bookingForm.reset({ fullName: '', email: '', phoneNumber: '', notes: '' });
    this.isBookingFormOpen = true;
  }

  submitNewAppointment(): void {
    if (this.bookingForm.invalid || !this.selectedDateForBooking || !this.selectedTimeForBooking) {
      this.bookingForm.markAllAsTouched();
      return;
    }

    const formValue = this.bookingForm.value;
    const startDate = new Date(this.selectedDateForBooking!);
    const [startHours, startMinutes] = this.selectedTimeForBooking!.split(':').map(Number);
    startDate.setHours(startHours, startMinutes, 0, 0);

    let endDate = new Date(startDate);
    if (this.selectedEndTimeForBooking) {
      const [endHours, endMinutes] = this.selectedEndTimeForBooking.split(':').map(Number);
      endDate.setHours(endHours, endMinutes, 0, 0);
    } else { // Fallback si selectedEndTimeForBooking n'est pas défini (ne devrait pas arriver avec la logique actuelle)
      endDate.setMinutes(startDate.getMinutes() + this.slotDurationMinutes);
    }

    // Double vérification pour date passée et créneau occupé
    if (startDate < new Date()) {
      alert("Impossible de créer un rendez-vous dans le passé.");
      this.closeBookingForm();
      return;
    }
    if (this.isSlotOccupied(startDate, endDate)) {
      alert("Ce créneau horaire a été réservé pendant que vous remplissiez le formulaire.");
      this.closeBookingForm();
      return;
    }

    const newEvent: MyCalendarEvent = {
      id: `new_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`, // ID plus unique
      title: formValue.fullName,
      start: startDate,
      end: endDate,
      allDay: false,
      extendedProps: {
        description: formValue.notes,
        status: 'Pending', // Statut par défaut
        patientEmail: formValue.email,
        patientPhone: formValue.phoneNumber,
        // resourceId: this.resources[0].id, // Assigner une ressource par défaut si nécessaire ou via sélection
      },
      backgroundColor: '#ffc107', // Jaune pour "Pending"
      borderColor: '#ffc107'
    };

    this.allCalendarEvents.push(newEvent);
    this.filterAndSearchEvents(); // Rafraîchit le calendrier principal
    this.closeBookingForm();
  }

  closeBookingForm(): void {
    this.isBookingFormOpen = false;
    this.selectedDateForBooking = null;
    this.selectedTimeForBooking = null;
    this.selectedEndTimeForBooking = null;
    if (this.calendarApi) {
      this.calendarApi.unselect();
    }
  }

  handleEventClick(clickInfo: EventClickArg) {
    this.selectedEventDetails = {
      id: clickInfo.event.id,
      title: clickInfo.event.title,
      start: clickInfo.event.start || new Date(),
      end: clickInfo.event.end ?? undefined,
      allDay: clickInfo.event.allDay,
      extendedProps: clickInfo.event.extendedProps,
      backgroundColor: clickInfo.event.backgroundColor,
      borderColor: clickInfo.event.borderColor
    };
    this.isEventModalOpen = true;
  }

  closeEventModal(): void {
    this.isEventModalOpen = false;
    this.selectedEventDetails = null;
  }

  printCalendar(): void {
    alert('Fonctionnalité d\'impression à implémenter.');
    // window.print(); // Peut nécessiter des styles CSS @media print
  }
}


