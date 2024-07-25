@props(['event'])

<div class="container" x-show="view" x-data="initData()" x-init="getReservs">

    <div class="row">

        <div x-show="step != 3" class="col-lg-4 col-12">

            <h3>{{ $event->name }}</h3>

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
            {!! file_get_contents(public_path('shemes/skbar-1.svg')) !!}
        </div>

        <div x-show="step == 2" class="col-lg-4 col-12 ms-auto me-auto">

            <div class="mb-4">
                <label for="name" class="form-label">ФИО</label>
                <input class="form-control bg-body-secondary" x-model="name">
            </div>

            <div class="mb-4">
                <label for="name" class="form-label">Телефон</label>
                <input class="form-control bg-body-secondary" x-model="phone" x-mask="+7 (999) 999-99-99">
            </div>

        </div>

        <div x-show="step == 3">
            Заявка на бронь оставленна, скоро с вами свяжутся для подтверждения!
        </div>

    </div>

    <div class="row">
        <div class="col-auto ms-auto">
            <button x-show="step == 1" @click="step = 2" class="btn btn-primary text-white">Дальше</button>
            <button x-show="step == 2" @click="step = 1" class="btn btn-primary text-white">Назад</button>

            <button x-show="step == 2" @click="check()" class="btn btn-primary text-white">Подтвердить</button>
        </div>
    </div>

    <div aria-live="polite" aria-atomic="true" class="bg-dark position-relative bd-example-toasts">
        <div class="toast-container position-fixed p-3 top-0 end-0">

            <div x-show="!tableId || !name || !phone" class="toast text-white bg-primary border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex justify-content-between">
                    <div class="toast-body">
                        <ul class="m-0">
                            <li x-show="!tableId">Выберите стол</li>
                            <li x-show="!name">Заполните ФИО</li>
                            <li x-show="!phone">Заполните телефон</li>
                        </ul>
                    </div>
                    <button class="btn-close btn-close-white me-2 mt-2" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    function initData() {
        return {
            eventId: {{ $event->id }},

            tableId: false,
            name: null,
            phone: null,

            step: 1,
            view: false,
            tables: {},

            init() {
                const that = this;
                const items = document.querySelectorAll("[data-table]");

                for (let i = 0; i < items.length; ++i) {
                    const item = items[i];

                    item.addEventListener("click", function(event) {
                        const current = event.target;
                        const parent = current.closest("[data-table]");
                        const table = parent.querySelector("[table]");

                        that.tableId = parent.getAttribute("data-table");
                        that.fillSelectTable(table);
                    });
                }

                setInterval(function() {
                    that.getReservs()
                }, 10000);
            },

            check() {
                var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                var toastList = toastElList.map(function(toastEl) {
                    return new bootstrap.Toast(toastEl, {
                        delay: 10000
                    })
                })

                if (!this.tableId || !this.name || !this.phone)
                    toastList.forEach(toast => toast.show())
                else {
                    // axios
                    axios.post('/api/reserv', {
                            event_id: this.eventId,
                            table: this.tableId,
                            phone: this.phone,
                            name: this.name,
                        })
                        .then(function(response) {
                            // handle success
                            console.log(response);
                            this.step = 3
                        })
                        .catch(function(error) {
                            // handle error
                            console.log(error);
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
                    console.log(tableInfo.color)
                    table.setAttribute("fill", tableInfo.color);
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

    /* [data-table]:hover>[table] {
        fill: yellow;
    } */

    /* [data-table]:active>[table] {
        stroke: red;
        stroke-width: 4px;
    } */

    /* .tooltip {
        position: absolute;
        background-color: #f9f9f9;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        pointer-events: none;
    } */
</style>
