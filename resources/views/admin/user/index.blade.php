@extends('admin.layouts.main')

@section('content')

    <div class="card">
        <div class="card-header">
            Пользователи
        </div>
    </div>

    <div id="grid" class="min-vh-50 mt-4" style="height: 75%"></div>

@endsection

@section('scripts')
    <script type="module">
        import { w2grid } from 'https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.es6.min.js'

        let selectedGrid = undefined;
        let grid = new w2grid({
            name: 'grid',
            box: '#grid',
            multiSelect: false,
            show: {
                toolbar: false,
                toolbarReload: false,
                footer: true,
                toolbarAdd: false,
                toolbarDelete: false,
                toolbarSearch: true,
                toolbarInput: true,
                toolbarEdit: false,
            },
            searches: [
                { field: 'fname', text: 'First Name', type: 'text' },
                { field: 'lname', text: 'Last Name', type: 'text' },
                { field: 'email', text: 'Email', type: 'text' }
            ],
            sortData: [ { field: 'sdate', direction: 'asc' } ],
            columns: [
                { field: 'recid', text: 'ID', size: '50px', sortable: true },
                { field: 'fname', text: 'First Name', size: '30%', sortable: true },
                { field: 'lname', text: 'Last Name', size: '30%', sortable: true },
                { field: 'phone', text: 'Phone', size: '40%' },
                { field: 'email', text: 'Email', size: '40%' },
                { field: 'sdate', text: 'Start Date', size: '120px', sortable: true }
            ],
            toolbar: {
                items: [
                    {type: 'button', id: 'append', text: 'Добавить', icon: 'w2ui-icon-plus', disabled: false},
                    {type: 'button', id: 'show', text: 'Детально', icon: 'w2ui-icon-check', disabled: true},
                    {
                        type: 'button',
                        id: 'edit',
                        text: 'Редактировать',
                        icon: 'w2ui-icon-pencil',
                        disabled: true
                    },
                    {type: 'button', id: 'delete', text: 'Отключить', icon: 'fa fa-eraser', disabled: true},
                    {type: 'break', id: 'break0'},
                ]
            },
            onSelect: function (event) {
                if (selectedGrid == event.detail.clicked.recid) {
                    selectedGrid = undefined;
                }
                else {
                    selectedGrid = event.detail.clicked.recid;
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
                @foreach($users as $user)
                {
                    recid: '{{ $user->id }}',
                    fname: '{{ $user->first_name }}',
                    lname: '{{ $user->last_name }}',
                    phone: '{{ $user->phone }}',
                    email: '{{ $user->email }}',
                    sdate: '{{ $user->created_at }}'
                },
                @endforeach
            ]
        })
    </script>
@endsection
