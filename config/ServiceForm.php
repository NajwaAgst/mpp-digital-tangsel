<?php

return [

    'adminduk' => [

        'code' => 'kk',

        'title' => 'Pembuatan Kartu Keluarga',

        'auto' => [
            'nik',
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat'
        ],

        'manual' => [
            'hp',
            'status_perkawinan'
        ]

    ],

    'perizinan-berusaha' => [

    'code' => 'nib',

    'title' => 'Nomor Induk Berusaha (NIB)',

    'auto' => [

        'nik',
        'nama',
        'alamat',
        'npwp',
        'status_npwp'

    ],

    'manual' => [

        'nama_usaha',
        'jenis_usaha',
        'email',
        'whatsapp',
        'modal_usaha',
        'lokasi_usaha',
        'jumlah_tenaga_kerja',
        'kbli'

    ]

],

    'perpajakan' => [

        'code' => 'pbb',

        'title' => 'Pajak Bumi dan Bangunan',

        'auto' => [
            'nik',
            'nama',
            'alamat',
            'npwp'
        ],

        'manual' => [
            'nop',
            'tahun_pajak',
            'alamat_objek_pajak'
        ]

    ],

    'ketenagakerjaan-jaminan-sosial' => [

        'code' => 'bpjs',

        'title' => 'BPJS Ketenagakerjaan',

        'auto' => [
            'nik',
            'nama',
            'tanggal_lahir',
            'alamat'
        ],

        'manual' => [
            'hp',
            'nama_perusahaan',
            'jabatan',
            'gaji'
        ]

    ],

    'pertanahan' => [

        'code' => 'tanah',

        'title' => 'Pendaftaran Tanah',

        'auto' => [
            'nik',
            'nama',
            'alamat',
            'npwp'
        ],

        'manual' => [
            'lokasi_tanah',
            'luas_tanah',
            'status_kepemilikan'
        ]

    ],

    'kepolisian-hukum' => [

        'code' => 'skck',

        'title' => 'SKCK',

        'auto' => [
            'nik',
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat'
        ],

        'manual' => [
            'hp',
            'keperluan_skck'
        ]

    ],

    'imigrasi-pmi' => [

        'code' => 'paspor',

        'title' => 'Pembuatan Paspor',

        'auto' => [
            'nik',
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat'
        ],

        'manual' => [
            'hp',
            'tujuan_negara',
            'tujuan_keberangkatan'
        ]

    ],

    'perbankan-keuangan' => [

        'code' => 'tilang',

        'title' => 'Pembayaran Tilang',

        'auto' => [
            'nik',
            'nama',
            'alamat'
        ],

        'manual' => [
            'nomor_tilang',
            'nomor_kendaraan',
            'nomor_briva'
        ]

    ]

];