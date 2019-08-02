<?php

return [
    /*
     * Namespaces used by the generator.
     */
    'namespace' => [
        /*
         * Base namespace/directory to create the new file.
         * This is appended on default Laravel namespace.
         * Usage: php artisan datatables:make User
         * Output: App\DataTables\UserDataTable
         * With Model: App\User (default model)
         * Export filename: users_timestamp
         */
        'base' => 'DataTables',

        /*
         * Base namespace/directory where your model's are located.
         * This is appended on default Laravel namespace.
         * Usage: php artisan datatables:make Post --model
         * Output: App\DataTables\PostDataTable
         * With Model: App\Post
         * Export filename: posts_timestamp
         */
        'model' => '',
    ],

    /*
     * Set Custom stub folder
     */
    //'stub' => '/resources/custom_stub',

    /*
     * PDF generator to be used when converting the table to pdf.
     * Available generators: excel, snappy
     * Snappy package: barryvdh/laravel-snappy
     * Excel package: maatwebsite/excel
     */
    'pdf_generator' => 'snappy',

    /*
     * Snappy PDF options.
     */
    'snappy' => [
        'options' => [
            'no-outline'    => true,
            'margin-left'   => '0',
            'margin-right'  => '0',
            'margin-top'    => '10mm',
            'margin-bottom' => '10mm',
        ],
        'orientation' => 'landscape',
    ],

    /*
     * Default html builder parameters.
     */
    'parameters' => [
        'dom'     => 'Blfrtip',
        'order'   => [[0, 'desc']],
        'sPaginationType'=> 'full_numbers',
        'autoWidth' => false,
        'lengthMenu'=> [
            [ 10, 25, 50, -1 ],
            [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
        ],
        'buttons' => [
          [
            'extend'=>'copy',
            'className'=> 'btn btn-light btn-sm',
            'text'=> '<i class="fas fa-copy"></i> Copiar'
          ],
          [
            'extend'=> 'export',
            'className'=> 'btn btn-light btn-sm',
            'text'=> '<i class="fas fa-download"></i> Exportar'
          ],
          [
            'extend'=>'print',
            'className'=> 'btn btn-light btn-sm',
            'text'=>'<i class="fas fa-print"></i> Imprimir',
             'messageTop' => 'User Report',
            
          ],
          [
            'extend'=>'reset',
            'className'=> 'btn btn-light btn-sm',
            'text'=>'<i class="fas fa-undo-alt"></i> Resetear'
          ],
          [
            'extend'=>'reload',
            'className'=> 'btn btn-light btn-sm',
            'text'=>'<i class="fas fa-sync"></i> Recargar'
          ]
        ],
        'language'=> [
            "sProcessing"=> "Procesando...",
            "sLengthMenu"=> "Mostrar _MENU_ registros",
            "sZeroRecords"=> "No se encontraron resultados",
            "sEmptyTable"=> "Ningún dato disponible en esta tabla",
            "sInfo"=> "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty"=> "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered"=> "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix"=> "",
            "sSearch"=> "Buscar:",
            "sUrl"=> "",
            "sInfoThousands"=> ",",
            "sLoadingRecords"=> "Cargando...",
    
            "oPaginate"=> [
                "sFirst"=> "Primero",
                "sLast"=> "Último",
                "sNext"=> "Siguiente",
                "sPrevious"=> "Anterior"
            ],
            "oAria"=> [
                "sSortAscending"=> ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending"=> ": Activar para ordenar la columna de manera descendente"
            ]
        ],
    ],
];
