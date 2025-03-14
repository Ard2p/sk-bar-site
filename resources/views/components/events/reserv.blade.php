@props(['event', 'isAdmin' => false])

@if (!$isAdmin)
    <div class="container" x-show="view" x-data="initData()" x-init="getReservs">

        <div class="row">

            <div x-show="step != 3" class="col-lg-4 col-12">

                <h3>{!! $event->name !!}</h3>

                <div class="mb-3 text-primary">
                    <p>{{ $event->place->name }}, {{ $event->place->city }}, {{ $event->place->adress }}</p>

                    <span class="badge text-black bg-body-secondary">
                        {{ $event->event_start->translatedFormat('d F') }}
                    </span>
                    <span class="badge text-white bg-info">{{ $event->age_limit }} +</span>
                </div>

                <div class="mb-3" x-show="tableName">
                    <span>Бронь стола № </span>
                    <span x-text="tableName"></span>
                    <span class="float-end text-primary" x-text="tablePrice + 'р'"> x 3000</span>
                </div>
            </div>

            <div x-show="step == 1" class="col-lg-8 col-12">
                {!! file_get_contents(public_path('shemes/skbar-2.svg')) !!}
            </div>

            <div x-show="step == 2" class="col-lg-4 col-12 ms-auto me-auto">

                <div class="mb-4">
                    <label for="name" class="form-label">ФИО</label>
                    <input class="form-control bg-body-secondary" x-model="name">
                </div>

                <div class="mb-4">
                    <label for="name" class="form-label">Телефон</label>
                    <input class="form-control bg-body-secondary" x-model="phone" x-mask="+7 (999) 999-99-99"
                        min="18" id="phone">
                </div>

                <div class="mb-4">
                    <label for="name" class="form-label">Гостей</label>
                    <input class="form-control bg-body-secondary" x-model="seats" type="number" min="1">
                </div>

            </div>

            <div class="row flex-column align-items-center" x-show="step == 3">

                <div class="col-2">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <circle cx="12" cy="12" r="10" stroke="#0bad3b" stroke-width="1.5"></circle>
                            <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="#0bad3b" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>

                </div>

                <div class="col-10">
                    Заявка на бронь оставленна, ближе к событию с вами свяжутся для подтверждения!
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-auto ms-auto">
                <button x-show="step == 1" @click="step = 2" class="btn btn-primary text-white">Дальше</button>
                <button x-show="step == 2" @click="step = 1" class="btn btn-primary text-white">Назад</button>

                <button x-show="step == 2" @click="check()" class="btn btn-primary text-white">Подтвердить</button>
            </div>
        </div>

    </div>
@else
    <div class="col-span-10 bg-white" x-show="view" x-data="initData()" x-init="getReservs">
        {!! file_get_contents(public_path('shemes/skbar-2.svg')) !!}
    </div>
@endif


<script>
    function initData() {
        return {
            eventId: {{ $event->id }},

            tableId: false,
            name: null,
            phone: +7,
            seats: 1,

            step: 1,
            view: false,
            tables: {},

            init() {
                const that = this;
                const items = document.querySelectorAll("[data-table]");
                const inputPhone = document.querySelector("#phone");

                if (inputPhone)
                    inputPhone.addEventListener("input", function(event) {
                        if (event.target.value.length < 4) inputPhone.value = "+7 ("
                    });

                for (let i = 0; i < items.length; ++i) {
                    const item = items[i];

                    item.addEventListener("click", function(event) {
                        const current = event.target;
                        const parent = current.closest("[data-table]");
                        const table = parent.querySelector("[table]");

                        const tableId = parent.getAttribute("data-table");
                        const tableInfo = that.tables[tableId];

                        if (tableInfo.status == 'free') {
                            that.tableId = parent.getAttribute("data-table");
                            that.fillSelectTable(table);
                        }
                    });
                }

                setInterval(function() {
                    that.getReservs()
                }, 10000);
            },

            check() {
                const that = this;
                var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                var toastList = toastElList.map(function(toastEl) {
                    return new bootstrap.Toast(toastEl, {
                        delay: 10000
                    })
                })

                if (!this.tableId || !this.name || !this.phone || this.phone.length != 18) {

                    if (this.phone.length != 18)
                        new window.bs5.Toast({
                            body: 'Введите полный сотовый номер',
                            delay: 5000,
                            className: 'border-0 bg-primary text-white',
                        }).show()

                    if (!this.tableId)
                        new window.bs5.Toast({
                            body: 'Выберите стол',
                            delay: 5000,
                            className: 'border-0 bg-primary text-white',
                        }).show()

                    if (!this.tableId)
                        new window.bs5.Toast({
                            body: 'Выберите стол',
                            delay: 5000,
                            className: 'border-0 bg-primary text-white',
                        }).show()

                    if (!this.phone)
                        new window.bs5.Toast({
                            body: 'Заполните телефон',
                            delay: 5000,
                            className: 'border-0 bg-primary text-white',
                        }).show()

                    if (!this.name)
                        new window.bs5.Toast({
                            body: 'Заполните ФИО',
                            delay: 5000,
                            className: 'border-0 bg-primary text-white',
                        }).show()
                } else {
                    axios.post('/api/reserv', {
                            event_id: this.eventId,
                            table: this.tableId,
                            phone: this.phone,
                            seats: this.seats,
                            name: this.name,
                        })
                        .then(function(response) {
                            if (response.data == 'ok') {
                                that.step = 3;

                                that.tableId = null;
                                that.phone = null;
                                that.seats = null;
                                that.name = null;
                            }
                        })
                        .catch(function(error) {
                            Object.keys(error.response.data.errors).forEach(function(key) {
                                error.response.data.errors[key].forEach(async (error) => {
                                    new window.bs5.Toast({
                                        body: error,
                                        delay: 5000,
                                        className: 'border-0 bg-primary text-white',
                                    }).show()
                                });
                            });
                        });
                }
            },

            get tableName() {
                if (!this.tables || !this.tableId) return null;
                return this.tables[this.tableId].name;
            },

            get tablePrice() {
                if (!this.tables || !this.tableId) return null;
                return this.tables[this.tableId].price;
            },

            fillSelectTable(currentTable) {
                const elements = document.querySelectorAll("[data-table]");
                elements.forEach((element) => {
                    const tableId = element.getAttribute("data-table");
                    const tableInfo = this.tables[tableId];
                    const table = element.querySelector("[table]");
                    table.setAttribute("fill", tableInfo.color);
                });

                currentTable.setAttribute("fill", "yellowgreen");
            },

            async getReservs() {
                this.tables = await (await fetch("/api/reserv/" + this.eventId)).json();

                const elements = document.querySelectorAll("[data-table]");
                elements.forEach((element) => {
                    const tableId = element.getAttribute("data-table");
                    const tableInfo = this.tables[tableId];
                    const table = element.querySelector("[table]");

                    console.log(table, tableInfo)

                    if (tableInfo.status == 'removed') element.style.display = 'none';
                    else element.style.display = 'block';

                    table.setAttribute("fill", tableInfo.color);

                    if (tableId == this.tableId) {
                        if (tableInfo.status == 'free') {
                            this.fillSelectTable(table);
                        } else {
                            this.tableId = null;
                        }
                    }
                });

                this.view = true;
            },
        }
    }
</script>

<style>
    svg {
        user-select: none
    }
</style>
