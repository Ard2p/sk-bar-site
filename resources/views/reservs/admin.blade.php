@props(['event'])

<div class="col-span-10 bg-white" x-show="view" x-data="initData()" x-init="getReservs">


    {!! file_get_contents(public_path('shemes/skbar-2.svg')) !!}


</div>

<script>
    function initData() {
        return {
            eventId: {{ $event->id }},

            tableId: false,
            name: null,
            phone: null,
            seats: 1,

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

                if (!this.tableId || !this.name || !this.phone) {

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
