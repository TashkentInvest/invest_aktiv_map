<?php

return [
    'menu_top' => [
        'menu' => 'MENU',
        'api_users' => 'API foydalanuvchilar'
    ],
    'userManagement' => [
        'title'          => 'Foydalanuvchini boshqarish',
        'title_singular' => 'Boshqarish',
    ],
    'permission'     => [
        'title'          => 'Ruxsatlarni boshqarish',
        'title_singular' => 'Ruxsat',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Izoh',
            'name'              => 'Nomi',
            'permissions'       => 'Ruxsatlar',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role'           => [
        'title'          => 'Ro`llarni boshqarish',
        'title_singular' => 'Ro`l',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'title'             => 'Izoh',
            'name'              => 'Nomi',
            'roles'             => 'Rollari',
            'title_helper'       => ' ',
            'permissions'        => 'Ro`lning ruxsatlari',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user'           => [
        'title'          => 'Foydalanuvchilar',
        'title_singular' => 'Foydalanuvchi',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'Ism',
            'name_helper'              => ' ',
            'email'                    => 'Email',
            'email_helper'             => ' ',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => ' ',
            'password'                 => 'Parol',
            'password_helper'          => ' ',
            'roles'                    => 'Ro`llari',
            'roles_helper'             => ' ',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
        ],
    ],
    
    'client'           => [
        'title'          => 'Mijozlar',
        'title_singular' => 'Mijoz',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'Ism',
            'first_name'               => 'Ism',
            'last_name'                => 'Familiya',
            'father_name'              => 'Otasining ismi',
            'contact'                  => 'Aloqa uchun telefon',
            'client_description'       => 'Mijoz Tafsilotlari',
            'yuridik_address'          => 'Yuridik manzil',
            'yuridik_rekvizid'         => 'Xisob raqam',
            'mijoz_turi_yuridik'       => 'Yuridik shaxs',
            'mijoz_turi_fizik'         => 'Jismoniy shaxs',
            'mijoz_turi'               => 'Shaxs turi',
            'passport_date'            => 'Berilgan sana',
            'passport_location'        => 'Berilgan joy',
            'passport_serial'          => 'Pasport seriyasi yoki ID',
            'passport_pinfl'           => 'PINFL',
            'name_helper'              => ' ',
            'email'                    => 'Email',
            'email_helper'             => ' ',
            'email_verified_at'        => 'Email tasdiqlangan vaqti',
            'email_verified_at_helper' => ' ',
            'password'                 => 'Parol',
            'password_helper'          => ' ',
            'roles'                    => 'Rollar',
            'roles_helper'             => ' ',
            'remember_token'           => 'Eslab qolish tokeni',
            'remember_token_helper'    => ' ',
            'created_at'               => 'Yaratilgan vaqti',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Yangilangan vaqti',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'O\'chirilgan vaqti',
            'deleted_at_helper'        => ' ',
        ],
    ],
    
    'setting'        => [
        'title'          => 'Sozlamalar',
        'about_company'  => 'Kompaniya haqida',
        'text_bot'       => "Telgram-bot uchun kirish so'z",
        'about'  => [
            'description' => 'Kompaniya haqida'
        ],
        'start_message' => [
            'title' => "Kirish so'z"
        ]
    ],
    'regions_districts' => [
        'title'          => 'Hududlar va tumanlar',
        'regions' => [
            'title' => 'Hududlar',
            'name_uz' => "O'zbekcha nomi",
            'name_ru' => 'Rus tilida nomi'
        ],
        'districts' => [
            'title' => 'Tumanlar',
            'streets_title' => 'Ko\'chalar',
            "select_region" => 'Viloyatni tanlang',
            "select_district" => 'Tumanni tanlang',
            "select_street" => 'Ko\'chani tanlang',
        ]
    ],
    'job'  => [
        'title' => 'Ish',
        'programs' => 'Dasturlar',
        'fields' => [
            'name_uz' => "O'zbekcha nomi",
            'name_ru' => 'Rus tilida nomi'
        ]
    ],
    'branches' => [
        'title' => 'Xaritalar',
        'fields' => [
            'name_uz' => "O'zbekcha nomi",
            'name_ru' => 'Rus tilida nomi',
            'description_uz' => "O'zbek tilida izoh",
            'description_ru' => "Rus tilida izoh",
            'photo' => "Rasm",
            'longitude' => 'Uzunlik',
            'latitude' => 'Kenglik',
            'kubmetr' => 'Kubmetr',
            'region_id' => 'Joylashgan viloyati',
            'district_id' => 'Joylashgan tuman',
            'street_id' => 'Joylashgan ko\'cha',
            'address' => "Manzil",
            'open_with_google_maps' => 'Xarita orqali oching'
        ]
    ],

    'history' => [
        'title' => 'So\'rovlar tarixi',
        'fields' => [
            'name_uz' => "O'zbekcha nomi",
            'name_ru' => 'Rus tilida nomi',
        ]
    ],

    'backup' => [
        'title' => 'Backup',
        'fields' => [
            'name_uz' => "O'zbekcha nomi",
            'name_ru' => 'Rus tilida nomi',
        ]
    ],

    'transaction' => [
        'title' => 'Transaktsiyalar',
        'fields' => [
            'show' => 'Transaktsiya',
            'name' => "Transaktsiya nomi",
            'description' => 'Transaktsiya tavsifi',
            'credit' => 'Kredit',
            'payers' => 'Transaktsiya to‘lovchilari',
            'import' => 'Yangi transaktsiyani import qilish',

            'all' => 'Barcha Transaktsiyalar',
            'apz' => 'ART Transaktsiyalar',
            'ads' => 'Reklama Transaktsiyalar'
        ]
    ],


    'blogs' => [
        'title' => 'Blog',
        'fields' => [
            'name_uz' => "O'zbekcha nomi",
            'name_ru' => 'Rus tilida nomi',
            'description_uz' => "O'zbek tilida izoh",
            'description_ru' => "Rus tilida izoh",
            'photo' => "Rasm",
            'address' => "Manzil",
            'open_with_google_maps' => 'Google Xarita orqali oching'
        ]
    ],
    'category' => [
        'title' => 'Kategoriyalar',
        'fields' => [
            'branch_id' => 'Offis',
            'name_uz' => "O'zbekcha nomi",
            'name_ru' => 'Rus tilida nomi',
            'parent_id'=>'Bosh kategoriya',
            'address' => "Manzil"
        ]
        ],
        'company' => [
            'title' => 'Kompaniya',
            'fields' => [
                'address' => "Manzil",
                'company_name' => 'Kompaniya nomi',
                'raxbar' => 'Lavozim',
                'company_location' => 'Kompaniya joylashuvi',
                'branch_location' => 'Obyekt manzili',

                'branch_type' => 'Obyekt turi',

                'bank_service' => 'Bank nomi',
                'bank_code' => 'Bank ko\'di',
                'bank_account' => 'Bank hisob raqami',
                'stir' => 'STIR',
                'oked' => 'OKED'
            ]
            ],

            'construction'       => [
                'title' => 'Qurilish',
                'text' => 'Qurilish Boshqarmasi',
                'fields' => [
                    'viewers' => 'Ko\'rganlar',
                    'views_count' => 'Ko\'rganlar soni'
                ]
            ]
];
