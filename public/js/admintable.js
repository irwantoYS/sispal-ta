const basicData = {
    columns: [{
            label: 'User',
            field: 'user',
            sort: true,
            width: 300,
            fixed: true
        },
        {
            label: 'Tanggal',
            field: 'position',
            sort: false,
            width: 200
        },
        {
            label: 'Alamat Awal',
            field: 'alamatawal',
            sort: false,
            width: 200,
        },
        {
            label: 'Alamat Akhir',
            field: 'alamatakhir',
            sort: false,
            width: 200
        },
        {
            label: 'KM Awal',
            field: 'kmawal',
            sort: true,
            width: 200
        },
        {
            label: 'KM Akhir',
            field: 'kmakhir',
            sort: false,
            width: 200,
        },
        {
            label: 'Jenis Perjalanan',
            field: 'jperjalanan',
            sort: false,
            width: 200,
        },
        {
            label: 'Perkiraan BBM',
            field: 'bbm',
            sort: false,
            width: 200,
        },
        {
            label: 'Foto KM Awal',
            field: 'fotokmawal',
            sort: false,
            width: 200,
        },
        {
            label: 'Foto KM Akhir',
            field: 'fotokmakhir',
            sort: false,
            width: 200,
        },
    ],
    rows: [
        ['Tiger Nixon', '2023-09-10', 'Palembang', 'Bandar Lampung', '30', 65, 95, '$320,800', '$320,800'],
        ['Sonya Frost', '2023-09-10', 'Palembang', 'Bandar Lampung', '30', 65, 95, '$103,600', '$320,800'],
        ['Jena Gaines', '2023-09-10', 'Palembang', 'Bandar Lampung', '30', 65, 95, '$90,560', '$320,800'],
        ['Quinn Flynn', '2023-09-10', 'Palembang', 'Bandar Lampung', '30', 65, 95, '$342,000', '$320,800'],
        ['Charde Marshall', '2023-09-10', 'Palembang', 'Bandar Lampung', '30', 65, 95, '$470,600', '$320,800'],
        ['Haley Kennedy', '2023-09-10', 'Palembang', 'Bandar Lampung', '30', 65, 95, '$313,500', '$320,800'],
        ['Tatyana Fitzpatrick', '2023-09-10', 'Palembang', 'Bandar Lampung', '30', 65, 95, '$385,750', '$320,800'],
    ],
};

const datatable = document.getElementById('datatable');

new mdb.Datatable(datatable, basicData);