@extends('admin.layouts.main')

@section('content')

    <div class="card">
        <div class="card-header">
            События
        </div>
    </div>

    <div id="grid" class="min-vh-50 mt-4" style="height: 75%"></div>

@endsection

<script type="module">
    import { w2grid } from 'https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.es6.min.js'

    let selectedGrid = undefined;
    let grid = new w2grid({
        name: 'grid',
        box: '#grid',
        multiSelect: false,
        show: {
            toolbar: true,
            toolbarReload: false,
            footer: true,
            toolbarAdd: false,
            toolbarDelete: false,
            toolbarSearch: true,
            toolbarInput: true,
            toolbarEdit: false,
        },
        searches: [
            { field: 'title', text: 'Title', type: 'text' },
            { field: 'address', text: 'Address', type: 'text' },
            { field: 'created_by', text: 'Created By', type: 'text' }
        ],
        sortData: [ { field: 'sdate', direction: 'asc' } ],
        columns: [
            { field: 'recid', text: 'ID', size: '50px', sortable: true },
            { field: 'title', text: 'Title', size: '30%', sortable: true },
            { field: 'category', text: 'Category', size: '30%' },
            { field: 'address', text: 'Address', size: '40%' },
            { field: 'status', text: 'Status', size: '25%' },
            { field: 'created_by', text: 'Created By', size: '25%', sortable: true },
            { field: 'created_at', text: 'Start Date', size: '120px', sortable: true }
        ],
        toolbar: {
            onClick (event) {
                if (event.detail.item.id === 'show') {
                    window.open('/events/' + selectedGrid, "_self");
                }

            },
            items: [
                {type: 'button', id: 'show', text: 'Посмотреть', icon: 'w2ui-icon-check', disabled: true},
                {type: 'break', id: 'break0'},
            ]
        },
        onSelect: function (event) {
            if (selectedGrid == grid.get(event.detail.clicked.recid).id_inc) {
                selectedGrid = undefined;
            }
            else {
                selectedGrid = grid.get(event.detail.clicked.recid).id_inc;
            }

            this.toolbar.enable('edit');
            this.toolbar.enable('show');
            this.toolbar.enable('delete');
        },
        onUnselect: function (event) {
            console.log(123);
            this.toolbar.disable('edit');
            this.toolbar.disable('show');
            this.toolbar.disable('delete');
        },
        records: [
            @foreach($events as $event)
            {
                id_inc: '{{ $event->id_inc }}',
                recid: '{{ $event->id }}',
                title: '{{ $event->title }}',
                created_by: '{{ $event->created_by->full_name }}',
                category: '{{ $event->event_category->name }}',
                status: '{{ $event->event_status->name }}',
                address: '{{ $event->city?->name . ', ' . $event->address }}',
                created_at: '{{ $event->created_at }}'
            },
            @endforeach
        ]
    })
</script>
@section('scripts')
@endsection
