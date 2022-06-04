<script>
    export default {
        select: {
            info: false,
            items: 'cell',
        },
        autoFill: true,
        colReorder: true,
        keys: true,
        buttons: [
            {
                extend: 'excel',
                className: 'btn',
                titleAttr: 'Скачать таблицу в формате Excel'
            },
            {
                extend: 'pdf',
                className: 'btn',
                titleAttr: 'Скачать таблицу в формате PDF'
            },
            {
                extend: 'print',
                className: 'btn',
                titleAttr: 'Распечатать таблицу'
            },
        ],
        searchPanes: {
            collapse: true,
            columns: [4]

        },
        // columns: [
        //     { "type": "num" },
        //     null,
        //     null,
        //     null,
        //     null,
        //     null,
        //     null,
        //     // { "type": "num", "searchBuilderType": "num"},
        //     // { "type": "num", "searchBuilderType": "num"},
        //     // { "type": "num", "searchBuilderType": "num"},
        //     null,
        //     null,
        //     null,
        //     null,
        //     null
        // ],
        // columns: {
        //     searchBuilderType: 'num',
        // },
        searchBuilder: true,
        dom: "<'row'<'col-sm-12 col-md-7'i><'col-sm-12 col-md-5'<'text-right'B>>>" +
            "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12'<'pull-center'p>>>" +
            "<'row'<'col-sm-12 col-md-12'Q>>",

        stateSave: true,
        language: {
            url: '/langs/data_tables/ru.json'
        },
    }
</script>
