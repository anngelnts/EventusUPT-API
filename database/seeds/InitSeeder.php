<?php

use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('audiences')->insert([
            ['id' => 1, 'name' => 'Estudiante', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 2, 'name' => 'Público', 'created_at' => date('Y-m-d H:i:s')],
        ]);

        DB::table('event_types')->insert([
            ['id' => 1, 'name' => 'Académico', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 2, 'name' => 'Atletismo', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 3, 'name' => 'Ceremonia', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 4, 'name' => 'Conferencia', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 5, 'name' => 'Exposición', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 6, 'name' => 'Sesion de informacion', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 7, 'name' => 'Conferencias y seminarios', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 8, 'name' => 'Reunión', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 9, 'name' => 'Actuación', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 10, 'name' => 'Evento especial', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 11, 'name' => 'Actividad estudiantil', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 12, 'name' => 'Taller', 'created_at' => date('Y-m-d H:i:s')],
        ]);

        DB::table('universities')->insert([
            ['id' => 1, 'name' => 'Universidad Privada de Tacna', 'acronym' => 'UPT', 'created_at' => date('Y-m-d H:i:s')],
        ]);

        DB::table('faculties')->insert([
            ['id' => 1, 'univerity_id' => 1, 'name' => 'Facultad de Ingeniería', 'acronym' => 'FAING', 'created_at' => date('Y-m-d H:i:s')],
        ]);

        DB::table('schools')->insert([
            ['id' => 1, 'faculty_id' => 1, 'name' => 'Escuela Profesional Ingeniería de Sistemas', 'acronym' => 'EPIS', 'created_at' => date('Y-m-d H:i:s')],
        ]);

        DB::table('organizers')->insert([
            ['id' => 1, 'name' => 'Capacitación Tecnológica', 'acronym' => 'CATEC', 'email' => 'catec@upt.pe', 'password' => app('hash')->make('eventus'), 'status' => 1, 'created_at' => date('Y-m-d H:i:s')],
        ]);

        DB::table('events')->insert([
            ['id' => 1, 
            'type_id' => 7, 
            'school_id' => 1, 
            'organizer_id' => 1, 
            'title' => 'Ciberseguridad en tiempos de pandemia', 
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore accusamus reiciendis, veniam, et delectus consectetur quasi provident',
            'image' => '',
            'event_date' => date('Y-m-d'),
            'start_time' => date('H:i:s'),
            'end_time' => date('H:i:s'),
            'is_outstanding' => false,
            'is_virtual' => true,
            'is_open' => false,
            'location' => '',
            'event_link' => '',
            'status' => 1, 
            'created_at' => date('Y-m-d H:i:s')],

            ['id' => 2, 
            'type_id' => 7, 
            'school_id' => 1, 
            'organizer_id' => 1, 
            'title' => 'Marketing Digital en tiempos de COVID-19', 
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore accusamus reiciendis, veniam, et delectus consectetur quasi provident',
            'image' => '',
            'event_date' => date('Y-m-d'),
            'start_time' => date('H:i:s'),
            'end_time' => date('H:i:s'),
            'is_outstanding' => false,
            'is_virtual' => true,
            'is_open' => false,
            'location' => '',
            'event_link' => '',
            'status' => 1, 
            'created_at' => date('Y-m-d H:i:s')],

            ['id' => 3, 
            'type_id' => 7, 
            'school_id' => 1, 
            'organizer_id' => 1, 
            'title' => 'Tecnología 5G', 
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore accusamus reiciendis, veniam, et delectus consectetur quasi provident',
            'image' => '',
            'event_date' => date('Y-m-d'),
            'start_time' => date('H:i:s'),
            'end_time' => date('H:i:s'),
            'is_outstanding' => false,
            'is_virtual' => true,
            'is_open' => false,
            'location' => '',
            'event_link' => '',
            'status' => 1, 
            'created_at' => date('Y-m-d H:i:s')],
        ]);
    }
}
