<x-blank-layout>

    <div class="content">
        <div class="shemas">
            <h2>{!! $event->name !!}</h2>
            <h4>Дата: {{ $event->event_start->translatedFormat('d.m.Y') }}</h4>

            {!! file_get_contents(public_path('shemes/skbar-2.svg')) !!}

        </div>

        <table>
            <thead>
                <tr>
                    <th scope="col">Стол</th>
                    <th scope="col">Гостей</th>
                    <th scope="col">ФИО</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Оплата</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservs as $reserv)
                    @php
                        $reserv = (object) $reserv;
                    @endphp
                    <tr>
                        <td align="right">{{ $reserv->name }}</td>
                        <td align="right">{{ $reserv->seats }}</td>
                        <td>{{ $reserv->fio }}</td>
                        <td>{{ $reserv->phone }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-blank-layout>


<script type="text/javascript">
    window.onafterprint = window.close;
    window.print();
</script>


<style>
    @page {
        size: A4 landscape;
    }

    html,
    body {
        font-size: 14px
    }

    @media print {}

    .content {
        display: flex;
        justify-content: space-between;
    }

    .shemas {
        width: 39%;
    }

    table {
        width: 60%;
        border-collapse: collapse;
    }

    table td,
    table th {
        border: 1px solid black;
        padding: 2px 5px;
    }

    table tr:first-child th {
        border-top: 0;
    }

    table tr:last-child td {
        border-bottom: 0;
    }

    table tr td:first-child,
    table tr th:first-child {
        border-left: 0;
    }

    table tr td:last-child,
    table tr th:last-child {
        border-right: 0;
    }
</style>
