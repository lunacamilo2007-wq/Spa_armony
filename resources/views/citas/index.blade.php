@extends('layouts.app')

@section('titulo', 'Historial de Citas')

@push('styles')
    <style>
        /* Personalización de FullCalendar para que coincida con el estilo de la app */
        .fc {
            font-family: 'Inter', sans-serif;
        }

        .fc-theme-standard td,
        .fc-theme-standard th {
            border-color: #e5e7eb;
        }

        .fc-theme-standard .fc-scrollgrid {
            border-color: #e5e7eb;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .fc .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            text-transform: capitalize;
        }

        .fc .fc-button-primary {
            background-color: #f3f4f6;
            border-color: #d1d5db;
            color: #374151;
            text-transform: capitalize;
            transition: all 0.2s ease-in-out;
        }

        .fc .fc-button-primary:not(:disabled):active,
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #dbeafe !important;
            border-color: #bfdbfe !important;
            color: #1e40af !important;
        }

        .fc .fc-button-primary:hover {
            background-color: #e5e7eb;
            border-color: #d1d5db;
            color: #111827;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background-color: #eff6ff;
        }

        .fc-event {
            cursor: pointer;
            border: none;
            padding: 2px 4px;
            border-radius: 4px;
            font-size: 0.75rem;
            margin-bottom: 2px;
            transition: transform 0.1s;
        }

        .fc-event:hover {
            transform: scale(1.02);
        }

        /* Colores según estado */
        .fc-event.bg-pendiente {
            background-color: #fef3c7;
            color: #b45309;
        }

        .fc-event.bg-confirmada {
            background-color: #e0e7ff;
            color: #4338ca;
        }

        .fc-event.bg-finalizada {
            background-color: #d1fae5;
            color: #047857;
        }

        .fc-event.bg-cancelada {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .fc-daygrid-day-number {
            color: #374151;
            font-weight: 500;
            text-decoration: none !important;
        }

        .fc-col-header-cell-cushion {
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            padding: 8px 0;
            text-decoration: none !important;
        }

        .fc-daygrid-day {
            transition: background-color 0.2s;
        }

        .fc-daygrid-day:hover {
            background-color: #f9fafb;
            cursor: pointer;
        }
    </style>
@endpush

@section('contenido')
    <div class="bg-surface-50 min-h-[calc(100vh-4rem)]" id="citas-index-page" x-data="citasCalendario()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900"
                        x-text="view === 'calendar' ? 'Calendario de Citas' : 'Citas del día'">Historial de Citas</h1>
                    <p class="text-primary-600 text-sm mt-0.5" x-show="view === 'calendar'">{{ $citas->count() }} citas
                        registradas</p>
                    <p class="text-primary-600 text-sm mt-0.5 capitalize" x-show="view === 'list'"
                        x-text="selectedDateFormatted" style="display: none;"></p>

                    <div x-show="view === 'list' && masajistasDelDia.length > 0" class="mt-3 animate-fade-in"
                        style="display: none;">
                        <div class="inline-flex flex-col">
                            <label for="filtro_masajista" class="label-field text-xs text-gray-500 mb-1">Filtrar por
                                masajista:</label>
                            <select id="filtro_masajista" x-model="selectedMasajista" @change="filterCitas()"
                                class="select-field py-1.5 px-3 text-sm min-w-[200px]">
                                <option value="">Todos los masajistas</option>
                                <template x-for="mas in masajistasDelDia" :key="mas.id">
                                    <option :value="mas.id" x-text="mas.nombre"></option>
                                </template>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-4 sm:mt-0">
                    <button x-show="view === 'list'" @click="backToCalendar"
                        class="btn-secondary bg-white border-gray-200 text-gray-700 hover:bg-gray-50 flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                        style="display: none;">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver al Calendario
                    </button>
                    <a href="{{ route('citas.create') }}" class="btn-primary" id="btn-nueva-cita-page">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nueva Cita
                    </a>
                </div>
            </div>

            {{-- Calendario View --}}
            <div x-show="view === 'calendar'"
                class="card p-6 animate-fade-in bg-white shadow-sm rounded-xl border border-gray-100">
                <div id="calendar"></div>
            </div>

            {{-- List View --}}
            <div x-show="view === 'list'" style="display: none;" class="animate-fade-in">
                <div class="space-y-4" id="citas-list-container">
                    @forelse($citas as $cita)
                        <div class="card p-6 cita-card" data-date="{{ $cita->fecha->format('Y-m-d') }}"
                            data-masajista-id="{{ $cita->masajista }}"
                            data-masajista-nombre="{{ $cita->masajistaRel->nombre ?? 'Desconocido' }}" x-data="{ open: false }"
                            :class="{ 'relative z-50': open }" style="display: none;">
                            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                                {{-- Avatar + Client Info --}}
                                <div class="flex items-start gap-4 flex-1 min-w-0">
                                    <div
                                        class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold shrink-0">
                                        {{ strtoupper(substr($cita->cliente->nombre ?? '?', 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h3 class="font-semibold text-gray-900">{{ $cita->cliente->nombre ?? 'N/A' }}</h3>
                                        </div>
                                        <div class="flex flex-wrap gap-x-6 gap-y-1 mt-2 text-sm text-gray-500">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $cita->fecha->format('d M, Y') }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $cita->fecha->format('H:i') }}
                                                @if($cita->duracion_total)
                                                    ({{ $cita->duracion_total }} min)
                                                @endif
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ $cita->masajistaRel->nombre ?? 'N/A' }}
                                            </span>
                                            @if($cita->habitacion)
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    Hab. {{ $cita->habitacion }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            Cédula: {{ $cita->cliente->cedula ?? '' }} · Tel:
                                            {{ $cita->cliente->telefono ?? 'N/A' }} · Email:
                                            {{ $cita->cliente->correo ?? 'N/A' }}
                                        </div>
                                        {{-- Service tags --}}
                                        <div class="flex flex-wrap gap-2 mt-3">
                                            @foreach($cita->servicios as $srv)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-primary-50 text-primary-700 border border-primary-200">
                                                    {{ $srv->nombre_servicio }} - ${{ number_format($srv->precio, 0, ',', '.') }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Status + Total + Actions --}}
                                <div class="flex items-center gap-4 lg:flex-col lg:items-end shrink-0">
                                    <span class="badge-{{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span>
                                    <span
                                        class="text-lg font-bold text-gray-900">${{ number_format($cita->total, 0, ',', '.') }}</span>

                                    {{-- Actions Dropdown --}}
                                    <div class="relative">
                                        <button @click="open = !open"
                                            class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>
                                        <div x-show="open" @click.outside="open = false" x-transition
                                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                                            @if($cita->estado === 'pendiente')
                                                <form method="POST" action="{{ route('citas.confirm', $cita->id_cita) }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2 text-sm text-primary-600 hover:bg-gray-50">✓
                                                        Confirmar</button>
                                                </form>
                                            @endif
                                            @if(in_array($cita->estado, ['pendiente', 'confirmada']))
                                                <form method="POST" action="{{ route('citas.cancel', $cita->id_cita) }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">✕
                                                        Cancelar</button>
                                                </form>
                                            @endif
                                            @if($cita->estado === 'confirmada')
                                                <form method="POST" action="{{ route('citas.finalize', $cita->id_cita) }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-50">✓
                                                        Finalizar</button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('citas.destroy', $cita->id_cita) }}"
                                                onsubmit="return confirm('¿Eliminar esta cita?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">🗑
                                                    Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Notes --}}
                            @if($cita->nota)
                                <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                                    <span class="text-sm font-medium text-amber-700">Notas:</span>
                                    <span class="text-sm text-amber-600 ml-1">{{ $cita->nota }}</span>
                                </div>
                            @endif
                        </div>
                    @empty
                        {{-- Esto solo se muestra si NO hay citas en absoluto, aunque está manejado por FullCalendar
                        principalmente --}}
                    @endforelse
                </div>

                {{-- Empty State for Day --}}
                <div id="empty-day-state" style="display: none;" class="card p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-500 text-lg">No hay citas programadas para este día.</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @php
            $eventosCalendario = $citas->map(function ($cita) {
                $estadoClass = match ($cita->estado) {
                    'pendiente' => 'bg-pendiente',
                    'confirmada' => 'bg-confirmada',
                    'finalizada' => 'bg-finalizada',
                    'cancelada' => 'bg-cancelada',
                    default => 'bg-pendiente'
                };

                return [
                    'id' => $cita->id_cita,
                    'title' => ($cita->cliente->nombre ?? 'Sin Cliente') . ' - ' . ($cita->servicios->first()->nombre_servicio ?? 'Cita'),
                    'start' => $cita->fecha->format('Y-m-d\TH:i:s'),
                    'className' => $estadoClass,
                    'extendedProps' => [
                        'estado' => $cita->estado,
                    ]
                ];
            });
        @endphp
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/locales/es.global.min.js'></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('citasCalendario', () => ({
                    view: 'calendar',
                    selectedDate: null,
                    selectedDateFormatted: '',
                    selectedMasajista: '',
                    masajistasDelDia: [],
                    calendar: null,

                    init() {
                        const urlParams = new URLSearchParams(window.location.search);
                        const dateParam = urlParams.get('date');

                        this.$nextTick(() => {
                            this.initCalendar();
                            if (dateParam) {
                                this.showDate(dateParam);
                            }
                        });
                    },

                    initCalendar() {
                        var calendarEl = document.getElementById('calendar');
                        if (!calendarEl) return;

                        var eventos = @json($eventosCalendario);

                        this.calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            locale: 'es',
                            height: 'auto',
                            contentHeight: 'auto',
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            events: eventos,
                            buttonText: {
                                today: 'Hoy',
                                month: 'Mes',
                                week: 'Semana',
                                day: 'Día',
                                list: 'Lista'
                            },
                            eventTimeFormat: {
                                hour: '2-digit',
                                minute: '2-digit',
                                meridiem: false,
                                hour12: false
                            },
                            dayMaxEvents: 2,
                            moreLinkClick: (info) => {
                                let d = info.date;
                                let dateStr = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
                                this.showDate(dateStr);
                                return 'none';
                            },
                            dateClick: (info) => {
                                this.showDate(info.dateStr);
                            },
                            eventClick: (info) => {
                                this.showDate(info.event.startStr.split('T')[0]);
                            }
                        });

                        this.calendar.render();
                    },

                    showDate(dateStr) {
                        this.selectedDate = dateStr;

                        let parts = dateStr.split('-');
                        let d = new Date(Date.UTC(parts[0], parts[1] - 1, parts[2]));

                        this.selectedDateFormatted = d.toLocaleDateString('es-ES', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            timeZone: 'UTC'
                        });

                        this.view = 'list';
                        this.selectedMasajista = '';

                        let cards = document.querySelectorAll('.cita-card');
                        let count = 0;
                        let masajistasMap = new Map();

                        cards.forEach(card => {
                            if (card.dataset.date === this.selectedDate) {
                                card.style.display = 'block';
                                count++;

                                let mId = card.dataset.masajistaId;
                                let mNombre = card.dataset.masajistaNombre;
                                if (mId && mNombre) {
                                    masajistasMap.set(mId, mNombre);
                                }
                            } else {
                                card.style.display = 'none';
                            }
                        });

                        this.masajistasDelDia = Array.from(masajistasMap, ([id, nombre]) => ({ id, nombre }));

                        let emptyState = document.getElementById('empty-day-state');
                        if (emptyState) {
                            emptyState.style.display = count === 0 ? 'block' : 'none';
                        }

                        let btnCreate = document.getElementById('btn-create-cita-day');
                        if (btnCreate) {
                            btnCreate.href = "{{ route('citas.create') }}" + "?fecha=" + dateStr;
                        }
                    },

                    filterCitas() {
                        let cards = document.querySelectorAll('.cita-card');
                        let count = 0;
                        cards.forEach(card => {
                            if (card.dataset.date === this.selectedDate) {
                                if (this.selectedMasajista === '' || card.dataset.masajistaId === this.selectedMasajista) {
                                    card.style.display = 'block';
                                    count++;
                                } else {
                                    card.style.display = 'none';
                                }
                            } else {
                                card.style.display = 'none';
                            }
                        });
                        let emptyState = document.getElementById('empty-day-state');
                        if (emptyState) {
                            emptyState.style.display = count === 0 ? 'block' : 'none';
                        }
                    },

                    backToCalendar() {
                        this.view = 'calendar';
                        this.selectedDate = null;
                        this.selectedMasajista = '';
                        this.masajistasDelDia = [];
                        this.$nextTick(() => {
                            if (this.calendar) {
                                this.calendar.updateSize();
                            }
                        });
                    }
                }));
            });
        </script>
    @endpush
@endsection