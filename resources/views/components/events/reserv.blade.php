<x-guest-layout>

    <div class="container mb-5">

        <div class="row" x-show="view" x-data="{
            step: 1,
            view: false,
            tables: {},
            async getReservs() {
                this.tables = await (await fetch('/api/reserv/1')).json()
                const elements = document.querySelectorAll('[data-table]')
                elements.forEach(element => {
                    tableId = element.getAttribute('data-table')
                    tableInfo = this.tables[tableId]
                    table = element.querySelector('[table]')
                    table.setAttribute('fill', tableInfo.color)
                })
                this.view = true
            }
        }" x-init="getReservs">

            <div class="row" x-show="step == 1">

                <div class="col-4">
                    Название мероприятия
                    дата

                    вид депозита
                </div>

                <div class="col-8">
                    {!! file_get_contents(public_path('shemes/skbar-1.svg')) !!}
                </div>

            </div>

            <div x-show="step == 2">
                2
            </div>

            <div x-show="step == 3">
                3
            </div>

            <div class="row">
                <button x-show="step == 1" @click="step = 2" class="btn btn-primary text-white">Дальше</button>
                <button x-show="step == 2" @click="step = 1" class="btn btn-primary text-white">Назад</button>

                <button x-show="step == 2" @click="step = 3" class="btn btn-primary text-white">Подтвердить</button>
            </div>

        </div>

    </div>

</x-guest-layout>

<script>
    // var exampleEl = document.getElementById('tooltip');
    // var bootstrap = window.bootstrap;
    // var tooltip;

    const items = document.querySelectorAll('[data-table]')
    for (let i = 0; i < items.length; ++i) {
        const item = items[i]

        item.addEventListener('click', function(event) {
            console.log(event.target.closest('[data-table]').getAttribute('data-table'))

            // Get mouse position
            // var mouseX = event.clientX;
            // var mouseY = event.clientY;

            // tooltip = new bootstrap.Tooltip(exampleEl, {
            //     title: '11123'
            // })
            // tooltip.show()
        });

        // item.addEventListener('mouseout', function() {
        //     tooltip.hide()
        // });
    }
</script>

<style>
    svg {
        user-select: none
    }

    /* [data-table]:hover>[table] {
        fill: yellow;
    } */

    [data-table]:active>[table] {
        stroke: red;
        stroke-width: 4px;
    }

    /* .tooltip {
        position: absolute;
        background-color: #f9f9f9;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        pointer-events: none;
    } */
</style>
